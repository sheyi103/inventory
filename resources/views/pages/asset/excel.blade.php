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
				<th colspan="5">Asset List</th>
			</tr>
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
</body>
</html>