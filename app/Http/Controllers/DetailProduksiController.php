<?php

namespace App\Http\Controllers;

use App\Models\DetailProduksi;
use App\Models\Bahan;
use App\Models\ProduksiBarang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DetailProduksiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bahan = Bahan::all()->pluck('nama_bahan', 'id_bahan');
        return view('detailProduksi.index', compact('bahan'));
    }

    public function data()
    {
        $detailproduksi = DetailProduksi::leftJoin('bahan', 'bahan.id_bahan', '=', 'detail_produksi.id_bahan')
        ->select('detail_produksi.*', 'bahan.nama_bahan')
        ->orderBy('id_detail', 'asc')
        ->get();

        return datatables()
        ->of($detailproduksi)
        ->addIndexColumn()

        ->addColumn('jumlah', function ($detailproduksi) {
            return format_uang($detailproduksi->jumlah);
        })

        ->addColumn('aksi', function ($detailproduksi) {
            return '
            <div class="">
                <button onclick="editForm(`'. route('detailProduksi.update', $detailproduksi->id_detail) .'`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-pencil"></i></button>
                <button onclick="deleteData(`'. route('detailProduksi.destroy', $detailproduksi->id_detail) .'`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
            </div>
            ';
        })
        ->rawColumns(['aksi'])
        ->make(true);
    }

    public function create()
    {
        
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

            $detailproduksi = new detailproduksi();
            $detailproduksi->id_bahan = $request->id_bahan;
            $detailproduksi->jumlah = $request->jumlah;
            $detailproduksi->save();

            DB::commit();
            return response()->json('Data berhasil disimpan', 200);    
        } catch (\Throwable $th) {
            DB::rollback();
            Log::error("tambah request detail produksi".$th);
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
