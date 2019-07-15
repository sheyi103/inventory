@extends('layouts.master')
@section('title', 'Delivery')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">All Deliveries</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
            <li class="breadcrumb-item active">Deliveries</li>
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
                  <th>Customer</th>
                  <th>Work Order No</th>
                  <th>Challan No</th>
                  <th>Product</th>
                  <th>Quantity</th>
                  <th>Action</th>
                </tr>
              </thead>
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
        "url": "{{ url('all-deliveries') }}",
        "dataType": "json",
        "type": "POST",
        "data":{ _token: "{{ csrf_token() }}"}
      },
      "columns": [
      { "data": "id" },
      { "data": "date" },
      { "data": "customer_id" },
      { "data": "workOrder_id" },
      { "data": "challan_no" },
      { "data": "product_id" },
      { "data": "quantity" },
      { "data": "actions" },
      ], 
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