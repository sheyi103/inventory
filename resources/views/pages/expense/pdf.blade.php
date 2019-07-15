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
			<h2 style="text-align: center;">Expenses From {{ $start_date }} To {{ $end_date }}</h2>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
						<thead>
							<tr>
								<th>Sl</th>
								<th>Date</th>
								<th>Expense Type</th>
								<th>Amount</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($expenses as $expense)
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
				</div>
			</div>
		</div>
	</div>
</body>
</html>