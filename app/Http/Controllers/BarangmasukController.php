<?php

namespace App\Http\Controllers;

use App\Models\Bahan;
use App\Models\Kategori;
use App\Models\Supplier;
use App\Models\Barangmasuk;
use App\Models\Lab;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BarangmasukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bahan = Bahan::all()->pluck('nama_bahan', 'id_bahan');
        $kategori = Kategori::all()->pluck('nama_kategori', 'id_kategori');
        $supplier = Supplier::all()->pluck('nama_supplier', 'id_supplier');

        return view('barangmasuk.index', compact('bahan','kategori','supplier'));
        // return view('barangmasuk.index', compact('kategori'));
        // return view('barangmasuk.index', compact('supplier'));
    }

    public function data()
    {
        $barangmasuk = Barangmasuk::leftJoin('bahan', 'bahan.id_bahan', '=', 'barangmasuk.id_bahan')
        ->leftJoin('kategori', 'kategori.id_kategori', '=', 'barangmasuk.id_kategori')
        ->leftJoin('supplier', 'supplier.id_supplier', '=', 'barangmasuk.id_supplier')
        ->select('barangmasuk.*', 'nama_bahan', 'nama_kategori', 'nama_supplier')
        ->orderBy('kode_barangmasuk', 'asc')
        ->get();

        return datatables()
        ->of($barangmasuk)
        ->addIndexColumn()
        ->addColumn('kode_barangmasuk', function ($barangmasuk) {
            return '<span class="label label-success">'. $barangmasuk->kode_barangmasuk .'</span>';
        })
        ->addColumn('jumlah_bahan', function ($barangmasuk) {
            return format_uang($barangmasuk->jumlah_bahan);
        })
        ->addColumn('aksi', function ($barangmasuk) {
            return '
            <div class="">
                <button onclick="editForm(`'. route('barangmasuk.update', $barangmasuk->id_barangmasuk) .'`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-pencil"></i></button>
                <button onclick="deleteData(`'. route('barangmasuk.destroy', $barangmasuk->id_barangmasuk) .'`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
                <button onclick="alert(`belum ada fungsi :(`)" class="btn btn-xs btn-primary btn-flat">Lab <i class="fa fa-flask"></i></button>
            </div>
            ';
        })
        ->rawColumns(['aksi', 'kode_barangmasuk'])
        ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public static function convertdate()
    // {
    //     date_default_timezone_set('Asia/jakarta');
    //     $date = date('dmy');
    //     return $date;
    // }

    // public static function autonumber($barangmasuk, $primary, $prefix) {
    //     $q=DB::table($barangmasuk)->select(DB::raw('Max(RIGHT('.$primary.',5)) as kd_max'));
    //     $prx=$prefix.Dateindo::convertdate();
    //     if($q->count()>0)
    //     {
    //         foreach($q->get() as $k)
    //         {
    //             $tmp = ((int)$k->kd_max)+1;
    //             $kd = $prx.sprintf("%06s", $tmp);
    //         }
    // }
    // else
    // {
    //     $kd = $prx."000001";
    // }
    // return $kd;
    // }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $request->whenFilled('jumlah_bahan',function($input) use($request) {
                $request->merge(['sisa_bahan'=>$input]);
            });
            DB::beginTransaction();
            $barangmasuk = Barangmasuk::latest()->first() ?? new Barangmasuk();
            $request['kode_barangmasuk'] = 'P'. tambah_nol_didepan((int)$barangmasuk->id_barangmasuk +1, 6);
            $barangmasuk = Barangmasuk::create($request->all());
            if ($barangmasuk) {
                Lab::create([
                    'id_barangmasuk'=> $barangmasuk->id_barangmasuk,
                    'satuan' => 'kg',
                    'bahan_layak' => 0,
                    'bahan_tidak_layak' => 0,
                ]);
            }
            DB::commit();
            return response()->json('Data berhasil disimpan', 200);
        } catch (\Throwable $th) {
            DB::rollback();
            Log::error("tambah barang masuk".$th);
            return response()->json('gagal disimpan'.$th->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $barangmasuk = Barangmasuk::find($id);

        return response()->json($barangmasuk);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $barangmasuk = Barangmasuk::find($id);
        $barangmasuk->update($request->all());

        return response()->json('Data Berhasil Disimpan', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $barangmasuk = Barangmasuk::find($id);
        $barangmasuk->delete();

        return response(null, 204);
    }
}
