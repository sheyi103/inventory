@extends('layouts.master')
@section('title', 'Raw Material')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Raw Materials</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
						<li class="breadcrumb-item active">Raw Materials</li>
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
					<a href="{{ url('raw-material/print') }}" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Print" target="_blank">
						<i class="fa fa-print" aria-hidden="true" title="Print"></i> Print
					</a>

					<a href="{{ url('raw-material/pdf') }}" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="PDF" target="_blank">
						<i class="fa fa-file-pdf-o" aria-hidden="true" title="PDF"></i> PDF
					</a>

					<a href="{{ url('raw-material/excel') }}" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Excel" target="_blank">
						<i class="fa fa-file-excel-o" aria-hidden="true" title="Excel"></i> Excel
					</a>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-bordered" id="rawmaterialTable" width="100%" cellspacing="0">
							<thead>
								<tr>
									<th>SL</th>
									<th>Name</th>
									<th>Stock</th>
									<th>Remarks</th>								
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								@foreach($rawmaterials as $rawmaterial)
								<tr>
									<td>{{ $loop->iteration }}</td>
									<td>{{ $rawmaterial->name }}</td>							
									<td>{{ $rawmaterial->stock }}</td>
									<td>{{ $rawmaterial->details }}</td>
									<td>
										<div class="btn-group">
											<a href="{{ route('raw-material.edit', $rawmaterial->id) }}" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top" title="Update">
												Update
											</a>
											<form action="{{ route('raw-material.destroy', $rawmaterial->id) }}" method="POST">
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
									<th colspan="2" style="text-align:right">Total:</th>
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

		$('#rawmaterialTable').DataTable({

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
			    .column( 2 )
			    .data()
			    .reduce( function (a, b) {
			    	return intVal(a) + intVal(b);
			    });
			    
			    // Total over this page
			    totalQuantity = api
			    .column( 2, { page: 'current'} )
			    .data()
			    .reduce( function (a, b) {
			    	return intVal(a) + intVal(b);
			    });
			    
			    // Update footer
			    $( api.column( 2 ).footer() ).html(
			    	''+totalQuantity +' ( '+ quantity +' total)'
			    );
			}
		});
	});
</script>
@endsection