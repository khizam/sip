<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bahan;
use Illuminate\Support\Facades\Gate;

class BahanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('bahan_index');
        return view('bahan.index');
    }

    public function data()
    {
        if (Gate::denies('bahan_index')) {
            return jsonResponse("Anda tidak dapat Mengakses Halaman atau Tindakan ini", 403);
        }
        $bahan = Bahan::orderBy('id_bahan', 'desc')->get();

        return datatables()
        ->of($bahan)
        ->addIndexColumn()
        ->addColumn('aksi', function ($bahan) {
            return '
            <div class="btn-group">
                    <button onClick="editForm(`'. route('bahan.update', $bahan->id_bahan) .'`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-pencil"></i></button>
                    <button onClick="deleteData(`'. route('bahan.destroy', $bahan->id_bahan).'`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
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
        $this->authorize('bahan_create');
        $bahan = Bahan::latest()->first();
        $bahan = Bahan::create($request->all());
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
        $this->authorize('bahan_edit');
        $bahan = Bahan::find($id);

        return response()->json($bahan);
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
        $this->authorize('bahan_edit');
        $bahan = Bahan::find($id);
        $bahan->nama_bahan = $request->nama_bahan;
        $bahan->update();

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
        $this->authorize('bahan_delete');
        $bahan = Bahan::find($id);
        $bahan->delete();

        return response(null, 204);
    }
}
