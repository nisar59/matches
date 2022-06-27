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
            <div class="row">
              <div class="col-12">
                <div class="card card-primary">
                  <div class="card-header">
                    <h4 class="col-md-6">
                      @if($type=='vendor')
                      Vendors
                      @else
                      Customer
                      @endif
                    </h4>
                    <div class="col-md-6 text-right">
                    @if($type=='vendor')
                    <a href="{{url('contacts/create?type=vendor')}}" class="btn btn-success">+</a>
                    @else
                    <a href="{{url('contacts/create?type=customer')}}" class="btn btn-success">+</a>
                    @endif                    
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-striped table-hover" id="users" style="width:100%;">
                        <thead>
                          <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone No</th>
                            <th>Address</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody> 
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
@endsection
@section('js')
<script type="text/javascript">
    //Roles table
    $(document).ready( function(){
  var roles_table = $('#users').DataTable({
              processing: true,
              serverSide: true,
              ajax: "{{url('contacts?type='.$type)}}",
              buttons:[],
              columns: [
                {data: 'name', name: 'name'},
                {data: 'email', name: 'email'},
                {data: 'phone_no', name: 'phone_no'},
                {data: 'address', name: 'address'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
          });
      });
</script>
@endsection
