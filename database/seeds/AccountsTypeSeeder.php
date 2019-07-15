<?php

use App\AccountType;
use Illuminate\Database\Seeder;

class AccountsTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $accountTypes = [
        	[
        		'name'		=> 'Asset',
        		'details'	=> 'All types of assets.',
        	],
        	[
        		'name'		=> 'Liability',
        		'details'	=> 'All types of liabilities',
        	],
        	[
        		'name'		=> 'Equity',
        		'details'	=> 'All types of equities'
        	],
        	[
        		'name'		=> 'Revenue',
        		'details'	=> 'All types of revenues'
        	],
        	[
        		'name'		=> 'Expense',
        		'details'	=> 'All types of expenses'
        	],
        ];

        foreach ($accountTypes as $key => $value) {
        	AccountType::create($value);
        }
    }
}
