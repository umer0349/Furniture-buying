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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  $(document).ready(function() {
    // Function to load products from the server
    function loadProducts() {
      $.ajax({
        url: "{{ route('product.list') }}", // Route to fetch products
        type: "GET",
        success: function(response) {
          if (response.success) {
            let products = response.products;
            let tableBody = $("#productTableBody");
            tableBody.empty(); // Clear existing rows

            // Append each product to the table
            products.forEach(function(product, index) {
              let newRow = `
                <tr id="productRow_${product.id}">
                  <td>${index + 1}</td>
                  <td>${product.title}</td>
                  <td>${product.price}</td>
                  <td><img src="/gallery/product/${product.image}" alt="Product Image" width="50"></td>
                  <td>${new Date(product.created_at).toLocaleDateString('en-GB', { day: 'numeric', month: 'short', year: 'numeric' })}</td>
                  <td>
                    <a class="btn btn-primary btn-sm" href="/product/edit/${product.id}">Edit</a>
                    <a class="btn btn-danger btn-sm delete-product" data-id="${product.id}" href="#">Delete</a>
                  </td>
                </tr>
              `;
              tableBody.append(newRow);
            });
          }
        },
        error: function(xhr) {
          alert('An error occurred while loading products.');
        }
      });
    }

    // Load products when the page is loaded
    loadProducts();

    // AJAX for creating a product
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
            $("#productform").trigger("reset");
            $("#preview").attr("src", "").hide();
            $("body").append(response.toast);
            // Reload products after creating a new one
            loadProducts();

          }
        },
        error: function(xhr) {
          if (xhr.responseJSON && xhr.responseJSON.toast) {
            $("body").append(xhr.responseJSON.toast);
          } else {
            $("body").append('<div class="alert alert-danger">Something went wrong</div>');
          }
        }
      });
    });

    // AJAX for deleting a product
    $(document).on('click', '.delete-product', function(e) {
    e.preventDefault();
    let productId = $(this).data('id');

    // Show SweetAlert confirmation before deleting
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Yes, delete it!"
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `/product/delete/${productId}`,  // ✅ Fixed URL syntax
                type: 'GET',
                success: function(response) {
                    if (response.success) {
                        // Remove the product row
                        $(`#productRow_${productId}`).remove();  // ✅ Fixed selector syntax

                        // Show PHP-based Toast Notification if exists
                        if (response.toast) {
                            $("body").append(response.toast);
                        }
                    }
                },
                error: function(xhr) {
                    Swal.fire("Error!", "An error occurred while deleting the product.", "error");
                }
            });
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