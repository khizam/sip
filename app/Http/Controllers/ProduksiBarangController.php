<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use App\Models\DetailProduksi;
use App\Models\JenisProduksi;
use Illuminate\Auth\Access\AuthorizationException;
use App\Models\Enums\StatusPermintaanBahanEnum;
use App\Models\Enums\StatusProduksiEnum;
use App\Models\LabProduksi;
use App\Models\StatusProduksi;
use App\Models\Satuan;
use App\Models\User;
use App\Models\Produk;
use App\Models\ProduksiBarang;
use App\Models\PermintaanBahan;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\HttpException;
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
            ->leftJoin('jenis_produksi', 'jenis_produksi.id_jenisproduksi', '=', 'produksi_barang.id_jenisproduksi')
            ->leftJoin('users', 'users.id', '=', 'produksi_barang.id_user')
            ->leftJoin('satuan', 'satuan.id_satuan', '=', 'produksi_barang.id_satuan')
            ->select('produksi_barang.*', 'produk.nama_produk', 'status_produksi.status', 'users.id', 'satuan.satuan', 'jenis_produksi.jenis')
            ->orderBy('id_produksi', 'asc');

        return datatables()
            ->of($produksibarang)
            ->addIndexColumn()
            ->addColumn('jumlah_hasil_produksi', function ($produksibarang) {
                $hasil_produksi = format_uang($produksibarang->jumlah_hasil_produksi);
                if (is_null($hasil_produksi)) {
                    $hasil_produksi = '-';
                }
                return $hasil_produksi;
            })
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
                    <button onclick="tolakProduksiBarang(`' . route('produksi.tolak_produksi', $produksibarang->id_produksi) . '`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-ban"></i></button>';
                } elseif ($produksibarang->id_status == StatusProduksiEnum::Tolak) {
                    $html .= '<b><i>Produksi ditolak</i></b>';
                } elseif ($produksibarang->id_status == StatusProduksiEnum::Terima) {
                    $html .= '<button onclick="editForm(`' . route('produksi.update', $produksibarang->id_produksi) . '`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-pencil"></i></button>
                    <button onclick="deleteData(`' . route('produksi.destroy', $produksibarang->id_produksi) . '`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
                    <a href=' . route('detailProduksi.index', $produksibarang->id_produksi) . ' class="btn btn-xs btn-primary btn-flat">detail produksi</a>
                    ';
                } elseif ($produksibarang->id_status == StatusProduksiEnum::Proses) {
                    $html .= '<button onclick="selesaiProduksiBarang(`' . route('produksi.selesai_produksi', $produksibarang->id_produksi) . '`)" class="btn btn-xs btn-success btn-flat"><i class="fa fa-check"></i></button>
                    <a href=' . route('detailProduksi.index', $produksibarang->id_produksi) . ' class="btn btn-xs btn-primary btn-flat">detail produksi</a>
                    <a href=' . route('batchDetail.index', $produksibarang->id_produksi) . ' class="btn btn-xs btn-primary btn-flat">Batch</a>
                    <a href="' . route('produksi.printByProduksi', $produksibarang->id_produksi) . '" target="_blank" class="btn btn-xs btn-warning btn-flat ml-1"><i class="fa  fa-print"></i></button>
                    ';
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
            // Cek Bahan di detail produksi
            $bahan = DetailProduksi::where('id_produksi', $request->id_produksi)->get();
            if ($bahan->isEmpty()) {
                throw new NotFoundHttpException("Bahan produksi belum dimasukkan");
            }
            // Cek Apakah ada request bahan
            $bahan->load('permintaanBahan')->each(function ($item) {
                if (is_null($item->permintaanBahan)) {
                    throw new NotFoundHttpException("Selesaikan permintaan bahan ke gudang");
                } else {
                    if ($item->permintaanBahan->status == StatusPermintaanBahanEnum::Proses) {
                        throw new NotFoundHttpException("Permintaan bahan menunggu persetujuan gudang");
                    }
                }
            });
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
            $produksibarang = ProduksiBarang::find($id_produksi);
            if ($produksibarang->count() == 0) {
                throw new NotFoundHttpException("Permintaan produksi tidak ditemukan");
            }
            $produksibarang->update([
                'keterangan' => $request->keterangan,
                'id_status' => StatusProduksiEnum::Tolak,
            ]);
            return jsonResponse($produksibarang);
        } catch (NotFoundHttpException $th) {
            return jsonResponse($th->getMessage(), $th->getStatusCode() ?? Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (\Throwable $th) {
            return jsonResponse($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function selesaiProduksiBahan(Request $request, $id_produksi)
    {
        try {
            DB::beginTransaction();
            $produksibarang = ProduksiBarang::find($id_produksi);
            $jumlahHasilProduksi = $request->jumlah_hasil_produksi;
            if ($jumlahHasilProduksi > $produksibarang->jumlah) {
                throw new HttpException(Response::HTTP_INTERNAL_SERVER_ERROR, "Jumlah produksi tidak lebih dari " . $produksibarang->jumlah);
            }
            if ($produksibarang->count() == 0) {
                throw new NotFoundHttpException("Permintaan produksi tidak ditemukan");
            }
            $produksibarang->update([
                'jumlah_hasil_produksi' => $jumlahHasilProduksi,
            ]);
            $produksiItem = LabProduksi::where('id_produksi', $id_produksi)->first();
            $dataLab = [
                'jumlah_produksi' => $jumlahHasilProduksi,
                'lost' => null
            ];
            if (is_null($produksiItem)) {
                $dataLab += [
                    'id_produksi' => $id_produksi,

                ];
                LabProduksi::create($dataLab);
            } else {
                $produksiItem->update($dataLab);
            }
            DB::commit();
            return jsonResponse($produksibarang);
        } catch (NotFoundHttpException $th) {
            DB::rollback();
            return jsonResponse($th->getMessage(), $th->getStatusCode() ?? Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (\Throwable $th) {
            DB::rollback();
            return jsonResponse($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function terimaProduksiBahan(Request $request, $id_produksi)
    {
        try {
            $produksibarang = ProduksiBarang::find($id_produksi);
            if ($produksibarang->count() == 0) {
                throw new NotFoundHttpException("Permintaan produksi tidak ditemukan");
            }
            $produksibarang->update([
                'keterangan' => 'Proses produksi',
                'id_status' => StatusProduksiEnum::Terima,
            ]);
            //  Tambahkan Batch
            for ($i = 1; $i <= $produksibarang->batch; $i++) {
                Batch::create([
                    'nama_batch' => 'BATCH ' . $i,
                    'id_produksi' => $id_produksi,
                    'id_status' => 1,
                    'jumlah_batch' => $produksibarang->jumlah / $produksibarang->batch
                ]);
            }
            return jsonResponse($produksibarang);
        } catch (NotFoundHttpException $th) {
            return jsonResponse($th->getMessage(), $th->getStatusCode() ?? Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (\Throwable $th) {
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

    public function printByProduksi($id_produksi)
    {
        $produksibarang = ProduksiBarang::with(['produk','jenis_produksi','user','satuan','detailProduksi.bahan',
        'detailProduksi.produksi', 'status', 'detail_Produksi.permintaan_bahan'])->where('id_produksi', $id_produksi)->first();

        return view('produksi.print', compact('produksibarang'));
    }
}
