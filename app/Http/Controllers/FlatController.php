<?php

namespace App\Http\Controllers;

use App\Flat;
use Illuminate\Http\Request;

class FlatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $flats = Flat::latest()->get();
        return view('pages.flats.index', compact('flats'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $flat = null;
        return view('pages.flats.create', compact('flat'));
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
            'name'      => 'required|string',
            'tenant_name'      => 'required|string',
            'tenant_mobile'      => 'required',
        ]);

        Flat::create([
            'name'   => $request->name,
            'tenant_name'   => $request->tenant_name,
            'tenant_mobile'  => $request->tenant_mobile,
            'details'  => $request->details,
        ]);

        return redirect()
                    ->route('flat.index')
                    ->with('success', 'Added Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Flat  $flat
     * @return \Illuminate\Http\Response
     */
    public function show(Flat $flat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Flat  $flat
     * @return \Illuminate\Http\Response
     */
    public function edit(Flat $flat)
    {
        return view('pages.flats.edit', compact('flat'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Flat  $flat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Flat $flat)
    {
        $request->validate([
            'name'      => 'required|string',
            'tenant_name'      => 'required|string',
            'tenant_mobile'      => 'required',
        ]);

        $flat->update([
            'name'   => $request->name,
            'tenant_name'   => $request->tenant_name,
            'tenant_mobile'  => $request->tenant_mobile,
            'details'  => $request->details,
        ]);

        return redirect()
                    ->route('flat.index')
                    ->with('success', 'Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Flat  $flat
     * @return \Illuminate\Http\Response
     */
    public function destroy(Flat $flat)
    {
        $flat->delete();

        return redirect()
                    ->route('flat.index')
                    ->with('warning', 'Deleted Successfully');
    }

    //print flat list
    public function print()
    {
        $flats = Flat::all();
        return view('pages.flats.print',compact('flats'));
    }

    //pdf flat list
    public function exportPDF()
    {
        $flats = Flat::all();

        $pdf = PDF::loadView('pages.flats.pdf', compact('flats'));
        return $pdf->download('Flats.pdf');
    }

    //excel of flat list
    public function exportExcel()
    {
        $flats = Flat::all();

        Excel::create('Flats', function($excel) use ($flats) {
            $excel->sheet('Flats', function($sheet) use ($flats) {
                $sheet->loadView('pages.flats.excel')->with('flats',$flats);
            });
        })->download('xls');
    }
}
