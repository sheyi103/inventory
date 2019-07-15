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
			<h2 style="text-align: center;">Products List</h2>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
						<thead>
							<tr>
								<th>SL</th>
								<th>Name</th>
								<th>Vat</th>
								<th>Stock</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($products as $product)
							<tr>
								<td>{{ $loop->iteration }}</td>
								<td>{{ $product->name }}</td>
								<td>{{ $product->vat }}</td>
								<td>{{ $product->stock }}</td>
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