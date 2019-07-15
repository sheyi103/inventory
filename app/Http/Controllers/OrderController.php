<?php

namespace App\Http\Controllers;

use App\Order;
use App\Product;
use App\Customer;
use App\Delivery;
use DB;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.order.index');
    }

    //server side datatable
    public function allOrders(Request $request)
    {      
        $columns = array( 
                            0 =>'id', 
                            1 =>'date',
                            2=> 'customer_id',
                            3=> 'workOrder_id',
                            4=> 'status',
                            5=> 'actions',
                        );
  
        $totalData = Order::groupBy('workOrder_id')->get()->count();
            
        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
            
        if(empty($request->input('search.value')))
        {            
            $orders = Order::with('product', 'customer')
            ->latest()
            ->groupBy('workOrder_id')
            ->selectRaw('id, workOrder_id, date, customer_id, remaining')
            ->offset($start)
            ->limit($limit)
            ->orderBy($order,$dir)
            ->get();
        }
        else {
            $search = $request->input('search.value'); 

            $orders = Order::with('product', 'customer')
            ->latest()
            ->groupBy('workOrder_id')
            ->selectRaw('id, workOrder_id, date, customer_id, remaining')
            ->where('date','LIKE',"%{$search}%")
            ->orWhere('workOrder_id','LIKE',"%{$search}%")
            ->orWhereHas('customer', function($query) use($search) {
                $query->where('name','LIKE',"%{$search}%");
            })
            ->offset($start)
            ->limit($limit)
            ->orderBy($order,$dir)
            ->get();

            $totalFiltered = Order::with('product', 'customer')
            ->groupBy('workOrder_id')
            ->selectRaw('id, workOrder_id, date, customer_id, remaining')
            ->where('date','LIKE',"%{$search}%")
            ->orWhere('workOrder_id','LIKE',"%{$search}%")
            ->orWhereHas('customer', function($query) use($search) {
                $query->where('name','LIKE',"%{$search}%");
            })
            ->get()
            ->count();
        }

        $data = array();
        if(!empty($orders))
        {
            foreach ($orders as $key => $value)
            {
                $nestedData['id'] = $key + 1;
                $nestedData['date'] = $value->date;
                $nestedData['customer_id'] = $value->customer->name;
                $nestedData['workOrder_id'] = $value->workOrder_id;
                $nestedData['status'] = $value->remaining <= '0' ? "<span class='badge badge-primary'>Completed</span>" : "<span class='badge badge-warning'>Pending</span>";
                $nestedData['actions'] = '<div class="btn-group">
                                    <a href="'.url('order/delivery',$value->workOrder_id) .'" class="btn btn-warning btn-sm" title="Delivery">
                                        Delivery
                                    </a>
                                    <a href="'.route('order.show',$value->workOrder_id) .'" class="btn btn-primary btn-sm" title="View">
                                        View
                                    </a>
                                    <button class="btn btn-sm btn-danger btn-delete" data-remote=" '.url('full-order/destroy',$value->workOrder_id) .'" title="Delete">Delete
                                    </button>
                                    <a href="'.url('order/delivery/report',$value->workOrder_id) .'" class="btn btn-info btn-sm" title="Report">
                                        Report
                                    </a>
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
        $order = null;
        $products = Product::all('id','name');
        $customers = Customer::all('id','name');
        return view('pages.order.create', compact('order','products','customers'));
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
            'customer_id'  => ['required', Rule::notIn(['','0'])],
            'workOrder_id'     => 'required|unique:orders',
        ]);

        for ($i=0; $i < count($request->product_id) ; $i++) { 

            $order =  new Order;

            $order->date = $request->date;
            $order->customer_id = $request->customer_id;
            $order->workOrder_id = $request->workOrder_id;
            $order->details = $request->details;
            $order->product_id = $request->product_id[$i];
            $order->rate = $request->rate[$i];
            $order->vat = $request->vat[$i];
            $order->quantity = $request->quantity[$i];
            $order->remaining = $request->quantity[$i];
            $order->amount = $request->quantity[$i] * $request->rate[$i];

            $order->save();
        }

        return redirect()
                    ->route('order.index')
                    ->with('success', 'Added Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $orders = Order::where('workOrder_id', $id)->get();
        return view('pages.order.show',compact('orders'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        return view('pages.order.edit',compact('order'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        $request->validate([
            'rate'      => 'required|numeric',
            'vat'      => 'required|numeric',
            'quantity'      => 'required|numeric',
        ]);

        $order->update([
            'vat'      => $request->vat,
            'quantity'   => $request->quantity,
            'rate'   => $request->rate,
            'amount'   => $request->rate * $request->quantity,
        ]);

        return redirect()
                    ->route('order.index')
                    ->with('success', 'Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        $deliveries = Delivery::where([
                    ['workOrder_id', $order->workOrder_id],
                    ['product_id', $order->product_id]
                ])->get();
        DB::transaction(function () use ($order, $deliveries) {

            foreach ($deliveries as $delivery) {
                $delivery->delete();    
            }  

            $order->delete();
        });

        return redirect()
        ->route('order.index')
        ->with('success', 'Delivery Deleted Successfully');
    }

    //destroy full order
    public function destroyFullOrder($id)
    {
        $orders = Order::where('workOrder_id', $id)->get();
        DB::transaction(function () use ($orders) {

            foreach ($orders as $order) {
                $deliveries = Delivery::where([
                    ['workOrder_id', $order->workOrder_id],
                    ['product_id', $order->product_id]
                ])->get();
                foreach ($deliveries as $delivery) {
                    $delivery->delete();    
                }  
                $order->delete();
            }
        });

        return redirect()
        ->route('order.index')
        ->with('success', 'Order Deleted Successfully');
    }
}
