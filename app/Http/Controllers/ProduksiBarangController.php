<?php

namespace App\Http\Controllers;

use App\Models\Enums\StatusProduksiEnum;
use App\Models\StatusProduksi;
use App\Models\Satuan;
use App\Models\User;
use App\Models\Produk;
use App\Models\ProduksiBarang;
use Illuminate\Http\Request;
use Illuminate\Facades\Auth;
use Illuminate\Facedes\DB;
USE Illuminate\Facedes\Log;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProduksiBarangController extends Controller
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

        return view('produksi.index', compact('produk', 'user', 'statusProduksi', 'satuan'));
    }

    public function data()
    {
        $produksibarang = ProduksiBarang::leftJoin('produk', 'produk.id_produk', '=', 'produksi_barang.id_produk')
        ->leftJoin('status_produksi', 'status_produksi.id_status', '=', 'produksi_barang.id_status')
        ->leftJoin('users', 'users.id', '=', 'produksi_barang.id_user')
        ->leftJoin('satuan', 'satuan.id_satuan', '=', 'produksi_barang.id_satuan')
        ->select('produksi_barang.*', 'produk.nama_produk', 'status_produksi.status', 'users.id', 'satuan.satuan')
        ->orderBy('id_produksi', 'asc')
        ->get();

        return datatables()
        ->of($produksibarang)
        ->addIndexColumn()

        ->addColumn('jumlah', function ($produksibarang) {
            return format_uang($produksibarang->jumlah);
        })

        ->addColumn('aksi', function ($produksibarang) {
            return '
            <div class="">
                <button onclick="editForm(`'. route('produksi.update', $produksibarang->id_produksi) .'`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-pencil"></i></button>
                <button onclick="deleteData(`'. route('produksi.destroy', $produksibarang->id_produksi) .'`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
                <a href=`'.route('detailProduksi.index').'`class="btn btn-xs btn-primary btn-flat">button</a>
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
