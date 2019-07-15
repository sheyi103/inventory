<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<!-- Styles -->
	<link href="{{ asset('css/app.css') }}" rel="stylesheet">
	<link href="{{ asset('css/style.css') }}" rel="stylesheet">

	<!-- Fonts -->
	<link rel="stylesheet" href="{{ asset('vendor/font-awesome/css/font-awesome.min.css') }}">
	<link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
	<title>Print</title>
</head>
<body>
	<div class="container">
		<div style="text-align: center;">
			<img src="{{ asset('images/mayer doa logo 1.png') }}" class="" alt="{{ config('app.name', 'WardanTech') }}" style="width: 400px; height: 70px;">
		</div>
		<br><br>
		<h2 style="text-align: center;">{{ $customer->name }}'s Report</h2>
		<hr>
		<div class="row">
			<div class="col-md-12">
				<div class="row">
					<h4>Sale Table</h4>
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
							@foreach($sales as $sale)
							<tr>
								<td>{{ $loop->iteration }}</td>
								<td>{{ $sale->product->name }}</td>
								<td>{{ $sale->date }}</td>
								<td>{{ $sale->quantity }}</td>
								<td>{{ $sale->amount }}</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
				<br><br>
				<div class="row">
					<h4>Payment Table</h4>
					<table>
						<tr>
							<td>Cash Sale</td>
							<td>{{ $cash_sales }}</td>
						</tr>
						<tr>
							<td>Due Sale</td>
							<td>{{ $due_sales }}</td>
						</tr>
						<tr>
							<td>Receivable</td>
							<td>{{ $receivable }}</td>
						</tr>
					</table>         
				</div>
			</div>
		</div>
	</div>
</body>
</html>