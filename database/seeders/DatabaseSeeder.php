<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\PermissionRegistrar;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        // nambah seeder
        // Hapus cache permission package spatie-permission
        // Artisan::call('php artisan permission:cache-reset');
        app(PermissionRegistrar::class)->forgetCachedPermissions();
        $this->call([
            StatusGudangProduksiSeeder::class,
            StatusGudangSeeder::class,
            StatusProduksiSeeder::class,
            SatuanSeeder::class,
            RoleSeeder::class,
            BahanPermissionSeeder::class,
            BarangMasukPermissionSeeder::class,
            DetailProduksiPermissionSeeder::class,
            GudangPermissionSeeder::class,
            KategoriPermissionSeeder::class,
            LabPermissionSeeder::class,
            LabProduksiPermissionSeeder::class,
            ProdukPermissionSeeder::class,
            ProduksiBarangPermissionSeeder::class,
            SupplierPermissionSeeder::class,
            UserPermissionSeeder::class,
            DumpInsertSeeder::class,

        ]);
    }
}
