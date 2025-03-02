<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create([
            'name'=>'dashboard',
        ]);

        Role::create([
            'name'=>'owner',
        ]);

        Role::create([
            'name'=>'bank',
        ]);

        Role::create([
            'name'=>'pos',
        ]);

        Role::create([
            'name'=>'sales',
        ]);

        Role::create([
            'name'=>'purchase',
        ]);

        Role::create([
            'name'=>'stock',
        ]);

        Role::create([
            'name'=>'damage',
        ]);

        Role::create([
            'name'=>'unit',
        ]);

        Role::create([
            'name'=>'product',
        ]);

        Role::create([
            'name'=>'category',
        ]);

        Role::create([
            'name'=>'brand',
        ]);

        Role::create([
            'name'=>'customer',
        ]);

        Role::create([
            'name'=>'supplier',
        ]);

        Role::create([
            'name'=>'setting',
        ]);

        Role::create([
            'name'=>'user_and_role',
        ]);

    }
}
