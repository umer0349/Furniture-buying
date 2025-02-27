@extends('layouts.index')
@section('title','create product')
@section('content')




<div class="container">
  <h2 class="mb-4 text-center">Users List</h2>
  <div class="table-responsive">
      <table class="table table-hover table-bordered text-center">
          <thead class="table-info">
              <tr>
                  <th>#</th>
                  <th>name</th>
                  <th>email</th>
                  <th>Created_At</th>
                  <th>action</th>
              </tr>
          </thead>
          <tbody>
            @foreach ($allusers as $item)
          <tr>
        <td>{{$loop->iteration}}</td>
        <td>{{$item->name}}</td>
        <td>{{$item->email}}</td>
          <td>{{$item->created_at->format('d,M,y')}}</td>
          @if($item->hasRole('user'))
    <td>
        <a href="{{route('user.delete',$item->id)}}" class="btn btn-danger btn-sm fa fa-trash"></a>
    </td>
@else
    <td class="text-center text-muted">
        <i class="fas fa-times-circle text-danger"></i> <span class="ms-1">Action Not Allowed</span>
    </td>
@endif

          </tr>
          @endforeach
          </tbody>
      </table>
  </div>
</div>

<div class="d-flex justify-content-center mt-4">
    {{ $allusers->links('pagination::bootstrap-4') }}
</div>




@endsection