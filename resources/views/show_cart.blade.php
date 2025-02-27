@extends('layouts.user')
@section('title','Cart Items')

@section('content')
@if($carts->count()>0)
<div class="untree_co-section before-footer-section">
    <div class="container">
      <div class="row mb-5">
        <form class="col-md-12" method="post">
          <div class="site-blocks-table">
            <table class="table">
              <thead>
                <tr>
                  <th class="product-thumbnail">Image</th>
                  <th class="product-name">Product</th>
                  <th class="product-price">Price</th>
                  <th class="product-quantity">Quantity</th>
                  <th class="product-total">Total</th>
                  <th class="product-remove">Remove</th>
                </tr>
              </thead>
              <tbody>
                @php
                 $subtotal=0   
                @endphp
                @foreach ($carts as $item)
                <tr>
                  <td class="product-thumbnail">
                    <img src="/gallery/product/{{ $item->product->image}}" alt="Image" class="img-fluid">
                  </td>
                  <td class="product-name">
                    <h2 class="h5 text-black">{{$item->product->title}}</h2>
                  </td>
                  <td>${{$item->product->price}}</td>
                  <td>
                    {{$item->quantity}}
                  </td>
                  <td>${{$item->total_price}}</td>
                  <td><a href="{{route('delete.cart',$item->id)}}" class="btn btn-danger btn-sm fa fa-trash" style="color: rgb(207, 14, 14)"></a></td>
                </tr>
                   @php
                     $subtotal+=$item->total_price;
                    @endphp   
                @endforeach
              </tbody>
            </table>
          </div>
        </form>
      </div>
      <div class="col-md-12 text-end">
        <div class="row">
          <div class="col-md-12 border-bottom mb-5">
            <h3 class="text-black h4 text-uppercase">Cart Totals</h3>
          </div>
        </div>
        <div class="d-flex justify-content-end align-items-center mb-5 ml-5">
          <span class="text-black fw-bold">Subtotal:</span>
          <strong class="text-black ms-5">${{$subtotal}}</strong>
      </div>
        <div class="row">
          <div class="col-md-12">
            <form action="{{ route('checkout') }}" method="POST">
              @csrf
              <input type="hidden" name="subtotal" value="{{ $subtotal }}">
              <button type="submit" class="btn btn-black btn-lg py-3 btn-block">Proceed To Checkout</button>
          </form>
          
          
          </div>
        </div>
      </div>
    </div>
  </div>
  @else
<div class="text-center mt-5 container p-4 rounded shadow" 
     style="height: 20vh; background-color: rgb(245, 97, 97); display: flex; align-items: center; justify-content: center;">
    <h3 class="text-white fw-bold">No items in cart</h3>
</div>
@endif

@endsection