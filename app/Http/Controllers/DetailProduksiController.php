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
    public function index($id_produksi = null)
    {
        $bahan = Bahan::all(['nama_bahan', 'id_bahan']);
        return view('detailProduksi.index', compact('bahan'));
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

            // ->addColumn('permintaan_bahan', function ($detailproduksi) {
            //     return '
            //     <div class="">
            //         <a href=' . route('detailProduksi.index', $detailproduksi->id_detail) . ' class="btn btn-xs btn-success btn-flat"> permintaan Bahan </a>
            //     </div>
            //     ';
            ->addColumn('permintaan_bahan', function ($detailProduksi) {
                return $this->generatePermintaanBahan($detailProduksi);
            })


            // 1. buat migration request
            // 2. join detail_produksi dan permintaan_bahan yang dijoinkan id_detail dengan detail_bahan_produksi
            // 3. permintaan bahan yg dicek id_request jika null muncul tombol jika ada id_request munculkan nama default

            ->addColumn('aksi', function ($detailproduksi) {
                $html = '<div class="">';
                if (is_null($detailproduksi->id_request)) {
                    $html .= '<button onclick="editDetailForm(`' . route('detailProduksi.show', $detailproduksi->id_detail) . '` , `' . route('detailProduksi.update', $detailproduksi->id_detail) . '`)" class="btn btn-xs btn-primary btn-flat"><i class="fa fa-pencil"></i></button>';
                }
                $html .= '<button onclick="deleteData(`' . route('detailProduksi.destroy', $detailproduksi->id_detail) . '`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
                    </div>';
                return $html;
            })
<<<<<<< HEAD
            ->rawColumns(['aksi', 'jumlah', 'permintaan_bahan'])
=======
            ->rawColumns(['aksi', 'permintaan_bahan'])
>>>>>>> 662fc8ed07bf5a87b4bacf1da5b51f0bee205839
            ->make(true);
    }

    public function generatePermintaanBahan($detailProduksi)
    {
        $html = '';
        if (is_null($detailProduksi->id_request)) {
            $html = '<button onclick="permintaanKeGudang(`' . route('permintaan_bahan.insert', $detailProduksi->id_detail) . '`)" class="btn btn-xs btn-primary btn-flat">request bahan ke gudang</button>';
        } elseif (!is_null($detailProduksi->id_request) && is_null($detailProduksi->id_user_gudang)) {
            $html = '<i style="padding: 2px"><b>Menunggu Konfirmasi dari Gudang</b></i>';
        }
        return $html;
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
            return redirect()->route('detailProduksi.show', $request->id_produksi);
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
                throw new NotFoundHttpException('detail produksi tidak ditemukan');
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
