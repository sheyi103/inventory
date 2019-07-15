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
			<h2 style="text-align: center;">Raw Materials List</h2>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
						<thead>
							<tr>
								<th>SL</th>
								<th>Name</th>
								<th>Stock</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($rawmaterials as $rawmaterial)
							<tr>
								<td>{{ $loop->iteration }}</td>
								<td>{{ $rawmaterial->name }}</td>
								<td>{{ $rawmaterial->stock }}</td>
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