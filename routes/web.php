<?php

use App\Events\OwnerProductRequestEvent;
use App\Events\Testing;
use App\Http\Controllers\{
    KategoriController,
    SupplierController,
    BahanController,
    ProdukController,
    BarangmasukController,
    LabController,
    GudangController,
    LogActivityController,
    NotificationController,
    UserController,
    OwnerController,
    ProduksiBarangController,
};
use App\Models\Enums\StatusProduksiEnum;
use App\Models\ProduksiBarang;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('home');
    })->name('dashboard');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/kategori/data', [KategoriController::class, 'data'])->name('kategori.data');
    Route::resource('/kategori', KategoriController::class);

    Route::get('/supplier/data', [SupplierController::class, 'data'])->name('supplier.data');
    Route::resource('/supplier', SupplierController::class);

    Route::get('/bahan/data', [BahanController::class, 'data'])->name('bahan.data');
    Route::resource('/bahan', BahanController::class);

    Route::get('/produk/data', [ProdukController::class, 'data'])->name('produk.data');
    Route::resource('/produk', ProdukController::class);

    Route::get('/barangmasuk/data', [BarangmasukController::class, 'data'])->name('barangmasuk.data');
    Route::resource('/barangmasuk', BarangmasukController::class);

    Route::get('/lab/data', [LabController::class, 'data'])->name('lab.data');
    Route::get('/lab/edit-lab/{id}', [LabController::class, 'editLab'])->name('lab.editLab');
    Route::put('/lab/update-lab/{id}', [LabController::class, 'updateLab'])->name('lab.updateLab');
    Route::put('/lab/check-status/{id}', [LabController::class, 'checkStatus'])->name('lab.checkStatus');
    Route::get('/lab/cetak_pdf', [LabController::class, 'printPdfLab']);
    Route::resource('/lab', LabController::class);

    Route::get('/gudang/data', [GudangController::class, 'data'])->name('gudang.data');
    Route::get('/gudang/edit-gudang/{id}', [GudangController::class, 'editGudang'])->name('gudang.editGudang');
    Route::resource('/gudang', GudangController::class);

    // Route User
    Route::get('/user/data',[UserController::class,'data'])->name('user.data');
    Route::resource('/user', UserController::class);

    Route::get('/owner/data',[OwnerController::class,'data'])->name('owner.data');
    Route::resource('/owner', OwnerController::class);

    Route::get('/produksi/data', [ProduksiBarangController::class,'data'])->name('produksi.data');
    Route::resource('/produksi', ProduksiBarangController::class);

    Route::get('logs',[LogActivityController::class, 'index'])->name('log.activity_user');
    Route::get('logs/data',[LogActivityController::class, 'data'])->name('log.activity_data');
    Route::get('logs/delete/all',[LogActivityController::class, 'delete'])->name('log.delete_all');

    Route::get('notifications/user', [NotificationController::class,'index'])->name('notifications.index');
});
Route::get('pusher/test', function () {
    event(new Testing('Broadcasting testing'));
    return "berhasil";
});
Route::get('pusher/test/owner', function () {
    $produksibarang = new ProduksiBarang();
    $produksibarang->id_produk = 1;
    $produksibarang->jumlah = 1;
    $produksibarang->id_satuan = 1;
    $produksibarang->id_status = StatusProduksiEnum::Belum;
    $produksibarang->id_user = 1;
    $produksibarang->save();
    $data = $produksibarang->load('produk','user');
    event(new OwnerProductRequestEvent($data));
    return "berhasil";
});
