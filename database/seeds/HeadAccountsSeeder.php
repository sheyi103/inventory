<?php

use App\HeadAccount;
use Illuminate\Database\Seeder;

class HeadAccountsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $headAccounts = [
        	[
        		'account_type_id'	=> '1',
        		'name'				=> 'Current Assets',
        	],
        	[
        		'account_type_id'	=> '1',
        		'name'				=> 'Fixed Assets',
        	],
        	[
        		'account_type_id'	=> '2',
        		'name'				=> 'Current Liabilities',
        	],
        	[
        		'account_type_id'	=> '2',
        		'name'				=> 'Long-Term Liabilities',
        	],
        	[
        		'account_type_id'	=> '3',
        		'name'				=> 'Invested Capital',
        	],
        	[
        		'account_type_id'	=> '3',
        		'name'				=> 'Owner Distribution',
        	],
        	[
        		'account_type_id'	=> '4',
        		'name'				=> 'Operating Revenue',
        	],
        	[
        		'account_type_id'	=> '4',
        		'name'				=> 'Non-Operating Revenue and Gains',
        	],
        	[
        		'account_type_id'	=> '5',
        		'name'				=> 'Operating Expenses',
        	],
        	[
        		'account_type_id'	=> '5',
        		'name'				=> 'Non-Operating Expenses and Losses',
        	],
        ];

        foreach ($headAccounts as $key => $value) {
        	HeadAccount::create($value);
        }
    }
}
