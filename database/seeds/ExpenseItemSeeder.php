<?php

use Illuminate\Database\Seeder;
use App\ExpenseItem;

class ExpenseItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
        	[
        		'name'				=> 'Felicitation',
        		'details'		=> 'Expense for customer and other persons felicitation',
        	],
        	[   'name'				=> 'Donation',
        		'details'		=> 'Expense for Donation',
        	],
        	[   'name'				=> 'Other',
        		'details'		=> 'Other Expenses',
        	],
        ];

        foreach ($items as $key => $value) {
        	ExpenseItem::create($value);
        }
    }
}
