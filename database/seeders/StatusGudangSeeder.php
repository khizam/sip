<?php

namespace Database\Seeders;

use App\Models\StatusGudang;
use Illuminate\Database\Seeder;

class StatusGudangSeeder extends Seeder
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
                'status'=>'belum di gudang',
            ],
            [
                'id_status'=> 2,
                'status'=>'sudah di gudang',
            ],
        ];
        StatusGudang::insert($data);
    }
}
