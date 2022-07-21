<?php

namespace App\Http\Controllers;

use App\Models\Enums\StatusProduksiEnum;
use App\Models\StatusProduksi;
use App\Models\User;
use App\Models\Produk;
use App\Models\ProduksiBarang;
use Illuminate\Http\Request;
use Illuminate\Facades\Auth;
use Illuminate\Facedes\DB;
USE Illuminate\Facedes\Log;

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

        return view('produksi.index', compact('produk', 'user', 'statusProduksi'));
    }

    public function data()
    {
        // $produksibarang = ProduksiBarang::leftJoin('produk', '')
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProduksiBarang  $produksiBarang
     * @return \Illuminate\Http\Response
     */
    public function show(ProduksiBarang $produksiBarang)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProduksiBarang  $produksiBarang
     * @return \Illuminate\Http\Response
     */
    public function edit(ProduksiBarang $produksiBarang)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProduksiBarang  $produksiBarang
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProduksiBarang $produksiBarang)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProduksiBarang  $produksiBarang
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProduksiBarang $produksiBarang)
    {
        //
    }
}
