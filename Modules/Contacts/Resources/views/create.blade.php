@php
$type=request()->type;
@endphp

@extends('layouts.template')
@section('title')
@if($type=='vendor')
Vendors
@else
Customer
@endif
@endsection
@section('content')
        <section class="section">
          <div class="section-body">
            
            <form action="{{url('contacts/store/'.$type)}}" method="post" enctype="multipart/form-data">
              @csrf  
            <div class="row">  
              <div class="col-12 col-md-12">
                <div class="card card-primary">
                  <div class="card-header">
                    <h4>
                      @if($type=='vendor')
                      Vendors
                      @else
                      Customer
                      @endif
                    </h4>
                  </div>
                  <div class="card-body">
                    <div class="row">
                    <div class="form-group col-md-6">
                      <label>Name</label>
                      <input type="text" class="form-control" name="name" placeholder="Name">
                    </div>
                    <div class="form-group col-md-6">
                      <label>Email</label>
                      <input type="email" class="form-control" name="email" placeholder="Email">
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group col-md-6">
                      <label>Phone No</label>
                      <input type="text" class="form-control" name="phone_no" placeholder="Phone No">
                    </div>
                    <div class="form-group col-md-6">
                      <label>Address</label>
                      <input type="text" class="form-control" name="address" placeholder="Address">
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
