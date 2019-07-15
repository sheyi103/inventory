<?php

namespace App\Http\Controllers;

use App\Bill;
use App\SaleTransaction;
use App\Customer;
use App\Product;
use DB;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BillController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.bill.index');
    }

    //server side datatable
    public function allBills(Request $request)
    {      
        $columns = array( 
                            0 =>'id', 
                            1 =>'date',
                            2=> 'customer_id',
                            3=> 'workOrder_id',
                            4=> 'challan_no',
                            5=> 'amount',
                            6=> 'actions',
                        );
  
        $totalData = Bill::groupBy('token')->get()->count();
            
        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
            
        if(empty($request->input('search.value')))
        {            
            $bills = Bill::with('product', 'customer')
            ->latest()
            ->groupBy('token')
            ->selectRaw('id, workOrder_id, date, customer_id, challan_no, sum(amount)as amount, token')
            ->offset($start)
            ->limit($limit)
            ->orderBy($order,$dir)
            ->get();
        }
        else {
            $search = $request->input('search.value'); 

            $bills = Bill::with('product', 'customer')
            ->latest()
            ->groupBy('token')
            ->selectRaw('id, workOrder_id, date, customer_id, challan_no, sum(amount)as amount, token')
            ->where('date','LIKE',"%{$search}%")
            ->orWhere('workOrder_id','LIKE',"%{$search}%")
            ->orWhere('challan_no','LIKE',"%{$search}%")
            ->orWhereHas('customer', function($query) use($search) {
                $query->where('name','LIKE',"%{$search}%");
            })
            ->offset($start)
            ->limit($limit)
            ->orderBy($order,$dir)
            ->get();

            $totalFiltered = Bill::with('product', 'customer')
            ->groupBy('token')
            ->selectRaw('id, workOrder_id, date, customer_id, challan_no, sum(amount)as amount, token')
            ->where('date','LIKE',"%{$search}%")
            ->orWhere('workOrder_id','LIKE',"%{$search}%")
            ->orWhere('challan_no','LIKE',"%{$search}%")
            ->orWhereHas('customer', function($query) use($search) {
                $query->where('name','LIKE',"%{$search}%");
            })
            ->get()
            ->count();
        }

        $data = array();
        if(!empty($bills))
        {
            foreach ($bills as $key => $value)
            {
                $nestedData['id'] = $key + 1;
                $nestedData['date'] = $value->date;
                $nestedData['customer_id'] = $value->customer->name;
                $nestedData['workOrder_id'] = $value->workOrder_id;
                $nestedData['challan_no'] = $value->challan_no;
                $nestedData['amount'] = $value->amount;
                $nestedData['actions'] = '<div class="btn-group">
                                    <a href="'.route('bill.show',$value->token) .'" class="btn btn-primary btn-sm" title="Show">
                                        Show
                                    </a>
                                    <a href="'.url('bill/print',$value->token) .'" class="btn btn-success btn-sm" title="Print">
                                        Print
                                    </a>
                                    <button class="btn btn-sm btn-danger btn-delete" data-remote=" '.url('bill/full-destroy',$value->token) .'" title="Delete">Delete</button>
                                </div>';
                $data[] = $nestedData;

            }
        }
          
        $json_data = array(
                    "draw"            => intval($request->input('draw')),  
                    "recordsTotal"    => intval($totalData),  
                    "recordsFiltered" => intval($totalFiltered), 
                    "data"            => $data   
                    );
            
        echo json_encode($json_data);        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $bill = null;
        $products = Product::all('id','name');
        $customers = Customer::all('id','name');
        return view('pages.bill.create', compact('bill','products','customers'));
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
            'date'      => 'required',
            'challan_no'      => 'required',
            'customer_id'  => ['required', Rule::notIn(['','0'])],
        ]);
        $totalBill = [];
        $token = time().str_random(10);
        DB::transaction(function () use ($request, $totalBill, $token) {
            for ($i=0; $i < count($request->product_id) ; $i++) { 

                $bill =  new Bill;

                $bill->date = $request->date;
                $bill->customer_id = $request->customer_id;
                $bill->details = $request->details;
                $bill->product_id = $request->product_id[$i];
                $bill->rate = $request->rate[$i];
                $bill->vat = $request->vat[$i];
                $bill->quantity = $request->quantity[$i];
                $bill->amount = $request->quantity[$i] * $request->rate[$i];
                $bill->challan_no = $request->challan_no;
                $bill->workOrder_id = $request->workOrder_id;
                $bill->token = $token;

                $bill->save();
                $total = ($request->quantity[$i] * $request->rate[$i]) + $request->vat[$i];
                array_push($totalBill, $total);
            }

            $transaction = new SaleTransaction;

            $transaction->date = $request->date;
            $transaction->customer_id = $request->customer_id;
            $transaction->token = $token;
            $transaction->amount = array_sum($totalBill);
            $transaction->purpose = 1;

            $transaction->save();

            // if ($request->payment) {
            //     $transaction = new SaleTransaction;

            //     $transaction->date = $request->date;
            //     $transaction->customer_id = $request->customer_id;
            //     $transaction->invoice = $request->invoice;
            //     $transaction->amount = $request->payment;
            //     $transaction->purpose = 2;

            //     $transaction->save();
            // }
        });

        return redirect()
                    ->route('bill.index')
                    ->with('success', 'Added Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Bill  $bill
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $bills = Bill::where('token', $id)->get();
        return view('pages.bill.show',compact('bills'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Bill  $bill
     * @return \Illuminate\Http\Response
     */
    public function edit(Bill $bill)
    {
        $products = Product::all('id','name');
        $customers = Customer::all('id','name');
        return view('pages.bill.edit',compact('bill','products','customers'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Bill  $bill
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bill $bill)
    {
        $request->validate([
            'date'      => 'required',
            'rate'      => 'required',
            'quantity'      => 'required',
            'product_id'  => ['required', Rule::notIn(['','0'])],
        ]);
        DB::transaction(function () use ($request, $bill) {
            $transaction = SaleTransaction::where([
                    ['token', $bill->token],
                    ['purpose', '=', '1']
                ])->first();
            $transaction->amount = $transaction->amount - ($bill->amount + $bill->vat);
            $transaction->amount = $transaction->amount + (($request->rate * $request->quantity) + $request->vat);
            $transaction->save();

            $bill->update([
                'date'      => $request->date,
                'details'   => $request->details,
                'rate'     => $request->rate,
                'quantity'     => $request->quantity,
                'vat'     => $request->vat,
                'amount'     => $request->rate * $request->quantity,
                'product_id'    => $request->product_id,
            ]);
        });
        return redirect()
                    ->route('bill.index')
                    ->with('success', 'Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Bill  $bill
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bill $bill)
    {
        DB::transaction(function () use ($bill) {
            $transaction = SaleTransaction::where([
                    ['token', $bill->token],
                    ['purpose', '=', '1']
                ])->first();
            $transaction->amount = $transaction->amount - ($bill->amount + $bill->vat);
            $transaction->save();

            $bill->delete();
        });
        return redirect()
                    ->route('bill.index')
                    ->with('success', 'Deleted Successfully');
    }

    public function destroyBill($id)
    {
        DB::transaction(function () use ($id) {
            $transaction = SaleTransaction::where([
                    ['token', $id],
                    ['purpose', '=', '1']
                ])->first();
            $transaction->delete();

            $bills = Bill::where('token', $id)->get();
            foreach ($bills as $bill) {
               $bill->delete();
            }
            
        });
        return redirect()
                    ->route('bill.index')
                    ->with('success', 'Deleted Successfully');
    }
}
