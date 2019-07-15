<?php

namespace App\Http\Controllers;

use App\Expense;
use App\ExpenseItem;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\CashBook;
use Excel;
use PDF;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.expense.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $items = ExpenseItem::all('name','id');
        $expense = null;
        return view('pages.expense.create', compact('items','expense'));
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
            'expense_item_id'  => ['required', Rule::notIn(['','0'])],
            'date'              => 'required',
            'amount'            => 'required|numeric',
        ]);
        $expense = Expense::create($request->all());

        $cashBook = new CashBook;
        $cashBook->date = $request->date;
        $cashBook->purpose = 3;
        $cashBook->expense_transaction_id = $expense->id;

        $cashBook->save();

        return redirect()
                    ->route('expense.index')
                    ->with('success', 'Added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function show(Expense $expense)
    {
        return view('pages.expense.show', compact('expense'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function edit(Expense $expense)
    {
        $items = ExpenseItem::all('name','id');
        return view('pages.expense.edit', compact('items','expense'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Expense $expense)
    {
        $request->validate([ 
            'expense_item_id'  => ['required', Rule::notIn(['','0'])],
            'date'              => 'required',
            'amount'            => 'required|numeric',
        ]);

        $expense->update([
            'date'      => $request->date,
            'details'   => $request->details,
            'amount'     => $request->amount,
            'accounts_id'    => $request->accounts_id,
        ]);

        $cashBook = CashBook::where('expense_transaction_id',$expense->id)->first();
        $cashBook->date = $request->date;
        $cashBook->save();

        return redirect()
                    ->route('expense.index')
                    ->with('success', 'Updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function destroy(Expense $expense)
    {
        $cashBook = CashBook::where('expense_transaction_id',$expense->id)->first();
        $cashBook->delete();
        $expense->delete();

        return redirect()
                    ->route('expense.index')
                    ->with('warning', 'Deleted Successfully');
    }

    //date to date expenses report
    public function report(Request $request)
    {
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        if($end_date < $start_date){
            return back()->with('warning', 'End Date Need to be Greater than the Start Date!');
        }
        $expenses = Expense::whereBetween('date', [$start_date, $end_date])->latest()->get();
        return view('pages.expense.report',compact('expenses','start_date','end_date'));
    }

    //print date to date expenses report
    public function printExpenseReport(Request $request)
    {

        $start_date = $request->start_date;
        $end_date = $request->end_date;

        $expenses = Expense::whereBetween('date', [$start_date, $end_date])->get();

        $total = [];

        foreach ($expenses as $expense) {
            array_push($total, $expense->amount);
        }
        return view('pages.expense.print',compact('expenses','start_date','end_date','total'));
    }

    //pdf of expenses report 
    public function exportPDF(Request $request)
    {
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        $expenses = Expense::whereBetween('date', [$start_date, $end_date])->get();

        $total = [];

        foreach ($expenses as $expense) {
            array_push($total, $expense->amount);
        }
        $pdf = PDF::loadView('pages.expense.pdf', compact('expenses','start_date','end_date','total'));
        return $pdf->download('expensesReport.pdf');
    }

    //excel of expenses report 
    public function exportExcel(Request $request)
    {
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        $expenses = Expense::whereBetween('date', [$start_date, $end_date])->get();

        $total = [];

        foreach ($expenses as $expense) {
            array_push($total, $expense->amount);
        }

        Excel::create('expense', function($excel) use ($expenses, $start_date, $end_date, $total) {
            $excel->sheet('expense', function($sheet) use ($expenses, $start_date, $end_date, $total) {
                $sheet->loadView('pages.expense.excel')->with('expenses',$expenses)
                ->with('start_date',$start_date)
                ->with('end_date',$end_date)
                ->with('total',$total);
            });
        })->download('xls');
    }

    //date to date particular expenses report
    public function particularExpense(Request $request)
    {
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $accounts_id = $request->accounts_id;

        if($end_date < $start_date){
            return back()->with('warning', 'End Date Need to be Greater than the Start Date!');
        }
        $expenses = Expense::where('accounts_id','=', $accounts_id)->whereBetween('date', [$start_date, $end_date])->latest()->get();

        $account = AccountType::find(5);
        return view('pages.expense.particular-expense-report',compact('expenses','start_date','end_date','account','accounts_id'));
    }

    //print date to date particular expenses report
    public function particularExpensePrint(Request $request)
    {
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $accounts_id = $request->accounts_id;

        $expenses = Expense::where('accounts_id','=', $accounts_id)->whereBetween('date', [$start_date, $end_date])->latest()->get();

        $total = [];

        foreach ($expenses as $expense) {
            array_push($total, $expense->amount);
        }
        return view('pages.expense.print',compact('expenses','start_date','end_date','total'));
    }

    //pdf of date to date particular expenses report
    public function particularExpensePDF(Request $request)
    {
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $accounts_id = $request->accounts_id;

        $expenses = Expense::where('accounts_id','=', $accounts_id)->whereBetween('date', [$start_date, $end_date])->latest()->get();

        $total = [];

        foreach ($expenses as $expense) {
            array_push($total, $expense->amount);
        }
        $pdf = PDF::loadView('pages.expense.pdf', compact('expenses','start_date','end_date','total'));
        return $pdf->download('ExpensesReport.pdf');
    }

    //excel of date to date particular expenses report
    public function particularExpenseExcel(Request $request)
    {
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $accounts_id = $request->accounts_id;

        $expenses = Expense::where('accounts_id','=', $accounts_id)->whereBetween('date', [$start_date, $end_date])->latest()->get();

        $total = [];

        foreach ($expenses as $expense) {
            array_push($total, $expense->amount);
        }
        
        Excel::create('ExpensesReport', function($excel) use ($expenses, $start_date, $end_date, $total) {
            $excel->sheet('ExpensesReport', function($sheet) use ($expenses, $start_date, $end_date, $total) {
                $sheet->loadView('pages.expense.excel')->with('expenses',$expenses)
                ->with('start_date',$start_date)
                ->with('end_date',$end_date)
                ->with('total',$total);
            });
        })->download('xls');
    }

    //server side datatable
    public function allExpenses(Request $request)
    {      
        $columns = array( 
                            0 =>'id', 
                            1 =>'date',
                            2=> 'expense_item_id',
                            3=> 'amount',
                            4=> 'actions',
                        );
  
        $totalData = Expense::count();
            
        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
            
        if(empty($request->input('search.value')))
        {            
            $expenses = Expense::offset($start)
                         ->limit($limit)
                         ->orderBy($order,$dir)
                         ->get();
        }
        else {
            $search = $request->input('search.value'); 

            $expenses =  Expense::with('expenseitem')
                            ->where('amount','LIKE',"%{$search}%")
                            ->orWhere('date', 'LIKE',"%{$search}%")
                            ->orWhereHas('expenseitem', function($query) use($search) {
                                $query->where('name','LIKE',"%{$search}%");
                            })
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();

            $totalFiltered = Expense::with('expenseitem')
                            ->where('amount','LIKE',"%{$search}%")
                            ->orWhere('date', 'LIKE',"%{$search}%")
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
                $nestedData['expense_item_id'] = $value->expenseitem->name;
                $nestedData['amount'] = $value->amount;
                $nestedData['actions'] = '<div class="btn-group">
                                    <a href="'.route('expense.show',$value->id) .'" class="btn btn-primary btn-sm" title="Show">
                                        Show
                                    </a>
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
                    "data"            => $data   
                    );
            
        echo json_encode($json_data);        
    }
}
