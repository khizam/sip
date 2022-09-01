<?php

namespace Database\Seeders;

use App\Models\Enums\RolesEnum;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

<<<<<<< HEAD
=======

>>>>>>> 59f03402ea085b02933713efa41aadbe2c703545
class PeralatanKerjaPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
<<<<<<< HEAD
        // Peralatan Kerja Permission
        $datas = [
            [
                'name' => 'peralatan_index',
            ],
            [
                'name' => 'peralatan_create',
            ],
            [
                'name' => 'peralatan_edit',
            ],
            [
                'name' => 'peralatan_delete',
=======
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
>>>>>>> 59f03402ea085b02933713efa41aadbe2c703545
            ],
        ];
        foreach ($datas as $data) {
            Permission::create($data);
        }

        $ownerRole = Role::findById(RolesEnum::Owner);
<<<<<<< HEAD
        $ownerRole->givePermissionTo(['peralatan_index', 'peralatan_create', 'peralatan_edit', 'peralatan_delete']);

        $InventoryAlatRole = Role::findById(RolesEnum::InventoryAlat);
        $InventoryAlatRole->givePermissionTo(['peralatan_index', 'peralatan_create', 'peralatan_edit', 'peralatan_delete']);
=======
        $ownerRole->givePermissionTo(['peralatan_index','peralatan_create','peralatan_edit','peralatan_delete']);

        $inventoryRole = Role::findById(RolesEnum::InventoryAlat);
        $inventoryRole->givePermissionTo(['peralatan_index','peralatan_create','peralatan_edit','peralatan_delete']);

>>>>>>> 59f03402ea085b02933713efa41aadbe2c703545
    }
}
