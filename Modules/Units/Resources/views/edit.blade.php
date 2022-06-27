@extends('layouts.template')
@section('title')
Units
@endsection
@section('content')
        <section class="section">
          <div class="section-body">
            
            <form action="{{url('units/update/'.$data['units']->id)}}" method="post" enctype="multipart/form-data">
              @csrf  
            <div class="row">  
              <div class="col-12 col-md-12">
                <div class="card card-primary">
                  <div class="card-header">
                    <h4>Units</h4>
                  </div>
                  <div class="card-body">
                    <div class="row">
                    <div class="form-group col-md-12">
                      <label>Unit Name</label>
                      <input type="text" class="form-control" name="name" value="{{$data['units']->name}}" placeholder="Unit Name">
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
