<?php

namespace App\Http\Controllers;

use App\PurchaseTransaction;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Supplier;
use App\BankAccount;
use App\BankTransaction;
use App\MobileBanking;
use App\CashBook;
use DB;

class PurchaseTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.purchase-transaction.index');
    }

    //server side datatable super admin view
    public function allPayments(Request $request)
    {     
        $columns = array( 
                            0 => 'id', 
                            1 => 'date',
                            2 => 'supplier_id',
                            3 => 'amount',
                            4 => 'payment_type',
                            5 => 'payment_mode',
                            6 => 'actions',
                        );
        

        $totalData = PurchaseTransaction::where('purpose','=','2')->count();
        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
            
        if(empty($request->input('search.value')))
        {

            $transactions = PurchaseTransaction::where('purpose','=','2')
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order,$dir)
                    ->get();

        }
        else {
            $search = $request->input('search.value'); 

            $transactions =  PurchaseTransaction::with('supplier','account','mobileBanking')
                        ->where('purpose','=','2')
                        ->where(function ($query) use($search) {
                            $query->where('amount','LIKE',"%{$search}%")
                                ->orWhere('date', 'LIKE',"%{$search}%")
                                ->orWhereHas('supplier', function($query) use($search) {
                                    $query->where('name','LIKE',"%{$search}%");
                                })
                                ->orWhereHas('account', function($query) use($search) {
                                    $query->where('name','LIKE',"%{$search}%");
                                })
                                ->orWhereHas('mobileBanking', function($query) use($search) {
                                    $query->where('name','LIKE',"%{$search}%");
                                });
                        })
                        ->offset($start)
                        ->limit($limit)
                        ->orderBy($order,$dir)
                        ->get();

            $totalFiltered = PurchaseTransaction::with('supplier','account','mobileBanking')
                        ->where('purpose','=','2')
                        ->where(function ($query) use($search) {
                            $query->where('amount','LIKE',"%{$search}%")
                                ->orWhere('date', 'LIKE',"%{$search}%")
                                ->orWhereHas('supplier', function($query) use($search) {
                                    $query->where('name','LIKE',"%{$search}%");
                                })
                                ->orWhereHas('account', function($query) use($search) {
                                    $query->where('name','LIKE',"%{$search}%");
                                })
                                ->orWhereHas('mobileBanking', function($query) use($search) {
                                    $query->where('name','LIKE',"%{$search}%");
                                });
                        })
                        ->count();
        }

        $data = array();
        if(!empty($transactions))
        {
            foreach ($transactions as $key => $value)
            {
                $nestedData['id'] = $key + 1;
                $nestedData['date'] = $value->date;
                $nestedData['supplier_id'] = $value->supplier->name;
                $nestedData['amount'] = $value->amount;
                if ($value->payment_type == 1) {
                    $nestedData['payment_type'] = 'Cash';
                }
                else if ($value->payment_type == 2) {
                    $nestedData['payment_type'] = 'Due';
                }
                else {
                    $nestedData['payment_type'] = 'Advance';
                }

                if ($value->payment_mode == 1) {
                    $nestedData['payment_mode'] = 'Hand Cash';
                }
                else if ($value->payment_mode == 2) {
                    $nestedData['payment_mode'] = 'Regular Banking';
                }
                else {
                    $nestedData['payment_mode'] = 'Mobile Banking';
                }
                $nestedData['actions'] = '<div class="btn-group">
                                    <a href="'.route('purchase-transaction.show',$value->id) .'" class="btn btn-secondary btn-sm" title="Show">
                                        Show
                                    </a>
                                    <a href="'.route('purchase-transaction.edit',$value->id) .'" class="btn btn-success btn-sm" title="Update">
                                        Update
                                    </a>
                                    <button class="btn btn-sm btn-danger btn-delete" data-remote=" '.route('purchase-transaction.destroy',$value->id) .'" title="Delete">Delete</button>
                                </div>';
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $purchaseTransaction = null;
        $suppliers = Supplier::all('id', 'name');
        $accounts = BankAccount::all();
        $mobileBankings = MobileBanking::all('id', 'name');
        return view('pages.purchase-transaction.create', compact('purchaseTransaction','suppliers','accounts','mobileBankings'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'date'      => 'required',
            'supplier_id'  => ['required', Rule::notIn(['','0'])],
            'payment_type'  => ['required', Rule::notIn(['','0'])],
            'payment_mode'  => ['required', Rule::notIn(['','0'])],
            'amount'    => 'required|numeric',
        ]);
        DB::transaction(function () use ($request) {
            $token = time().str_random(10);

            $transaction = new PurchaseTransaction;

            $transaction->date = $request->date;
            $transaction->supplier_id = $request->supplier_id;
            $transaction->details = $request->details;
            $transaction->amount = $request->amount;
            $transaction->payment_type = $request->payment_type;
            $transaction->payment_mode = $request->payment_mode;
            $transaction->token = $token;
            $transaction->bank_account_id = $request->bank_account_id;
            $transaction->cheque_number = $request->cheque_number;
            $transaction->mobile_banking_id = $request->mobile_banking_id;
            $transaction->phone_number = $request->phone_number;
            $transaction->receiver = $request->receiver;
            $transaction->purpose = 2;

            $transaction->save();

            $cashBook = new CashBook;
            $cashBook->date = $request->date;
            $cashBook->purpose = 2;
            $cashBook->purchase_transaction_id = $transaction->id;

            $cashBook->save();

            if ($request->payment_mode == 2) {
                $bankTransaction = new BankTransaction;

                $bankTransaction->date = $request->date;
                $bankTransaction->amount = $request->amount;
                $bankTransaction->purpose = 4;
                $bankTransaction->token = $token;
                $bankTransaction->bankAccount_id = $request->bank_account_id;
                $bankTransaction->cheque_number = $request->cheque_number;

                $bankTransaction->save();

                $bankAccount = BankAccount::find($request->bank_account_id);

                $bankAccount->amount = $bankAccount->amount - $request->amount;
                $bankAccount->save();

            }
        });

        return redirect()
                    ->route('purchase-transaction.index')
                    ->with('success', 'Payment Added Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PurchaseTransaction  $purchaseTransaction
     * @return \Illuminate\Http\Response
     */
    public function show(PurchaseTransaction $purchaseTransaction)
    {
        return view('pages.purchase-transaction.show', compact('purchaseTransaction'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PurchaseTransaction  $purchaseTransaction
     * @return \Illuminate\Http\Response
     */
    public function edit(PurchaseTransaction $purchaseTransaction)
    {
        $suppliers = Supplier::all('id', 'name');
        $accounts = BankAccount::all();
        $mobileBankings = MobileBanking::all('id', 'name');
        return view('pages.purchase-transaction.edit', compact('purchaseTransaction','suppliers','accounts','mobileBankings'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PurchaseTransaction  $purchaseTransaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PurchaseTransaction $purchaseTransaction)
    {
        $request->validate([
            'date'      => 'required',
            'supplier_id'  => ['required', Rule::notIn(['','0'])],
            'payment_type'  => ['required', Rule::notIn(['','0'])],
            'payment_mode'  => ['required', Rule::notIn(['','0'])],
            'amount'    => 'required|numeric',
        ]);

        DB::transaction(function () use ($request, $purchaseTransaction) {
            //$transaction = BusinesspurchaseTransaction::find($id);
            //$token = time().str_random(10);

            if ($purchaseTransaction->payment_mode != 2 && $request->payment_mode == 2) {
                $bankTransaction = new BankTransaction;

                $bankTransaction->date = $request->date;
                $bankTransaction->amount = $request->amount;
                $bankTransaction->purpose = 4;
                $bankTransaction->token = $purchaseTransaction->token;
                $bankTransaction->bankAccount_id = $request->bank_account_id;
                $bankTransaction->cheque_number = $request->cheque_number;

                $bankTransaction->save();

                $bankAccount = BankAccount::find($request->bank_account_id);

                $bankAccount->amount = $bankAccount->amount - $request->amount;
                $bankAccount->save();
            }

            if ($purchaseTransaction->payment_mode == 2 && $request->payment_mode == 2) {
                $bankTransaction = BankTransaction::where([
                    ['purpose','=','4'],
                    ['token',$purchaseTransaction->token]
                ])->first();
                if ($bankTransaction->bankAccount_id == $request->bank_account_id) {
                    $bankAccount = BankAccount::find($request->bank_account_id);

                    $bankAccount->amount = ($bankAccount->amount + $bankTransaction->amount) - $request->amount;
                    $bankAccount->save();
                }

                else{
                    //remove balance from the old account
                    $oldBankAccount = BankAccount::find($bankTransaction->bankAccount_id);

                    $oldBankAccount->amount = $oldBankAccount->amount + $bankTransaction->amount;
                    $oldBankAccount->save();

                    //add balance to the new account
                    $bankAccount = BankAccount::find($request->bank_account_id);

                    $bankAccount->amount = $bankAccount->amount - $request->amount;
                    $bankAccount->save();
                }

                $bankTransaction->date = $request->date;
                $bankTransaction->amount = $request->amount;
                $bankTransaction->bankAccount_id = $request->bank_account_id;
                $bankTransaction->cheque_number = $request->cheque_number;

                $bankTransaction->save();
            }

            if ($purchaseTransaction->payment_mode == 2 && $request->payment_mode != 2) {
                $bankTransaction = BankTransaction::where([
                    ['purpose','=','4'],
                    ['token',$purchaseTransaction->token]
                ])->first();

                $bankAccount = BankAccount::find($bankTransaction->bankAccount_id);

                $bankAccount->amount = $bankAccount->amount + $bankTransaction->amount;
                $bankAccount->save();

                $bankTransaction->delete();
            }

            $purchaseTransaction->date = $request->date;
            $purchaseTransaction->supplier_id = $request->supplier_id;
            $purchaseTransaction->details = $request->details;
            $purchaseTransaction->amount = $request->amount;
            $purchaseTransaction->payment_type = $request->payment_type;
            $purchaseTransaction->payment_mode = $request->payment_mode;
            //$purchaseTransaction->bank_id = $request->bank_id;
            $purchaseTransaction->bank_account_id = $request->bank_account_id;
            $purchaseTransaction->cheque_number = $request->cheque_number;
            $purchaseTransaction->mobile_banking_id = $request->mobile_banking_id;
            $purchaseTransaction->phone_number = $request->phone_number;
            $purchaseTransaction->receiver = $request->receiver;
            $purchaseTransaction->purpose = 2;

            $purchaseTransaction->save();

            $cashBook = CashBook::where('purchase_transaction_id',$purchaseTransaction->id)->first();
            $cashBook->date = $request->date;
            $cashBook->save();
        });

        return redirect()
                    ->route('purchase-transaction.index')
                    ->with('success', 'Payment Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PurchaseTransaction  $purchaseTransaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(PurchaseTransaction $purchaseTransaction)
    {
        DB::transaction(function () use ($purchaseTransaction) {
            if ($purchaseTransaction->payment_mode == 2) {
                $bankTransaction = BankTransaction::where([
                    ['purpose','=','4'],
                    ['token',$purchaseTransaction->token]
                ])->first();

                $bankAccount = BankAccount::find($bankTransaction->bankAccount_id);

                $bankAccount->amount = $bankAccount->amount + $bankTransaction->amount;
                $bankAccount->save();

                $bankTransaction->delete();
            }

            $cashBook = CashBook::where('purchase_transaction_id',$id)->first();
            $cashBook->delete();
            $purchaseTransaction->delete();
        });
        return redirect()
                    //->back()
                    ->route('purchase-transaction.index')
                    ->with('warning', 'Payment Deleted Successfully');
    }
}
