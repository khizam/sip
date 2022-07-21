<?php

namespace Database\Seeders;

use App\Models\StatusGudangProduksi;
use Illuminate\Database\Seeder;

class StatusGudangProduksiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                
                'status'=>'belum di gudang produksi',
            ],
            [
                
                'status'=>'sudah di gudang produksi',
            ],
        ];
        StatusGudangProduksi::insert($data);
    }
}
