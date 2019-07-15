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
				<th colspan="4">Flat List</th>
			</tr>
			<tr>
				<th>Sl</th>
				<th>Name</th>
				<th>Tenant Name</th>
				<th>Tenant Mobile</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($flars as $flar)
			<tr>
				<td>{{ $loop->iteration }}</td>
				<td>{{ $flar->name }}</td>
				<td>{{ $flar->tenant_name }}</td>
				<td>{{ $flar->tenant_mobole }}</td>
			</tr>
			@endforeach
		</tbody>
	</table>
</body>
</html>