<?php

namespace Database\Seeders;

use App\Models\Unit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Unit::create([
            'unit_name'=>'pc',
            // 'related_to_unit'=>'',
            // 'operator'=>'',
            // 'related_by_value'=>'',
        ]);

    }
}
