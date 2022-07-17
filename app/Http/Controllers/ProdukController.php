<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use Illuminate\Support\Facades\Gate;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('produk_index');
        return view('produk.index');
    }

    public function data()
    {
        if (Gate::denies('produk_index')) {
            return jsonResponse("Anda tidak dapat Mengakses Halaman atau Tindakan ini", 403);
        }
        $produk = Produk::orderBy('id_produk', 'desc')->get();

        return datatables()
        ->of($produk)
        ->addIndexColumn()
        ->addColumn('aksi', function ($produk) {
            return '
            <div class="btn-group">
                <button onClick="editForm(`'. route('produk.update', $produk->id_produk) .'`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-pencil"></i></button>
                <button onClick="deleteData(`'. route('produk.destroy', $produk->id_produk) .'`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
            </div>
            ';
        })
        ->rawColumns(['aksi'])
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
        if (Gate::denies('produk_create')) {
            return jsonResponse("Anda tidak dapat Mengakses Halaman atau Tindakan ini", 403);
        }
        $produk = Produk::latest()->first();
        $produk = Produk::create($request->all());

        return response()->json('Data Berhasil Disimpan', 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (Gate::denies('produk_edit')) {
            return jsonResponse("Anda tidak dapat Mengakses Halaman atau Tindakan ini", 403);
        }
        $produk = Produk::find($id);

        return response()->json($produk);
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
        if (Gate::denies('produk_edit')) {
            return jsonResponse("Anda tidak dapat Mengakses Halaman atau Tindakan ini", 403);
        }
        $produk = Produk::find($id);
        $produk->nama_produk = $request->nama_produk;
        $produk->update();

        return response()->json('Data Berhasil disimpan', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Gate::denies('produk_delete')) {
            return jsonResponse("Anda tidak dapat Mengakses Halaman atau Tindakan ini", 403);
        }
        $produk = Produk::find($id);
        $produk->delete();

        return response(null, 204);
    }
}
