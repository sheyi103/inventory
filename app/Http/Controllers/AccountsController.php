<?php

namespace App\Http\Controllers;

use App\Account;
use App\HeadAccount;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AccountsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $accounts = Account::latest()->paginate(10);
        return view('pages.accounts.index', compact('accounts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $account = null;
        $headAccounts = HeadAccount::all();
        return view('pages.accounts.create', compact('headAccounts','account'));
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
            'head_account_id'  => ['required', Rule::notIn(['','0'])],
            'name'              => 'required',
            'open_balance'      => ['required', 'integer'],
        ]);

        Account::create($request->all());

        return redirect()
                    ->route('accounts.index')
                    ->with('success', 'Added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Accounts  $accounts
     * @return \Illuminate\Http\Response
     */
    public function show(Account $account)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Accounts  $accounts
     * @return \Illuminate\Http\Response
     */
    public function edit(Account $account)
    {
        $headAccounts = HeadAccount::all();
        return view('pages.accounts.edit', compact('account','headAccounts'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Accounts  $accounts
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Account $account)
    {
        $request->validate([ 
            'head_account_id'  => ['required', Rule::notIn(['','0'])],
            'name'              => 'required',
            'open_balance'      => ['required', 'integer'],
        ]);

        $account->update([
            'name'      => $request->name,
            'head_account_id'   => $request->head_account_id,
            'open_balance'   => $request->open_balance,
        ]);

        return redirect()
                    ->route('accounts.index')
                    ->with('success', 'Updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Accounts  $accounts
     * @return \Illuminate\Http\Response
     */
    public function destroy(Account $account)
    {
        //
    }
}
