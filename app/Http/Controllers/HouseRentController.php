<?php

namespace App\Http\Controllers;

use App\HouseRent;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Flat;

class HouseRentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.house-rent.index');
    }

    //server side datatable
    public function allRents(Request $request)
    {      
        $columns = array( 
                            0 =>'id', 
                            1 =>'date',
                            2=> 'flat_id',
                            3=> 'amount',
                            4=> 'actions',
                        );
  
        $totalData = HouseRent::count();
            
        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
            
        if(empty($request->input('search.value')))
        {            
            $houserents = HouseRent::offset($start)
                         ->limit($limit)
                         ->orderBy($order,$dir)
                         ->get();
        }
        else {
            $search = $request->input('search.value'); 

            $houserents =  HouseRent::with('flat')
                            ->where('amount','LIKE',"%{$search}%")
                            ->orWhere('date', 'LIKE',"%{$search}%")
                            ->orWhereHas('flat', function($query) use($search) {
                                $query->where('name','LIKE',"%{$search}%");
                            })
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();

            $totalFiltered = HouseRent::with('flat')
                            ->where('amount','LIKE',"%{$search}%")
                            ->orWhere('date', 'LIKE',"%{$search}%")
                            ->orWhereHas('flat', function($query) use($search) {
                                $query->where('name','LIKE',"%{$search}%");
                            })
                            ->count();
        }

        $data = array();
        if(!empty($houserents))
        {
            foreach ($houserents as $key => $value)
            {
                $nestedData['id'] = $key + 1;
                $nestedData['date'] = $value->date;
                $nestedData['flat_id'] = $value->flat->name;
                $nestedData['amount'] = $value->amount;
                $nestedData['actions'] = '<div class="btn-group">
                                    <a href="'.route('house-rent.show',$value->id) .'" class="btn btn-primary btn-sm" title="Show">
                                        Show
                                    </a>
                                    <a href="'.route('house-rent.edit',$value->id) .'" class="btn btn-success btn-sm" title="Update">
                                        Update
                                    </a>
                                    <button class="btn btn-sm btn-danger btn-delete" data-remote=" '.route('house-rent.destroy',$value->id) .'" title="Delete">Delete</button>
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
        $flats = Flat::all('id','name');
        $houseRent = null;
        return view('pages.house-rent.create', compact('flats','houseRent'));
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
            'flat_id'  => ['required', Rule::notIn(['','0'])],
            'date'              => 'required',
            'amount'            => 'required|numeric',
        ]);
        HouseRent::create($request->all());

        return redirect()
                    ->route('house-rent.index')
                    ->with('success', 'Added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\HouseRent  $houseRent
     * @return \Illuminate\Http\Response
     */
    public function show(HouseRent $houseRent)
    {
        return view('pages.house-rent.show', compact('houseRent'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\HouseRent  $houseRent
     * @return \Illuminate\Http\Response
     */
    public function edit(HouseRent $houseRent)
    {
        $flats = Flat::all('id','name');
        return view('pages.house-rent.edit', compact('flats','houseRent'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\HouseRent  $houseRent
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, HouseRent $houseRent)
    {
        $request->validate([ 
            'flat_id'  => ['required', Rule::notIn(['','0'])],
            'date'              => 'required',
            'amount'            => 'required|numeric',
        ]);
        $houseRent->update([
            'date'      => $request->date,
            'details'   => $request->details,
            'amount'     => $request->amount,
            'flat_id'    => $request->flat_id,
        ]);

        return redirect()
                    ->route('house-rent.index')
                    ->with('success', 'Updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\HouseRent  $houseRent
     * @return \Illuminate\Http\Response
     */
    public function destroy(HouseRent $houseRent)
    {
        $houseRent->delete();

        return redirect()
                    ->route('house-rent.index')
                    ->with('warning', 'Deleted Successfully');
    }
}
