<?php

namespace Database\Seeders;

use App\Models\LabProduksi;
use Illuminate\Database\Seeder;

class LabProduksiSeeder extends Seeder
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
                // 'id_labproduksi'=> 1,
                // 'id_produksi'=> 1,
                // 'jumlah_produksi'=> 100,
                // 'lost' => 50,
            ],
        ];
        LabProduksi::insert($data);
    }
}
