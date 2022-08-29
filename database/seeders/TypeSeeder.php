<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('type')->insert([
            'name' => 'select',
        ]);
        DB::table('type')->insert([
            'name' => 'text',
        ]);
        DB::table('type')->insert([
            'name' => 'number',
        ]);
        DB::table('type')->insert([
            'name' => 'checkbox',
        ]);
        DB::table('type')->insert([
            'name' => 'textarea',
        ]);
    }
}
