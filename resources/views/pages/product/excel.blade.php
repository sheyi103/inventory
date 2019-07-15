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
				<th colspan="4">Products List</th>
			</tr>
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
</body>
</html>