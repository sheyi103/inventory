<?php

namespace App\Http\Controllers;

use App\CcLoanWithdraw;
use App\CcLoan;
use Illuminate\Http\Request;
use DB;

class CcLoanWithdrawController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $withdraws = CcLoanWithdraw::latest()->get();
        return view('pages.cc-loan-withdraw.index',compact('withdraws'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $ccLoans = CcLoan::all();
        $ccLoanWithdraw = null;
        return view('pages.cc-loan-withdraw.create', compact('ccLoans','ccLoanWithdraw'));
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
            'date'      => 'required',
        ]);
        DB::transaction(function () use ($request) {
            CcLoanWithdraw::create($request->all());
            $ccLoan = CcLoan::find($request->loan_id);
            $ccLoan->available = $ccLoan->available - $request->amount;
            $ccLoan->save();
        });
        return redirect()
                    ->route('cc-loan-withdraw.index')
                    ->with('success', 'Added Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CcLoanWithdraw  $ccLoanWithdraw
     * @return \Illuminate\Http\Response
     */
    public function show(CcLoanWithdraw $ccLoanWithdraw)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CcLoanWithdraw  $ccLoanWithdraw
     * @return \Illuminate\Http\Response
     */
    public function edit(CcLoanWithdraw $ccLoanWithdraw)
    {
        $ccLoans = CcLoan::all();
        return view('pages.cc-loan-withdraw.edit', compact('ccLoanWithdraw','ccLoans'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CcLoanWithdraw  $ccLoanWithdraw
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CcLoanWithdraw $ccLoanWithdraw)
    {
        $request->validate([
            'loan_id'  =>'required',
            'amount'      => 'required|numeric',
            'date'      => 'required',
        ]);
        DB::transaction(function () use ($request, $ccLoanWithdraw) {
            //CcLoanWithdraw::create($request->all());
            $ccLoan = CcLoan::find($ccLoanWithdraw->loan_id);
            $ccLoan->available = $ccLoan->available + $ccLoanWithdraw->amount;
            $ccLoan->save();

            $ccLoanWithdraw->update($request->all());

            $newCcLoan = CcLoan::find($request->loan_id);
            $newCcLoan->available = $newCcLoan->available - $request->amount;
            $newCcLoan->save();
        });
        return redirect()
                    ->route('cc-loan-withdraw.index')
                    ->with('success', 'Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CcLoanWithdraw  $ccLoanWithdraw
     * @return \Illuminate\Http\Response
     */
    public function destroy(CcLoanWithdraw $ccLoanWithdraw)
    {
        DB::transaction(function () use ($ccLoanWithdraw) {
            //CcLoanWithdraw::create($request->all());
            $ccLoan = CcLoan::find($ccLoanWithdraw->loan_id);
            $ccLoan->available = $ccLoan->available + $ccLoanWithdraw->amount;
            $ccLoan->save();

            $ccLoanWithdraw->delete();
        });
        return redirect()
                    ->route('cc-loan-withdraw.index')
                    ->with('success', 'Deleted Successfully');
    }
}
