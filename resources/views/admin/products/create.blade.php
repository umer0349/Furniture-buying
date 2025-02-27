@extends('layouts.index')
@section('title','create product')
@section('content')

@if(Session::has('success'))
<div class="alert alert-success">{{Session::get('success')}}</div>
@endif
<div class="row mt-5">
  <div class="col-lg-6">
  <i class="fw-bolder fs-4" >Users List</i>
  </div>
  <div class="col-lg-6">
  <button type="button" class="btn btn-success btn-sm float-end" data-toggle="modal" data-target="#exampleModal">
   create product
</button>
  </div>
</div>

<div class="container">
 
  <div class="table-responsive">
      <table class="table table-hover table-bordered text-center">
          <thead class="table-info">
              <tr>
                  <th>#</th>
                  <th>title</th>
                  <th>price</th>
                  <th>Image</th>
                  <th>Created_At</th>
                  <th>action</th>
              </tr>
          </thead>
          <tbody>
            @foreach ($products as $item)
          <tr>
        <td>{{$loop->iteration}}</td>
        <td>{{$item->title}}</td>
        <td>{{$item->price}}</td>
        <td>
          <img src="/gallery/product/{{ $item->image}}" alt="Product Image" width="50">


        </td>
          <td>{{$item->created_at->format('d,M,y')}}</td>
        <td>
          <a class="btn btn-primary btn-sm"  href="{{route('product.edit',$item->id)}}">edit</a>
          <a  class="btn btn-danger btn-sm" href="{{route('product.delete',$item->id)}}">delete</a>
        </td>
          </tr>
          @endforeach
          </tbody>
      </table>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"> create products</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{route('product.store')}}" method="post" enctype="multipart/form-data">
          @csrf
            <div class="row">
              <div class="col-8 offset-1">
                <div class="form-group">
                  <label class="text-black" for="fname">Title:</label>
                  <input type="text" class="form-control" id="fname" name="title">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-8 offset-1">
                <div class="form-group">
                  <label class="text-black" for="fname">price:</label>
                  <input type="number" class="form-control" id="fname" name="price" min="0">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-8 offset-1">
                <div class="form-group">
                  <label class="text-black" for="fname">image:</label>
                  <input type="file" class="form-control" id="fname" name="image">
                </div>
              </div>
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-info btn-sm ">submit</button>
      </div>
    </form>
    </div>
  </div>
</div>
<div class="d-flex justify-content-center mt-4">
    {{ $products->links('pagination::bootstrap-4') }}
</div>




@endsection