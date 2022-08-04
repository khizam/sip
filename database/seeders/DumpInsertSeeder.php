<?php

namespace Database\Seeders;

use App\Models\Bahan;
use App\Models\Enums\RolesEnum;
use App\Models\Kategori;
use App\Models\Produk;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Database\Seeder;

class DumpInsertSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $owner = User::firstOrCreate([
            'name' => 'owner',
            'email' => 'owner@gmail.com',
            'password' => bcrypt('123')
        ]);
        $lab = User::firstOrCreate([
            'name' => 'lab',
            'email' => 'lab@gmail.com',
            'password' => bcrypt('123')
        ]);
        $produksi = User::firstOrCreate([
            'name' => 'produksi',
            'email' => 'produksi@gmail.com',
            'password' => bcrypt('123')
        ]);
        $gudang = User::firstOrCreate([
            'name' => 'gudang',
            'email' => 'gudang@gmail.com',
            'password' => bcrypt('123')
        ]);
        $inventoryAlat = User::firstOrCreate([
            'name' => 'Inventory alat',
            'email' => 'inventoryalat@gmail.com',
            'password' => bcrypt('123')
        ]);
        // Assign Role
        $owner->assignRole(RolesEnum::Owner);
        $lab->assignRole(RolesEnum::Lab);
        $produksi->assignRole(RolesEnum::Produksi);
        $gudang->assignRole(RolesEnum::Gudang);
        $inventoryAlat->assignRole(RolesEnum::InventoryAlat);

        Produk::firstOrCreate([
            'nama_produk' => 'nike'
        ]);
        Supplier::firstOrCreate([
            'nama_supplier' => 'PT BENKA NUSANTARA',
            'alamat' => 'jl samudra surabaya',
            'telepon' => '0221098664',
            'contact_person' => '082234554330'
        ]);
        Kategori::firstOrCreate([
            'nama_kategori' => 'sepatu',
        ]);
        Bahan::firstOrCreate([
            'nama_bahan' => 'kain',
            'id_satuan' => 1
        ]);
    }
}
