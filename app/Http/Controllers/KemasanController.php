<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Gate;
use App\Models\Kemasan;
use Illuminate\Http\Request;

class KemasanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('kemasan.index');
    }

    public function data()
    {
        $kemasan = Kemasan::orderBy('id_kemasan', 'desc')->get();

        return datatables()
            ->of($kemasan)
            ->addIndexColumn()
            ->addColumn('aksi', function ($kemasan) {
                return'
                <div class="btn-group">
                    <button onclick="editForm(`'. route('kemasan.update', $kemasan->id_kemasan) .'`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-pencil"></i></button>
                    <button onclick="deleteData(`'. route('kemasan.destroy', $kemasan->id_kemasan) .'`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
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
        $kemasan = new Kemasan();
        $kemasan->jenis_kemasan = $request->jenis_kemasan;
        $kemasan->save();

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
        $kemasan = Kemasan::find($id);

        return response()->json($kemasan);
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
        $kemasan = Kemasan::find($id);
        $kemasan->jenis_kemasan = $request->jenis_kemasan;
        $kemasan->update();

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
        $kemasan = Kemasan::find($id);
        $kemasan->delete();

        return response(null, 204);
    }
}
