<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bahan;
use App\Models\Enums\StatusPermintaanBahanEnum;
use App\Models\PermintaanBahan;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class GudangRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('gudang_request.index');
    }

    public function data()
    {
        $permintaanBahan = PermintaanBahan::leftJoin('detail_produksi', 'permintaan_bahan.id_detail_produksi', '=', 'detail_produksi.id_detail')
            ->leftJoin('bahan', 'bahan.id_bahan', '=', 'detail_produksi.id_bahan')
            ->select('detail_produksi.*', 'bahan.nama_bahan', 'permintaan_bahan.*')
            ->orderBy('id_detail', 'asc')
            // ->where('id_produksi')
            ->get();

        return datatables()
            ->of($permintaanBahan)
            ->addIndexColumn()

            ->addColumn('jumlah', function ($permintaanBahan) {
                return format_uang($permintaanBahan->jumlah);
            })

            ->addColumn('aksi', function ($permintaanBahan) {
                $html = '<div class="">';
                if (
                    is_null($permintaanBahan->id_user_gudang) &&
                    $permintaanBahan->status == StatusPermintaanBahanEnum::Proses
                ){
                    $html .= '<button onclick="terimaPermintaanKeGudang(`' . route('gudang_request.terima_permintaan', $permintaanBahan->id_request) . '`)" class="btn btn-xs btn-primary btn-flat"><i class="fa fa-check"></i></button>

                    <button onclick="tolakPermintaanKeGudang(`' . route('gudang_request.tolak_permintaan', $permintaanBahan->id_request) . '` )" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-ban"></i></button>';

                } else {
                    $html .= 'Permintaan bahan di' . $permintaanBahan->status;
                }
                $html .= '</div>';
                return $html;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }


    public function terimaPermintaanBahan($id_request)
    {
        try {
            $id_user = Auth::user();
            $permintaanBahan = PermintaanBahan::find($id_request);
            if ($permintaanBahan->count() == 0) {
                throw new NotFoundHttpException("Permintaan Bahan tidak ditemukan");
            }
            $permintaanBahan->update([
                'id_user_gudang' => $id_user->id,
                'status' => StatusPermintaanBahanEnum::Terima,
                'keterangan' => 'bahan sesuai dengan permintaan'
                // 'satuan' => $

            ]);
            return jsonResponse($permintaanBahan);
        } catch (NotFoundHttpException $th) {
            return jsonResponse($th->getMessage(), $th->getStatusCode() ?? Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (\Throwable $th) {
            return jsonResponse($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function tolakPermintaanBahan(Request $request, $id_request)
    {
        try {
            $id_user = Auth::user();
            $permintaanBahan = PermintaanBahan::find($id_request);
            if ($permintaanBahan->count() == 0) {
                throw new NotFoundHttpException("Permintaan Bahan tidak ditemukan");
            }
            $permintaanBahan->update([
                'id_user_gudang' => $id_user->id,
                'status' => StatusPermintaanBahanEnum::Tolak,
                'keterangan' => $request->keterangan,
            ]);
            return jsonResponse($permintaanBahan);
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
    public function show()
    {

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
