@extends('layouts.master')
@section('title', 'Delivery Report')

@section('content')
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Delivery Report</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
						<li class="breadcrumb-item"><a href="{{ url('order') }}">Orders</a></li>
						<li class="breadcrumb-item active">Report</li>
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
					<a href="{{ url('order/delivery/report/print', $id) }}" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Print">
						<i class="fa fa-print" aria-hidden="true" title="Print"></i> Print
					</a>

					<a href="{{ url('order/delivery/report/pdf', $id) }}" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="PDF">
						<i class="fa fa-file-pdf-o" aria-hidden="true" title="PDF"></i> PDF
					</a>

					<a href="{{ url('order/delivery/report/excel', $id) }}" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Excel">
						<i class="fa fa-file-excel-o" aria-hidden="true" title="Excel"></i> Excel
					</a>
				</div>
				<div class="card-body">
					<h5>Work Order No: {{ $id }}</h5>
					<br>
					<h5>Delivery Table</h5>
					<div class="table-responsive">
						<table class="table table-bordered table-hover" id="deliveryTable" width="100%" cellspacing="0">
							<thead>
								<tr>
									<th>SL</th>
									<th>Date</th>
									<th>Product</th>
									<th>Quantity</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								@foreach($deliveries as $delivery)
								<tr>
									<td>{{ $loop->iteration }}</td>
									<td>{{ $delivery->date }}</td>
									<td>{{ $delivery->product->name }}</td>
									<td>{{ $delivery->quantity }}</td>
									<td>
										<div class="btn-group">
											<a href="{{ url('order/delivery/edit',$delivery->id) }}" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top" title="Update">
												Update
											</a>
											<form action="{{ url('destroy-order-delivery', $delivery->id) }}" method="POST">
												@csrf
												<button class="btn btn-danger btn-sm">Delete</button>
											</form>
										</div>
									</td>
								</tr>
								@endforeach
							</tbody>
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

		$('#deliveryTable').DataTable();
	});
</script>
@endsection