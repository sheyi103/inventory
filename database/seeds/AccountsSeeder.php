<?php

use App\Account;
use Illuminate\Database\Seeder;

class AccountsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $accounts = [
        	[
        		'head_account_id'	=> '1',
        		'name'				=> 'Cash',
        		'open_balance'		=> '0',
        	],
        	[
        		'head_account_id'	=> '1',
        		'name'				=> 'Bank',
        		'open_balance'		=> '0',
        	],
        	[
        		'head_account_id'	=> '1',
        		'name'				=> 'Accounts Receivable',
        		'open_balance'		=> '0',
        	],
        	[
        		'head_account_id'	=> '1',
        		'name'				=> 'Inventory',
        		'open_balance'		=> '0',
        	],
        	[
        		'head_account_id'	=> '1',
        		'name'				=> 'Prepaid Expense',
        		'open_balance'		=> '0',
        	],
        	[
        		'head_account_id'	=> '2',
        		'name'				=> 'Land',
        		'open_balance'		=> '0',
        	],
        	[
        		'head_account_id'	=> '2',
        		'name'				=> 'Furniture',
        		'open_balance'		=> '0',
        	],
        	[
        		'head_account_id'	=> '3',
        		'name'				=> 'Credit Accounts',
        		'open_balance'		=> '0',
        	],
        	[
        		'head_account_id'	=> '3',
        		'name'				=> 'Accounts Payable',
        		'open_balance'		=> '0',
        	],
        	[
        		'head_account_id'	=> '5',
        		'name'				=> 'Initial Invest',
        		'open_balance'		=> '0',
        	],
        	[
        		'head_account_id'	=> '6',
        		'name'				=> 'Owner Distribution',
        		'open_balance'		=> '0',
        	],
        	[
        		'head_account_id'	=> '8',
        		'name'				=> 'Rental Income',
        		'open_balance'		=> '0',
        	],
        	[
        		'head_account_id'	=> '9',
        		'name'				=> 'Advertising',
        		'open_balance'		=> '0',
        	],
        	[
        		'head_account_id'	=> '9',
        		'name'				=> 'Office Expenses',
        		'open_balance'		=> '0',
        	],
        	[
        		'head_account_id'	=> '9',
        		'name'				=> 'Insurance',
        		'open_balance'		=> '0',
        	],
        	[
        		'head_account_id'	=> '9',
        		'name'				=> 'Meals & Entertainment',
        		'open_balance'		=> '0',
        	],
        	[
        		'head_account_id'	=> '9',
        		'name'				=> 'Travel',
        		'open_balance'		=> '0',
        	],
        	[
        		'head_account_id'	=> '9',
        		'name'				=> 'Utilities',
        		'open_balance'		=> '0',
        	],
        	[
        		'head_account_id'	=> '9',
        		'name'				=> 'Telephone',
        		'open_balance'		=> '0',
        	],
        	[
        		'head_account_id'	=> '10',
        		'name'				=> 'Donations',
        		'open_balance'		=> '0',
        	],
        ];

        foreach ($accounts as $key => $value) {
        	Account::create($value);
        }
    }
}