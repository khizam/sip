<?php

namespace Database\Seeders;

use App\Models\Enums\RolesEnum;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // user Permission
        $datas = [
            [
                'name'=>'user_index',
            ],
            [
                'name'=>'user_create',
            ],
            [
                'name'=>'user_edit',
            ],
            [
                'name'=>'user_delete',
            ],
        ];
        foreach ($datas as $data) {
            Permission::create($data);
        }

        $userRole = Role::findById(RolesEnum::Owner);
        $userRole->givePermissionTo(['user_index','user_create','user_edit','user_delete']);
    }
}
