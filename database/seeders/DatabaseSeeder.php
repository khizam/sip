<?php

namespace Database\Seeders;

use App\Models\Bahan;
use App\Models\Enums\RolesEnum;
use App\Models\Kategori;
use App\Models\Produk;
use App\Models\Supplier;
use App\Models\User;
use App\Models\Satuan;
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
        // \App\Models\User::factory(10)->create();
        User::firstOrCreate([
            'name' => 'user 1',
            'email'=>'user@gmail.com',
            'password'=> bcrypt('123')
        ]);
        Produk::firstOrCreate([
            'nama_produk'=>'nike'
        ]);
        Supplier::Create([
            'nama_supplier'=>'PT BENKA NUSANTARA',
            'alamat'=>'jl samudra surabaya',
            'telepon'=> '0221098664',
            'contact_person' => '082234554330'
        ]);
        Kategori::firstOrCreate([
            'nama_kategori'=>'sepatu',
        ]);
        Bahan::firstOrCreate([
            'nama_bahan'=>'kain',
        ]);

        // nambah seeder
        // Hapus cache permission package spatie-permission
        // Artisan::call('php artisan permission:cache-reset');
        app(PermissionRegistrar::class)->forgetCachedPermissions();
        $this->call([
            RoleSeeder::class,
            StatusGudangProduksiSeeder::class,
            StatusGudangSeeder::class,
            StatusProduksiSeeder::class,
            SatuanSeeder::class,
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