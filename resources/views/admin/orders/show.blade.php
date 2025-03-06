@extends('layouts.index')
@section('title','Order List')

@section('content')
<div class="container">
    <h2 class="mb-4 text-center">Order List</h2>
    <div class="table-responsive">
        <table id="orders-table" class="table table-hover table-bordered text-center">
            <thead class="table-secondary">
                <tr>
                    <th>#</th>
                    <th>Order No</th>
                    <th>Customer Name</th>
                    <th>Subtotal</th>
                    <th>Payment Status</th>
                    <th>Created At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody></tbody> <!-- Data AJAX se populate hoga -->
        </table>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#orders-table').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "{{ route('orders.show') }}",
            "columns": [
                { "data": "DT_RowIndex", "orderable": false, "searchable": false },
                { "data": "order_number" },
                { "data": "user_name" },
                { "data": "subtotal" },
                { "data": "status" },
                { "data": "created_at" },
                { "data": "action", "orderable": false, "searchable": false }
            ]
          
        });
    });
</script>
@endsection







