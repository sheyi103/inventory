@extends('layouts.master')
@section('title', 'Production')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">View Production</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
						<li class="breadcrumb-item"><a href="{{ url('production') }}">Productions</a></li>
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
			<div class="card card-warning">
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
							<tbody>
								<tr>
									<td>Production Date</td>
									<td>{{ $production->date }}</td>
								</tr>
								<tr>
									<td>Product Produced</td>
									<td>{{ $production->product->name }}</td>
								</tr>
								<tr>
									<td>Quantity</td>
									<td>{{ $production->quantity }}</td>
								</tr>
								<tr>
									<td>Remarks</td>
									<td>{{ $production->details }}</td>
								</tr>
							</tbody>
						</table>

						<br>
						<h5>Raw Materials Used</h5>
						<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
							<thead>
								<tr>
									<th>Raw Material</th>
									<th>Quantity</th>
								</tr>
								
							</thead>
							<tbody>
								@foreach($rawMaterials as $key => $value)
								<tr>
									<td>{{ $value->name }}</td>
									<td>{{ $rawMaterialsQuantity[$key] }}</td>
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