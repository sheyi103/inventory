<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Bill;
use App\SaleTransaction;
use Illuminate\Http\Request;
use PDF;
use Excel;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = Customer::latest()->get();
        return view('pages.customer.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $customer = null;
        return view('pages.customer.create', compact('customer'));
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

        Customer::create($request->all());

        return redirect()
                    ->route('customer.index')
                    ->with('success', 'Added Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        return view('pages.customer.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customer $customer)
    {
        $request->validate([
            'name'      => 'required|string',
            'mobile'    => 'required',
            'address'   => 'required|string',
        ]);

        $customer->update($request->all());

        return redirect()
                    ->route('customer.index')
                    ->with('success','Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();

        return redirect()
                    ->route('customer.index')
                    ->with('success','Deleted Successfully');
    }

    //autocomplete search of customer
    public function autocompletesearch(Request $request)
    {
        $query = $request->get('term','');
                
        $customers = Customer::where('name','LIKE','%'.$query.'%')
                            ->get();

        $results=array();                    
        
        if(count($customers ) > 0){
            foreach ($customers  as $customer) {
                $results[] = [ 'id' => $customer['id'], 'text' => $customer['name']];                  
            }
            return response()->json($results);
        }
        else{
            $data[] = 'Nothing Found';
            return $data;
        }
    }

    //individual customer transaction report
    public function report($id)
    {
        $customer = Customer::find($id);
        $bills = Bill::where('customer_id','=', $id)->get();
        $transactions = SaleTransaction::where('customer_id', $customer->id)->get();
        $bill_amount = 0;
        $paid_amount = 0;
        foreach ($transactions as $transaction) {
            if ($transaction->purpose == 1) {
                $bill_amount = $bill_amount + $transaction->amount;
            }
            else {
                $paid_amount = $paid_amount + $transaction->amount;
            }
        }
        $balance = $bill_amount - $paid_amount;

        return view('pages.customer.report',compact('customer','bills','balance','id','transactions'));
    }

    //print customer list
    public function print()
    {
        $customers = Customer::all();
        return view('pages.customer.print',compact('customers'));
    }

    //pdf customer list
    public function exportPDF()
    {
        $customers = Customer::all();

        $pdf = PDF::loadView('pages.customer.pdf', compact('customers'));
        return $pdf->download('Customers.pdf');
    }

    //pdf customer list
    public function exportExcel()
    {
        $customers = Customer::all();

        Excel::create('Customers', function($excel) use ($customers) {
            $excel->sheet('Customers', function($sheet) use ($customers) {
                $sheet->loadView('pages.customer.excel')->with('customers',$customers);
            });
        })->download('xls');
    }

    //print customer report
    // public function printReport($id)
    // {
    //     $customer = Customer::find($id);
    //     $sales = Sale::where('customer_id','=', $id)->get();
    //     $cash_sales = CashPayment::where('customer_id','=', $id)->sum('amount');
    //     $due_sales = DuePayment::where('customer_id','=', $id)->sum('amount');
    //     $receivable = DuePayment::where('customer_id','=', $id)->sum('due');

    //     return view('pages.customer.print-report',compact('customer','sales','cash_sales','due_sales','receivable'));
    // }

    //pdf of customer report 
    // public function reportPDF($id)
    // {
    //     $customer = Customer::find($id);
    //     $sales = Sale::where('customer_id','=', $id)->get();
    //     $cash_sales = CashPayment::where('customer_id','=', $id)->sum('amount');
    //     $due_sales = DuePayment::where('customer_id','=', $id)->sum('amount');
    //     $receivable = DuePayment::where('customer_id','=', $id)->sum('due');

    //     $pdf = PDF::loadView('pages.customer.report-pdf', compact('customer','sales','cash_sales','due_sales','receivable'));
    //     return $pdf->download('CustomerReport.pdf');
    // }

    //excel of customer report 
    // public function reportExcel($id)
    // {
    //     $customer = Customer::find($id);
    //     $sales = Sale::where('customer_id','=', $id)->get();
    //     $cash_sales = CashPayment::where('customer_id','=', $id)->sum('amount');
    //     $due_sales = DuePayment::where('customer_id','=', $id)->sum('amount');
    //     $receivable = DuePayment::where('customer_id','=', $id)->sum('due');

    //     Excel::create('CustomerReport', function($excel) use ($customer, $sales, $cash_sales, $due_sales,$receivable) {
    //         $excel->sheet('CustomerReport', function($sheet) use ($customer, $sales, $cash_sales, $due_sales, $receivable) {
    //             $sheet->loadView('pages.customer.report-excel')->with('customer',$customer)
    //             ->with('sales',$sales)
    //             ->with('cash_sales',$cash_sales)
    //             ->with('due_sales',$due_sales)
    //             ->with('receivable',$receivable);
    //         });
    //     })->download('xls');
    // }
}
