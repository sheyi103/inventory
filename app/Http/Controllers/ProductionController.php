<?php

namespace App\Http\Controllers;

use App\Production;
use App\Product;
use App\RawMaterial;
use DB;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class ProductionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.production.index');
    }

    //server side datatable
    public function allProductions(Request $request)
    {      
        $columns = array( 
                            0 =>'id', 
                            1 =>'date',
                            2 => 'product_id',
                            3 => 'quantity',
                            4 => 'details',
                            5 => 'actions',
                        );
  
        $totalData = Production::count();
        $totalSum = Production::sum('quantity');
            
        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
            
        if(empty($request->input('search.value')))
        {            
            $productions = Production::offset($start)
                         ->limit($limit)
                         ->orderBy($order,$dir)
                         ->get();
        }
        else {
            $search = $request->input('search.value'); 

            $productions =  Production::with('product')
                            ->where('quantity','LIKE',"%{$search}%")
                            ->orWhere('date', 'LIKE',"%{$search}%")
                            ->orWhere('details', 'LIKE',"%{$search}%")
                            ->orWhereHas('product', function($query) use($search) {
                                $query->where('name','LIKE',"%{$search}%");
                            })
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();

            $totalFiltered = Production::with('product')
                            ->where('quantity','LIKE',"%{$search}%")
                            ->orWhere('date', 'LIKE',"%{$search}%")
                            ->orWhere('details', 'LIKE',"%{$search}%")
                            ->orWhereHas('product', function($query) use($search) {
                                $query->where('name','LIKE',"%{$search}%");
                            })
                            ->count();
        }

        $data = array();
        if(!empty($productions))
        {
            foreach ($productions as $key => $value)
            {
                $nestedData['id'] = $key + 1;
                $nestedData['date'] = $value->date;
                $nestedData['product_id'] = $value->product->name;
                $nestedData['quantity'] = $value->quantity;
                $nestedData['details'] = $value->details;
                $nestedData['actions'] = '<div class="btn-group">
                                    <a href="'.route('production.show',$value->id) .'" class="btn btn-primary btn-sm" title="Show">
                                        Show
                                    </a>
                                    <a href="'.route('production.edit',$value->id) .'" class="btn btn-success btn-sm" title="Update">
                                        Update
                                    </a>
                                    <button class="btn btn-sm btn-danger btn-delete" data-remote=" '.route('production.destroy',$value->id) .'" title="Delete">Delete</button>
                                </div>';
                $data[] = $nestedData;

            }
        }
          
        $json_data = array(
                    "draw"            => intval($request->input('draw')),  
                    "recordsTotal"    => intval($totalData),  
                    "recordsFiltered" => intval($totalFiltered), 
                    "data"            => $data,
                    "totalSum"            => $totalSum   
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
        $products = Product::all('id','name');
        $production = null;
        $rawMaterials = RawMaterial::all('id','name');
        return view('pages.production.create', compact('production','products','rawMaterials'));
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
            'product_id'  => ['required', Rule::notIn(['','0'])],
            'date'              => 'required',
            'quantity'            => ['required', 'integer'],
        ]);
        DB::transaction(function () use ($request) {
            $production = new Production;

            $production->date = $request->date;
            $production->product_id = $request->product_id;
            $production->quantity = $request->quantity;
            $production->details = $request->details;
            $production->raw_materials = implode("|", $request->raw_materials);
            $production->raw_materials_quantity = implode("|", $request->raw_materials_quantity);
            $production->save();

            //add product stock
            $product = Product::find($request->product_id);
            $product->stock = $product->stock + $request->quantity;
            $product->save();

            //deduct raw materials stock
            for ($i=0; $i < count($request->raw_materials) ; $i++) {
                $rawMaterial = RawMaterial::find($request->raw_materials[$i]);
                $rawMaterial->stock = $rawMaterial->stock - $request->raw_materials_quantity[$i];
                $rawMaterial->save();
            }
        });
        return redirect()
                    ->route('production.index')
                    ->with('success', 'Added Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Production  $production
     * @return \Illuminate\Http\Response
     */
    public function show(Production $production)
    {
        $rawMaterialsID = explode("|", $production->raw_materials);
        $rawMaterialsQuantity = explode("|", $production->raw_materials_quantity);
        $rawMaterials = [];
        foreach ($rawMaterialsID as $key => $value) {
            $rawMaterial = RawMaterial::find($value);
            array_push($rawMaterials, $rawMaterial);
        }
        return view('pages.production.show',compact('production','rawMaterials','rawMaterialsQuantity'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Production  $production
     * @return \Illuminate\Http\Response
     */
    public function edit(Production $production)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Production  $production
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Production $production)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Production  $production
     * @return \Illuminate\Http\Response
     */
    public function destroy(Production $production)
    {
        DB::transaction(function () use ($production) {
            $rawMaterialsID = explode("|", $production->raw_materials);
            $rawMaterialsQuantity = explode("|", $production->raw_materials_quantity);
            foreach ($rawMaterialsID as $key => $value) {
                $rawMaterial = RawMaterial::find($value);
                $rawMaterial->stock = $rawMaterial->stock + $rawMaterialsQuantity[$key];
                $rawMaterial->save();
            }

            $product = Product::find($production->product_id);
            $product->stock = $product->stock - $production->quantity;
            $product->save();

            $production->delete();
        });

        return redirect()
                    ->route('production.index')
                    ->with('success', 'Deleted Successfully');
    }
}
