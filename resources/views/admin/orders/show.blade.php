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
                   <a href="{{route('orderdtail.show',$item->id)}}" class="btn btn-primary btn-sm fa fa-eye"></a> 
                   <a href="{{route('order.delete',$item->id)}}"  class="btn btn-danger btn-sm fa fa-trash"></a>
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