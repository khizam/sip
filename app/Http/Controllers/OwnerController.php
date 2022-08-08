<?php

namespace App\Http\Controllers;

use App\Events\PermintaanProduksiEvent;
use App\Models\Enums\StatusProduksiEnum;
use App\Models\StatusProduksi;
use App\Models\ProduksiBarang;
use App\Models\Produk;
use App\Models\Satuan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OwnerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $produk = Produk::all()->pluck('nama_produk', 'id_produk');
        $statusProduksi = StatusProduksi::all()->pluck('status', 'id_status');
        $user = User::all()->pluck('name', 'id');
        $satuan = Satuan::all()->pluck('satuan', 'id_satuan');

        return view('owner.index', compact('produk', 'user', 'statusProduksi', 'satuan'));
    }

    public function data()
    {
        $produksibarang = ProduksiBarang::leftJoin('produk', 'produk.id_produk', '=', 'produksi_barang.id_produk')
            ->leftJoin('status_produksi', 'status_produksi.id_status', '=', 'produksi_barang.id_status')
            ->leftJoin('users', 'users.id', '=', 'produksi_barang.id_user')
            ->leftJoin('satuan', 'satuan.id_satuan', '=', 'produksi_barang.id_satuan')
            ->select('produksi_barang.*', 'produk.nama_produk', 'status_produksi.status', 'users.id', 'satuan.satuan')
            ->orderBy('created_at', 'asc')
            ->get();

        return datatables()
            ->of($produksibarang)
            ->addIndexColumn()

            ->addColumn('kode_produksi', function ($produksibarang) {
                return '<span class="label label-success">' . $produksibarang->kode_produksi . '</span>';
            })

            ->addColumn('jumlah', function ($produksibarang) {
                return format_uang($produksibarang->jumlah);
            })


            ->addColumn('status', function ($produksibarang) {
                if (is_null($produksibarang->id_status)) {
                    return  'masi menunggu konfirmasi';
                }
                return $produksibarang->status;
            })

            ->addColumn('aksi', function ($produksibarang) {
                return '
            <div class="">
                <button onclick="editForm(`' . route('owner.update', $produksibarang->id_produksi) . '`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-pencil"></i></button>
                <button onclick="deleteData(`' . route('owner.destroy', $produksibarang->id_produksi) . '`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
            </div>
            ';
            })
            ->rawColumns(['aksi', 'jumlah', 'kode_produksi'])
            ->make(true);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $produksibarang = ProduksiBarang::latest()->first() ?? new ProduksiBarang();
            $kode_produksi = (int) $produksibarang->kode_produksi + 1;

            $produksibarang = new produksibarang();
            $produksibarang->kode_produksi = tambah_nol_didepan($kode_produksi, 6);
            $produksibarang->id_produk = $request->id_produk;
            $produksibarang->jumlah = $request->jumlah;
            $produksibarang->id_satuan = $request->id_satuan;
            $produksibarang->id_status = null;
            $produksibarang->id_user = Auth::id();
            $produksibarang->save();

            // Notification to Produksi User
            $data = $produksibarang->load('produk', 'user');
            event(new PermintaanProduksiEvent($data));
            DB::commit();
            return response()->json('Data berhasil disimpan', 200);
        } catch (\Throwable $th) {
            DB::rollback();
            Log::error("tambah request produksi" . $th);
            return response()->json('gagal disimpan' . $th->getMessage(), 500);
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
        $produksibarang = ProduksiBarang::find($id);

        return response()->json($produksibarang);
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
        $produksibarang = ProduksiBarang::find($id);
        $produksibarang->update($request->all());

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
        $produksibarang = ProduksiBarang::find($id);
        $produksibarang->delete();

        return response(null, 204);
    }
}
