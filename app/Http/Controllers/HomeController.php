<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Expense;
use App\SaleTransaction;
use App\PurchaseTransaction;
use App\CashBook;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    //server side datatable of cash book
    public function fullCashBook(Request $request)
    {     
        $columns = array( 
                            0 =>'id', 
                            1 =>'date',
                            2 => 'purpose',
                            3 => 'details',
                            4 => 'debit',
                            5 => 'credit',
                            6 => 'balance',
                            7 => 'action',
                        );
        

        $totalData = CashBook::count();
        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
            
        if(empty($request->input('search.value')))
        {

            $transactions = CashBook::offset($start)
                    ->limit($limit)
                    ->orderBy($order,$dir)
                    ->get();

        }
        else {
            $search = $request->input('search.value'); 

            $transactions =  CashBook::with('sale','purchase','expense')
                        ->where(function ($query) use($search) {
                            $query->where('date', 'LIKE',"%{$search}%")
                                ->orWhereHas('expense', function($query) use($search) {
                                    $query->where('amount','LIKE',"%{$search}%")
                                        ->orWhereHas('expenseitem', function($query) use($search) {
                                            $query->where('name','LIKE',"%{$search}%");
                                        });
                                })
                                ->orWhereHas('sale', function($query) use($search) {
                                    $query->where('amount','LIKE',"%{$search}%")
                                        ->orWhereHas('customer', function($query) use($search) {
                                            $query->where('name','LIKE',"%{$search}%");
                                        })
                                        ->orWhereHas('account', function($query) use($search) {
                                            $query->where('account_no','LIKE',"%{$search}%");
                                        })
                                        ->orWhereHas('mobileBanking', function($query) use($search) {
                                        $query->where('name','LIKE',"%{$search}%");
                                    });
                                })
                                ->orWhereHas('purchase', function($query) use($search) {
                                    $query->where('amount','LIKE',"%{$search}%")
                                        ->orWhereHas('supplier', function($query) use($search) {
                                            $query->where('name','LIKE',"%{$search}%");
                                        })
                                        ->orWhereHas('bank', function($query) use($search) {
                                            $query->where('name','LIKE',"%{$search}%");
                                        })
                                        ->orWhereHas('mobileBanking', function($query) use($search) {
                                        $query->where('name','LIKE',"%{$search}%");
                                    });
                                });
                        })
                        ->offset($start)
                        ->limit($limit)
                        ->orderBy($order,$dir)
                        ->get();

            $totalFiltered = CashBook::with('sale','purchase','company','expense')
                        ->where(function ($query) use($search) {
                            $query->where('date', 'LIKE',"%{$search}%")
                                ->orWhereHas('expense', function($query) use($search) {
                                    $query->where('amount','LIKE',"%{$search}%")
                                        ->orWhereHas('expenseitem', function($query) use($search) {
                                            $query->where('name','LIKE',"%{$search}%");
                                        });
                                })
                                ->orWhereHas('sale', function($query) use($search) {
                                    $query->where('amount','LIKE',"%{$search}%")
                                        ->orWhereHas('customer', function($query) use($search) {
                                            $query->where('name','LIKE',"%{$search}%");
                                        })
                                        ->orWhereHas('account', function($query) use($search) {
                                            $query->where('account_no','LIKE',"%{$search}%");
                                        })
                                        ->orWhereHas('mobileBanking', function($query) use($search) {
                                        $query->where('name','LIKE',"%{$search}%");
                                    });
                                })
                                ->orWhereHas('company', function($query) use($search) {
                                    $query->where('name','LIKE',"%{$search}%");
                                })
                                ->orWhereHas('purchase', function($query) use($search) {
                                    $query->where('amount','LIKE',"%{$search}%")
                                        ->orWhereHas('supplier', function($query) use($search) {
                                            $query->where('name','LIKE',"%{$search}%");
                                        })
                                        ->orWhereHas('bank', function($query) use($search) {
                                            $query->where('name','LIKE',"%{$search}%");
                                        })
                                        ->orWhereHas('mobileBanking', function($query) use($search) {
                                        $query->where('name','LIKE',"%{$search}%");
                                    });
                                });
                        })
                        ->count();
        }

        $data = array();
        if(!empty($transactions))
        {
            $balance = 0;
            foreach ($transactions as $key => $value)
            {
                $nestedData['id'] = $key + 1;
                $nestedData['date'] = $value->date->format("d-m-Y");
                if ($value->purpose == 1) {
                    
                    $nestedData['purpose'] = 'Sale Payment';
                    $nestedData['details'] = 'Received From '.$value->sale->customer->name.'.';
                    $nestedData['debit'] = $value->sale->amount;
                    $nestedData['credit'] = '';
                    $nestedData['balance'] = $balance += $value->sale->amount;
                    $nestedData['action'] = '<div class="btn-group">
                                    <a href="'.route('sale-transaction.show',$value->sale_transaction_id) .'" class="btn btn-success btn-sm" title="Show">
                                        Show
                                    </a>
                                </div>';
                }
                else if ($value->purpose == 2) {                  
                    $nestedData['purpose'] = 'Purchase Payment';
                    $nestedData['details'] = 'Paid to '.$value->purchase->supplier->name.'.';
                    $nestedData['debit'] = '';
                    $nestedData['credit'] = $value->purchase->amount;
                    $nestedData['balance'] = $balance -= $value->purchase->amount;
                    $nestedData['action'] = '<div class="btn-group">
                                    <a href="'.route('purchase-transaction.show',$value->purchase_transaction_id) .'" class="btn btn-success btn-sm" title="Show">
                                        Show
                                    </a>
                                </div>';
                }
                else {
                    $nestedData['purpose'] = 'Expense Payment';
                    $nestedData['details'] = 'Paid to/for '.$value->expense->expenseitem->name.'.';
                    $nestedData['debit'] = '';
                    $nestedData['credit'] = $value->expense->amount;
                    $nestedData['balance'] = $balance -= $value->expense->amount;
                    $nestedData['action'] = '<div class="btn-group">
                                    <a href="'.route('expense.show',$value->expense_transaction_id) .'" class="btn btn-success btn-sm" title="Show">
                                        Show
                                    </a>
                                </div>';
                }
                $data[] = $nestedData;
            }
        }
          
        $json_data = array(
                    "draw"            => intval($request->input('draw')),  
                    "recordsTotal"    => intval($totalData),  
                    "recordsFiltered" => intval($totalFiltered), 
                    "data"            => $data,   
                    );
            
        echo json_encode($json_data);        
    }
}
