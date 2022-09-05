<?php

namespace Database\Seeders;

use App\Models\Enums\RolesEnum;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class BarangMasukPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // barangmasuk Permission
        $datas = [
            [
                'name'=>'barangmasuk_index',
            ],
            [
                'name'=>'barangmasuk_create',
            ],
            [
                'name'=>'barangmasuk_edit',
            ],
            [
                'name'=>'barangmasuk_delete',
            ],
        ];
        foreach ($datas as $data) {
            Permission::create($data);
        }

        $barangmasukRole = Role::findById(RolesEnum::Owner);
        $barangmasukRole->givePermissionTo(['barangmasuk_index','barangmasuk_create','barangmasuk_edit','barangmasuk_delete']);

        $gudangRole = Role::findById(RolesEnum::Gudang);
        $gudangRole->givePermissionTo(['barangmasuk_index','barangmasuk_create','barangmasuk_edit','barangmasuk_delete']);

        $labRole = Role::findById(RolesEnum::Lab);
        $labRole->givePermissionTo(['barangmasuk_index']);

        $produksiRole = Role::findById(RolesEnum::Produksi);
        $produksiRole->givePermissionTo(['barangmasuk_index']);
    }
}
