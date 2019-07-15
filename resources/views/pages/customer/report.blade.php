@extends('layouts.master')
@section('title', 'Customer')

@section('content')
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Customer Report</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
						<li class="breadcrumb-item"><a href="{{ url('customer') }}">Customers</a></li>
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
					<a href="{{ url('customer/report/print', $id) }}" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Print" target="_blank">
						<i class="fa fa-print" aria-hidden="true" title="Print"></i> Print
					</a>

					<a href="{{ url('customer/report/pdf', $id) }}" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="PDF" target="_blank">
						<i class="fa fa-file-pdf-o" aria-hidden="true" title="PDF"></i> PDF
					</a>

					<a href="{{ url('customer/report/excel', $id) }}" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Excel" target="_blank">
						<i class="fa fa-file-excel-o" aria-hidden="true" title="Excel"></i> Excel
					</a>
				</div>
			</div>
			<div class="row">
				<div class="col-12">
					<div class="row">
						{{-- Total sale count --}}
						<div class="col-sm-6">
							<div class="alert alert-secondary">
								<button type="button" class="close">
									<i class="fa fa-money fa-2x" aria-hidden="true"></i>
								</button>
								<h4>Bill Table</h4>
								<table>
									<thead>
										<tr>
											<th>SL</th>
											<th>Product</th>
											<th>Date</th>
											<th>Quantity</th>
											<th>Rate</th>
											<th>Amount</th>
										</tr>
									</thead>
									<tbody>
										@foreach($bills as $bill)
										<tr>
											<td>{{ $loop->iteration }}</td>
											<td>{{ $bill->product->name }}</td>
											<td>{{ $bill->date }}</td>
											<td>{{ $bill->quantity }}</td>
											<td>{{ $bill->rate }}</td>
											<td>{{ $bill->amount }}</td>
										</tr>
										@endforeach
									</tbody>
								</table>
							</div>
						</div>

						{{-- Total sale count --}}
						{{-- Total purchase count --}}
						<div class="col-sm-6">
							<div class="alert alert-primary">
								<button type="button" class="close">
									<i class="fa fa-money fa-2x" aria-hidden="true"></i>
								</button>
								<h4>Transaction Table</h4>
								<table>
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
												Sale
												@else
												Payment
												@endif
											</td>
											<td>{{ $transaction->date }}</td>
											<td>{{ $transaction->amount }}</td>
											@if($transaction->purpose == 2)
											<td>
												<div class="btn-group">
													<a href="{{ route('sale-transaction.edit', $transaction->id) }}" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top" title="Update">
														Update
													</a>
													<form action="{{ route('sale-transaction.destroy', $transaction->id) }}" method="POST">
														@csrf
														@method('DELETE')
														<button class="btn btn-danger btn-sm">Delete</button>
													</form>
												</div>
											</td>
											@endif
										</tr>
										@endforeach
									</tbody>
									<tfoot>
										<tr>
											<th>Balance</th>
											<th></th>
											<th>{{ $balance }}</th>
											<th></th>
										</tr>
									</tfoot>
								</table>
							</div>
						</div>            
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
@endsection
