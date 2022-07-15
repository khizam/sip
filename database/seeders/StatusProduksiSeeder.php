<?php

namespace Database\Seeders;

use App\Models\StatusProduksi;
use Illuminate\Database\Seeder;

class StatusProduksiSeeder extends Seeder
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
                'status'=>'belum diproduksi',
            ],
            [
                'id_status'=> 2,
                'status'=>'proses diproduksi',
            ],
            [
                'id_status'=> 3,
                'status'=>'selesai diproduksi',
            ],
        ];
        StatusProduksi::insert($data);
    }
}