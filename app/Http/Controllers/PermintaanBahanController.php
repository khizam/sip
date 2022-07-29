<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePermintaanBahan;
use App\Models\DetailProduksi;
use App\Models\PermintaanBahan;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PermintaanBahanController extends Controller
{
    public function insertIntoPermintaanBahan($idDetailProduksi)
    {
        try {
            $detail_produksi = DetailProduksi::find($idDetailProduksi);
            $data = [
                'id_detail_produksi' => $detail_produksi->id_detail,
                'jumlah_bahan' => $detail_produksi->jumlah,
            ];
            $permintaan = PermintaanBahan::create($data);
            return jsonResponse($permintaan, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return jsonResponse($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
