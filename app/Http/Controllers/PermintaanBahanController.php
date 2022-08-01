<?php

namespace App\Http\Controllers;

use App\Models\DetailProduksi;
use App\Models\Enums\StatusPermintaanBahanEnum;
use App\Models\PermintaanBahan;
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
                'status' => StatusPermintaanBahanEnum::Proses,
            ];
            $permintaan = PermintaanBahan::create($data);
            return jsonResponse($permintaan, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return jsonResponse($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
