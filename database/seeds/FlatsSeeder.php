<?php

use Illuminate\Database\Seeder;

class FlatsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Flat::class, 10)->create();
    }
}
