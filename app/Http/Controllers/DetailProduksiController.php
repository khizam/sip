<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateDetailRequest;
use App\Models\DetailProduksi;
use App\Models\Bahan;
use App\Models\ProduksiBarang;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DetailProduksiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bahan = Bahan::all()->pluck('nama_bahan', 'id_bahan');
        return view('detailProduksi.index', compact('bahan'));
    }

    public function data($id_produksi)
    {
        $detailproduksi = DetailProduksi::leftJoin('bahan', 'bahan.id_bahan', '=', 'detail_produksi.id_bahan')
        ->select('detail_produksi.*', 'bahan.nama_bahan')
        ->orderBy('id_detail', 'asc')
        ->where('id_produksi', $id_produksi)
        ->get();

        return datatables()
        ->of($detailproduksi)
        ->addIndexColumn()

        ->addColumn('jumlah', function ($detailproduksi) {
            return format_uang($detailproduksi->jumlah);
        })

        ->addColumn('permintaan_bahan', function ($detailproduksi) {
            return 'masih dikosongin zam';
        })

        // 1. buat migration request
        // 2. join detail_produksi dan permintaan_bahan yang dijoinkan id_detail dengan detail_bahan_produksi
        // 3. permintaan bahan yg dicek id_request jika null muncul tombol jika ada id_request munculkan nama default


        ->addColumn('aksi', function ($detailproduksi) {
            return '
            <div class="">
            <button onclick="editDetailForm(`'. route('detailProduksi.editDetail', $detailproduksi->id_detail) .'` , `'.route('detailProduksi.updateDetail', $detailproduksi->id_detail).'`)" class="btn btn-xs btn-primary btn-flat"><i class="fa fa-pencil"></i></button>
            <button onclick="deleteData(`'. route('detailProduksi.destroy', $detailproduksi->id_detail) .'`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
            </div>
            ';
        })
        ->rawColumns(['aksi'])
        ->make(true);
    }

    public function create()
    {

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
            return redirect()->route('detailProduksi.show',$request->id_produksi);
        } catch (\Throwable $th) {
            DB::rollback();
            Log::error("tambah request detail produksi".$th);
            return response()->json('gagal disimpan'.$th->getMessage(), 500);
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
            $detailproduksi = DetailProduksi::find($id);
            if ($detailproduksi == null) {
                throw new NotFoundHttpException('detail produksi tidak ditemukan');
            }
        } catch (AuthorizationException $th) {
            return jsonResponse($th->getMessage(), Response::HTTP_FORBIDDEN);
        } catch (NotFoundHttpException $th) {
            return jsonResponse($th->getMessage(), $th->getStatusCode() ?? Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (\Throwable $th) {
            return jsonResponse($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function showbahan($id_detail)
    {
        $bahan = Bahan::all();
        return view('detailProduksi.index', compact('bahan'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editDetail($id)
    {
        try {

            $detailproduksi = DetailProduksi::with('detail.bahan', 'detail.produk')->find($id);
            if($detailproduksi == null) {
                throw new NotFoundHttpException("Detail barang tidak ditemukan");
            }
            return jsonResponse($detailproduksi, 200);
        } catch (AuthorizationException $th) {
            return jsonResponse($th->getMessage(), Response::HTTP_FORBIDDEN);
        } catch (NotFoundHttpException $th) {
            return jsonResponse($th->getMessage(), $th->getStatusCode() ?? Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (\Throwable $th) {
            echo "authorization throwable";
            return jsonResponse($th->getMessage() ?? 'data tidak ditemukan', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function updateDetail(UpdateDetailRequest $request, $id): JsonResponse
    {
        try {
            $detailproduksi = DetailProduksi::find($id);
            if ($detailproduksi == null) {
                throw new NotFoundHttpException("Barang tidak ditemukan");
            }
            $detailproduksi->update($request->validated());
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
    public function update(Request $request, $id)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }

}
