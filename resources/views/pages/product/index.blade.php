@extends('layouts.master')
@section('title', 'Product')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Products</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
						<li class="breadcrumb-item active">Products</li>
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
					<a href="{{ url('product/print') }}" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Print" target="_blank">
						<i class="fa fa-print" aria-hidden="true" title="Print"></i> Print
					</a>

					<a href="{{ url('product/pdf') }}" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="PDF" target="_blank">
						<i class="fa fa-file-pdf-o" aria-hidden="true" title="PDF"></i> PDF
					</a>

					<a href="{{ url('product/excel') }}" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Excel" target="_blank">
						<i class="fa fa-file-excel-o" aria-hidden="true" title="Excel"></i> Excel
					</a>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-bordered" id="productTable" width="100%" cellspacing="0">
							<thead>
								<tr>
									<th>SL</th>
									<th>Name</th>
									<th>Vat</th>
									<th>Stock</th>
									<th>Image</th>							
									<th>Action</th>
								</tr>
							</thead>
							<tfoot>
								<tr>
									<th colspan="3" style="text-align:right">Total:</th>
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

	$(document).ready(function(){

		$('#productTable').DataTable({
			"processing": true,
			"serverSide": true,
			"ajax":{
				"url": "{{ url('all-products') }}",
				"dataType": "json",
				"type": "POST",
				"data":{ _token: "{{ csrf_token() }}"}
			},
			"columns": [
			{ "data": "id" },
			{ "data": "name" },
			{ "data": "vat" },
			{ "data": "stock" },
			{ "data": "image" },
			{ "data": "actions" }
			],
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
			    quantity = api
			    .column( 3 )
			    .data()
			    .reduce( function (a, b) {
			    	return intVal(a) + intVal(b);
			    }, 0);
			    
			    // Total over this page
			    totalQuantity = api
			    .column( 3, { page: 'current'} )
			    .data()
			    .reduce( function (a, b) {
			    	return intVal(a) + intVal(b);
			    }, 0);
			    
			    // Update footer
			    $( api.column( 3 ).footer() ).html(
			    	''+totalQuantity +' ( '+ quantity +' total)'
			    );
			}
		});
	});
</script>
@endsection