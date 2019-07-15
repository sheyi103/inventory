<?php

namespace App\Http\Controllers;

use App\AccountType;
use App\HeadAccount;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class HeadAccountsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $headAccounts = HeadAccount::latest()->paginate(10);
        return view('pages.head-accounts.index', compact('headAccounts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $accountTypes = AccountType::all('id','name');
        $headAccount = null;
        return view('pages.head-accounts.create', compact('accountTypes','headAccount'));
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
            'account_type_id'   => ['required', Rule::notIn([''])],
            'name'              => 'required',
        ]);

        HeadAccount::create($request->all());

        return redirect()
                    ->route('head-accounts.index')
                    ->with('success', 'Added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\HeadAccounts  $headAccounts
     * @return \Illuminate\Http\Response
     */
    public function show(HeadAccount $headAccount)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\HeadAccounts  $headAccounts
     * @return \Illuminate\Http\Response
     */
    public function edit(HeadAccount $headAccount)
    {
        $accountTypes = AccountType::all('id','name');
        return view('pages.head-accounts.edit', compact('headAccount','accountTypes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\HeadAccounts  $headAccounts
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, HeadAccount $headAccount)
    {
        $request->validate([
            'account_type_id'   => ['required', Rule::notIn([''])],
            'name'              => 'required',
        ]);
        $headAccount->update([
            'name'      => $request->name,
            'account_type_id'   => $request->account_type_id,
        ]);

        return redirect()
                    ->route('head-accounts.index')
                    ->with('success', 'Updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\HeadAccounts  $headAccounts
     * @return \Illuminate\Http\Response
     */
    public function destroy(HeadAccount $headAccount)
    {
        //
    }
}
