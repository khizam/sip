<?php

namespace Database\Seeders;

use App\Models\Bahan;
use App\Models\Kategori;
use App\Models\Produk;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Database\Seeder;

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
        User::firstOrNew([
            'name' => 'user 1',
            'email'=>'user@gmail.com',
            'password'=> bcrypt('123')
        ]);
        Produk::firstOrNew([
            'nama_produk'=>'nike'
        ]);
        Supplier::firstOrNew([
            'nama_supplier'=>'PT BENKA NUSANTARA',
            'alamat'=>'jl samudra surabaya',
            'telepon'=> '081456338765',
        ]);
        Kategori::firstOrNew([
            'nama_kategori'=>'sepatu',
        ]);
        Bahan::firstOrNew([
            'nama_bahan'=>'kain',
        ]);
    }
}
