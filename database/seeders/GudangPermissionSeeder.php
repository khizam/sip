<?php

namespace Database\Seeders;

use App\Models\Enums\RolesEnum;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class GudangPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // gudang Permission
        $datas = [
            [
                'name'=>'gudang_index',
            ],
            [
                'name'=>'gudang_create',
            ],
            [
                'name'=>'gudang_edit',
            ],
            [
                'name'=>'gudang_delete',
            ],
        ];
        foreach ($datas as $data) {
            Permission::create($data);
        }

        $ownerRole = Role::findById(RolesEnum::Owner);
        $ownerRole->givePermissionTo(['gudang_index','gudang_create','gudang_edit','gudang_delete']);

        $gudangRole = Role::findById(RolesEnum::Gudang);
        $gudangRole->givePermissionTo(['gudang_index','gudang_create','gudang_edit','gudang_delete']);
    }
}
