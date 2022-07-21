<?php

namespace Database\Seeders;

use App\Models\Enums\RolesEnum;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class KategoriPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // kategori Permission
        $datas = [
            [
                'name'=>'kategori_index',
            ],
            [
                'name'=>'kategori_create',
            ],
            [
                'name'=>'kategori_edit',
            ],
            [
                'name'=>'kategori_delete',
            ],
        ];
        foreach ($datas as $data) {
            Permission::create($data);
        }

        $kategoriRole = Role::findById(RolesEnum::Owner);
        $kategoriRole->givePermissionTo(['kategori_index','kategori_create','kategori_edit','kategori_delete']);
    }
}
