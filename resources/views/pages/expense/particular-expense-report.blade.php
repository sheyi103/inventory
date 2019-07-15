@extends('layouts.master')
@section('title', 'Expense')

@section('content')
{{-- Breadcrumbs--}}
<ol class="breadcrumb">
	<li class="breadcrumb-item">
		<a href="{{ url('/') }}">Dashboard</a>
	</li>
	<li class="breadcrumb-item">
		<a href="{{ route('expense.index') }}">
			Expense
		</a>
	</li>
	<li class="breadcrumb-item active">
		Report
	</li>
</ol>

{{-- Create New --}}
<a href="{{ url('expense/create') }}" class="btn btn-primary btn-sm mb-3">Create New</a>
<br><br>
<div class="button-inline">
	{{-- Report --}}
	<form  method="GET" action="{{url('particular-expense-report')}}" class="form-inline report-form">
		@csrf
		<input type="text" name="start_date" id="start_date" class="form-control" placeholder="Start Date">
		<input type="text" name="end_date" id="end_date" class="form-control" placeholder="End Date">
		<select name="accounts_id" class="form-control" id="accounts_id">
			<option value="">Select</option>
			@forelse($account->headAccount as $accountHead)
			@foreach($accountHead->accounts as $expenseAccount)
			<option value="{{ $expenseAccount->id }}">
				{{ $expenseAccount->name }}
			</option>
			@endforeach
			@empty
			<option value="">No Expense Type Found</option>
			@endforelse
		</select>
		<button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-line-chart" aria-hidden="true"></i> Report</button>
	</form>

	<form id="particularexpense" method="GET" action="{{ url('print-particular-expense-report') }}" class="form-inline">
		@csrf
		<input type="hidden" name="start_date" id="start_date" class="form-control" required="required" value="{{ $start_date }}">
		<input type="hidden" name="end_date" id="end_date" class="form-control" required="required" value="{{ $end_date }}">
		<input type="hidden" name="accounts_id" id="accounts_id" class="form-control" required="required" value="{{ $accounts_id }}">
		<button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-print" aria-hidden="true" title="Print"></i> Print</button>
	</form>

	<form id="particularexpense" method="GET" action="{{ url('pdf-particular-expense-report') }}" class="form-inline">
		@csrf
		<input type="hidden" name="start_date" id="start_date" class="form-control" required="required" value="{{ $start_date }}">
		<input type="hidden" name="end_date" id="end_date" class="form-control" required="required" value="{{ $end_date }}">
		<input type="hidden" name="accounts_id" id="accounts_id" class="form-control" required="required" value="{{ $accounts_id }}">
		<button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-file-pdf-o" aria-hidden="true" title="PDF"></i> PDF</button>
	</form>

	<form id="particularexpense" method="GET" action="{{ url('excel-particular-expense-report') }}" class="form-inline">
		@csrf
		<input type="hidden" name="start_date" id="start_date" class="form-control" required="required" value="{{ $start_date }}">
		<input type="hidden" name="end_date" id="end_date" class="form-control" required="required" value="{{ $end_date }}">
		<input type="hidden" name="accounts_id" id="accounts_id" class="form-control" required="required" value="{{ $accounts_id }}">
		<button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-file-excel-o" aria-hidden="true" title="Excel"></i> Excel</button>
	</form> 
</div>

<div class="card mb-3">
	<div class="card-header">
	Expenses from {{ $start_date }} to {{ $end_date }}</div>
	<div class="card-body">
		<div class="table-responsive">
			<table class="table table-bordered" id="expenseTable" width="100%" cellspacing="0">
				<thead>
					<tr>
						<th>Sl</th>
						<th>Date</th>
						<th>Expense Type</th>
						<th>Amount</th>
						<th>Remarks</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					@foreach($expenses as $expense)
					<tr>
						<td>{{ $loop->iteration }}</td>
						<td>{{ $expense->date }}</td>
						<td>{{ $expense->accounts->name }}</td>
						<td>{{ $expense->amount }}</td>
						<td>{{ $expense->details }}</td>
						<td>
							<div class="btn-group">
								<a href="{{ route('expense.edit', $expense->id) }}" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top" title="Update">
									Update
								</a>
								<form action="{{ route('expense.destroy', $expense->id) }}" method="POST">
									@csrf
									@method('DELETE')
									<button class="btn btn-danger btn-sm">Delete</button>
								</form>
							</div>
						</td>
					</tr>
					@endforeach
				</tbody>
				<tfoot>
					<tr>
						<th colspan="3" style="text-align:right">Total:</th>
						<th></th>
						<th></th>
						<th></th>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>
</div>
@endsection

@section('script')
<script>
	$(function () {
		$('[data-toggle="tooltip"]').tooltip()
	});

	$( function() {
		$( "#start_date" ).datepicker({
			dateFormat: 'yy-mm-dd',
			changeMonth: true,
			changeYear: true,
		});
	});

	$( function() {
		$( "#end_date" ).datepicker({
			dateFormat: 'yy-mm-dd',
			changeMonth: true,
			changeYear: true,
		});
	});

	$(document).ready(function(){

		$('#expenseTable').DataTable({

			"footerCallback": function ( row, data, start, end, display ) {
				var api = this.api(), data;
				
			    // Remove the formatting to get integer data for summation
			    var intVal = function ( i ) {
			    	return typeof i === 'string' ?
			    	i.replace(/[\$,]/g, '')*1 :
			    	typeof i === 'number' ?
			    	i : 0;
			    };
			    
			    // Total over all pages
			    total = api
			    .column( 3 )
			    .data()
			    .reduce( function (a, b) {
			    	return intVal(a) + intVal(b);
			    });
			    
			    // Total over this page
			    pageTotal = api
			    .column( 3, { page: 'current'} )
			    .data()
			    .reduce( function (a, b) {
			    	return intVal(a) + intVal(b);
			    });
			    
			    // Update footer
			    $( api.column( 3 ).footer() ).html(
			    	''+pageTotal +' ( '+ total +' total)'
			    	);
			}
		});
	});
</script>
@endsection