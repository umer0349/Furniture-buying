@extends('layouts.index')
@section('title','Create Product')
@section('content')

@if(Session::has('success'))
<div class="alert alert-success">{{ Session::get('success') }}</div>
@endif
@if ($errors->any())
<div class="alert alert-danger">
  <ul>
    @foreach ($errors->all() as $error)
    <li>{{ $error }}</li>
    @endforeach
  </ul>
</div>
@endif
<div class="row mt-5">
  <div class="col-lg-6">
    <i class="fw-bolder fs-4">Users List</i>
  </div>
  <div class="col-lg-6">
    <button type="button" class="btn btn-success btn-sm float-end" data-bs-toggle="modal" data-bs-target="#exampleModal">
      Create Product
    </button>
  </div>
</div>
<div id="message"></div>
<div class="container">
  <div class="table-responsive">
    <table class="table table-hover table-bordered text-center">
      <thead class="table-info">
        <tr>
          <th>#</th>
          <th>Title</th>
          <th>Price</th>
          <th>Image</th>
          <th>Created At</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($products as $item)
        <tr>
          <td>{{ $loop->iteration }}</td>
          <td>{{ $item->title }}</td>
          <td>{{ $item->price }}</td>
          <td>
            <img src="/gallery/product/{{ $item->image }}" alt="Product Image" width="50">
          </td>
          <td>{{ $item->created_at->format('d, M, y') }}</td>
          <td>
            <a class="btn btn-primary btn-sm" href="{{ route('product.edit', $item->id) }}">Edit</a>
            <a class="btn btn-danger btn-sm" href="{{ route('product.delete', $item->id) }}">Delete</a>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Create Product</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="productform" enctype="multipart/form-data">
          @csrf
          <div class="mb-3">
            <label class="form-label">Title:</label>
            <input type="text" class="form-control" name="title">
          </div>
          <div class="mb-3">
            <label class="form-label">Price:</label>
            <input type="number" class="form-control" name="price" min="0">
          </div>
          <div class="mb-3">
            <label class="form-label">Image:</label>
            <input type="file" class="form-control" name="image">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-info btn-sm">Submit</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="d-flex justify-content-center mt-4">
  {{ $products->links('pagination::bootstrap-4') }}
</div>
@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  $(document).ready(function() {
    $("#productform").submit(function(e) {
      e.preventDefault();
      let formdata = new FormData(this);
      $.ajax({
        url: "{{ route('product.store') }}",
        type: "post",
        data: formdata,
        contentType: false,
        processData: false,
        success: function(response) {
          if (response.success) {
            $("#exampleModal").modal("hide");
                     $("#message").html(`<div class="alert alert-success">${response.message}</div>`).fadeIn().delay(3000).fadeOut();
           
             
          }
        },
      });
    });
  });
</script>
