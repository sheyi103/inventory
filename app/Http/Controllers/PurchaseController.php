<?php

namespace App\Http\Controllers;

use App\Purchase;
use App\Supplier;
use App\RawMaterial;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use DB;
use Excel;
use PDF;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.purchase.index');
    }

    //server side datatable
    public function allPurchases(Request $request)
    {      
        $columns = array( 
                            0 =>'id', 
                            1 =>'date',
                            2=> 'rawMaterial_id',
                            3=> 'quantity',
                            4=> 'amount',
                            5=> 'actions',
                        );
  
        $totalData = Purchase::count();
            
        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
            
        if(empty($request->input('search.value')))
        {            
            $purchases = Purchase::offset($start)
                         ->limit($limit)
                         ->orderBy($order,$dir)
                         ->get();
        }
        else {
            $search = $request->input('search.value'); 

            $purchases =  Purchase::with('supplier','rawMaterial')
                            ->where('amount','LIKE',"%{$search}%")
                            ->orWhere('date', 'LIKE',"%{$search}%")
                            ->orWhereHas('supplier', function($query) use($search) {
                                $query->where('name','LIKE',"%{$search}%");
                            })
                            ->orWhereHas('rawMaterial', function($query) use($search) {
                                $query->where('name','LIKE',"%{$search}%");
                            })
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();

            $totalFiltered = Purchase::with('supplier','rawMaterial')
                            ->where('amount','LIKE',"%{$search}%")
                            ->orWhere('date', 'LIKE',"%{$search}%")
                            ->orWhereHas('supplier', function($query) use($search) {
                                $query->where('name','LIKE',"%{$search}%");
                            })
                            ->orWhereHas('rawMaterial', function($query) use($search) {
                                $query->where('name','LIKE',"%{$search}%");
                            })
                            ->count();
        }

        $data = array();
        if(!empty($purchases))
        {
            foreach ($purchases as $key => $value)
            {
                $nestedData['id'] = $key + 1;
                $nestedData['date'] = $value->date;
                $nestedData['rawMaterial_id'] = $value->rawMaterial->name;
                $nestedData['quantity'] = $value->quantity;
                $nestedData['amount'] = $value->amount;
                $nestedData['actions'] = '<div class="btn-group">
                                    <a href="'.route('purchase.show',$value->id) .'" class="btn btn-primary btn-sm" title="Show">
                                        Show
                                    </a>
                                    <a href="'.route('purchase.edit',$value->id) .'" class="btn btn-success btn-sm" title="Update">
                                        Update
                                    </a>
                                    <button class="btn btn-sm btn-danger btn-delete" data-remote=" '.route('purchase.destroy',$value->id) .'" title="Delete">Delete</button>
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
        $suppliers = Supplier::all('id','name');
        $rawMaterials = RawMaterial::all('id','name');
        $purchase = null;
        return view('pages.purchase.create', compact('suppliers','purchase','rawMaterials'));
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
            'rawMaterial_id'  => ['required', Rule::notIn(['','0'])],
            'supplier_id'  => ['required', Rule::notIn(['','0'])],
            'date'              => 'required',
            'invoice'              => 'required',
            'rate'      => ['required', 'numeric'],
            'quantity'            => ['required', 'integer'],
        ]);
        DB::transaction(function () use ($request) {
            Purchase::create($request->all());

            $rawMaterial = RawMaterial::find($request->rawMaterial_id);
            $rawMaterial->stock = $rawMaterial->stock + $request->quantity;
            $rawMaterial->save();
        });
        return redirect()
                    ->route('purchase.index')
                    ->with('success', 'Added Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function show(Purchase $purchase)
    {
        return view('pages.purchase.show',compact('purchase'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function edit(Purchase $purchase)
    {
        $suppliers = Supplier::all('id','name');
        $rawMaterials = RawMaterial::all('id','name');
        return view('pages.purchase.edit', compact('suppliers','purchase','rawMaterials'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Purchase $purchase)
    {
        $request->validate([ 
            'rawMaterial_id'  => ['required', Rule::notIn(['','0'])],
            'supplier_id'  => ['required', Rule::notIn(['','0'])],
            'date'              => 'required',
            'invoice'              => 'required',
            'rate'      => ['required', 'numeric'],
            'quantity'            => ['required', 'integer'],
        ]);
        DB::transaction(function () use ($request, $purchase) {
            $oldrawMaterial = RawMaterial::find($purchase->rawMaterial_id);
            $oldrawMaterial->stock = $oldrawMaterial->stock - $purchase->quantity;
            $oldrawMaterial->save();

            $purchase->update($request->all());

            $rawMaterial = RawMaterial::find($request->rawMaterial_id);
            $rawMaterial->stock = $rawMaterial->stock + $request->quantity;
            $rawMaterial->save();
        });
        return redirect()
                    ->route('purchase.index')
                    ->with('success', 'Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function destroy(Purchase $purchase)
    {
        DB::transaction(function () use ($purchase) {
            $oldrawMaterial = RawMaterial::find($purchase->rawMaterial_id);
            $oldrawMaterial->stock = $oldrawMaterial->stock - $purchase->quantity;
            $oldrawMaterial->save();

            $purchase->delete();
        });
        return redirect()
                    ->route('purchase.index')
                    ->with('success', 'Deleted Successfully');
    }
}
