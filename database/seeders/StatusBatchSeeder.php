<?php

namespace Database\Seeders;

use App\Models\StatusBatch;
use Illuminate\Database\Seeder;

class StatusBatchSeeder extends Seeder
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
                'status'=>'belum selesai',
            ],
            [
                'status'=>'selesai',
            ],
        ];
        StatusBatch::insert($data);
    }
}
