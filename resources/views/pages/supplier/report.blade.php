@extends('layouts.master')
@section('title', 'Supplier')

@section('content')
<!-- Breadcrumbs-->
<ol class="breadcrumb">
	<li class="breadcrumb-item">
		<a href="{{ url('/') }}">Dashboard</a>
	</li>
	<li class="breadcrumb-item">
		<a href="{{ route('supplier.index') }}">
			Supplier
		</a>
	</li>
	<li class="breadcrumb-item active">
		Report
	</li>
</ol>
<div class="card mb-3">
	<div class="card-header">
		<a href="{{ url('supplier/report/print', $id) }}" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Print" target="_blank">
			<i class="fa fa-print" aria-hidden="true" title="Print"></i> Print
		</a>

		<a href="{{ url('supplier/report/pdf', $id) }}" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="PDF" target="_blank">
			<i class="fa fa-file-pdf-o" aria-hidden="true" title="PDF"></i> PDF
		</a>

		<a href="{{ url('supplier/report/excel', $id) }}" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Excel" target="_blank">
			<i class="fa fa-file-excel-o" aria-hidden="true" title="Excel"></i> Excel
		</a>
	</div>
</div>
<div class="row">
	<div class="col-12">
		<div class="row">
			{{-- Total Purchase count --}}
			<div class="col-sm-6">
				<div class="alert alert-secondary">
					<button type="button" class="close">
						<i class="fa fa-money fa-2x" aria-hidden="true"></i>
					</button>
					<h4>Purchase Table</h4>
					<table>
						<thead>
							<tr>
								<th>SL</th>
								<th>Product</th>
								<th>Date</th>
								<th>Quantity</th>
								<th>Amount</th>
							</tr>
						</thead>
						<tbody>
							@foreach($purchases as $purchase)
							<tr>
								<td>{{ $loop->iteration }}</td>
								<td>{{ $purchase->product->name }}</td>
								<td>{{ $purchase->date }}</td>
								<td>{{ $purchase->quantity }}</td>
								<td>{{ $purchase->amount }}</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>

			{{-- Total purchase count --}}
			<div class="col-sm-6">
				<div class="alert alert-primary">
					<button type="button" class="close">
						<i class="fa fa-money fa-2x" aria-hidden="true"></i>
					</button>
					<h4>Payment Table</h4>
					<table>
						<tr>
		                    <td>Cash Purchase</td>
		                    <td>{{ $cash_purchases }}</td>
		                </tr>
		                <tr>
		                    <td>Due Purchase</td>
		                    <td>{{ $due_purchases }}</td>
		                </tr>
		                <tr>
		                    <td>Payable</td>
		                    <td>{{ $payable }}</td>
		                </tr>
					</table>
				</div>
			</div>            
		</div>
	</div>
</div>
@endsection
