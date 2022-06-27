@extends('layouts.template')
@section('title')
Products
@endsection
@section('content')
        <section class="section">
          <div class="section-body">           
            <form action="{{url('products/store/')}}" method="post" enctype="multipart/form-data">
              @csrf  
            <div class="row">  
              <div class="col-12 col-md-12">
                <div class="card card-primary">
                  <div class="card-header">
                    <h4>Products</h4>
                  </div>
                  <div class="card-body">
                    <div class="row">
                    <div class="form-group col-md-6">
                      <label>Product Name</label>
                      <input type="text" class="form-control" name="name" placeholder="Product Name">
                    </div>
                    <div class="form-group col-md-6">
                      <label>SKU#</label>
                      <input type="text" class="form-control" name="sku" value="{{SKU()}}" placeholder="SKU#">
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group col-md-6">
                      <label>Pricing Unit</label>
                      <select name="pricing_unit" class="form-control">
                        @foreach($data['units'] as $unit)
                        <option value="{{$unit->id}}">{{$unit->name}}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="form-group col-md-6">
                      <label>Price</label>
                      <input type="number" min="0" class="form-control" name="price" placeholder="Price">
                    </div>
                  </div>

                  <div class="row">
                    <div class="form-group col-md-6">
                      <label>Alert Quantity</label>
                      <input type="number" min="0" value="0" class="form-control" name="alert_quantity" placeholder="Alert Quantity">
                    </div>
                    <div class="form-group col-md-6">
                      <label>Category</label>
                      <select name="category" class="form-control">
                        @foreach($data['category'] as $category)
                        <option value="{{$category->id}}">{{$category->name}}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>

                  <div class="row">
                    <div class="form-group col-md-6">
                      <label>Margin (%)</label>
                      <input type="number" min="0" value="0" class="form-control" name="margin" placeholder="Margin">
                    </div>
                    <div class="form-group col-md-6">
                      <label>Product Image</label>
                      <input type="file" class="form-control" name="image" >
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group col-md-12">
                      <label>Description</label>
                      <textarea class="form-control note-codable" name="description"></textarea>
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
