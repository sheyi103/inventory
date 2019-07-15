@extends('layouts.master')
@section('title', 'Head Accounts')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Head Accounts</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
						<li class="breadcrumb-item active">Head Accounts</li>
					</ol>
				</div><!-- /.col -->
			</div><!-- /.row -->
		</div><!-- /.container-fluid -->
	</div>
	<!-- /.content-header -->

	<!-- Main content -->
	<section class="content">
		<div class="container-fluid">
			<div class="card">
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
							<thead>
								<tr>
									<th>Name</th>
									<th>Parent</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								@forelse($headAccounts as $headAccount)
								<tr>
									<td>{{ $headAccount->name }}</td>
									<td>{{ $headAccount->accountType->name }}</td>
									<td>
										<a href="{{ route('head-accounts.edit', $headAccount->id) }}" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top" title="Update">
											Update
										</a>
									</td>
								</tr>
								@empty
								@component('partials.warning')
								No Information Found
								@endcomponent
								@endforelse
							</tbody>
						</table>
					</div>

					{{ $headAccounts->links() }}
				</div>
			</div>
		</div>
	</section>
</div>
@endsection