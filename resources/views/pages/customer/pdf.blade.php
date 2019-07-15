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
			<h2 style="text-align: center;">Customer List</h2>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
						<thead>
							<tr>
								<th>Sl</th>
								<th>Name</th>
								<th>Mobile</th>
								<th>Address</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($customers as $customer)
							<tr>
								<td>{{ $loop->iteration }}</td>
								<td>{{ $customer->name }}</td>
								<td>{{ $customer->mobile }}</td>
								<td>{{ $customer->address }}</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</body>
</html>