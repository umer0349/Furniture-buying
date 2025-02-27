@extends('layouts.user')
@section('title','Buy Products')

@section('content')
<div class="row">
    <div class="col-12 col-md-6 col-lg-4">
        <h3 class="text-center text-dark mt-5 fw-bolder"> <i>Our Products</i></h3>
    </div>
</div>

<div class="untree_co-section product-section before-footer-section">
    <div class="container">
		<div class="row">
			@foreach($products as $item)
				<div class="col-12 col-md-4 col-lg-3 mb-5">
					<div class="shadow-lg border-0 h-100 p-3 rounded">
						<a class="product-item d-block text-center" > 
							<img src="{{ asset('gallery/product/' . $item->image) }}" class="img-fluid product-thumbnail"> 
							<h3 class="product-title mt-2">{{ $item->title }}</h3>
							<strong class="product-price d-block">${{ number_format($item->price, 2) }}</strong>
							<span class="icon-cross d-inline-block mt-2">
								<img src="{{ asset('images/cross.svg') }}" class="img-fluid" data-bs-toggle="modal" data-bs-target
								="#productModal__{{$item->id}}">
							</span>
						</a>
					</div> 
				</div>
		<!-- Modal -->
<div class="modal fade" id="productModal__{{$item->id}}" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body">
                <form action="{{route('add.cart')}}" method="post">
                    @csrf
                    <input type="hidden" name="product_id" value="{{$item->id}}">
                
                <div class="row">
                    <!-- Left Side: Product Image -->
                    <div class="col-md-5">
                        <img src="{{ asset('gallery/product/' . $item->image) }}" class="img-fluid rounded" alt="Product Image">
                    </div>
                    
                    <!-- Right Side: Product Details -->
                    <div class="col-md-7 d-flex flex-column justify-content-center">
                        <h4 id="productTitle">{{ $item->title }}</h4>
                        <p class="text-muted">Price: ${{ number_format($item->price, 2) }}<strong id="productPrice"></strong></p>
                        
                        <label for="productQuantity" class="form-label">Quantity:</label>
                        <input type="number" id="productQuantity" name="quantity" class="form-control mb-3" min="1" value="1">
                        
                        <button class="btn btn-success w-100" type="submit">Add to Cart</button>
                    </div>
                </div>
            </form>
            </div>
        </div>
    </div>
</div>

@endforeach
</div>
</div>
</div>
@endsection
