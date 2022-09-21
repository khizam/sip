<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use App\Models\StatusBatch;
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
        $statusbatchs = StatusBatch::all(['status', 'id_status']);

        return view('batchDetail.index', compact('statusbatchs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function data($id_produksi)
    {
        $batch = Batch::leftJoin('status_batch', 'status_batch.id_status', '=', 'batch.id_status')
            ->select('batch.nama_batch', 'jumlah_batch', 'status_batch.status', 'id_batch', 'id_produksi')
            ->orderBy('id_batch')
            ->where('id_produksi', $id_produksi);

        return datatables()
            ->of($batch)
            ->addIndexColumn()

            ->addColumn('aksi', function ($batch) {
                return '
                <div class="btn-group">
                        <button onClick="editDetailForm(`' . route('batch.edit', $batch->id_batch) . '`,`' . route('batch.update', $batch->id_batch) . '`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-pencil"></i></button>
                        <button onClick="deleteData(`' . route('batch.destroy', $batch->id_batch) . '`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
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
            return jsonResponse('batch maksimal ' . $batch->batch, 500);
        } else {
            Batch::create([
                'nama_batch' => $request->nama,
                'id_produksi' => $request->id_produksi,
                'id_status' => 1,
                'jumlah_batch' => $request->jumlah
            ]);
            return \jsonResponse('Data Berhasil disimpan');
        }
    }


    public function edit($id)
    {
        $batch = Batch::findOrFail($id);
        return jsonResponse($batch);
    }

    public function update(Request $request, $id)
    {
        $batch = Batch::findOrFail($id);
        $batch->update([
            'nama_batch' => $request->nama,
            'jumlah_batch' => $request->jumlah,
            'id_status' => $request->id_status,
        ]);

        return jsonResponse($batch);
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
