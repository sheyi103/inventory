<?php

namespace App\Http\Controllers;

use App\ExpenseItem;
use App\Expense;
use Illuminate\Http\Request;

class ExpenseItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $expenseItems = ExpenseItem::all();
        return view('pages.expense-item.index',compact('expenseItems'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $expenseItem = null;
        return view('pages.expense-item.create', compact('expenseItem'));
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
            'name'  =>'required',
        ]);

        ExpenseItem::create($request->all());
        return redirect()
                    ->route('expense-item.index')
                    ->with('success', 'Added Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ExpenseItem  $expenseItem
     * @return \Illuminate\Http\Response
     */
    public function show(ExpenseItem $expenseItem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ExpenseItem  $expenseItem
     * @return \Illuminate\Http\Response
     */
    public function edit(ExpenseItem $expenseItem)
    {
        return view('pages.expense-item.edit', compact('expenseItem'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ExpenseItem  $expenseItem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ExpenseItem $expenseItem)
    {
        $request->validate([
            'name'  =>'required',
        ]);

        $expenseItem->update($request->all());
        return redirect()
                    ->route('expense-item.index')
                    ->with('success', 'Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ExpenseItem  $expenseItem
     * @return \Illuminate\Http\Response
     */
    public function destroy(ExpenseItem $expenseItem)
    {
        $expenseItem->delete();
        return redirect()
                    ->route('expense-item.index')
                    ->with('warning', 'Deleted Successfully');
    }

    //individual expense item report
    public function report($id)
    {
        $expenseItem = ExpenseItem::find($id);     
        return view('pages.expense-item.report',compact('expenseItem','id'));
    }

    //server side datatable
    public function particularExpense(Request $request, $id)
    {      
        $columns = array( 
                            0 =>'id', 
                            1 =>'date',
                            2 => 'amount',
                            3 => 'details',
                            4 => 'actions',
                        );
  
        $totalData = Expense::where('expense_item_id', $id)->count();
        $totalSum = Expense::where('expense_item_id', $id)->sum('amount');
            
        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
            
        if(empty($request->input('search.value')))
        {            
            $expenses = Expense::with('expenseitem')
            ->where('expense_item_id', $id)
            ->offset($start)
            ->limit($limit)
            ->orderBy($order,$dir)
            ->get();
        }
        else {
            $search = $request->input('search.value'); 

            $expenses = Expense::with('expenseitem')
            ->where('expense_item_id', $id)
            ->where('date', 'LIKE',"%{$search}%")
            ->orWhere('amount', 'LIKE',"%{$search}%")
            ->orWhereHas('expenseitem', function($query) use($search) {
                $query->where('name','LIKE',"%{$search}%");
            })
            ->offset($start)
            ->limit($limit)
            ->orderBy($order,$dir)
            ->get();

            $totalFiltered = Expense::with('expenseitem')
            ->where('expense_item_id', $id)
            ->where('date', 'LIKE',"%{$search}%")
            ->orWhere('amount', 'LIKE',"%{$search}%")
            ->orWhereHas('expenseitem', function($query) use($search) {
                $query->where('name','LIKE',"%{$search}%");
            })
            ->count();
        }

        $data = array();
        if(!empty($expenses))
        {
            foreach ($expenses as $key => $value)
            {
                $nestedData['id'] = $key + 1;
                $nestedData['date'] = $value->date;
                $nestedData['amount'] = $value->amount;
                $nestedData['details'] = $value->details;
                $nestedData['actions'] = '<div class="btn-group">
                                    <a href="'.route('expense.edit',$value->id) .'" class="btn btn-success btn-sm" title="Update">
                                        Update
                                    </a>
                                    <button class="btn btn-sm btn-danger btn-delete" data-remote=" '.route('expense.destroy',$value->id) .'" title="Delete">Delete</button>
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
}
