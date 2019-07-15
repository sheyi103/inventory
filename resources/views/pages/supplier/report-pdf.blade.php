<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>PDF</title>
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
	<div class="card mb-3">
		<div class="card-header">
			<h2 style="text-align: center;">{{ $supplier->name }}'s Report</h2>
			<br><br>
			<div class="row">
				<div class="col-md-12">
					<h4>Purchase Table</h4>
					<div class="row">
						<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
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
					<br><br>
					<h4>Payment Table</h4>
					<div class="row">
						<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
							<tr>
								<td>Cash Purchases</td>
								<td>{{ $cash_purchases }}</td>
							</tr>
							<tr>
								<td>Due Purchases</td>
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
</body>
</html>