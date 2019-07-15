<?php

namespace App\Http\Controllers;

use App\CcLoanDeposit;
use App\CcLoan;
use Illuminate\Http\Request;
use DB;

class CcLoanDepositController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $deposits = CcLoanDeposit::latest()->get();
        return view('pages.cc-loan-deposit.index',compact('deposits'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $ccLoans = CcLoan::all();
        $ccLoanDeposit = null;
        return view('pages.cc-loan-deposit.create', compact('ccLoans','ccLoanDeposit'));
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
            'loan_id'  =>'required',
            'amount'      => 'required|numeric',
            'interest'      => 'required|numeric',
            'interest_rate'      => 'required|numeric',
            'withdraw_date'      => 'required',
            'deposit_date'      => 'required',
        ]);
        DB::transaction(function () use ($request) {
            CcLoanDeposit::create($request->all());
            $ccLoan = CcLoan::find($request->loan_id);
            $ccLoan->available = $ccLoan->available + $request->amount;
            $ccLoan->save();
        });
        return redirect()
                    ->route('cc-loan-deposit.index')
                    ->with('success', 'Added Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CcLoanDeposit  $ccLoanDeposit
     * @return \Illuminate\Http\Response
     */
    public function show(CcLoanDeposit $ccLoanDeposit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CcLoanDeposit  $ccLoanDeposit
     * @return \Illuminate\Http\Response
     */
    public function edit(CcLoanDeposit $ccLoanDeposit)
    {
        $ccLoans = CcLoan::all();
        return view('pages.cc-loan-deposit.edit', compact('ccLoans','ccLoanDeposit'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CcLoanDeposit  $ccLoanDeposit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CcLoanDeposit $ccLoanDeposit)
    {
        $request->validate([
            'loan_id'  =>'required',
            'amount'      => 'required|numeric',
            'interest'      => 'required|numeric',
            'interest_rate'      => 'required|numeric',
            'withdraw_date'      => 'required',
            'deposit_date'      => 'required',
        ]);

        DB::transaction(function () use ($request, $ccLoanDeposit) {
            //CcLoanWithdraw::create($request->all());
            $ccLoan = CcLoan::find($ccLoanDeposit->loan_id);
            $ccLoan->available = $ccLoan->available - $ccLoanDeposit->amount;
            $ccLoan->save();

            $ccLoanDeposit->update($request->all());

            $newCcLoan = CcLoan::find($request->loan_id);
            $newCcLoan->available = $newCcLoan->available + $request->amount;
            $newCcLoan->save();
        });
        return redirect()
                    ->route('cc-loan-deposit.index')
                    ->with('success', 'Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CcLoanDeposit  $ccLoanDeposit
     * @return \Illuminate\Http\Response
     */
    public function destroy(CcLoanDeposit $ccLoanDeposit)
    {
        DB::transaction(function () use ($ccLoanDeposit) {
            //CcLoanDeposit::create($request->all());
            $ccLoan = CcLoan::find($ccLoanDeposit->loan_id);
            $ccLoan->available = $ccLoan->available - $ccLoanDeposit->amount;
            $ccLoan->save();

            $ccLoanDeposit->delete();
        });
        return redirect()
                    ->route('cc-loan-deposit.index')
                    ->with('success', 'Deleted Successfully');
    }
}
