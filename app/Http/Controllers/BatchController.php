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
        // $produksibarang = ProduksiBarang::all(['id_produksi', 'nama_produk']);
        // $data = [
        //     'produksibarang' => $produksibarang
        // ];

        return view('batchDetail.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function data ($id_produksi)
     {
        $batch = Batch::leftJoin('produksi_barang', 'produksi_barang.id_produksi', '=', 'batch.id_produksi')
            ->leftJoin('status_batch', 'status_batch.id_status', '=', 'batch.id_batch')
            ->select('batch.nama_batch','produksi_barang.batch','produksi_barang.nama_produk', 'produksi_barang.jumlah', 'produksi_barang.keterangan', 'status_batch.status')
            ->orderBy('produksi_barang.id_produksi')
            ->where('batch.id_produksi', $id_produksi);

            return datatables()
            ->of($batch)
            ->addIndexColumn()

            ->addColumn('aksi', function ($detailproduksi) {
                $html = '<div class="">';
                if (is_null($detailproduksi->id_request)) {
                    $html .= '<button onclick="editDetailForm(`' . route('detailProduksi.show', $detailproduksi->id_detail) . '` , `' . route('detailProduksi.update', $detailproduksi->id_detail) . '`)" class="btn btn-xs btn-primary btn-flat"><i class="fa fa-pencil"></i></button>
                    <button onclick="deleteData(`' . route('detailProduksi.destroy', $detailproduksi->id_detail) . '`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>';
                }
                $html .= '</div>';
                return $html;
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
        //
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
