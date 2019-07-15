@extends('layouts.master')
@section('title', 'Sale')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Sale Payments</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
						<li class="breadcrumb-item active">Sale Payments</li>
					</ol>
				</div><!-- /.col -->
			</div><!-- /.row -->
		</div><!-- /.container-fluid -->
	</div>
	<!-- /.content-header -->

	<!-- Main content -->
	<section class="content">
		<div class="container-fluid">
			<div class="card card-warning">
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
							<thead>
								<tr>
									<th>SL</th>
									<th>Date</th>								
									<th>Customer</th>
									<th>Amount</th>							
									<th>Payment Type</th>
									<th>Payment Mode</th>
									<th>Action</th>
								</tr>
							</thead>
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
			"order": [[ 1, "desc" ]],
			"processing": true,
			"serverSide": true,
			"ajax":{
				"url": "{{ url('all-sale-transactions') }}",
				"dataType": "json",
				"type": "POST",
				"data":{ _token: "{{ csrf_token() }}"}
			},
			"columns": [
			{ "data": "id" },
			{ "data": "date" },
			{ "data": "customer_id" },
			{ "data": "amount" },
			{ "data": "payment_type" },
			{ "data": "payment_mode" },
			{ "data": "actions" }
			],	 
		});
	});

    //delete a row using ajax
    $('#dataTable').on('click', '.btn-delete[data-remote]', function (e) { 
    	e.preventDefault();
    	$.ajaxSetup({
    		headers: {
    			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    		}
    	});
    	var url = $(this).data('remote');
        // confirm then
        if (confirm('are you sure you want to delete this?')) {
        	$.ajax({
        		url: url,
        		type: 'POST',
        		dataType: 'json',
        		data: {_method: 'DELETE', submit: true}
        	}).always(function (data) {
        		$('#dataTable').DataTable().draw(false);
        	});
        }
    });
</script>
@endsection
