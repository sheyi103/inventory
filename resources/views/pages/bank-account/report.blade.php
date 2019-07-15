@extends('layouts.master')
@section('title', 'Bank Account')

@section('content')
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-8">
					<h1 class="m-0 text-dark">{{ $bankAccount->bank->name.', '.$bankAccount->account_no }} Transaction Report</h1>
				</div><!-- /.col -->
				<div class="col-sm-4">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
						<li class="breadcrumb-item"><a href="{{ url('bank-account') }}">Accounts</a></li>
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
					<a href="{{ url('bank-account/report/print', $id) }}" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Print" target="_blank">
						<i class="fa fa-print" aria-hidden="true" title="Print"></i> Print
					</a>

					<a href="{{ url('bank-account/report/pdf', $id) }}" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="PDF" target="_blank">
						<i class="fa fa-file-pdf-o" aria-hidden="true" title="PDF"></i> PDF
					</a>

					<a href="{{ url('bank-account/report/excel', $id) }}" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Excel" target="_blank">
						<i class="fa fa-file-excel-o" aria-hidden="true" title="Excel"></i> Excel
					</a>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
							<thead>
								<tr>
									<th>Purpose</th>
									<th>Date</th>
									<th>Amount</th>
									<th>Actions</th>
								</tr>
							</thead>
							<tbody>
								@foreach($transactions as $transaction)
								<tr>
									<td>
										@if($transaction->purpose == 1)
										Deposit
										@elseif($transaction->purpose == 2)
										Withdraw
										@elseif($transaction->purpose == 3)
										Sale Payment
										@else 
										Purchase Payment
										@endif
									</td>
									<td>{{ $transaction->date }}</td>
									<td>{{ $transaction->amount }}</td>
									<td>
										<div class="btn-group">
											<a href="{{ route('bank-transaction.edit', $transaction->id) }}" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top" title="Update">
												Update
											</a>
											<form action="{{ route('bank-transaction.destroy', $transaction->id) }}" method="POST">
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
									<th>Balance</th>
									<th></th>
									<th>{{ $bankAccount->amount }}</th>
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
	//server side data table
	$(document).ready(function () {
		$('#dataTable').DataTable();
	});
</script>
@endsection
