<?php

namespace App\Http\Controllers;

use App\Asset;
use Illuminate\Http\Request;
use PDF;
use Excel;

class AssetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $assets = Asset::latest()->get();
        return view('pages.asset.index',compact('assets'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $asset = null;
        return view('pages.asset.create', compact('asset'));
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
            'name'      => 'required|string',
            'amount'    => 'required|numeric',
        ]);

        Asset::create($request->all());
        return redirect()
                    ->route('asset.index')
                    ->with('success', 'Added Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Asset  $asset
     * @return \Illuminate\Http\Response
     */
    public function show(Asset $asset)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Asset  $asset
     * @return \Illuminate\Http\Response
     */
    public function edit(Asset $asset)
    {
        return view('pages.asset.edit', compact('asset'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Asset  $asset
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Asset $asset)
    {
        $request->validate([
            'date'  =>'required',
            'name'      => 'required|string',
            'amount'    => 'required|numeric',
        ]);

        $asset->update($request->all());
        return redirect()
                    ->route('asset.index')
                    ->with('success', 'Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Asset  $asset
     * @return \Illuminate\Http\Response
     */
    public function destroy(Asset $asset)
    {
        $asset->delete();
        return redirect()
                    ->route('asset.index')
                    ->with('success', 'Deleted Successfully');
    }

    //print customer list
    public function print()
    {
        $assets = Asset::all();
        $total = Asset::sum('amount');
        return view('pages.asset.print',compact('assets','total'));
    }

    //pdf customer list
    public function exportPDF()
    {
        $assets = Asset::all();
        $total = Asset::sum('amount');

        $pdf = PDF::loadView('pages.asset.pdf', compact('assets','total'));
        return $pdf->download('Assets.pdf');
    }

    //pdf customer list
    public function exportExcel()
    {
        $assets = Asset::all();
        $total = Asset::sum('amount');

        Excel::create('Assets', function($excel) use ($assets, $total) {
            $excel->sheet('Assets', function($sheet) use ($assets, $total) {
                $sheet->loadView('pages.asset.excel')
                ->with('assets',$assets)
                ->with('total',$total);
            });
        })->download('xls');
    }
}
