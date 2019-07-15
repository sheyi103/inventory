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
				<th colspan="4">Customer List</th>
			</tr>
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
</body>
</html>