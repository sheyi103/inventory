<?php

namespace App\Http\Controllers;

use App\Glove;
use App\Customer;
use App\SaleTransaction;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use DB;

class GloveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.glove.index');
    }

    //server side datatable
    public function allGloves(Request $request)
    {      
        $columns = array( 
                            0 =>'id', 
                            1 =>'date',
                            2=> 'customer',
                            3=> 'quantity',
                            4=> 'rate',
                            5=> 'amount',
                            6=> 'actions',
                        );
  
        $totalData = Glove::count();
            
        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
            
        if(empty($request->input('search.value')))
        {            
            $gloves = Glove::offset($start)
                        ->latest()
                        ->limit($limit)
                        ->orderBy($order,$dir)
                        ->get();
        }
        else {
            $search = $request->input('search.value'); 

            $gloves =  Glove::with('customer')
                            ->latest()
                            ->where('amount','LIKE',"%{$search}%")
                            ->orWhere('date', 'LIKE',"%{$search}%")
                            ->orWhereHas('customer', function($query) use($search) {
                                $query->where('name','LIKE',"%{$search}%");
                            })
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();

            $totalFiltered = Glove::with('customer')
                            ->where('amount','LIKE',"%{$search}%")
                            ->orWhere('date', 'LIKE',"%{$search}%")
                            ->orWhereHas('customer', function($query) use($search) {
                                $query->where('name','LIKE',"%{$search}%");
                            })
                            ->count();
        }

        $data = array();
        if(!empty($gloves))
        {
            foreach ($gloves as $key => $value)
            {
                $nestedData['id'] = $key + 1;
                $nestedData['date'] = $value->date;
                $nestedData['customer'] = $value->customer->name;
                $nestedData['quantity'] = $value->quantity;
                $nestedData['rate'] = $value->rate;
                $nestedData['amount'] = $value->amount;
                $nestedData['actions'] = '<div class="btn-group">
                                    <a href="'.route('glove.show',$value->id) .'" class="btn btn-primary btn-sm" title="Show">
                                        Show
                                    </a>
                                    <a href="'.route('glove.edit',$value->id) .'" class="btn btn-success btn-sm" title="Update">
                                        Update
                                    </a>
                                    <button class="btn btn-sm btn-danger btn-delete" data-remote=" '.route('glove.destroy',$value->id) .'" title="Delete">Delete</button>
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
        $customers = Customer::all('name','id');
        $glove = null;
        return view('pages.glove.create',compact('customers','glove'));
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
            'quantity'      => 'required|numeric',
            'rate'      => 'required|numeric',
            'invoice'      => 'required',
            'customer_id'  => ['required', Rule::notIn(['','0'])],
        ]);

        DB::transaction(function () use ($request) {
            $glove = Glove::create($request->all());

            $transaction = new SaleTransaction;

            $transaction->date = $request->date;
            $transaction->customer_id = $request->customer_id;
            $transaction->glove_id = $glove->id;
            $transaction->invoice = $request->invoice;
            $transaction->amount = $request->amount;
            $transaction->purpose = 1;

            $transaction->save();

            if ($request->paid) {
                $transaction = new SaleTransaction;

                $transaction->date = $request->date;
                $transaction->customer_id = $request->customer_id;
                $transaction->glove_id = $glove->id;
                $transaction->invoice = $request->invoice;
                $transaction->amount = $request->paid;
                $transaction->purpose = 2;

                $transaction->save();
            }
        });

        return redirect()
                    ->route('glove.index')
                    ->with('success', 'Added Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Glove  $glove
     * @return \Illuminate\Http\Response
     */
    public function show(Glove $glove)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Glove  $glove
     * @return \Illuminate\Http\Response
     */
    public function edit(Glove $glove)
    {
        $customers = Customer::all('name','id');
        return view('pages.glove.edit',compact('customers','glove'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Glove  $glove
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Glove $glove)
    {
        $request->validate([
            'date'      => 'required',
            'quantity'      => 'required|numeric',
            'rate'      => 'required|numeric',
            'invoice'      => 'required',
            'customer_id'  => ['required', Rule::notIn(['','0'])],
        ]);

        DB::transaction(function () use ($request, $glove) {
            $glove->update($request->all());

            $saleTransaction = SaleTransaction::where([
                    ['glove_id', $glove->id],
                    ['purpose', '=', '1']
                ])->first();

            $saleTransaction->date = $request->date;
            $saleTransaction->customer_id = $request->customer_id;
            $saleTransaction->invoice = $request->invoice;
            $saleTransaction->amount = $request->amount;

            $saleTransaction->save();

            $paidTransaction = SaleTransaction::where([
                    ['glove_id', $glove->id],
                    ['purpose', '=', '2']
                ])->first();

            $paidTransaction->date = $request->date;
            $paidTransaction->customer_id = $request->customer_id;
            $paidTransaction->invoice = $request->invoice;
            $paidTransaction->amount = $request->paid;

            $paidTransaction->save();
        });

        return redirect()
                    ->route('glove.index')
                    ->with('success', 'Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Glove  $glove
     * @return \Illuminate\Http\Response
     */
    public function destroy(Glove $glove)
    {
        DB::transaction(function () use ($glove) {
            $transactions = SaleTransaction::where([
                    ['glove_id', $glove->id]
                ])->get();
            foreach ($transactions as $transaction) {
                $transaction->delete();
            }
            $glove->delete();
        });
        return redirect()
                    ->route('glove.index')
                    ->with('success', 'Deleted Successfully');
    }
}
