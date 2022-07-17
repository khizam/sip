<?php

namespace Database\Seeders;

use App\Models\Enums\RolesEnum;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class BahanPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // bahan Permission
        $datas = [
            [
                'name'=>'bahan_index',
            ],
            [
                'name'=>'bahan_create',
            ],
            [
                'name'=>'bahan_edit',
            ],
            [
                'name'=>'bahan_delete',
            ],
        ];
        foreach ($datas as $data) {
            Permission::create($data);
        }
        $bahanRole = Role::findById(RolesEnum::Owner);
        $bahanRole->givePermissionTo(['bahan_index','bahan_create','bahan_edit','bahan_delete']);
    }
}
