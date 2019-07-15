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
				<th>{{ $supplier->name }}'s Report</th>
			</tr>
		</thead>
	</table>
	<table>
		<thead>
			<tr>
				<th>Purchase List</th>
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
			@foreach($purchases as $purchase)
			<tr>
				<td>{{ $loop->iteration }}</td>
				<td>{{ $purchase->product->name }}</td>
				<td>{{ $purchase->date }}</td>
				<td>{{ $purchase->quantity }}</td>
				<td>{{ $purchase->amount }}</td>
			</tr>
			@endforeach
		</tbody>
	</table>
	<table>
		<tr>
			<th>Payment Table</th>
		</tr>
		<tr>
			<td>Cash Purchase</td>
			<td>{{ $cash_purchases }}</td>
		</tr>
		<tr>
			<td>Due Purchase</td>
			<td>{{ $due_purchases }}</td>
		</tr>
		<tr>
			<td>Payable</td>
			<td>{{ $payable }}</td>
		</tr>
	</table> 
</body>
</html>