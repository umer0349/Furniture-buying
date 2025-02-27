@extends('layouts.index')
@section('title','ordera list')
@section('content')
<div class="container">
    <h2 class="mb-4 text-center">order List</h2>
    <div class="table-responsive">
        <table class="table table-hover table-bordered text-center">
            <thead class="table-secondary">
                <tr>
                    <td>#</td>
                    <th>order_no</th>
                    <th>costomer_name</th>
                    <th>subtotal</th>
                    <th> payment_status</th>
                    <th>created_at</th>
                    <th>action</th>

                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $item)
                <tr>
                    <td>{{ $loop->iteration}}</td>
                    <td> {{ $item->order_number}}</td>
                    <td> {{ $item->user->name}}</td>
                    <td> {{ $item->subtotal}}</td>
                    <td> {{ $item->status}}</td>
                    <td> {{ $item->created_at->format('d M,y')}}</td>
                    <td>
                        @if($item->deleted_at==null)
                        <a href="{{ route('orderdtail.show', $item->id) }}"
                            class="btn btn-info btn-sm fa fa-eye"
                            data-bs-toggle="tooltip"
                            data-bs-placement="top"
                            title="View Order Details">
                        </a>

                        <a href="{{route('order.delete',$item->id)}}"
                            class="btn btn-warning btn-sm fa fa-trash"
                            data-bs-toggle="tooltip"
                            data-bs-placement="top"
                            title="soft delete"></a>
                        @endif
                        @if(!$item->deleted_at==null)
                        <a href="{{route('order.restore',$item->id)}}"
                            class="btn btn-primary btn-sm fa fa-undo"
                            data-bs-toggle="tooltip"
                            data-bs-placement="top"
                            title="restore"></a>
                        <a href="{{route('order.heard_deleted',$item->id)}}"
                            class="btn btn-danger btn-sm fa fa-trash"
                            data-bs-toggle="tooltip"
                            data-bs-placement="top"
                            title="heard delete"></a>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="d-flex justify-content-center mt-4">
    {{ $orders->links('pagination::bootstrap-4') }}
</div>
@endsection
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>