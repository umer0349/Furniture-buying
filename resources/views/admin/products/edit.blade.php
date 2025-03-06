@extends('layouts.index')
@section('title', 'Edit Product')
@section('content')
<div class="container">
  <div class="row">
    <div class="col-lg-12">
      <h2>Edit Product</h2>
      <form id="editProductForm" action="{{ route('product.update', $edit->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
          <label for="title" class="form-label">Title:</label>
          <input type="text" class="form-control" id="title" name="title" value="{{ $edit->title }}" required>
        </div>
        <div class="mb-3">
          <label for="price" class="form-label">Price:</label>
          <input type="number" class="form-control" id="price" name="price" value="{{ $edit->price }}" required>
        </div>
        <div class="mb-3">
          <label for="image" class="form-label">Image:</label>
          <input type="file" class="form-control" id="image" name="image" onchange="previewImage(event)">
          <!-- Image Preview -->
          <div class="mt-2">
            <img id="preview" src="{{ $edit->image ? '/gallery/product/' . $edit->image : '' }}"
              alt="Product Image" width="100"
              style="{{ $edit->image ? '' : 'display: none;' }}">
          </div>
          <button type="submit" class="btn btn-primary">Update</button>
      </form>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  $(document).ready(function() {
    // Handle form submission via AJAX
    $('#editProductForm').submit(function(e) {
      e.preventDefault(); // Prevent default form submission

      let formData = new FormData(this); // Create FormData object

      $.ajax({
        url: $(this).attr('action'), // Form action URL
        type: 'POST',
        data: formData,
        contentType: false, // Don't set content type
        processData: false, // Don't process data
        success: function(response) {
          if (response.success) {
            // Redirect to the product.create route
            window.location.href = "{{ route('product.create') }}";
          }
        },
        error: function(xhr) {
          alert('An error occurred while updating the product.');
        }
      });
    });

  });
</script>
<script>
  function previewImage(event) {
    let reader = new FileReader();
    reader.onload = function() {
      let preview = document.getElementById('preview');
      preview.src = reader.result;
      preview.style.display = 'block'; // Ensure the image is visible
    };
    reader.readAsDataURL(event.target.files[0]);
  }
</script>
@endsection