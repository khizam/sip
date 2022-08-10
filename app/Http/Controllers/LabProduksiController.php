<?php

namespace App\Http\Controllers;

use App\Models\LabProduksi;
use App\Models\ProduksiBarang;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class LabProduksiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $produksibarang = ProduksiBarang::all(['jumlah_hasil_produksi', 'id_produksi']);
        return view('labProduksi.index', compact('produksibarang'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function data()
    {
        $labProduksi = LabProduksi::leftJoin('produksi_barang', 'produksi_barang.id_produksi', '=', 'lab_produksi.id_produksi')
            ->select('lab_produksi.*', 'produksi_barang.jumlah_hasil_produksi')
            ->orderBy('id_produksi', 'asc')
            ->get();

        return datatables()
            ->of($labProduksi)
            ->addIndexColumn()

            ->addColumn('aksi', function ($labProduksi) {
                return '
                    <div class="btn-group">
                        <button onClick="editForm(`'. route('labProduksi.update', $labProduksi->id_labproduksi) .'`, `'. route('labProduksi.show', $labProduksi->id_labProduksi) .'`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-pencil"></i></button>
                        <button onClick="deleteData(`'. route('labProduksi.destroy', $labProduksi->id_labproduksi) .'`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
                    </div>
                ';
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
        $labProduksi = LabProduksi::latest()->first();
        $labProduksi = LabProduksi::create($request->all());

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
        $labProduksi = LabProduksi::find($id);

        return response()->json($labProduksi);
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
        $labProduksi = LabProduksi::find($id);
        $labProduksi->jumlah_produksi = $request->jumlah_produksi;
        $labProduksi->lost = $request->lost;
        $labProduksi->save();

        return response()->json('Data berhasil disimpan', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $labProduksi = LabProduksi::find($id);
        $labProduksi->delete();

        return response(null, 204);
    }
}
