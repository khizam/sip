<?php

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
    GudangRequestController,
    SatuanController,
    GradeController,
    GradeLabProduksiController,
    GudangProdukJadiController,
    PeralatanKerjaController,
    LabProduksiController,
    ParameterController,
    KemasanController,
    ParameterLabController,
    JenisProduksiController,
    DashboardController,
    BatchController,
};
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
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('home');
    })->name('dashboard');
});


Route::group(['middleware' => 'auth'], function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('dashboard/total-data', [DashboardController::class, 'data'])
        ->name('dashboard.total.data');

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

    Route::get('/satuan/data', [SatuanController::class, 'data'])
        ->name('satuan.data');
    Route::resource('/satuan', SatuanController::class);

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
    Route::get('/lab/cetak_pdf', [LabController::class, 'printPdfLab'])->name('lab.cetakAll');
    Route::get('/lab/cetak/{id_lab}', [LabController::class, 'printByLab'])->name('lab.printByLab');
    Route::resource('/lab', LabController::class);


    Route::resource('/detailParameter', ParameterLabController::class)
        ->except('index')
        ->names('detailParameter');
    Route::get('/detailParameter/index/{id_lab?}', [ParameterLabController::class, 'index'])
        ->name('detailParameter.index');
    Route::get('/detailParameter/data/{id_lab}', [ParameterLabController::class, 'data'])
        ->name('detailParameter.data');
    Route::put('/detailParameter/update-detail/{id}', [ParameterLabController::class, 'updateDetail'])
        ->name('detailParameter.updateDetail');

    Route::get('/gudang/data', [GudangController::class, 'data'])
        ->name('gudang.data');
    Route::get('/gudang/edit-gudang/{id}', [GudangController::class, 'editGudang'])
        ->name('gudang.editGudang');
    Route::resource('/gudang', GudangController::class);

    Route::get('/gudang_request/data', [GudangRequestController::class, 'data'])
        ->name('gudang_request.data');
    Route::get('/gudang_request', [GudangRequestController::class, 'index'])
        ->name('gudang_request.index');
    Route::put('/gudang_request/terima/{id_request}', [GudangRequestController::class, 'terimaPermintaanBahan'])
        ->name('gudang_request.terima_permintaan');
    Route::put('/gudang_request/tolak/{id_request}', [GudangRequestController::class, 'tolakPermintaanBahan'])
        ->name('gudang_request.tolak_permintaan');

    // Route User
    Route::get('/user/data', [UserController::class, 'data'])
        ->name('user.data');
    Route::resource('/user', UserController::class);

    Route::get('/owner/data', [OwnerController::class, 'data'])
        ->name('owner.data');
    Route::get('/owner/cetak_owner', [OwnerController::class, 'cetak']);
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

    Route::get('/labProduksi/data', [LabProduksiController::class, 'data'])
        ->name('labProduksi.data');
    Route::resource('/labProduksi', LabProduksiController::class);

    Route::get('/produksibarang/data', [ProduksiBarangController::class, 'data'])
        ->name('produksibarang.data');

    Route::put('/produksi/terima/{id_produksi}', [ProduksiBarangController::class, 'terimaProduksiBahan'])
        ->name('produksi.terima_produksi');
    Route::put('/produksi/tolak/{id_produksi}', [ProduksiBarangController::class, 'tolakProduksiBahan'])
        ->name('produksi.tolak_produksi');
    Route::put('/produksi/selesai/{id_produksi}', [ProduksiBarangController::class, 'selesaiProduksiBahan'])
        ->name('produksi.selesai_produksi');
    Route::get('/produksi/jumlah-produksi/{id_produksi}', [ProduksiBarangController::class, 'showJumlahProduksi'])
        ->name('produksi.showJumlahProduksi');
    Route::get('/produksi/cetak_pdf', [ProduksiBarangController::class, 'printPdfProduksi'])->name('produksi.cetakAll');
    Route::get('/produksi/cetak/{id_produksi}', [ProduksiBarangController::class, 'printByProduksi'])->name('produksi.printByProduksi');
    Route::resource('/produksi', ProduksiBarangController::class);


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

    Route::post('/produksi/proses-produksi', [ProduksiBarangController::class, 'prosesProduksi'])
        ->name('produksi.proses_produksi');

    Route::get('/grade/data', [GradeController::class, 'data'])
        ->name('grade.data');
    Route::resource('grade', GradeController::class);

    Route::get('/peralatanKerja/data', [PeralatanKerjaController::class, 'data'])
        ->name('peralatanKerja.data');
    Route::resource('peralatanKerja', PeralatanKerjaController::class);

    Route::get('/lab-produksi/data', [LabProduksiController::class, 'data'])
        ->name('lab-produksi.data');
    Route::resource('/lab-produksi', LabProduksiController::class)
        ->names('lab-produksi');
    Route::get('/lab-produksi/grade/{id_produksi}', [LabProduksiController::class, 'halGrade'])
        ->name('lab-produksi.halGrade');
    Route::put('/lab-produksi/selesai/{id_labproduksi}', [LabProduksiController::class, 'selesaiLost'])
        ->name('lab-produksi.selesai_lost');



    Route::resource('/grade-lab-produksi', GradeLabProduksiController::class)
        ->except('index')
        ->names('grade-lab-produksi');
    Route::get('/grade-lab-produksi/data/{id_produksi}', [GradeLabProduksiController::class, 'data'])
        ->name('grade-lab-produksi.data');
    Route::get('/grade-lab-produksi/index/{id_produksi?}', [GradeLabProduksiController::class, 'index'])
        ->name('grade-lab-produksi.index');

    Route::resource('gudang-produksi', GudangProdukJadiController::class)
        ->except('index')
        ->names('gudang_produksi');
    Route::get('gudangproduksi/data', [GudangProdukJadiController::class, 'data'])
        ->name('gudang_produksi.data');
    // Route::get('gudang-produksi', [GudangProdukJadiController::class, 'index'])
    //     ->name('gudang_produksi.index');

    Route::get('gudang-produksi', [GudangProdukJadiController::class, 'index'])
        ->name('gudang_produksi.index');

    Route::get('/parameter/data', [ParameterController::class, 'data'])
        ->name('parameter.data');
    Route::resource('/parameter', ParameterController::class);

    Route::get('/kemasan/data', [KemasanController::class, 'data'])
        ->name('kemasan.data');
    Route::resource('/kemasan', KemasanController::class);

    Route::get('/jenisproduksi/data', [JenisProduksiController::class, 'data'])
        ->name('jenisproduksi.data');
    Route::resource('/jenisproduksi', JenisProduksiController::class);

    // Route::get('/jenis_produksi/data', [JenisProduksiController::class, 'data'])
    //     ->name('jenis_produksi.data');
    // Route::resource('/jenis_produksi', JenisProduksiController::class);

    Route::get('/alatlab/data', [AlatLabController::class, 'data'])
        ->name('alatlab.data');
    Route::resource('/alatlab', AlatLabController::class);

    Route::resource('/batchDetail', BatchController::class)
        ->except('index')
        ->names('batch');
    Route::get('/batchDetail/index/{id_produksi?}', [BatchController::class, 'index'])
        ->name('batchDetail.index');
    Route::get('/batchDetail/data/{id_produksi}', [BatchController::class, 'data'])
        ->name('batchDetail.data');
});

