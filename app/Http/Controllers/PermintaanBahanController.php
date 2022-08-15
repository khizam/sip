<?php

namespace App\Http\Controllers;

use App\Events\PermintaanBahanEvent;
use App\Events\RequestBahanToGudangEvent;
use App\Models\DetailProduksi;
use App\Models\Enums\StatusPermintaanBahanEnum;
use App\Models\Gudang;
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
            // $gudang = Gudang::where('id_lab', $detail_produksi->id_bahan)->first();
            // $stok = $gudang->stok;
            // $kurangiStok = $stok - $detail_produksi->jumlah;
            // $gudang->update([
            //     'stok' => $kurangiStok,
            // ]);
            event(new PermintaanBahanEvent($permintaan));
            return jsonResponse($permintaan, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return jsonResponse($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
