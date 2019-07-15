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
			<img src="{{ asset('images/al-ham.png') }}" class="" alt="{{ config('app.name', 'WardanTech') }}" style="width: 400px; height: 70px;">
		</div>
		<br><br>
		<h2 style="text-align: center;">Asset List</h2>
		<hr>
		<div class="table-responsive">
			<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
				<thead>
					<tr>
						<th>Sl</th>
						<th>Purchase Date</th>
						<th>Name</th>
						<th>Value</th>
						<th>Remarks</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($assets as $asset)
					<tr>
						<td>{{ $loop->iteration }}</td>
						<td>{{ $asset->date }}</td>
						<td>{{ $asset->name }}</td>
						<td>{{ $asset->amount }}</td>
						<td>{{ $asset->details }}</td>
					</tr>
					@endforeach
				</tbody>
				<tfoot>
					<tr>
						<th colspan="3" style="text-align:right">Total:</th>
						<th>{{ $total }}</th>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>
</body>
</html>