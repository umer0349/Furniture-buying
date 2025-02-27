
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body>
<div class="container d-flex justify-content-center align-items-center" style="height: 100vh;">
    <div class="text-center">
        <div class="card shadow-lg p-4 border-0 rounded" style="max-width: 400px;">
            <div class="card-body">
                <img src="{{ asset('images/ok.png') }}" alt="Success" width="100">
                <h2 class="mt-3 text-success">Payment Successful!</h2>
                <p class="text-muted">Thank you for your purchase. Your transaction has been completed successfully.</p>
                <a href="{{route('userside')}}" class="btn btn-success mt-3 fw-bold fa fa-arrow-right"></a>
            </div>
        </div>
    </div>
</div>

</body>
</html>
