<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class StoreTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        StoreType::factory()->count(10)->create();
    }
}
