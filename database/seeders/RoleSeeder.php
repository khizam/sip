<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create(['name'=>'owner']);
        Role::create(['name'=>'lab']);
        Role::create(['name'=>'produksi']);
        Role::create(['name'=>'gudang']);
    }
}
