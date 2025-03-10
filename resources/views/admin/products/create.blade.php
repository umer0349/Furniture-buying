@extends('layouts.index')
@section('title','Create Product')
@section('content')
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
<div class="container mt-5">
  <div class="table-responsive">
    <table class="table table-hover table-bordered text-center">
      <thead class="table-info">
        <tr>
          <th>#</th>
          <th>Title</th>
          <th>Price</th>
          <th>Image</th>
          <th>Created_at</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody id="productTableBody">
        <!-- Products will be loaded here dynamically -->
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
            <input type="file" class="form-control" name="image" onchange="previewImage(event)">
          </div>
          <div class="mt-2">
            <img id="preview"
              alt="Product Image" width="100"
              style="{{'display: none;' }}">
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
@endsection
@section('script')
    <script>
        var productStoreRoute = "{{ route('product.store') }}"; 
    </script>
    <script src="{{ asset('js/product.js') }}"></script>
@endsection

