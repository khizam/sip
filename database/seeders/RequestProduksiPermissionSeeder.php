<?php

namespace Database\Seeders;

use App\Models\Enums\RolesEnum;
use App\Models\Bahan;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RequestProduksiPermissionSeeder extends Seeder
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
                'name'=>'request_index',
            ],
            [
                'name'=>'request_create',
            ],
            [
                'name'=>'request_edit',
            ],
            [
                'name'=>'request_delete'
            ],
        ];
        foreach ($datas as $data) {
            Permission::create($data);
        }

        $ownerRole = Role::findById(RolesEnum::Owner);
        $ownerRole->givePermissionTo(['request_index','request_create','request_edit','request_delete']);

        $produksiRole = Role::findById(RolesEnum::Produksi);
        $produksiRole->givePermissionTo(['request_index']);

        $labRole = Role::findById(RolesEnum::Lab);
        $labRole->givePermissionTo(['request_index']);

        $gudangRole = Role::findById(RolesEnum::Gudang);
        $gudangRole->givePermissionTo(['request_index']);
    }
}
