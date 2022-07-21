<?php

namespace Database\Seeders;

use App\Models\Enums\RolesEnum;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DetailProduksiPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // detailproduksi Permission
        $datas = [
            [
                'name'=>'detailproduksi_index',
            ],
            [
                'name'=>'detailproduksi_create',
            ],
            [
                'name'=>'detailproduksi_edit',
            ],
            [
                'name'=>'detailproduksi_delete',
            ],
        ];
        foreach ($datas as $data) {
            Permission::create($data);
        }

        $ownerRole = Role::findById(RolesEnum::Owner);
        $ownerRole->givePermissionTo(['detailproduksi_index','detailproduksi_create','detailproduksi_edit','detailproduksi_delete']);

        $detailproduksiRole = Role::findById(RolesEnum::Produksi);
        $detailproduksiRole->givePermissionTo(['detailproduksi_index','detailproduksi_create','detailproduksi_edit','detailproduksi_delete']);
    }
}
