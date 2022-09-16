<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barangmasuk;
use App\Models\Lab;
use App\Models\LabProduksi;
use App\Models\Gudang;
use App\Models\ProduksiBarang;
use App\Models\PermintaanBahan;
use App\Models\GudangProdukJadi;
use App\Models\Activity;


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
}
