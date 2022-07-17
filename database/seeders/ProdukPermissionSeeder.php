<?php

namespace Database\Seeders;

use App\Models\Enums\RolesEnum;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class ProdukPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // produk Permission
        $datas = [
            [
                'name'=>'produk_index',
            ],
            [
                'name'=>'produk_create',
            ],
            [
                'name'=>'produk_edit',
            ],
            [
                'name'=>'produk_delete',
            ],
        ];
        foreach ($datas as $data) {
            Permission::create($data);
        }

        $ownerRole = Role::findById(RolesEnum::Owner);
        $ownerRole->givePermissionTo(['produk_index','produk_create','produk_edit','produk_delete']);

        $produkRole = Role::findById(RolesEnum::Produksi);
        $produkRole->givePermissionTo(['produk_index','produk_create','produk_edit','produk_delete']);
    }
}
