@extends('layouts.master')
@section('title', 'Expense Item')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Expense Items</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
						<li class="breadcrumb-item active">Expense Items</li>
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
							<thead>
								<tr>
									<th>Sl</th>
									<th>Name</th>
									<th>Remarks</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								@forelse($expenseItems as $expenseItem)
								<tr>
									<td>{{ $loop->iteration }}</td>
									<td>{{ $expenseItem->name }}</td>
									<td>{{ $expenseItem->details }}</td>
									<td>
										<div class="btn-group">
											<a href="{{ route('expense-item.edit', $expenseItem->id) }}" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top" title="Update">
												Update
											</a>
											<form action="{{ route('expense-item.destroy', $expenseItem->id) }}" method="POST">
												@csrf
												@method('DELETE')
												<button class="btn btn-danger btn-sm">Delete</button>
											</form>

											<a href="{{ url('expense-item/report', $expenseItem->id) }}" class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="top" title="Report">
												Report
											</a>
										</div>
									</td>
								</tr>
								@empty
								@endforelse
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
	$(document).ready(function () {
		$('#dataTable').DataTable();
	});
</script>
@endsection