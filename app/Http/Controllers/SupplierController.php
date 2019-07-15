<?php

namespace App\Http\Controllers;

use App\Supplier;
use App\Purchase;
use App\CashPurchase;
use App\DuePurchase;
use Illuminate\Http\Request;
use PDF;
use Excel;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $suppliers = Supplier::latest()->get();
        return view('pages.supplier.index', compact('suppliers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $supplier = null;
        return view('pages.supplier.create', compact('supplier'));
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
            'mobile'    => 'required',
            'address'   => 'required|string',
        ]);

        Supplier::create($request->all());

        return redirect()
                    ->route('supplier.index')
                    ->with('success', 'Added Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function show(Supplier $supplier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function edit(Supplier $supplier)
    {
        return view('pages.supplier.edit', compact('supplier'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Supplier $supplier)
    {
        $request->validate([
            'name'      => 'required|string',
            'mobile'    => 'required',
            'address'   => 'required|string',
        ]);

        $supplier->update($request->all());

        return redirect()
                    ->route('supplier.index')
                    ->with('success','Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function destroy(Supplier $supplier)
    {
        $supplier->delete();

        return redirect()
                    ->route('supplier.index')
                    ->with('success','Deleted Successfully');
    }

    //autocomplete search of supplier
    public function autocompletesearch(Request $request)
    {
        $query = $request->get('term','');
                
        $suppliers = Supplier::where('name','LIKE','%'.$query.'%')
                            ->get();

        $results=array();                    
        
        if(count($suppliers ) > 0){
            foreach ($suppliers  as $supplier) {
                $results[] = [ 'id' => $supplier['id'], 'text' => $supplier['name']];                  
            }
            return response()->json($results);
        }
        else{
            $data[] = 'Nothing Found';
            return $data;
        }
    }

    //individual supplier transaction report
    public function report($id)
    {
        $supplier = Supplier::find($id);
        $purchases = Purchase::where('supplier_id','=', $id)->get();
        $cash_purchases = CashPurchase::where('supplier_id','=', $id)->sum('amount');
        $due_purchases = DuePurchase::where('supplier_id','=', $id)->sum('amount');
        $payable = DuePurchase::where('supplier_id','=', $id)->sum('due');

        return view('pages.supplier.report',compact('supplier','purchases','cash_purchases','due_purchases','payable','id'));
    }

    //print supplier list
    public function print()
    {
        $suppliers = Supplier::all();
        return view('pages.supplier.print',compact('suppliers'));
    }

    //pdf supplier list
    public function exportPDF()
    {
        $suppliers = Supplier::all();

        $pdf = PDF::loadView('pages.supplier.pdf', compact('suppliers'));
        return $pdf->download('Suppliers.pdf');
    }

    //excel of supplier list
    public function exportExcel()
    {
        $suppliers = Supplier::all();

        Excel::create('Suppliers', function($excel) use ($suppliers) {
            $excel->sheet('Suppliers', function($sheet) use ($suppliers) {
                $sheet->loadView('pages.supplier.excel')->with('suppliers',$suppliers);
            });
        })->download('xls');
    }

    //print supplier report
    public function printReport($id)
    {
        $supplier = Supplier::find($id);
        $purchases = Purchase::where('supplier_id','=', $id)->get();
        $cash_purchases = CashPurchase::where('supplier_id','=', $id)->sum('amount');
        $due_purchases = DuePurchase::where('supplier_id','=', $id)->sum('amount');
        $payable = DuePurchase::where('supplier_id','=', $id)->sum('due');

        return view('pages.supplier.print-report',compact('supplier','purchases','cash_purchases','due_purchases','payable'));
    }

    //pdf of supplier report 
    public function reportPDF($id)
    {
        $supplier = Supplier::find($id);
        $purchases = Purchase::where('supplier_id','=', $id)->get();
        $cash_purchases = CashPurchase::where('supplier_id','=', $id)->sum('amount');
        $due_purchases = DuePurchase::where('supplier_id','=', $id)->sum('amount');
        $payable = DuePurchase::where('supplier_id','=', $id)->sum('due');

        $pdf = PDF::loadView('pages.supplier.report-pdf', compact('supplier','purchases','cash_purchases','due_purchases','payable'));
        return $pdf->download('SupplierReport.pdf');
    }

    //excel of supplier report 
    public function reportExcel($id)
    {
        $supplier = Supplier::find($id);
        $purchases = Purchase::where('supplier_id','=', $id)->get();
        $cash_purchases = CashPurchase::where('supplier_id','=', $id)->sum('amount');
        $due_purchases = DuePurchase::where('supplier_id','=', $id)->sum('amount');
        $payable = DuePurchase::where('supplier_id','=', $id)->sum('due');

        Excel::create('SupplierReport', function($excel) use ($supplier, $purchases, $cash_purchases, $due_purchases,$payable) {
            $excel->sheet('SupplierReport', function($sheet) use ($supplier, $purchases, $cash_purchases, $due_purchases, $payable) {
                $sheet->loadView('pages.supplier.report-excel')->with('supplier',$supplier)
                ->with('purchases',$purchases)
                ->with('cash_purchases',$cash_purchases)
                ->with('due_purchases',$due_purchases)
                ->with('payable',$payable);
            });
        })->download('xls');
    }
}
