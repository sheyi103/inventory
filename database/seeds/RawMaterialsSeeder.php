<?php

use Illuminate\Database\Seeder;

class RawMaterialsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\RawMaterial::class, 10)->create();
    }
}
