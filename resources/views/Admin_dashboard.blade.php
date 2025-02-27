
@extends('layouts.index')
@section('title','admin_dashboard')
    

@section('content')
    
 <!-- Dashboard Cards -->
 <div class="row">
    <div class="col-md-4">
        <div class="card text-white bg-primary mb-3 shadow-lg rounded-3">
            <div class="card-body d-flex align-items-center">
                <i class="fa fa-users fa-2x me-3"></i> <!-- Icon with proper spacing -->
                <div>
                    <h5 class="card-title mb-1">Total Users</h5>
                    <p class="card-text fs-4 fw-bold">{{$countuser}}</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-white bg-success mb-3 shadow-lg rounded-3">
            <div class="card-body d-flex align-items-center">
                <i class="fa fa-truck fa-2x me-3"></i> <!-- Icon with proper spacing -->
                <div>
                    <h5 class="card-title mb-1">orders</h5>
                    <p class="card-text fs-4 fw-bold">{{$countorder}}</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card text-white bg-secondary mb-3">
            <div class="card-body">
                <h5 class="card-title">Revenue</h5>
                <p class="card-text">$12,500</p>
            </div>
        </div>
    </div>
</div>


@endsection