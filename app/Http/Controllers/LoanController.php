<?php

namespace App\Http\Controllers;

use App\Loan;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $loans = Loan::latest()->get();
        return view('pages.loan.index',compact('loans'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $loan = null;
        return view('pages.loan.create', compact('loan'));
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
            'balance'      => 'required|numeric',
            'interest_rate'      => 'required|numeric',
            'extra_interest_rate'      => 'required|numeric',
            'amount'    => 'required|numeric',
        ]);

        Loan::create($request->all());
        return redirect()
                    ->route('loan.index')
                    ->with('success', 'Added Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function show(Loan $loan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function edit(Loan $loan)
    {
        return view('pages.loan.edit', compact('loan'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Loan $loan)
    {
        $request->validate([
            'date'  =>'required',
            'balance'      => 'required|numeric',
            'interest_rate'      => 'required|numeric',
            'extra_interest_rate'      => 'required|numeric',
            'amount'    => 'required|numeric',
        ]);

        $loan->update($request->all());
        return redirect()
                    ->route('loan.index')
                    ->with('success', 'Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Loan $loan)
    {
        $loan->delete();
        return redirect()
                    ->route('loan.index')
                    ->with('success', 'Deleted Successfully');
    }
}
