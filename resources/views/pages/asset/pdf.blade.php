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
			<h2 style="text-align: center;">Asset List</h2>
			<div class="card-body">
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
		</div>
	</div>
</body>
</html>