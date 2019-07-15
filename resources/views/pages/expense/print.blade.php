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
		<div class="container" id="printdiv">
			<h2 style="text-align: center;">Expenses From {{ $start_date }} To {{ $end_date }}</h2>
			<hr>
			<div class="table-responsive">
				<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
					<thead>
						<tr>
							<th>Sl</th>
							<th>Date</th>
							<th>Expense Type</th>
							<th>Amount</th>
						</tr>
					</thead>
					<tbody>
						@foreach($expenses as $expense)
						<tr>
							<td>{{ $loop->iteration }}</td>
							<td>{{ $expense->date }}</td>
							<td>{{ $expense->accounts->name }}</td>
							<td>{{ $expense->amount }}</td>
						</tr>
						@endforeach
					</tbody>

					<tfoot>
						<tr>
							<th colspan="3" style="text-align:right">Total:</th>
							<th>{{ array_sum($total) }}</th>
						</tr>
					</tfoot>
				</table>
			</div>
		</div>
	</div>
</body>
</html>