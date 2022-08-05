<?php

namespace App\Http\Controllers;

use App\Models\Enums\StatusProduksiEnum;
use App\Models\StatusProduksi;
use App\Models\Satuan;
use App\Models\User;
use App\Models\Produk;
use App\Models\ProduksiBarang;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProduksiBarangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $produk = Produk::all()->pluck('nama_produk', 'id_produk');
        $statusProduksi = StatusProduksi::all()->pluck('status', 'id_status');
        $user = User::all()->pluck('name', 'id');
        $satuan = Satuan::all()->pluck('satuan', 'id_satuan');

        return view('produksi.index', compact('produk', 'user', 'statusProduksi', 'satuan'));
    }

    public function data()
    {
        $produksibarang = ProduksiBarang::leftJoin('produk', 'produk.id_produk', '=', 'produksi_barang.id_produk')
            ->leftJoin('status_produksi', 'status_produksi.id_status', '=', 'produksi_barang.id_status')
            ->leftJoin('users', 'users.id', '=', 'produksi_barang.id_user')
            ->leftJoin('satuan', 'satuan.id_satuan', '=', 'produksi_barang.id_satuan')
            ->select('produksi_barang.*', 'produk.nama_produk', 'status_produksi.status', 'users.id', 'satuan.satuan')
            ->orderBy('id_produksi', 'asc')
            ->get();

        return datatables()
            ->of($produksibarang)
            ->addIndexColumn()

            ->addColumn('jumlah', function ($produksibarang) {
                return format_uang($produksibarang->jumlah);
            })

            ->addColumn('status', function ($produksibarang) {
                if (is_null($produksibarang->id_status)) {
                    return 'masi menunggu persetujuan';
                }
                return $produksibarang->status;
            })

            ->addColumn('aksi', function ($produksibarang) {
                $html = '<div class="">';
            if (is_null($produksibarang->id_status)) {
                $html .= '<button onclick="terimaProduksiBarang(`' . route('produksi.terima_produksi', $produksibarang->id_produksi) . '`)" class="btn btn-xs btn-primary btn-flat"><i class="fa fa-check"></i></button>

                <button onclick="tolakProduksiBarang"(`' .route('produksi.tolak_produksi', $produksibarang->id_produksi) . '`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-ban"></i></button>';

            } else {
                $html .=
                '<button onclick="editForm(`' . route('produksi.update', $produksibarang->id_produksi) . '`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-pencil"></i></button>

                <button onclick="deleteData(`' . route('produksi.destroy', $produksibarang->id_produksi) . '`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>

                <a href=' . route('detailProduksi.index', $produksibarang->id_produksi) . ' class="btn btn-xs btn-primary btn-flat">detail produksi</a>';
            }
            $html .= '</div>';
            return $html;
        })
        ->rawColumns(['aksi', 'jumlah', 'kode_produksi'])
        ->make(true);
    }

    public function prosesProduksi(Request $request)
    {
        try {
            $produksi = ProduksiBarang::findOrFail($request->id_produksi);
            $produksi->update([
                'id_status' => StatusProduksiEnum::Proses,
            ]);
            $response = route('detailProduksi.index', $request->id_produksi);
            return jsonResponse($response);
        } catch (\Throwable $th) {
            return jsonResponse($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function tolakProduksiBahan(Request $request, $id_produksi)
    {
        try {
            $id_user = Auth::user();
            $produksibarang = ProduksiBarang::find($id_produksi);
            if ($produksibarang->count() == 0) {
                throw new NotFoundHttpException("Permintaan produksi tidak ditemukan");
            }
            $produksibarang->update([
                'keterangan' => $request->keterangan,
                'id_user_produksi' => $id_user->id,
            ]);
            return jsonResponse($produksibarang);
        } catch (NotFoundHttpException $th) {
            return jsonResponse($th->getMessage(), $th->getStatusCode() ?? Response::HTTP_INTERNAL_SERVER_ERROR);
        }catch (\Throwable $th) {
            return jsonResponse($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
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
        $produksibarang = ProduksiBarang::find($id);

        return response()->json($produksibarang);
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
        $produksibarang = ProduksiBarang::find($id);
        $produksibarang->delete();

        return response(null, 204);
    }
}
