@extends('layouts.template')
@section('title')
Products
@endsection
@section('content')
        <section class="section">
          <div class="section-body">           
            <form action="{{url('products/update/'.$data['product']->id)}}" method="post" enctype="multipart/form-data">
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
                      <input type="text" class="form-control" value="{{$data['product']->name}}" name="name" placeholder="Product Name">
                    </div>
                    <div class="form-group col-md-6">
                      <label>SKU#</label>
                      <input type="text" class="form-control" value="{{$data['product']->sku}}" name="sku" placeholder="SKU#">
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group col-md-6">
                      <label>Pricing Unit</label>
                      <select name="pricing_unit" class="form-control">
                        @foreach($data['units'] as $unit)
                        <option value="{{$unit->id}}" @if($unit->id==$data['product']->pricing_unit) selected @endif >{{$unit->name}}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="form-group col-md-6">
                      <label>Price</label>
                      <input type="number" min="0" class="form-control" value="{{$data['product']->price}}" name="price" placeholder="Price">
                    </div>
                  </div>

                  <div class="row">
                    <div class="form-group col-md-6">
                      <label>Alert Quantity</label>
                      <input type="number" min="0" class="form-control" value="{{$data['product']->alert_quantity}}" name="alert_quantity" placeholder="Alert Quantity">
                    </div>
                    <div class="form-group col-md-6">
                      <label>Category</label>
                      <select name="category" class="form-control">
                        @foreach($data['category'] as $category)
                        <option value="{{$category->id}}" @if($category->id==$data['product']->category) selected @endif>{{$category->name}}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>

                  <div class="row">
                    <div class="form-group col-md-6">
                      <label>Margin (%)</label>
                      <input type="number" min="0" class="form-control" value="{{$data['product']->margin}}" name="margin" placeholder="Margin">
                    </div>
                    <div class="form-group col-md-6">
                      <label>Product Image</label>
                      <input type="file" class="form-control" name="image" >
                      <a href="{{url('public/img/products/'.$data['product']->image)}}" target="_blank">{{$data['product']->image}}</a>
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group col-md-12">
                      <label>Description</label>
                      <textarea class="form-control" name="description">{{$data['product']->description}}</textarea>
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
