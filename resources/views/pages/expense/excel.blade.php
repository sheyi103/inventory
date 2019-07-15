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
				<th>Expenses From {{ $start_date }} To {{ $end_date }}</th>
			</tr>
			<tr>
				<th>Sl</th>
				<th>Date</th>
				<th>Expense Type</th>
				<th>Amount</th>
			</tr>
		</thead>
		<tbody>
			@foreach($expenses as $expense)
			<tr>
				<td>{{ $loop->iteration }}</td>
				<td>{{ $expense->date }}</td>
				<td>{{ $expense->accounts->name }}</td>
				<td>{{ $expense->amount }}</td>
			</tr>
			@endforeach
		</tbody>
		<tfoot>
			<tr>
				<th colspan="3" style="text-align:right">Total:</th>
				<th>{{ array_sum($total) }}</th>
			</tr>
		</tfoot>
	</table>
</body>
</html>