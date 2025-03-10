@extends('layouts.index')
@section('title','Order List')

@section('content')
@if(session('success'))
    <div class="alert alert-success d-none">
        {!! session('success') !!}
    </div>
@endif

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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        let table = $('#orders-table').DataTable({
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

        // Soft Delete AJAX
        $(document).on("click", ".soft-delete", function(e) {
            e.preventDefault();
            let orderId = $(this).data("id");
          

            $.ajax({
                url: "{{ route('order.delete', '') }}/" + orderId,

                type: "get",
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    if (response.success) {
                        $("body").append(response.toast); // Alert ya Toastr use kar sakte hain
                        table.ajax.reload(); // Table ko refresh karega bina page reload kiye
                    }
                },
                error: function(response) {
                    alert("Something went wrong!");
                }
            });
        });
        $(document).on("click", ".hard-delete", function(e) {
            e.preventDefault();
            let orderId = $(this).data("id");
          

            $.ajax({
                url: "{{ route('order.heard_deleted', '') }}/" + orderId,

                type: "get",
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    if (response.success) {
                        $("body").append(response.toast); // Alert ya Toastr use kar sakte hain
                        table.ajax.reload(); // Table ko refresh karega bina page reload kiye
                    }
                },
                error: function(response) {
                    alert("Something went wrong!");
                }
            });
        });
        $(document).on("click", ".restore", function(e) {
            e.preventDefault();
            let orderId = $(this).data("id");
          

            $.ajax({
                url: "{{ route('order.restore', '') }}/" + orderId,

                type: "get",
              
                success: function(response) {
                    if (response.success) {
                        $("body").append(response.toast); // Alert ya Toastr use kar sakte hain
                        table.ajax.reload(); // Table ko refresh karega bina page reload kiye
                    }
                },
                error: function(response) {
                    alert("Something went wrong!");
                }
            });
        });
     
     
    });
</script>
@endsection
