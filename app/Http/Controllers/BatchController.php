<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use App\Models\ProduksiBarang;
use Illuminate\Http\Request;

class BatchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id_produksi = null)
    {
        return view('batchDetail.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function data($id_produksi)
    {
        $batch = Batch::leftJoin('status_batch', 'status_batch.id_status', '=', 'batch.id_status')
            ->select('batch.nama_batch', 'jumlah_batch', 'status_batch.status', 'id_batch')
            ->orderBy('id_batch')
            ->where('id_produksi', $id_produksi);

        return datatables()
            ->of($batch)
            ->addIndexColumn()

            ->addColumn('aksi', function ($detailproduksi) {
                return '
                <div class="btn-group">
                        <button onClick="" class="btn btn-xs btn-info btn-flat"><i class="fa fa-pencil"></i></button>
                        <button onClick="" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
                </div>
                ';
            })
            ->rawColumns(['aksi', 'permintaan_bahan'])
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
        $batch = ProduksiBarang::find($request->id_produksi, ['batch']);
        $countBatch = Batch::where('id_produksi', $request->id_produksi)->count();
        if ($countBatch >= $batch->batch) {
            return redirect()->back()->with('fail', 'batch maksimal ' . $batch->batch);
        } else {
            Batch::create([
                'nama_batch' => $request->nama,
                'id_produksi' => $request->id_produksi,
                'id_status' => 1,
                'jumlah_batch' => $request->jumlah
            ]);
            return redirect()->back()->with('success', 'batch berhasil ditambahkan');
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
        $jenisproduksi = Batch::find($id);
        $jenisproduksi->delete();

        return response(null, 204);
    }
}
