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
                'id_status'=>1,
                'status'=>'belum di gudang produksi',
            ],
            [
                'id_status'=> 2,
                'status'=>'sudah di gudang produksi',
            ],
        ];
        StatusGudangProduksi::insert($data);
    }
}
