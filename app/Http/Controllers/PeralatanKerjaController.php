<?php

namespace App\Http\Controllers;

use App\Models\PeralatanKerja;
use Illuminate\Http\Request;
use Illuminate\Support\Facedes\Gate;

class PeralatanKerjaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $this->authorize('peralatan_index');
        return view('peralatanKerja.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function  data()
    {
        // $this->authorize('peralatan_index');
        $peralatanKerja = PeralatanKerja::orderBy('id_peralatan_kerja', 'desc');

        return datatables()
            ->of($peralatanKerja)
            ->addIndexColumn()
            ->addColumn('aksi', function ($peralatanKerja) {
                return '
            <div class="btn-group">
                <button onClick="editForm(`' . route('peralatanKerja.update', $peralatanKerja->id_peralatan_kerja) . '`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-pencil"></i></button>
                <button onClick="deleteData(`' . route('peralatanKerja.destroy', $peralatanKerja->id_peralatan_kerja) . '`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
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
        // $this->authorize('peralatan_create');
        $peralatanKerja = $request->alat;
        $peralatanKerja = $request->jumlah_alat;
        $peralatanKerja = PeralatanKerja::create($request->all());
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
        $this->authorize('peralatan_edit');
        $peralatanKerja = PeralatanKerja::find($id);

        return response()->json($peralatanKerja);
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
        // $this->authorize('peralatan_edit');
        $peralatanKerja = PeralatanKerja::find($id);
        $peralatanKerja->alat = $request->alat;
        $peralatanKerja->jumlah_alat = $request->jumlah_alat;
        $peralatanKerja->update();

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
        // $this->authorize('peralatan_delete');
        $peralatanKerja = PeralatanKerja::find($id);
        $peralatanKerja->delete();

        return response(null, 204);
    }
}
