@extends('layouts.template')
@section('title')
Warehouses And Shops
@endsection
@section('content')
        <section class="section">
          <div class="section-body">
            
            <form action="{{url('warehousesandshops/update/'.$data['warehousesandshops']->id)}}" method="post" enctype="multipart/form-data">
              @csrf  
            <div class="row">  
              <div class="col-12 col-md-12">
                <div class="card card-primary">
                  <div class="card-header">
                    <h4>Warehouses And Shops</h4>
                  </div>
                  <div class="card-body">
                    <div class="row">
                    <div class="form-group col-md-6">
                      <label>Warehouse/Shop</label>
                      <select class="form-control" name="type">
                        <option @if($data['warehousesandshops']->type=='warehouse') selected @endif value="warehouse">Warehouse</option>
                        <option @if($data['warehousesandshops']->type=='shop') selected @endif value="shop">Shop</option>
                      </select>
                    </div>
                    <div class="form-group col-md-12">
                      <label>Warehouse And Shop Name</label>
                      <input type="text" class="form-control" name="name" value="{{$data['warehousesandshops']->name}}" placeholder="Warehouse And Shop Name">
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
