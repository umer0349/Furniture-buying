@extends('layouts.index')
@section('title','edit product')
@section('content')

      
          <form action="{{route('product.update',$edit->id)}}" method="post" enctype="multipart/form-data">
            @csrf
              <div class="row">
                <div class="col-8 offset-1">
                  <div class="form-group">
                    <label class="text-black" for="fname">Title:</label>
                    <input type="text" class="form-control" id="fname" name="title" value="{{$edit->title}}">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-8 offset-1">
                  <div class="form-group">
                    <label class="text-black" for="fname">price:</label>
                    <input type="number" class="form-control" id="fname" name="price" min="0" value="{{$edit->price}}" >
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-8 offset-1">
                  <div class="form-group">
                    <label class="text-black" for="image">Image:</label>
                    <input type="file" class="form-control" id="image" name="image" >
              
                    <!-- Agar edit mode mein pehle se image ho toh yahan dikhana -->
                    @if(isset($edit->image))
                      <div class="mt-2">
                        <img src="/gallery/product/{{ $edit->image}}"  alt="Current Image" width="150">
                      </div>
                    @endif
                  </div>
                </div>
              </div>
              
        <button class="btn btn-success btn-sm" type="submit">update</button>
      </form>
    


@endsection