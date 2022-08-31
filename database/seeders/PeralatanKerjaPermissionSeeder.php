<?php

namespace Database\Seeders;

use App\Models\Enums\RolesEnum;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;


class PeralatanKerjaPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = [
            [
                'name'=>'peralatan_index',
            ],
            [
                'name'=>'peralatan_create',
            ],
            [
                'name'=>'peralatan_edit',
            ],
            [
                'name'=>'peralatan_delete'
            ],
        ];
        foreach ($datas as $data) {
            Permission::create($data);
        }

        $ownerRole = Role::findById(RolesEnum::Owner);
        $ownerRole->givePermissionTo(['peralatan_index','peralatan_create','peralatan_edit','peralatan_delete']);

        $inventoryRole = Role::findById(RolesEnum::InventoryAlat);
        $inventoryRole->givePermissionTo(['peralatan_index','peralatan_create','peralatan_edit','peralatan_delete']);

    }
}
