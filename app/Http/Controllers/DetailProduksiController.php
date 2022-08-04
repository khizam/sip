<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateDetailRequest;
use App\Models\DetailProduksi;
use App\Models\Bahan;
use App\Models\Enums\StatusPermintaanBahanEnum;
use App\Models\ProduksiBarang;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class DetailProduksiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id_produksi = null)
    {
        $bahan = Bahan::all(['nama_bahan', 'id_bahan']);
        $data = [
            'bahan' => $bahan
        ];
        if (!is_null($id_produksi)) {
            $statusProduksi = ProduksiBarang::with('status')->findOrFail($id_produksi, ['id_status']);
            $data += [
                'statusProduksi' => $statusProduksi,
            ];
        }
        return view('detailProduksi.index', $data);
    }

    public function data($id_produksi)
    {
        $detailproduksi = DetailProduksi::leftJoin('permintaan_bahan', 'permintaan_bahan.id_detail_produksi', '=', 'detail_produksi.id_detail')
            ->leftJoin('bahan', 'bahan.id_bahan', '=', 'detail_produksi.id_bahan')
            ->select('detail_produksi.*', 'bahan.nama_bahan', 'permintaan_bahan.*')
            ->orderBy('id_detail', 'asc')
            ->where('id_produksi', $id_produksi)
            ->get();


        return datatables()
            ->of($detailproduksi)
            ->addIndexColumn()

            ->addColumn('jumlah', function ($detailproduksi) {
                return format_uang($detailproduksi->jumlah);
            })

            ->addColumn('permintaan_bahan', function ($detailProduksi) {
                return $this->generatePermintaanBahan($detailProduksi);
            })

            ->addColumn('aksi', function ($detailproduksi) {
                $html = '<div class="">';
                if (is_null($detailproduksi->id_request)) {
                    $html .= '<button onclick="editDetailForm(`' . route('detailProduksi.show', $detailproduksi->id_detail) . '` , `' . route('detailProduksi.update', $detailproduksi->id_detail) . '`)" class="btn btn-xs btn-primary btn-flat"><i class="fa fa-pencil"></i></button>';
                }
                if (
                    $detailproduksi->status == StatusPermintaanBahanEnum::Proses &&
                    is_null($detailproduksi->id_request)
                ) {
                    $html .= '<button onclick="deleteData(`' . route('detailProduksi.destroy', $detailproduksi->id_detail) . '`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>';
                }
                $html = '</div>';
                return $html;
            })
            ->rawColumns(['aksi', 'permintaan_bahan'])
            ->make(true);
    }

    public function generatePermintaanBahan($detailProduksi)
    {
        $html = '';
        if (is_null($detailProduksi->id_request)) {
            $html = '<button onclick="permintaanKeGudang(`' . route('permintaan_bahan.insert', $detailProduksi->id_detail) . '`)" class="btn btn-xs btn-primary btn-flat">request bahan ke gudang</button>';
        } elseif (
            (!is_null($detailProduksi->id_request)) &&
            is_null($detailProduksi->id_user_gudang)
        ) {
            $html = '<i style="padding: 2px"><b>Menunggu Konfirmasi dari Gudang</b></i>';
        } elseif (
            $detailProduksi->status != StatusPermintaanBahanEnum::Proses &&
            $detailProduksi->id_user_gudang != null
        ) {
            $html = '<i style="padding: 2px"><b> Permintaan di' . $detailProduksi->status . '</b></i>';
        }

        return $html;
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
            DB::beginTransaction();
            $detailproduksi = new DetailProduksi();
            $detailproduksi->id_bahan = $request->id_bahan;
            $detailproduksi->jumlah = $request->jumlah;
            $detailproduksi->id_produksi = $request->id_produksi;
            $detailproduksi->save();
            DB::commit();
            return redirect()->route('detailProduksi.index', $request->id_produksi);
        } catch (\Throwable $th) {
            DB::rollback();
            Log::error("tambah request detail produksi" . $th);
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
        try {
            $detailproduksi = DetailProduksi::with('bahan')->find($id);
            if ($detailproduksi == null) {
                throw new NotFoundHttpException('detail tidak ditemukan');
            }
            return jsonResponse($detailproduksi);
        } catch (AuthorizationException $th) {
            return jsonResponse($th->getMessage(), Response::HTTP_FORBIDDEN);
        } catch (NotFoundHttpException $th) {
            return jsonResponse($th->getMessage(), $th->getStatusCode() ?? Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (\Throwable $th) {
            return jsonResponse($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDetailRequest $request, DetailProduksi $detailProduksi)
    {
        try {
            $detailProduksi->update($request->validated());
            return jsonResponse($detailProduksi);
        } catch (AuthorizationException $th) {
            return jsonResponse($th->getMessage(), Response::HTTP_FORBIDDEN);
        } catch (NotFoundHttpException $th) {
            return jsonResponse($th->getMessage(), $th->getStatusCode() ?? Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (\Throwable $th) {
            return jsonResponse($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(DetailProduksi $detailProduksi)
    {
        try {
            $detailProduksi->delete();
            return jsonResponse('', Response::HTTP_NO_CONTENT);
        } catch (AuthorizationException $th) {
            return jsonResponse($th->getMessage(), Response::HTTP_FORBIDDEN);
        } catch (NotFoundHttpException $th) {
            return jsonResponse($th->getMessage(), $th->getStatusCode() ?? Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (\Throwable $th) {
            return jsonResponse($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
