<?php

namespace App\Http\Controllers;

use App\Events\PermintaanProduksiEvent;
use App\Models\Batch;
use App\Models\Enums\StatusProduksiEnum;
use App\Models\StatusProduksi;
use App\Models\ProduksiBarang;
use App\Models\Produk;
use App\Models\Satuan;
use App\Models\User;
use App\Models\JenisProduksi;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OwnerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('request_index');
        $produk = Produk::all()->pluck('nama_produk', 'id_produk');
        $statusProduksi = StatusProduksi::all()->pluck('status', 'id_status');
        $user = User::all()->pluck('name', 'id');
        $satuan = Satuan::all()->pluck('satuan', 'id_satuan');
        $jenisproduksi = JenisProduksi::all()->pluck('jenis', 'id_jenisproduksi');

        return view('owner.index', compact('produk', 'user', 'statusProduksi', 'satuan', 'jenisproduksi'));
    }

    public function data()
    {
        $this->authorize('request_index');
        $produksibarang = ProduksiBarang::leftJoin('produk', 'produk.id_produk', '=', 'produksi_barang.id_produk')
            ->leftJoin('status_produksi', 'status_produksi.id_status', '=', 'produksi_barang.id_status')
            ->leftJoin('users', 'users.id', '=', 'produksi_barang.id_user')
            ->leftJoin('satuan', 'satuan.id_satuan', '=', 'produksi_barang.id_satuan')
            ->leftJoin('jenis_produksi', 'jenis_produksi.id_jenisproduksi', '=', 'produksi_barang.id_jenisproduksi')
            ->select('produksi_barang.*', 'produk.nama_produk', 'status_produksi.status', 'users.id', 'satuan.satuan', 'jenis_produksi.jenis')
            ->orderBy('created_at', 'asc');

        return datatables()
            ->of($produksibarang)
            ->addIndexColumn()

            ->addColumn('kode_produksi', function ($produksibarang) {
                return '<span class="label label-success">' . $produksibarang->kode_produksi . '</span>';
            })

            ->addColumn('jumlah', function ($produksibarang) {
                return format_uang($produksibarang->jumlah);
            })


            ->addColumn('status', function ($produksibarang) {
                if (is_null($produksibarang->id_status)) {
                    return  'masi menunggu konfirmasi';
                }
                return $produksibarang->status;
            })

            ->addColumn('aksi', function ($produksibarang) {
                return '
            <div class="">
                <button onclick="editForm(`' . route('owner.update', $produksibarang->id_produksi) . '`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-pencil"></i></button>
                <button onclick="deleteData(`' . route('owner.destroy', $produksibarang->id_produksi) . '`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
            </div>
            ';
            })
            ->rawColumns(['aksi', 'jumlah', 'kode_produksi'])
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
        try {
            $this->authorize('request_create');
            DB::beginTransaction();
            $produksibarang = ProduksiBarang::latest()->first() ?? new ProduksiBarang();
            $kode_produksi = (int) $produksibarang->kode_produksi + 1;

            $produksibarang = new produksibarang();
            $produksibarang->kode_produksi = kodeRequest('RQP');
            $produksibarang->id_produk = $request->id_produk;
            $produksibarang->jumlah = $request->jumlah;
            $produksibarang->id_satuan = $request->id_satuan;
            $produksibarang->id_status = null;
            $produksibarang->id_jenisproduksi = $request->id_jenisproduksi;
            $produksibarang->id_user = Auth::id();
            $produksibarang->batch = $request->batch;
            $produksibarang->save();

            // Notification to Produksi User
            $data = $produksibarang->load('produk', 'user');
            event(new PermintaanProduksiEvent($data));
            DB::commit();
            return response()->json('Data berhasil disimpan', 200);
        } catch (\Throwable $th) {
            DB::rollback();
            Log::error("tambah request produksi" . $th);
            return response()->json('gagal disimpan' . $th->getMessage(), 500);
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
        $this->authorize('request_edit');
        $produksibarang = ProduksiBarang::find($id);

        return response()->json($produksibarang);
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
        $this->authorize('request_edit');
        $produksibarang = ProduksiBarang::find($id);
        $produksibarang->update($request->all());

        return response()->json('Data Berhasil Disimpan', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('request_delete');
        $produksibarang = ProduksiBarang::find($id);
        $produksibarang->delete();

        return response(null, 204);
    }

    public function cetak()
    {
        $produksibarangs = ProduksiBarang::all(['produksi_barang']);
        $pdf = PDF::loadView('owner/cetak_owner', compact('produksibarangs'))->setPaper('a4', 'landscape');
        return $pdf->stream();
    }
}
