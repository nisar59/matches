@extends('layouts.template')
@section('title')
Products
@endsection
@section('content')
        <section class="section">
          <div class="section-body">
            <div class="row">
              <div class="col-12">
                <div class="card card-primary">
                  <div class="card-header">
                    <h4 class="col-md-6">Products</h4>
                    <div class="col-md-6 text-right">
                    <a href="{{url('products/create')}}" class="btn btn-success">+</a>
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-striped table-hover" id="users" style="width:100%;">
                        <thead>
                          <tr>                            
                            <th>Image</th>
                            <th>Name</th>
                            <th>SKU</th>
                            <th>Pricing Unit</th>
                            <th>Price</th>
                            <th>Category</th>
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
              ajax: "{{url('products')}}",
              buttons:[],
              columns: [
                {data: 'image', name: 'image',  orderable: false, searchable: false},
                {data: 'name', name: 'name'},
                {data: 'sku', name: 'sku'},
                {data: 'pricing_unit', name: 'pricing_unit'},
                {data: 'price', name: 'price'},
                {data: 'category', name: 'category'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
          });
      });
</script>
@endsection
