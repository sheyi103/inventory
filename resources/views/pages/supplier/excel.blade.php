<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Excel</title>
</head>
<body>
	<table>
		<thead>
			<tr>
				<th colspan="4">Supplier List</th>
			</tr>
			<tr>
				<th>Sl</th>
				<th>Name</th>
				<th>Mobile</th>
				<th>Address</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($suppliers as $supplier)
			<tr>
				<td>{{ $loop->iteration }}</td>
				<td>{{ $supplier->name }}</td>
				<td>{{ $supplier->mobile }}</td>
				<td>{{ $supplier->address }}</td>
			</tr>
			@endforeach
		</tbody>
	</table>
</body>
</html>