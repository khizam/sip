<?php

namespace Database\Seeders;

use App\Models\Enums\RolesEnum;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class ProduksiBarangPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // produksibarang Permission
        $datas = [
            [
                'name'=>'produksibarang_index',
            ],
            [
                'name'=>'produksibarang_create',
            ],
            [
                'name'=>'produksibarang_edit',
            ],
            [
                'name'=>'produksibarang_delete',
            ],
        ];
        foreach ($datas as $data) {
            Permission::create($data);
        }

        $ownerRole = Role::findById(RolesEnum::Owner);
        $ownerRole->givePermissionTo(['produksibarang_index','produksibarang_create','produksibarang_edit','produksibarang_delete']);

        $produksibarangRole = Role::findById(RolesEnum::Produksi);
        $produksibarangRole->givePermissionTo(['produksibarang_index','produksibarang_create','produksibarang_edit','produksibarang_delete']);
    }
}
