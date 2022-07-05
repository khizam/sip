<?php

namespace App\Http\Controllers;

use App\Models\Bahan;
use App\Models\Kategori;
use App\Models\Supplier;
use App\Models\Barangmasuk;
use App\Models\Lab;
use Illuminate\Http\Request;


class LabController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
        return view('lab.index');
        // return view('barangmasuk.index', compact('kategori'));
        // return view('barangmasuk.index', compact('supplier'));
        
    }

    public function data()
    {
        $lab = Lab::leftJoin('barangmasuk','barangmasuk.id_barangmasuk','=','lab.id_barangmasuk')
        ->leftJoin('bahan', 'bahan.id_bahan', '=', 'barangmasuk.id_bahan')
        ->leftJoin('kategori', 'kategori.id_kategori', '=', 'barangmasuk.id_kategori')
        ->leftJoin('supplier', 'supplier.id_supplier', '=', 'barangmasuk.id_supplier')
        ->select('*','barangmasuk.*', 'nama_bahan', 'nama_kategori', 'nama_supplier')
        ->orderBy('kode_barangmasuk', 'asc')
        ->get();

        return datatables()
        ->of($lab)
        ->addIndexColumn()
        ->addColumn('id_lab', function ($lab) {
            return '<span class="label label-success">'. $lab->id_lab .'</span>';
        })
        ->addColumn('jumlah_bahan', function ($barangmasuk) {
            return format_uang($barangmasuk->jumlah_bahan);
        })
        ->addColumn('aksi', function ($lab) {
            return '
            <div class="btn-group">
                <button onclick="editForm(`'. route('lab.update', $lab->id_lab) .'`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-pencil"></i></button>
                <button onclick="deleteData(`'. route('lab.destroy', $lab->id_lab) .'`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button> 
            </div>
            ';
        })
        ->rawColumns(['aksi', 'id_lab'])
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
    
        return response()->json('Data berhasil disimpan', 200); 
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
