@extends('layouts.template')
@section('title')
Products Stock Report
@endsection
@section('content')
        <section class="section">
          <div class="section-body">
            <div class="row">
              <div class="col-12">
                <div class="card card-primary">
                  <div class="card-header">
                    <h4><i class="fas fa-filter"></i> Filter</h4>
                  </div>
                  <div class="card-body">
                    <div class="row">
                      <div class="form-group col-md-3">
                        <label>Product Name:</label>
                        <input type="text" class="form-control filters" id="name" placeholder="Product Name">
                      </div>
                      <div class="form-group col-md-3">
                        <label>Product SKU:</label>
                        <input type="text" class="form-control filters" id="sku" placeholder="Product SKU">
                      </div>
                    <div class="form-group col-md-3">
                      <label>Category</label>
                      <select name="category" id="category" class="form-control filters select2">
                        @foreach($data['category'] as $category)
                        <option value="">Select</option>
                        <option value="{{$category->id}}">{{$category->name}}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="form-group col-md-3">
                      <label>Pricing Unit</label>
                      <select id="unit" class="form-control filters select2">
                        @foreach($data['units'] as $unit)
                        <option value="">Select</option>
                        <option value="{{$unit->id}}">{{$unit->name}}</option>
                        @endforeach
                      </select>
                    </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-12">
                <div class="card card-primary">
                  <div class="card-header">
                    <h4 class="col-md-6">Products Stock Report</h4>
                    <div class="col-md-6 text-right">
                    <span id="buttons">
                    <a href="javascript:void(0)" class="btn btn-primary" id="dropdownMenuButton2"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-th-list"></i> Action</a>
                        <div class="dropdown-menu bg-primary">
                        <a class="dropdown-item has-icon text-light" id="excelexport" href="javascript:void(0)"><i class="fas fa-file-excel"></i> Export to excel</a>
                        <a class="dropdown-item has-icon text-light" id="printexport" href="javascript:void(0)"><i class="far fa-file"></i> Print</a>
                        <a class="dropdown-item has-icon text-light" href="{{url('products/export-pdf')}}"><i class="fas fa-file-pdf"></i> Export to PDf</a>
                      </div>
                    </span>
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-striped table-hover table-sm" id="users" style="width:100%;">
                        <thead>
                          <tr>                            
                            <th>Name</th>
                            <th>SKU</th>
                            <th>Pricing Unit</th>
                            <th>Unit Price</th>
                            <th>Category</th>
                            <th>Current Stock</th>
                            <th>Total Sold</th>
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

      /*////////////////////////////*/
      var roles_table;
      DrawDatatable();
  function DrawDatatable(name='',sku='',category='',unit='') {
    roles_table = $('#users').DataTable({
                processing: true,
                serverSide: true,
                "ajax": {
                  url:"{{url('products/stock-report')}}",
                  data:{
                    name:name,
                    sku:sku,
                    category:category,
                    unit:unit,
                  },
                },
                buttons:[
                      {
                        extend:"collection",
                        buttons:[
                            {
                              extend:'excelHtml5',
                              title:'{{Settings()->portal_name}}-Products Detail',
                              exportOptions: {
                              columns: [1,2,3,4,5],
                              search: 'applied',
                              order: 'applied',
                              },
                              footer:true,
                            },
                            {
                              extend:'print',
                              title:'<h2 class="text-center mb-2">{{Settings()->portal_name}}</h2><h4 class="text-center mb-5">Products Detail</h4>',
                              exportOptions: {
                              columns: [0,1,2,3,4,5],
                              search: 'applied',
                              order: 'applied',                              
                              stripHtml: false,

                              },
                              footer:true,
                            },
                        ],
                      }
                ],
                columns: [
                  {data: 'name', name: 'name'},
                  {data: 'sku', name: 'sku'},
                  {data: 'pricing_unit', name: 'pricing_unit'},
                  {data: 'price', name: 'price'},
                  {data: 'category', name: 'category'},
                  {data: 'available_quantity', name: 'available_quantity'},
                  {data: 'sold_quantity', name: 'sold_quantity'},
              ],

            });

  }

      $(".filters").on('change input',function () {
            var name=$("#name").val();
            var sku=$("#sku").val();
            var category=$("#category").val();
            var unit=$("#unit").val();
            roles_table.destroy();
            DrawDatatable(name,sku,category,unit);
      });

      $("#printexport").on('click', function() {
          roles_table.button('.buttons-print').trigger();
      });      
      $("#excelexport").on('click', function() {
          roles_table.button('.buttons-excel').trigger();
      });
      });
</script>
@endsection
