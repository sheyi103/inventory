@extends('layouts.master')
@section('title', 'Expense')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">{{ $expenseItem->name }} Expense Report</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('expense-item') }}">Expense Items</a></li>
                        <li class="breadcrumb-item active">Report</li>
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
                                    <th>Sl</th>
                                    <th>Date</th>
                                    <th>Amount</th>
                                    <th>Remarks</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th colspan="2" style="text-align:right">Total:</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@section('script')
<script>
	//server side data table
    $(document).ready(function () {
        $('#dataTable').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax":{
                "url": "{{ url('all-expenses-of',$id) }}",
                "dataType": "json",
                "type": "POST",
                "data":{ _token: "{{ csrf_token() }}"}
            },
            "columns": [
            { "data": "id" },
            { "data": "date" },
            { "data": "amount" },
            { "data": "details" },
            { "data": "actions" },
            ],
            "footerCallback": function ( row, data, start, end, display ) {
                var api = this.api(), data;
                var json = api.ajax.json();
                
                // Remove the formatting to get integer data for summation
                var intVal = function ( i ) {
                    return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                    i : 0;
                };
                
                // Total over all pages
                total = json.totalSum;
                
                // Total over this page
                pageTotal = api
                .column( 2, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
                
                // Update footer
                $( api.column( 2 ).footer() ).html(
                    ''+pageTotal +' ( '+ total +' total)'
                    );
            }	 
        });
    });

    //delete a row using ajax
    $('#dataTable').on('click', '.btn-delete[data-remote]', function (e) { 
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var url = $(this).data('remote');
        // confirm then
        if (confirm('are you sure you want to delete this?')) {
            $.ajax({
                url: url,
                type: 'POST',
                dataType: 'json',
                data: {_method: 'DELETE', submit: true}
            }).always(function (data) {
                $('#dataTable').DataTable().draw(false);
            });
        }
    });
</script>
@endsection