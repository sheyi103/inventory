<?php

namespace App\Http\Controllers;

use App\BankTransaction;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\BankAccount;
use DB;

class BankTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $bankTransaction = null;
        $bankAccounts = BankAccount::all('account_no','id','account_holder_name','bank_id');
        return view('pages.bank-transaction.create', compact('bankAccounts','bankTransaction'));
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
            'date'  =>'required',
            'amount'      => 'required|numeric',
            'bankAccount_id'  => ['required', Rule::notIn(['','0'])],
            'purpose'  => ['required', Rule::notIn(['','0'])],
        ]);
        DB::transaction(function () use ($request) {
            BankTransaction::create($request->all());
            $bankAccount = BankAccount::find($request->bankAccount_id);
            if ($request->purpose == 1) {
                $bankAccount->amount = $bankAccount->amount + $request->amount;
                $bankAccount->save();
            }
            else {
                $bankAccount->amount = $bankAccount->amount - $request->amount;
                $bankAccount->save();
            }
        });
        return redirect()
                    ->route('bank-account.index')
                    ->with('success', 'Transaction Added Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\BankTransaction  $bankTransaction
     * @return \Illuminate\Http\Response
     */
    public function show(BankTransaction $bankTransaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\BankTransaction  $bankTransaction
     * @return \Illuminate\Http\Response
     */
    public function edit(BankTransaction $bankTransaction)
    {
        $bankAccounts = BankAccount::all('account_no','id');
        return view('pages.bank-transaction.edit', compact('bankAccounts','bankTransaction'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\BankTransaction  $bankTransaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BankTransaction $bankTransaction)
    {
        $request->validate([
            'date'  =>'required',
            'amount'      => 'required|numeric',
            'bankAccount_id'  => ['required', Rule::notIn(['','0'])],
            'purpose'  => ['required', Rule::notIn(['','0'])],
        ]);
        DB::transaction(function () use ($request, $bankTransaction) {
            $bankAccount = BankAccount::find($bankTransaction->bankAccount_id);
            if ($bankTransaction->purpose == 1) {
                $bankAccount->amount = $bankAccount->amount - $bankTransaction->amount;
                $bankAccount->save();
            }
            else {
                $bankAccount->amount = $bankAccount->amount + $bankTransaction->amount;
                $bankAccount->save();
            }

            $bankTransaction->update($request->all());
            $newBankAccount = BankAccount::find($request->bankAccount_id);
            if ($request->purpose == 1) {
                $newBankAccount->amount = $newBankAccount->amount + $request->amount;
                $newBankAccount->save();
            }
            else {
                $newBankAccount->amount = $newBankAccount->amount - $request->amount;
                $newBankAccount->save();
            }
        });
        return redirect()
                    ->route('bank-account.index')
                    ->with('success', 'Transaction Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\BankTransaction  $bankTransaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(BankTransaction $bankTransaction)
    {
        DB::transaction(function () use ($bankTransaction) {
            $bankAccount = BankAccount::find($bankTransaction->bankAccount_id);
            if ($bankTransaction->purpose == 1) {
                $bankAccount->amount = $bankAccount->amount - $bankTransaction->amount;
                $bankAccount->save();
            }
            else {
                $bankAccount->amount = $bankAccount->amount + $bankTransaction->amount;
                $bankAccount->save();
            }

            $bankTransaction->delete();
        });
        return redirect()
                    ->route('bank-account.index')
                    ->with('success', 'Transaction Deleted Successfully');
    }
}
