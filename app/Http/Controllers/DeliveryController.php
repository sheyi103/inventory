<?php

namespace App\Http\Controllers;

use App\Delivery;
use App\Order;
use App\Product;
use App\Customer;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use DB;

class DeliveryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.delivery.index');
    }

    //server side datatable
    public function allDeliveries(Request $request)
    {      
        $columns = array( 
                            0 =>'id', 
                            1 =>'date',
                            2=> 'customer_id',
                            3=> 'workOrder_id',
                            4=> 'challan_no',
                            5=> 'product_id',
                            6=> 'quantity',
                            7=> 'actions',
                        );
  
        $totalData = Delivery::count();
            
        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
            
        if(empty($request->input('search.value')))
        {            
            $deliveries = Delivery::with('product', 'customer')
            ->latest()
            ->selectRaw('id, workOrder_id, date, customer_id, product_id, quantity, challan_no')
            ->offset($start)
            ->limit($limit)
            ->orderBy($order,$dir)
            ->get();
        }
        else {
            $search = $request->input('search.value'); 

            $deliveries = Delivery::with('product', 'customer')
            ->latest()
            ->selectRaw('id, workOrder_id, date, customer_id, product_id, quantity, challan_no')
            ->where('date','LIKE',"%{$search}%")
            ->orWhere('workOrder_id','LIKE',"%{$search}%")
            ->orWhere('challan_no','LIKE',"%{$search}%")
            ->orWhereHas('customer', function($query) use($search) {
                $query->where('name','LIKE',"%{$search}%");
            })
            ->orWhereHas('product', function($query) use($search) {
                $query->where('name','LIKE',"%{$search}%");
            })
            ->offset($start)
            ->limit($limit)
            ->orderBy($order,$dir)
            ->get();

            $totalFiltered = Delivery::with('product', 'customer')
            ->selectRaw('id, workOrder_id, date, customer_id, product_id, quantity, challan_no')
            ->where('date','LIKE',"%{$search}%")
            ->orWhere('workOrder_id','LIKE',"%{$search}%")
            ->orWhere('challan_no','LIKE',"%{$search}%")
            ->orWhereHas('customer', function($query) use($search) {
                $query->where('name','LIKE',"%{$search}%");
            })
            ->orWhereHas('product', function($query) use($search) {
                $query->where('name','LIKE',"%{$search}%");
            })
            ->count();
        }

        $data = array();
        if(!empty($deliveries))
        {
            foreach ($deliveries as $key => $value)
            {
                $nestedData['id'] = $key + 1;
                $nestedData['date'] = $value->date;
                $nestedData['customer_id'] = $value->customer->name;
                $nestedData['workOrder_id'] = $value->workOrder_id;
                $nestedData['challan_no'] = $value->challan_no;
                $nestedData['product_id'] = $value->product->name;
                $nestedData['quantity'] = $value->quantity;
                $nestedData['actions'] = '<div class="btn-group">
                                    <a href="'.route('delivery.edit',$value->id) .'" class="btn btn-primary btn-sm" title="Update">
                                        Update
                                    </a>
                                    <button class="btn btn-sm btn-danger btn-delete" data-remote=" '.route('delivery.destroy',$value->id) .'" title="Delete">Delete
                                    </button>
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
        $products = Product::all('name','id');
        $customers = Customer::all('name','id');
        $delivery = null;
        return view('pages.delivery.create',compact('customers','delivery','products'));
    }

    //create delivery from an order
    public function createDeliveryFromOrder($id)
    {
        $orders = Order::where('workOrder_id', $id)->get();
        $products = [];
        foreach ($orders as $order) {
            $product = Product::find($order->product_id);
            array_push($products, $product);
        }
        $delivery = null;
        return view('pages.delivery.create-from-order',compact('id','delivery','products'));
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
        ]);

        DB::transaction(function () use ($request) {
            for ($i=0; $i < count($request->product_id) ; $i++) { 
                $delivery = new Delivery;

                $delivery->date = $request->date;
                $delivery->customer_id = $request->customer_id;
                $delivery->details = $request->details;
                $delivery->challan_no = $request->challan_no;
                $delivery->product_id = $request->product_id[$i];
                $delivery->quantity = $request->quantity[$i];

                $delivery->save();
            }      
        });
        return redirect()
                    ->route('delivery.index')
                    ->with('success', 'Delivery Added Successfully');
    }

    //store delivery created from an order
    public function storeDeliveryFromOrder(Request $request, $id)
    {
        $request->validate([
            'date'      => 'required',
        ]);

        DB::transaction(function () use ($id, $request) {
            for ($i=0; $i < count($request->product_id) ; $i++) { 

                $order = Order::where([
                    ['workOrder_id', $id],
                    ['product_id', $request->product_id[$i]]
                ])->first();

                if ($order->remaining < $request->quantity[$i]) {
                    return Redirect::back()
                    ->withInput(Input::all())
                    ->with('warning', 'order remaining quantity is less than the given quantity');
                }

                $delivery = new Delivery;

                $delivery->date = $request->date;
                $delivery->customer_id = $order->customer_id;
                $delivery->workOrder_id = $id;
                $delivery->details = $request->details;
                $delivery->challan_no = $request->challan_no;
                $delivery->product_id = $request->product_id[$i];
                $delivery->quantity = $request->quantity[$i];

                $delivery->save();

                $order->remaining = $order->remaining - $request->quantity[$i];
                $order->save();
            }      
        });
        return redirect()
                    ->route('order.index')
                    ->with('success', 'Delivery Added Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Delivery  $delivery
     * @return \Illuminate\Http\Response
     */
    public function show(Delivery $delivery)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Delivery  $delivery
     * @return \Illuminate\Http\Response
     */
    public function edit(Delivery $delivery)
    {
        $products = Product::all('name','id');
        $customers = Customer::all('name','id');
        return view('pages.delivery.edit',compact('customers','delivery','products'));
    }

    //edit delivery created from an order
    public function editDeliveryFromOrder($id)
    {
        $delivery = Delivery::find($id);
        $orders = Order::where('workOrder_id', $delivery->workOrder_id)->get();
        $products = [];
        foreach ($orders as $order) {
            $product = Product::find($order->product_id);
            array_push($products, $product);
        }
        return view('pages.delivery.edit',compact('delivery','products'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Delivery  $delivery
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Delivery $delivery)
    {
        $request->validate([ 
            'product_id'  => ['required', Rule::notIn(['','0'])],
            'customer_id'  => ['required', Rule::notIn(['','0'])],
            'date'              => 'required',
            'quantity'            => ['required', 'integer'],
        ]);

        $delivery->update([
            'date'      => $request->date,
            'product_id'  =>$request->product_id,
            'customer_id'  =>$request->customer_id,
            'quantity'   => $request->quantity,
            'details'   => $request->details,
            'challan_no' => $request->challan_no
        ]);

        return redirect()
                    ->route('delivery.index')
                    ->with('success', 'Delivery Updated Successfully');
    }

    //update delivery created from an order
    public function updateDeliveryFromOrder(Request $request, $id)
    {
        $request->validate([ 
            'product_id'  => ['required', Rule::notIn(['','0'])],
            'date'              => 'required',
            'quantity'            => ['required', 'integer'],
        ]);

        $delivery = Delivery::find($id);
        $oldOrder = Order::where([
                    ['workOrder_id', $delivery->workOrder_id],
                    ['product_id', $delivery->product_id]
                ])->first();
        DB::transaction(function () use ($oldOrder, $delivery, $request) {

            $oldOrder->remaining = $oldOrder->remaining + $delivery->quantity;
            $oldOrder->save();

            $order = Order::where([
                    ['workOrder_id', $delivery->workOrder_id],
                    ['product_id', $request->product_id]
                ])->first();

            if ($order->remaining < $request->quantity) {
                return Redirect::back()
                ->withInput(Input::all())
                ->with('warning', 'remaining quantity is less than the given quantity');
            }

            $order->remaining = $order->remaining - $request->quantity;
            $order->save();

            $delivery->update([
                'date'      => $request->date,
                'product_id'  =>$request->product_id,
                'quantity'   => $request->quantity,
                'details'   => $request->details,
                'challan_no' => $request->challan_no
            ]);
        });

        return redirect()
        ->route('order.index')
        ->with('success', 'Delivery Info Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Delivery  $delivery
     * @return \Illuminate\Http\Response
     */
    public function destroy(Delivery $delivery)
    {
        $delivery->delete();
        return redirect()
                    ->route('delivery.index')
                    ->with('success', 'Delivery Deleted Successfully');
    }

    //destroy a delivery created from an order
    public function destroyDeliveryFromOrder($id)
    {
        $delivery = Delivery::find($id);
        $order = Order::where([
                    ['workOrder_id', $delivery->workOrder_id],
                    ['product_id', $delivery->product_id]
                ])->first();
        DB::transaction(function () use ($order, $delivery) {

            $order->remaining = $order->remaining + $delivery->quantity;
            $order->save();    

            $delivery->delete();
        });

        return redirect()
        ->route('order.index')
        ->with('success', 'Delivery Deleted Successfully');
    }

    //order delivery report
    public function report($id)
    {
        $deliveries = Delivery::where('workOrder_id', $id)->get();
        return view('pages.delivery.report',compact('id','deliveries'));
    }
}
