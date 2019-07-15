<?php

namespace App\Http\Controllers;

use App\RawMaterial;
use Illuminate\Http\Request;
use PDF;
use Excel;

class RawMaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rawmaterials = RawMaterial::latest()->get();
        return view('pages.raw-materials.index', compact('rawmaterials'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $rawMaterial = null;
        return view('pages.raw-materials.create', compact('rawMaterial'));
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
        ]);

        RawMaterial::create([
            'name'   => $request->name,
            'details'   => $request->details,
        ]);

        return redirect()
                    ->route('raw-material.index')
                    ->with('success', 'Added Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\RawMaterial  $rawMaterial
     * @return \Illuminate\Http\Response
     */
    public function show(RawMaterial $rawMaterial)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\RawMaterial  $rawMaterial
     * @return \Illuminate\Http\Response
     */
    public function edit(RawMaterial $rawMaterial)
    {
        return view('pages.raw-materials.edit', compact('rawMaterial'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\RawMaterial  $rawMaterial
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RawMaterial $rawMaterial)
    {
        $request->validate([
            'name'      => 'required|string',
        ]);

        $rawMaterial->update([
            'name'   => $request->name,
            'details'   => $request->details,
        ]);

        return redirect()
                    ->route('raw-material.index')
                    ->with('success', 'Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\RawMaterial  $rawMaterial
     * @return \Illuminate\Http\Response
     */
    public function destroy(RawMaterial $rawMaterial)
    {
        $rawMaterial->delete();

        return redirect()
                    ->route('raw-material.index')
                    ->with('warning', 'Deleted Successfully');
    }

    //print raw materials list
    public function print()
    {
        $rawmaterials = RawMaterial::all();
        return view('pages.raw-materials.print',compact('rawmaterials'));
    }

    //pdf raw materials list
    public function exportPDF()
    {
        $rawmaterials = RawMaterial::all();

        $pdf = PDF::loadView('pages.raw-materials.pdf', compact('rawmaterials'));
        return $pdf->download('Raw Materials.pdf');
    }

    //excel of raw materials list
    public function exportExcel()
    {
        $rawmaterials = RawMaterial::all();

        Excel::create('Raw Materials', function($excel) use ($rawmaterials) {
            $excel->sheet('Raw Materials', function($sheet) use ($rawmaterials) {
                $sheet->loadView('pages.raw-materials.excel')->with('rawmaterials',$rawmaterials);
            });
        })->download('xls');
    }
}
