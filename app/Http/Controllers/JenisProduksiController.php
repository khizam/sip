<?php

namespace App\Http\Controllers;

use App\Models\JenisProduksi;
use Illuminate\Http\Request;

class JenisProduksiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('jenis_produksi.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function data()
     {
        $jenisproduksi = JenisProduksi::orderBy('id_jenisproduksi', 'desc')->get();

        return datatables()
        ->of($jenisproduksi)
        ->addIndexColumn()
        ->addColumn('aksi', function ($jenisproduksi) {
            return '
            <div class="btn-group">
                <button onclick="editForm(`'. route('jenisproduksi.update', $jenisproduksi->id_jenisproduksi) .'`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-pencil"></i></button>
                <button onclick="deleteData(`'. route('jenisproduksi.destroy', $jenisproduksi->id_jenisproduksi) .'`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
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
        $jenisproduksi = new JenisProduksi();
        $jenisproduksi->jenis = $request->jenis;
        $jenisproduksi->save();

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
        $jenisproduksi = JenisProduksi::find($id);

        return response()->json($jenisproduksi);
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
        $jenisproduksi = JenisProduksi::find($id);
        $jenisproduksi->jenis = $request->jenis;
        $jenisproduksi->update();

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
        $jenisproduksi = JenisProduksi::find($id);
        $jenisproduksi->delete();

        return response(null, 204);
    }
}
