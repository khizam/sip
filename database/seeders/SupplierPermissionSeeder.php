<?php

namespace Database\Seeders;

use App\Models\Enums\RolesEnum;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class SupplierPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // supplier Permission
        $datas = [
            [
                'name'=>'supplier_index',
            ],
            [
                'name'=>'supplier_create',
            ],
            [
                'name'=>'supplier_edit',
            ],
            [
                'name'=>'supplier_delete',
            ],
        ];
        foreach ($datas as $data) {
            Permission::create($data);
        }

        $supplierRole = Role::findById(RolesEnum::Owner);
        $supplierRole->givePermissionTo(['supplier_index','supplier_create','supplier_edit','supplier_delete']);
    }
}
