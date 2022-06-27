@extends('layouts.template')
@section('title')
Category
@endsection
@section('content')
        <section class="section">
          <div class="section-body">
            
            <form action="{{url('category/update/'.$data['category']->id)}}" method="post" enctype="multipart/form-data">
              @csrf  
            <div class="row">  
              <div class="col-12 col-md-12">
                <div class="card card-primary">
                  <div class="card-header">
                    <h4>Category</h4>
                  </div>
                  <div class="card-body">
                    <div class="row">
                    <div class="form-group col-md-12">
                      <label>Category Name</label>
                      <input type="text" class="form-control" name="name" value="{{$data['category']->name}}" placeholder="Category Name">
                    </div>
                  </div>
                </div>
                  <div class="card-footer text-right">
                    <button class="btn btn-primary mr-1" type="submit">Submit</button>
                  </div>
                </div>
              </div>
              </div>
            </form>
          </div>
        </section>
@endsection
@section('js')

@endsection
