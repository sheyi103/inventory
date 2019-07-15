<?php

namespace App\Http\Controllers;

use App\CcLoan;
use Illuminate\Http\Request;

class CcLoanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $loans = CcLoan::latest()->get();
        return view('pages.cc-loan.index',compact('loans'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $ccLoan = null;
        return view('pages.cc-loan.create', compact('ccLoan'));
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
            'loan_from'  =>'required',
            'limit'      => 'required|numeric',
            'available'      => 'required|numeric',
            'interest_rate'      => 'required|numeric',
        ]);

        CcLoan::create($request->all());
        return redirect()
                    ->route('cc-loan.index')
                    ->with('success', 'Added Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CcLoan  $ccLoan
     * @return \Illuminate\Http\Response
     */
    public function show(CcLoan $ccLoan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CcLoan  $ccLoan
     * @return \Illuminate\Http\Response
     */
    public function edit(CcLoan $ccLoan)
    {
        return view('pages.cc-loan.edit', compact('ccLoan'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CcLoan  $ccLoan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CcLoan $ccLoan)
    {
        $request->validate([
            'loan_from'  =>'required',
            'limit'      => 'required|numeric',
            'available'      => 'required|numeric',
            'interest_rate'      => 'required|numeric',
        ]);

        $ccLoan->update($request->all());
        return redirect()
                    ->route('cc-loan.index')
                    ->with('success', 'Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CcLoan  $ccLoan
     * @return \Illuminate\Http\Response
     */
    public function destroy(CcLoan $ccLoan)
    {
        $ccLoan->delete();
        return redirect()
                    ->route('cc-loan.index')
                    ->with('success', 'Deleted Successfully');
    }
}
