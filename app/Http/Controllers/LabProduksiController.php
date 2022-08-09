<?php

namespace App\Http\Controllers;

use App\Models\LabProduksi;
use Illuminate\Http\Request;

class LabProduksiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('lab_produksi.index');
    }

    public function data()
    {
        $labProduksi = LabProduksi::leftJoin('produksi_barang', 'produksi_barang.id_produksi', '=', 'lab_produksi.id_produksi')
            ->leftJoin('produk', 'produk.id_produk', '=', 'produksi_barang.id_produk')
            ->leftJoin('status_produksi', 'status_produksi.id_status', '=', 'produksi_barang.id_status')
            ->orderBy('lab_produksi.created_at', 'DESC')
            ->select(['id_labproduksi', 'produk.nama_produk', 'status_produksi.status', 'lab_produksi.jumlah_produksi', 'lab_produksi.created_at', 'produksi_barang.jumlah'])
            ->get();

        return datatables()
            ->of($labProduksi)
            ->addIndexColumn()
            ->addColumn('kode_lab', function ($labProduksi) {
                return '<span class="label label-success">' . $labProduksi->kode_lab . '</span>';
            })
            ->addColumn('aksi', function ($labProduksi) {
                $html = '<div class="">
                    <button onclick="editLabForm(`' . route('lab.editLab', $labProduksi->id_labproduksi) . '` , `' . route('lab.updateLab', $labProduksi->id_labproduksi) . '`)" class="btn btn-xs btn-primary btn-flat"><i class="fa fa-pencil"></i></button>
                    <button onclick="editForm(`' . route('lab.edit', $labProduksi->id_labproduksi) . '` , `' . route('lab.update', $labProduksi->id_labproduksi) . '`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-plus"></i></button>
                    <button onclick="check(`' . route('lab.edit', $labProduksi->id_labproduksi) . '` , `' . route(
                    'lab.checkStatus',
                    $labProduksi->id_labproduksi
                ) . '`)" class="btn btn-xs btn-warning btn-flat"><i class="fa fa-check"></i></button>
                    </div>';
                return $html;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
