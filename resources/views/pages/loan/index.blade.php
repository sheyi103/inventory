@extends('layouts.master')
@section('title', 'Loan')

@section('content')
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Loans</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
						<li class="breadcrumb-item active">Loans</li>
					</ol>
				</div><!-- /.col -->
			</div><!-- /.row -->
		</div><!-- /.container-fluid -->
	</div>
	<!-- /.content-header -->
	<!-- Main content -->
	<section class="content">
		<div class="container-fluid">
			<div class="card">
				<div class="card-header">
					<a href="{{ url('loan/print') }}" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Print" target="_blank">
						<i class="fa fa-print" aria-hidden="true" title="Print"></i> Print
					</a>

					<a href="{{ url('loan/pdf') }}" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="PDF" target="_blank">
						<i class="fa fa-file-pdf-o" aria-hidden="true" title="PDF"></i> PDF
					</a>

					<a href="{{ url('loan/excel') }}" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Excel" target="_blank">
						<i class="fa fa-file-excel-o" aria-hidden="true" title="Excel"></i> Excel
					</a>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
							<thead>
								<tr>
									<th>Sl</th>
									<th>Cash Limit</th>
									<th>Balance</th>
									<th>Interest Rate</th>
									<th>Interest</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								@forelse($loans as $loan)
								<tr>
									<td>{{ $loop->iteration }}</td>
									<td>{{ $loan->amount }}</td>
									<td>{{ $loan->balance }}</td>
									<td>{{ $loan->interest_rate }}</td>
									<td>{{ (($loan->balance * $loan->interest_rate)/100)/365 }}</td>
									<td>
										<div class="btn-group">
											<a href="{{ route('loan.edit', $loan->id) }}" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top" title="Update">
												Update
											</a>
											<form action="{{ route('loan.destroy', $loan->id) }}" method="POST">
												@csrf
												@method('DELETE')
												<button class="btn btn-danger btn-sm">Delete</button>
											</form>
										</div>
									</td>
								</tr>
								@empty
								@endforelse
							</tbody>
							{{-- <tfoot>
								<tr>
									<th colspan="3" style="text-align:right">Total:</th>
									<th></th>
									<th></th>
								</tr>
							</tfoot> --}}
						</table>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>

@endsection

@section('script')
<script>
	//server side data table
	$(document).ready(function () {
		$('#dataTable').DataTable({
			// "footerCallback": function ( row, data, start, end, display ) {
			// 	var api = this.api(), data;
				
			//     // Remove the formatting to get integer data for summation
			//     var intVal = function ( i ) {
			//     	return typeof i === 'string' ?
			//     	i.replace(/[\$,]/g, '')*1 :
			//     	typeof i === 'number' ?
			//     	i : 0;
			//     };
			    
			//     // Total over all pages
			//     total = api
			//     .column( 3 )
			//     .data()
			//     .reduce( function (a, b) {
			//     	return intVal(a) + intVal(b);
			//     }, 0);
			    
			//     // Total over this page
			//     pageTotal = api
			//     .column( 3, { page: 'current'} )
			//     .data()
			//     .reduce( function (a, b) {
			//     	return intVal(a) + intVal(b);
			//     }, 0);
			    
			//     // Update footer
			//     $( api.column( 3 ).footer() ).html(
			//     	''+pageTotal +' ( '+ total +' total)'
			//     	);
			// }     
		});
	});
</script>
@endsection