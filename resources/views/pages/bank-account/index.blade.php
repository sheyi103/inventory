@extends('layouts.master')
@section('title', 'Bank Account')

@section('content')
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Bank Accounts</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
						<li class="breadcrumb-item active">Accounts</li>
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
					<a href="{{ url('bank-account/print') }}" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Print" target="_blank">
						<i class="fa fa-print" aria-hidden="true" title="Print"></i> Print
					</a>

					<a href="{{ url('bank-account/pdf') }}" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="PDF" target="_blank">
						<i class="fa fa-file-pdf-o" aria-hidden="true" title="PDF"></i> PDF
					</a>

					<a href="{{ url('bank-account/excel') }}" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Excel" target="_blank">
						<i class="fa fa-file-excel-o" aria-hidden="true" title="Excel"></i> Excel
					</a>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
							<thead>
								<tr>
									<th>Sl</th>
									<th>Account No</th>
									<th>Account Holder</th>
									<th>Bank</th>
									<th>Amount</th>
									<th>Remarks</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								@forelse($bankAccounts as $bankAccount)
								<tr>
									<td>{{ $loop->iteration }}</td>
									<td>{{ $bankAccount->account_no }}</td>
									<td>{{ $bankAccount->account_holder_name }}</td>
									<td>{{ $bankAccount->bank->name }}</td>
									<td>{{ $bankAccount->amount }}</td>
									<td>{{ $bankAccount->details }}</td>
									<td>
										<div class="btn-group">
											<a href="{{ route('bank-account.edit', $bankAccount->id) }}" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top" title="Update">
												Update
											</a>
											<form action="{{ route('bank-account.destroy', $bankAccount->id) }}" method="POST">
												@csrf
												@method('DELETE')
												<button class="btn btn-danger btn-sm">Delete</button>
											</form>
											<a href="{{ url('bank-account/report', $bankAccount->id) }}" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Report">
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