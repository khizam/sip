<?php

use App\Events\OwnerProductRequestEvent;
use App\Events\Testing;
use App\Http\Controllers\{
    KategoriController,
    SupplierController,
    BahanController,
    ProdukController,
    BarangmasukController,
    DetailProduksiController,
    LabController,
    GudangController,
    LogActivityController,
    NotificationController,
    UserController,
    OwnerController,
    PermintaanBahanController,
    ProduksiBarangController,
};
use App\Models\Enums\StatusProduksiEnum;
use App\Models\ProduksiBarang;
use Illuminate\Support\Facades\Auth;
use App\Models\DetailProduksi;
use App\Models\User;
use Illuminate\Support\Facades\Request;
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
    Route::get('/kategori/data', [KategoriController::class, 'data'])
        ->name('kategori.data');
    Route::resource('/kategori', KategoriController::class);

    Route::get('/supplier/data', [SupplierController::class, 'data'])
        ->name('supplier.data');
    Route::resource('/supplier', SupplierController::class);

    Route::get('/bahan/data', [BahanController::class, 'data'])
        ->name('bahan.data');
    Route::resource('/bahan', BahanController::class);

    Route::get('/produk/data', [ProdukController::class, 'data'])
        ->name('produk.data');
    Route::resource('/produk', ProdukController::class);

    Route::get('/barangmasuk/data', [BarangmasukController::class, 'data'])
        ->name('barangmasuk.data');
    Route::resource('/barangmasuk', BarangmasukController::class);

    Route::get('/lab/data', [LabController::class, 'data'])
        ->name('lab.data');
    Route::get('/lab/edit-lab/{id}', [LabController::class, 'editLab'])
        ->name('lab.editLab');
    Route::put('/lab/update-lab/{id}', [LabController::class, 'updateLab'])
        ->name('lab.updateLab');
    Route::put('/lab/check-status/{id}', [LabController::class, 'checkStatus'])
        ->name('lab.checkStatus');
    Route::get('/lab/cetak_pdf', [LabController::class, 'printPdfLab']);
    Route::resource('/lab', LabController::class);

    Route::get('/gudang/data', [GudangController::class, 'data'])
        ->name('gudang.data');
    Route::get('/gudang/edit-gudang/{id}', [GudangController::class, 'editGudang'])
        ->name('gudang.editGudang');
    Route::resource('/gudang', GudangController::class);

    // Route User
    Route::get('/user/data', [UserController::class, 'data'])
        ->name('user.data');
    Route::resource('/user', UserController::class);

    Route::get('/owner/data', [OwnerController::class, 'data'])
        ->name('owner.data');
    Route::resource('/owner', OwnerController::class);

    Route::resource('/detailProduksi', DetailProduksiController::class)
        ->except('index')
        ->names('detailProduksi');
    Route::get('/detailProduksi/index/{id_produksi?}', [DetailProduksiController::class, 'index'])
        ->name('detailProduksi.index');
    Route::get('/detailProduksi/data/{id_produksi}', [DetailProduksiController::class, 'data'])
        ->name('detailProduksi.data');
    Route::put('/detailProduksi/update-detail/{id}', [DetailProduksiController::class, 'updateDetail'])
        ->name('detailProduksi.updateDetail');

    Route::get('/produksibarang/data', [ProduksiBarangController::class, 'data'])
        ->name('produksibarang.data');
    Route::put('/produksi/check-status/{id}', [detailProduksiController::class, 'data'])
        ->name('produksi.checkStatus');
    Route::resource('/produksi', ProduksiBarangController::class);

    Route::get('logs', [LogActivityController::class, 'index'])
        ->name('log.activity_user');
    Route::get('logs/data', [LogActivityController::class, 'data'])
        ->name('log.activity_data');
    Route::get('logs/delete/all', [LogActivityController::class, 'delete'])
        ->name('log.delete_all');

    Route::get('notifications/user', [NotificationController::class, 'index'])
        ->name('notifications.index');
    Route::get('/notifications/{read_at?}', [NotificationController::class, 'show'])
        ->name('notifications.show');
    Route::get('/notifications/mark-as-read/{notifications}/{redirect?}', [NotificationController::class, 'markAsRead'])
        ->name('notifications.markAsRead');

    Route::post('/permintaan-bahan/{id_detail_produksi}', [PermintaanBahanController::class, 'insertIntoPermintaanBahan'])
        ->name('permintaan_bahan.insert');
});
