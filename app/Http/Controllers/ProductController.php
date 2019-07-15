<?php

namespace App\Http\Controllers;

use App\Product;
use App\Category;
use App\SubCategory;
use App\Supplier;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use PDF;
use Excel;
use DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.product.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $product = null;
        return view('pages.product.create', compact('product'));
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
            'vat'      => 'required',
            'name'      => 'required|string',
            'image'     => 'mimes:jpeg,png',
        ]);

        if(!empty($request->file('image')))
        {
            $file = $request->file('image') ;
            $image = time() . '.' . $file->getClientOriginalExtension() ;
            $destinationPath = public_path().'/images/products/' ;
            $file->move($destinationPath,$image);
        }
        else {
            $image = 'default.png';
        }

        $product = new Product;
        $product->create([
            'vat'      => $request->vat,
            'name'   => $request->name,
            'details'   => $request->details,
            'image'  => $image,
        ]);

        return redirect()
                    ->route('product.index')
                    ->with('success', 'Added Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return view('pages.product.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        return view('pages.product.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'vat'      => 'required',
            'name'      => 'required|string',
            'image'     => 'mimes:jpeg,png',
            'status'    => 'boolean',
        ]);

        if(!empty($request->file('image')))
        {
            $file = $request->file('image') ;
            $image = time() . '.' . $file->getClientOriginalExtension() ;
            $destinationPath = public_path().'/images/products/' ;
            $file->move($destinationPath,$image);
        }
        else {
            $image = $request->oldimage;
        }

        $product->update([
            'vat'      => $request->vat,
            'name'   => $request->name,
            'details'   => $request->details,
            'image'  => $image,
        ]);

        return redirect()
                    ->route('product.index')
                    ->with('success', 'Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()
                    ->route('product.index')
                    ->with('warning', 'Deleted Successfully');
    }

    //server side datatable
    public function allProducts(Request $request)
    {      
        $columns = array( 
                            0 =>'id', 
                            1 =>'name',
                            2=> 'vat',
                            3=> 'stock',
                            4=> 'image',
                            5=> 'actions',
                        );
  
        $totalData = Product::count();
            
        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
            
        if(empty($request->input('search.value')))
        {            
            $products = Product::latest()
                        ->offset($start)
                        ->limit($limit)
                        ->orderBy($order,$dir)
                        ->get();
        }
        else {
            $search = $request->input('search.value'); 

            $products =  Product::latest()
                            ->where('name','LIKE',"%{$search}%")
                            ->orWhere('vat', 'LIKE',"%{$search}%")
                            ->orWhere('stock', 'LIKE',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();

            $totalFiltered = Product::latest()
                            ->where('name','LIKE',"%{$search}%")
                            ->orWhere('vat', 'LIKE',"%{$search}%")
                            ->orWhere('stock', 'LIKE',"%{$search}%")
                            ->count();
        }

        $data = array();
        if(!empty($products))
        {
            foreach ($products as $key => $value)
            {
                $nestedData['id'] = $key + 1;
                $nestedData['name'] = $value->name;
                $nestedData['vat'] = $value->vat;
                $nestedData['stock'] = $value->stock;
                $nestedData['image'] = '<img src="' .asset('images/products/'.$value->image).' " class="user-avatar">';
                $nestedData['actions'] = '<div class="btn-group">
                                    <a href="'.route('product.show',$value->id) .'" class="btn btn-primary btn-sm" title="Show">
                                        Show
                                    </a>
                                    <a href="'.route('product.edit',$value->id) .'" class="btn btn-success btn-sm" title="Update">
                                        Update
                                    </a>
                                    <button class="btn btn-sm btn-danger btn-delete" data-remote=" '.route('product.destroy',$value->id) .'" title="Delete">Delete</button>
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

    //autocomplete search of customer
    public function autocompletesearch(Request $request)
    {
        $query = $request->get('term','');
                
        $products = Product::where('name','LIKE','%'.$query.'%')
                            ->get();

        $results=array();                    
        
        if(count($products ) > 0){
            foreach ($products  as $product) {
                $results[] = [ 'id' => $product['id'], 'text' => $product['name']];                  
            }
            return response()->json($results);
        }
        else{
            $data[] = 'Nothing Found';
            return $data;
        }
    }

    //print product list
    public function print()
    {
        $products = Product::all();
        return view('pages.product.print',compact('products'));
    }

    //pdf product list
    public function exportPDF()
    {
        $products = Product::all();

        $pdf = PDF::loadView('pages.product.pdf', compact('products'));
        return $pdf->download('Products.pdf');
    }

    //excel of product list
    public function exportExcel()
    {
        $products = Product::all();

        Excel::create('Products', function($excel) use ($products) {
            $excel->sheet('Products', function($sheet) use ($products) {
                $sheet->loadView('pages.product.excel')->with('products',$products);
            });
        })->download('xls');
    }
}
