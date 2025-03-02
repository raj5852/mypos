<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(UnitSeeder::class);
        $this->call(SupplierSeeder::class);
        $this->call(CustomerSeeder::class);
        $this->call(SettingSeeder::class);
        $this->call(BankSeeder::class);
        $this->call(OwnerSeeder::class);
        $this->call(RoleSeeder::class);

        $this->call(UserSeeder::class);


    }
}
