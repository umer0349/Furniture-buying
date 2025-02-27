<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Additional CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <style>
        body {
            display: flex;
            height: 100vh;
            flex-direction: column;
        }

        .main-container {
            display: flex;
            flex: 1;
        }

        .sidebar {
            width: 250px;
            background: black;
            color: white;
            padding: 15px;
            height: 100vh;
            font-weight: bolder;
        }

        .sidebar a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 10px;
        }

        .sidebar a:hover {
            background: #495057;
        }

        .content {
            flex: 1;
            padding: 20px;
        }
    </style>
</head>

<body>

    <div class="main-container">
        <!-- Sidebar -->
        <div id="sidebarr" class="sidebar">
            <h2>Admin Panel</h2>
            <a href="{{url('/admin')}}"> <i class="fa fa-tachometer-alt me-2"></i> Dashboard
            </a>
            <a href="{{route('product.create')}}">
                <li class="fa fa-tags me-2"></li>Products
            </a>
            <a href="{{route('orders.show')}}"> <i class="fa fa-truck me-2"></i>Orders</a>
            <a href="{{route('user.show')}}"> <i class="fa fa-users me-2"></i>users</a>
            <a href="#"> <i class="fa fa-cog me-2"></i>Settings</a>
        </div>

        <!-- Main Content -->
        <div class="content">
            <!-- Navbar -->
            <nav class="navbar navbar-expand-lg navbar-light bg-light mb-3">
                <div class="container-fluid">
                    <!-- Sidebar Toggle Button (Hamburger Icon) -->
                    <button class="btn btn-dark me-2" id="toggle-sidebar">
                        <i class="bi bi-list"></i> <!-- Bootstrap 3-line icon -->
                    </button>

                    <span class="navbar-brand">Dashboard</span>
                    <div class="d-flex align-items-center ms-auto">
                        <!-- Notification Icon -->
                        <div class="dropdown me-3">
                            <button class="btn position-relative" type="button" id="notificationDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-bell fs-4"></i>
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                    {{ auth()->user()->unreadNotifications->count() }}
                                </span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notificationDropdown">
                                <li>
                                    <h6 class="dropdown-header">Notifications</h6>
                                </li>
                                @foreach(auth()->user()->unreadNotifications as $notification)
                                <li><a class="dropdown-item" href="#">{{$notification->data['message']}}</a></li>
                                @endforeach

                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item text-center fw-bold" href="{{route('read.notify')}}">View All</a></li>
                            </ul>
                        </div>
                        <!-- User Dropdown -->
                        <div class="dropdown ms-auto">
                            <button class="text-white fw-bold dropdown-toggle" style="background-color: black" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="https://via.placeholder.com/30" alt="" class="rounded-circle">
                                <span id="username">{{Auth::user()?->name}}</span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                <li>
                                    <a class="dropdown-item fw-semibold" href="{{ route('profile.edit') }}">
                                        <i class="bi bi-person-circle"></i> Profile
                                    </a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger fw-bold">
                                            <i class="bi bi-box-arrow-right"></i> Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
            </nav>

            @yield('content')

        </div>
    </div>

</body>

</html>

<!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $('#toggle-sidebar').click(function() {
            $('#sidebarr').toggle('hidden');
        });
    });
</script>
<!-- Bootstrap JS and jQuery -->