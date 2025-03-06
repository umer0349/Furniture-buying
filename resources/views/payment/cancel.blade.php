<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="text-center p-5 border rounded shadow-lg bg-white">
        <h1 class="text-danger">Payment Canceled</h1>
        <p class="text-muted">Your payment was not completed. You will be redirected shortly...</p>

        <div class="spinner-border text-danger mt-3" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>

        <p class="mt-3">If you're not redirected, <a href="{{route('userside')}}">click here</a>.</p>
    </div>
</div>

<script>
    setTimeout(function() {
        window.location.href = "{{route('userside')}}";
    }, 5000); // Redirect after 5 seconds
</script>

<style>
    body {
        background-color: #f8f9fa;
    }
</style>
</body>
</html>