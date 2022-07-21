<?php

namespace Database\Seeders;

use App\Models\Satuan;
use Illuminate\Database\Seeder;

class SatuanSeeder extends Seeder
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
                'id_satuan'=>1,
                'satuan'=>'Kg',
            ],
            [
                'id_satuan'=>2,
                'satuan'=>'Pcs',
            ],
            [
                'id_satuan'=>3,
                'satuan'=>'Liter',
            ],
            [
                'id_satuan'=>4,
                'satuan'=>'Gram',
            ]
        ];
        Satuan::insert($data);
    }
}
