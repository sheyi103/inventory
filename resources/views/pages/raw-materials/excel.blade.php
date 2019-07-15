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
				<th colspan="3">Raw Materials List</th>
			</tr>
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
</body>
</html>