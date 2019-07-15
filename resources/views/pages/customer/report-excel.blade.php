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
				<th>{{ $customer->name }}'s Report</th>
			</tr>
		</thead>
	</table>
	<table>
		<thead>
			<tr>
				<th>Sale List</th>
			</tr>
			<tr>
				<th>SL</th>
				<th>Product</th>
				<th>Date</th>
				<th>Quantity</th>
				<th>Amount</th>
			</tr>
		</thead>
		<tbody>
			@foreach($sales as $sale)
			<tr>
				<td>{{ $loop->iteration }}</td>
				<td>{{ $sale->product->name }}</td>
				<td>{{ $sale->date }}</td>
				<td>{{ $sale->quantity }}</td>
				<td>{{ $sale->amount }}</td>
			</tr>
			@endforeach
		</tbody>
	</table>
	<table>
		<tr>
			<th>Payment Table</th>
		</tr>
		<tr>
			<td>Cash Sale</td>
			<td>{{ $cash_sales }}</td>
		</tr>
		<tr>
			<td>Due Sale</td>
			<td>{{ $due_sales }}</td>
		</tr>
		<tr>
			<td>Receivable</td>
			<td>{{ $receivable }}</td>
		</tr>
	</table> 
</body>
</html>