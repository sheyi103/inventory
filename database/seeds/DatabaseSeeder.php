<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UsersSeeder::class,
            AccountsTypeSeeder::class,
            HeadAccountsSeeder::class,
            AccountsSeeder::class,
            CustomersSeeder::class,
            SuppliersSeeder::class,
            ProductsSeeder::class,
            RawMaterialsSeeder::class,
            FlatsSeeder::class,
            AssetsSeeder::class,
            BankSeeder::class,
            MobileBankingSeeder::class,
            ExpenseItemSeeder::class,
        ]);
    }
}
