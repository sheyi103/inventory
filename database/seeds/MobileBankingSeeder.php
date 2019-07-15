<?php

use Illuminate\Database\Seeder;

class MobileBankingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\MobileBanking::class, 10)->create();
    }
}
