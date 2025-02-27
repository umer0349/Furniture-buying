@extends('layouts.index')
@section('title', 'Order Detail')
@section('content')

<div class="container">
    <h2 class="mb-4 text-center">Order Detail List</h2>
    <div class="mb-3 ">
        <a href="{{ route('orders.show') }}">
            <img src="{{ asset('images/back.png') }}" alt="" style="background-color:rgb(110, 100, 100);padding:3px; border-radius:10px">
        </a>
        
</div>
    <div class="table-responsive">
        <table class="table table-hover table-bordered text-center">
            <thead class="table-secondary">
                <tr>
                    <th>#</th>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total Price</th>
                    <th>Ordered At</th>
                </tr>
            </thead>
            <tbody>
                 @php
                 $subtotal=0;
                 @endphp
                @foreach ($orderdetail->items as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->product->title ?? 'N/A' }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>${{ number_format($item->price, 2) }}</td>
                    <td>${{ number_format($item->quantity*$item->price, 2)}}</td>
                    <td>{{ $orderdetail->created_at->format('d M, Y') }}</td>
                    @php
                    $subtotal+=$item->quantity * $item->price
                    @endphp
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="col-md-12 text-end">
        <div class="d-flex justify-content-end align-items-center mb-5 ml-2">
          <span class="text-black fw-bold">Subtotal =</span>
          <strong class="text-black ms-3">${{ number_format($subtotal, 2) }}</strong>
      </div>
</div>
@endsection
