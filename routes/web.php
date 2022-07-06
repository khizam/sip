<?php
use App\Http\Controllers\{
    KategoriController,
    SupplierController,
    BahanController,
    ProdukController,
    BarangmasukController,
    LabController,
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
    Route::resource('/lab', LabController::class);
});
