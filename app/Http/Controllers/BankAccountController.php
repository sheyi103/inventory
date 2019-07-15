<?php

namespace App\Http\Controllers;

use App\BankAccount;
use App\BankTransaction;
use Illuminate\Http\Request;
use App\Bank;

class BankAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bankAccounts = BankAccount::latest()->get();
        return view('pages.bank-account.index',compact('bankAccounts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $bankAccount = null;
        $banks = Bank::all();
        return view('pages.bank-account.create', compact('bankAccount','banks'));
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
            'account_no'  =>'required',
            'account_holder_name'  =>'required',
            'bank_id'      => 'required',
        ]);

        BankAccount::create($request->all());
        return redirect()
                    ->route('bank-account.index')
                    ->with('success', 'Added Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\BankAccount  $bankAccount
     * @return \Illuminate\Http\Response
     */
    public function show(BankAccount $bankAccount)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\BankAccount  $bankAccount
     * @return \Illuminate\Http\Response
     */
    public function edit(BankAccount $bankAccount)
    {
        $banks = Bank::all();
        return view('pages.bank-account.edit', compact('bankAccount','banks'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\BankAccount  $bankAccount
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BankAccount $bankAccount)
    {
        $request->validate([
            'account_no'  =>'required',
            'account_holder_name'  =>'required',
            'bank_id'      => 'required',
        ]);

        $bankAccount->update($request->all());
        return redirect()
                    ->route('bank-account.index')
                    ->with('success', 'Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\BankAccount  $bankAccount
     * @return \Illuminate\Http\Response
     */
    public function destroy(BankAccount $bankAccount)
    {
        $bankAccount->delete();
        return redirect()
                    ->route('bank-account.index')
                    ->with('success', 'Deleted Successfully');
    }

    public function report($id)
    {
        $bankAccount = BankAccount::find($id);
        $transactions = BankTransaction::where('bankAccount_id', $id)->get();
        return view('pages.bank-account.report',compact('bankAccount','transactions','id'));
    }
}
