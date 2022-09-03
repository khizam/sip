<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Gate;
use App\Models\Parameter;
use Illuminate\Http\Request;

class ParameterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('parameter.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function data()
    {
        $parameter = Parameter::orderBy('id_parameter', 'desc')->get();

        return datatables()
        ->of($parameter)
        ->addIndexColumn()
        ->addColumn('aksi', function ($parameter) {
            return '
            <div class="btn-group">
                <button onclick="editForm(`'. route('parameter.update', $parameter->id_parameter) .'`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-pencil"></i></button>
                <button onclick="deleteData(`'. route('parameter.destroy', $parameter->id_parameter) .'`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
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
        $parameter = new Parameter();
        $parameter->nama_parameter = $request->nama_parameter;
        $parameter->nomor_parameter = $request->nomor_parameter;
        $parameter->save();

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
        $parameter = Parameter::find($id);

        return response()->json($parameter);
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
        $parameter = Parameter::find($id);
        $parameter->nama_parameter = $request->nama_parameter;
        $parameter->update();

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
        $parameter = Parameter::find($id);
        $parameter->delete();

        return response(null, 204);
    }
}
