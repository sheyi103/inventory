@extends('layouts.master')
@section('title', 'Bill')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">View Bill</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
						<li class="breadcrumb-item"><a href="{{ url('bill') }}">Bill</a></li>
						<li class="breadcrumb-item active">View</li>
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
				{{-- <div class="card-header">
					<a href="{{ url('order/print',$orders[0]->workOrder_id) }}" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Print" target="_blank">
						<i class="fa fa-print" aria-hidden="true" title="Print"></i> Print
					</a>

					<a href="{{ url('order/pdf',$orders[0]->workOrder_id) }}" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="PDF" target="_blank">
						<i class="fa fa-file-pdf-o" aria-hidden="true" title="PDF"></i> PDF
					</a>

					<a href="{{ url('order/excel',$orders[0]->workOrder_id) }}" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Excel" target="_blank">
						<i class="fa fa-file-excel-o" aria-hidden="true" title="Excel"></i> Excel
					</a>
				</div> --}}
				<div class="card-body">
					<div class="row">
						<div class="col-sm-8">
							<h6>Customer Name: {{ $bills[0]->customer->name }}</h6>
							<h6>Customer Address: {{ $bills[0]->customer->address }}</h6>
							<h6>Work Order No: {{ $bills[0]->workOrder_id }}</h6>
							<h6>Delivery Challan No: {{ $bills[0]->challan_no }}</h6>
						</div>
						<div class="col-sm-4">
							
						</div>
					</div>
					<br>
					<div class="table-responsive">
						<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
							<thead>
								<tr>
									<th>Sl</th>
									<th>Product</th>
									<th>Quantity</th>
									<th>Rate</th>
									<th>Amount</th>
									<th>Vat</th>
									<th>Total</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								@forelse($bills as $bill)
								<tr>
									<td>{{ $loop->iteration }}</td>
									<td>{{ $bill->product->name }}</td>
									<td>{{ $bill->quantity }}</td>
									<td>{{ $bill->rate }}</td>
									<td>{{ $bill->amount }}</td>
									<td>{{ $bill->vat }}</td>
									<td>{{ $bill->vat + $bill->amount }}</td>
									<td>
										<div class="btn-group">
											<a href="{{ route('bill.edit', $bill->id) }}" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top" title="Update">
												Update
											</a>
											<form action="{{ route('bill.destroy', $bill->id) }}" method="POST">
												@csrf
												@method('DELETE')
												<button class="btn btn-danger btn-sm">Delete</button>
											</form>
										</div>
									</td>
								</tr>
								@empty
								@component('partials.warning')
								No Information Found
								@endcomponent
								@endforelse
							</tbody>

							<tfoot>
								<tr>
									<th colspan="4" style="text-align:right">Total:</th>
									<th></th>
									<th></th>
									<th></th>
									<th></th>
								</tr>
							</tfoot>
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
	$(function () {
		$("#dataTable").DataTable({
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
			    .column( 6 )
			    .data()
			    .reduce( function (a, b) {
			    	return intVal(a) + intVal(b);
			    }, 0);
			    
			    // Total over this page
			    pageTotal = api
			    .column( 6, { page: 'current'} )
			    .data()
			    .reduce( function (a, b) {
			    	return intVal(a) + intVal(b);
			    }, 0);
			    
			    // Update footer
			    $( api.column( 6 ).footer() ).html(
			    	''+pageTotal +' ( '+ total +' total)'
			    );

			    // Total over all pages
			    vat = api
			    .column( 4 )
			    .data()
			    .reduce( function (a, b) {
			    	return intVal(a) + intVal(b);
			    }, 0);
			    
			    // vat over this page
			    pagevat = api
			    .column( 4, { page: 'current'} )
			    .data()
			    .reduce( function (a, b) {
			    	return intVal(a) + intVal(b);
			    }, 0);
			    
			    // Update footer
			    $( api.column( 4 ).footer() ).html(
			    	''+pagevat +' ( '+ vat +' total)'
			    );

			    // Total over all pages
			    amount = api
			    .column( 5 )
			    .data()
			    .reduce( function (a, b) {
			    	return intVal(a) + intVal(b);
			    }, 0);
			    
			    // amount over this page
			    pageamount = api
			    .column( 5, { page: 'current'} )
			    .data()
			    .reduce( function (a, b) {
			    	return intVal(a) + intVal(b);
			    }, 0);
			    
			    // Update footer
			    $( api.column( 5 ).footer() ).html(
			    	''+pageamount +' ( '+ amount +' total)'
			    );
			}
		});
	});
</script>
@endsection