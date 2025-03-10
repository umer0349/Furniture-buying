$(document).ready(function() {
    function loadProducts() {
        $.ajax({
            url: "/product/list",
            type: "GET",
            success: function(response) {
                if (response.success) {
                    let products = response.products;
                    let tableBody = $("#productTableBody");
                    tableBody.empty();

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
            error: function() {
                alert('An error occurred while loading products.');
            }
        });
    }

    loadProducts();

    $("#productform").submit(function(e) {
        e.preventDefault();
        let formdata = new FormData(this);
        $.ajax({
            url: productStoreRoute,// Correct Laravel route
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

    $(document).on('click', '.delete-product', function(e) {
        e.preventDefault();
        let productId = $(this).data('id');

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
                    url: `/product/delete/${productId}`,
                    type: 'GET',
                    success: function(response) {
                        if (response.success) {
                            $(`#productRow_${productId}`).remove();
                            if (response.toast) {
                                $("body").append(response.toast);
                            }
                        }
                    },
                    error: function() {
                        Swal.fire("Error!", "An error occurred while deleting the product.", "error");
                    }
                });
            }
        });
    });
});

function previewImage(event) {
    let reader = new FileReader();
    reader.onload = function() {
        let preview = document.getElementById('preview');
        preview.src = reader.result;
        preview.style.display = 'block';
    };
    reader.readAsDataURL(event.target.files[0]);
}
