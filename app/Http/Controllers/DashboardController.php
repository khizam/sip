<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barangmasuk;
use App\Models\Lab;
use App\Models\LabProduksi;
use App\Models\Gudang;
use App\Models\ProduksiBarang;
use App\Models\PermintaanBahan;
use App\Models\Activity;
use App\Models\GudangProdukJadi;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $barangmasuk = Barangmasuk::count();
        $lab = Lab::count();
        $labproduksi = LabProduksi::count();
        $gudang = Gudang::count();
        $produksibarang = ProduksiBarang::count();
        $permintaanbahan = PermintaanBahan::count();
        $gudangprodukjadi = GudangProdukJadi::count();

        return view('home', compact('barangmasuk', 'lab', 'labproduksi', 'gudang', 'produksibarang', 'permintaanbahan', 'gudangprodukjadi'));
    }

    public function data()
    {
        $ttlProduk = GudangProdukJadi::Join('grade_lab_produksi', 'grade_lab_produksi.id_gradelab', '=', 'gudang_produk.id_gradelab')
            ->Join('grade', 'grade.id_grade', '=', 'grade_lab_produksi.id_grade')
            ->Join('produksi_barang', 'produksi_barang.id_produksi', '=', 'grade_lab_produksi.id_produksi')
            ->Join('produk', 'produk.id_produk', '=', 'produksi_barang.id_produk')
            ->select(DB::raw('SUM(grade_lab_produksi.jumlah_produk) as jumlah_count'), DB::raw('SUM(grade_lab_produksi.stok) as stok_count'), 'grade.nama_grade', 'grade.id_grade', 'produk.id_produk', 'produk.nama_produk',)
            ->groupBy('grade.id_grade', 'produk.id_produk')
            ->orderBy('produk.id_produk', 'ASC');

        return datatables()
            ->of($ttlProduk)
            ->addIndexColumn()
            ->make(true);
    }
}
