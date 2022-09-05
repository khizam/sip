<?php

namespace Database\Seeders;

use App\Models\Enums\RolesEnum;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class LabProduksiPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // labproduksi Permission
        $datas = [
            [
                'name'=>'labproduksi_index',
            ],
            [
                'name'=>'labproduksi_create',
            ],
            [
                'name'=>'labproduksi_edit',
            ],
            [
                'name'=>'labproduksi_delete',
            ],
        ];
        foreach ($datas as $data) {
            Permission::create($data);
        }

        $ownerRole = Role::findById(RolesEnum::Owner);
        $ownerRole->givePermissionTo(['labproduksi_index','labproduksi_create','labproduksi_edit','labproduksi_delete']);

        $labproduksiRole = Role::findById(RolesEnum::Lab);
        $labproduksiRole->givePermissionTo(['labproduksi_index','labproduksi_create','labproduksi_edit','labproduksi_delete']);

        $gudangRole = Role::findById(RolesEnum::Gudang);
        $gudangRole->givePermissionTo(['labproduksi_index']);

        $produksiRole = Role::findById(RolesEnum::Produksi);
        $produksiRole->givePermissionTo(['labproduksi_index']);
    }
}
