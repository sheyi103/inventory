@extends('layouts.master')
@section('title', 'CC Loan')

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
						<li class="breadcrumb-item active">Loan</li>
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
					{{-- <a href="{{ url('loan/print') }}" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Print" target="_blank">
						<i class="fa fa-print" aria-hidden="true" title="Print"></i> Print
					</a>

					<a href="{{ url('loan/pdf') }}" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="PDF" target="_blank">
						<i class="fa fa-file-pdf-o" aria-hidden="true" title="PDF"></i> PDF
					</a>

					<a href="{{ url('loan/excel') }}" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Excel" target="_blank">
						<i class="fa fa-file-excel-o" aria-hidden="true" title="Excel"></i> Excel
					</a> --}}
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
							<thead>
								<tr>
									<th>Sl</th>
									<th>From</th>
									<th>Limit</th>
									<th>Available</th>
									<th>Profit Rate</th>
									<th>Profit</th>
									<th>Remarks</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								@forelse($loans as $loan)
								<tr>
									<td>{{ $loop->iteration }}</td>
									<td>{{ $loan->loan_from }}</td>
									<td>{{ $loan->limit }}</td>
									<td>{{ $loan->available }}</td>
									<td>{{ $loan->interest_rate }}</td>
									<td>{{ (((($loan->limit - $loan->available) * $loan->interest_rate) / 10)/365) }}</td>
									<td>{{ $loan->details }}</td>
									<td>
										<div class="btn-group">
											<a href="{{ route('cc-loan.edit', $loan->id) }}" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top" title="Update">
												Update
											</a>
											<form action="{{ route('cc-loan.destroy', $loan->id) }}" method="POST">
												@csrf
												@method('DELETE')
												<button class="btn btn-danger btn-sm">Delete</button>
											</form>
											<a href="{{ url('cc-loan/report', $loan->id) }}" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Report">
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
	//server side data table
	$(document).ready(function () {
		$('#dataTable').DataTable();
	});
</script>
@endsection