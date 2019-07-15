<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'Auth\LoginController@showLoginForm')->name('login');

Auth::routes();

//server side processing of data table
Route::post('all-products', 'ProductController@allProducts');

//server side processing of data table
Route::post('all-orders', 'OrderController@allOrders');

//server side processing of data table
Route::post('all-bills', 'BillController@allBills');

//product search via select2
Route::get('product-autocomplete-search','ProductController@autocompletesearch')->name('product-autocomplete-search');

//asset list print
Route::get('asset/print', 'AssetController@print');

//asset list pdf
Route::get('asset/pdf', 'AssetController@exportPDF');

//asset list excel
Route::get('asset/excel', 'AssetController@exportExcel');

//supplier list print
Route::get('supplier/print', 'SupplierController@print');

//supplier list pdf
Route::get('supplier/pdf', 'SupplierController@exportPDF');

//supplier list excel
Route::get('supplier/excel', 'SupplierController@exportExcel');

//individual customer report
Route::get('customer/report/{id}', 'CustomerController@report');

//individual supplier report
Route::get('supplier/report/{id}', 'SupplierController@report');

//customer list print
Route::get('customer/print', 'CustomerController@print');

//customer list pdf
Route::get('customer/pdf', 'CustomerController@exportPDF');

//customer list excel
Route::get('customer/excel', 'CustomerController@exportExcel');

//flat list print
Route::get('flat/print', 'FlatController@print');

//flat list pdf
Route::get('flat/pdf', 'FlatController@exportPDF');

//flat list excel
Route::get('flat/excel', 'FlatController@exportExcel');

//product list print
Route::get('product/print', 'ProductController@print');

//product list pdf
Route::get('product/pdf', 'ProductController@exportPDF');

//product list excel
Route::get('product/excel', 'ProductController@exportExcel');

//raw-material list print
Route::get('raw-material/print', 'RawMaterialController@print');

//raw-material list pdf
Route::get('raw-material/pdf', 'RawMaterialController@exportPDF');

//raw-material list excel
Route::get('raw-material/excel', 'RawMaterialController@exportExcel');

//server side data table processing of expenses
Route::post('all-expenses', 'ExpenseController@allExpenses');

//server side data table processing of gloves business
Route::post('all-gloves', 'GloveController@allGloves');

//server side data table processing of house rents
Route::post('all-house-rents', 'HouseRentController@allRents');

//server side data table processing of purchases
Route::post('all-purchases', 'PurchaseController@allPurchases');

//server side data table processing of productions
Route::post('all-productions', 'ProductionController@allProductions');

//server side data table processing of deliveries
Route::post('all-deliveries', 'DeliveryController@allDeliveries');

//server side data table processing of sale payments
Route::post('all-sale-transactions', 'SaleTransactionController@allPayments');

//server side data table processing of purchase payments
Route::post('all-purchase-transactions', 'PurchaseTransactionController@allPayments');

//server side data table processing of cash book
Route::post('full-cash-book', 'HomeController@fullCashBook');

//supplier search via select2
Route::get('supplier-autocomplete-search','SupplierController@autocompletesearch')->name('supplier-autocomplete-search');

//customer search via select2
Route::get('customer-autocomplete-search','CustomerController@autocompletesearch')->name('customer-autocomplete-search');

//order delivery
Route::get('order/delivery/{id}', 'DeliveryController@createDeliveryFromOrder');
Route::post('order/delivery/{id}', 'DeliveryController@storeDeliveryFromOrder');

//delivery report
Route::get('order/delivery/report/{id}', 'DeliveryController@report');

//bank account transaction report
Route::get('bank-account/report/{id}', 'BankAccountController@report');

//expense item report
Route::get('expense-item/report/{id}', 'ExpenseItemController@report');
Route::post('all-expenses-of/{id}', 'ExpenseItemController@particularExpense');

//update delivery
Route::get('order/delivery/edit/{id}', 'DeliveryController@editDeliveryFromOrder');
Route::post('order/delivery/edit/{id}', 'DeliveryController@updateDeliveryFromOrder');

//delete delivery
Route::post('destroy-order-delivery/{id}', 'DeliveryController@destroyDeliveryFromOrder');

//delete delivery
Route::post('bill/full-destroy/{id}', 'BillController@destroyBill');

//delete delivery
Route::delete('full-order/destroy/{id}', 'OrderController@destroyFullOrder');

Route::group(['middleware' => ['auth']], function() {
	Route::get('/home', 'HomeController@index')->name('home');
	Route::resource('head-accounts', 'HeadAccountsController');
	Route::resource('accounts', 'AccountsController');
	Route::resource('customer', 'CustomerController');
	Route::resource('supplier', 'SupplierController');
	Route::resource('product', 'ProductController');
	Route::resource('purchase', 'PurchaseController');
	Route::resource('order', 'OrderController');
	Route::resource('sale', 'SaleController');
	Route::resource('expense', 'ExpenseController');
	Route::resource('user', 'UserController');
	Route::resource('raw-material', 'RawMaterialController');
	Route::resource('flat', 'FlatController');
	Route::resource('house-rent', 'HouseRentController');
	Route::resource('asset', 'AssetController');
	Route::resource('loan', 'LoanController');
	Route::resource('delivery', 'DeliveryController');
	Route::resource('bill', 'BillController');
	Route::resource('glove', 'GloveController');
	Route::resource('sale-transaction', 'SaleTransactionController');
	Route::resource('purchase-transaction', 'PurchaseTransactionController');
	Route::resource('bank-account', 'BankAccountController');
	Route::resource('bank-transaction', 'BankTransactionController');
	Route::resource('expense-item', 'ExpenseItemController');
	Route::resource('production', 'ProductionController');
	Route::resource('cc-loan', 'CcLoanController');
	Route::resource('cc-loan-withdraw', 'CcLoanWithdrawController');
	Route::resource('cc-loan-deposit', 'CcLoanDepositController');
});
