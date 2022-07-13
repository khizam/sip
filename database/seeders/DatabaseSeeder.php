<?php

namespace Database\Seeders;

use App\Models\Bahan;
use App\Models\Kategori;
use App\Models\Produk;
use App\Models\StatusGudangProduksi;
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
        User::firstOrCreate([
            'name' => 'user 1',
            'email'=>'user@gmail.com',
            'password'=> bcrypt('123')
        ]);
        Produk::firstOrCreate([
            'nama_produk'=>'nike'
        ]);
        Supplier::firstOrCreate([
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
        $this->call([
            StatusGudangSeeder::class,
            StatusProduksiSeeder::class,
            StatusGudangProduksiSeeder::class,
        ]);
    }
}
