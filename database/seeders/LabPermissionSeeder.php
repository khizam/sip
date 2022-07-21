<?php

namespace Database\Seeders;

use App\Models\Enums\RolesEnum;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class LabPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Lab Permission
        $datas = [
            [
                'name'=>'lab_index',
            ],
            [
                'name'=>'lab_create',
            ],
            [
                'name'=>'lab_edit',
            ],
            [
                'name'=>'lab_delete',
            ],
        ];
        foreach ($datas as $data) {
            Permission::create($data);
        }
        $ownerRole = Role::findById(RolesEnum::Owner);
        $ownerRole->givePermissionTo(['lab_index','lab_create','lab_edit','lab_delete']);

        $labRole = Role::findById(RolesEnum::Lab);
        $labRole->givePermissionTo(['lab_index','lab_create','lab_edit','lab_delete']);
    }
}
