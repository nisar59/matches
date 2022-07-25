@extends('layouts.template')
@section('title')
Purchase Report
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
                      <label>Vendor:</label>
                      <select id="vendor" class="form-control filters select2">
                        <option value="">Select</option>
                        @foreach($data['vendors'] as $vendor)
                        <option value="{{$vendor->id}}">{{$vendor->name}}</option>
                        @endforeach
                      </select>                      
                    </div>
                      <div class="form-group col-md-3">
                        <label>Reference No:</label>
                        <input type="text" class="form-control filters" id="reference_no" placeholder="Reference No">
                      </div>
                    <div class="form-group col-md-3">
                      <label>Payment Status:</label>
                      <select id="payment_status" class="form-control filters select2">
                        <option value="">Select</option>
                       <option value="paid">Paid</option>
                       <option value="partial">Partial</option>
                       <option value="due">Due</option>

                      </select>
                    </div>
                    <div class="form-group col-md-3">
                      <label>Shipping Status:</label>
                      <select id="shipping_status" class="form-control filters select2">
                        <option value="">Select</option>
                        @foreach(ShippingStatus() as $key=> $shipping)
                        <option value="{{$key}}">{{$shipping}}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="form-group col-md-4">
                      <label>Date</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <div class="input-group-text">
                            <i class="fas fa-calendar"></i>
                          </div>
                        </div>
                        <input type="text" id="order_date" placeholder="Select Date Range" autocomplete="off" class="form-control filters daterange">
                      </div>
                    </div>                    
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-12">
                <div class="card card-primary">
                  <div class="card-header">
                    <h4 class="col-md-6">Purchase Report</h4>
                    <div class="col-md-6 text-right">
                    <span id="buttons">
                    <a href="javascript:void(0)" class="btn btn-primary" id="dropdownMenuButton2"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-th-list"></i> Action</a>
                        <div class="dropdown-menu bg-primary">
                        <a class="dropdown-item has-icon text-light" id="excelexport" href="javascript:void(0)"><i class="fas fa-file-excel"></i> Export to excel</a>
                        <a class="dropdown-item has-icon text-light" id="printexport" href="javascript:void(0)"><i class="far fa-file"></i> Print</a>
                        <a class="dropdown-item has-icon text-light" href="{{url('purchases/export-pdf')}}"><i class="fas fa-file-pdf"></i> Export to PDf</a>
                      </div>
                    </span>
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-sm table-striped table-hover" id="users" style="width:100%;">
                        <thead>
                          <tr>
                            <th>Vendor</th>
                            <th>Order Date</th>
                            <th>Reference No</th>
                            <th>Purchase Total</th>
                            <th>Payment Amount</th>
                            <th>Due</th>                            
                            <th>Payment Status</th>                            
                            <th>Shipping Status</th>
                            <th>Added By</th>
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
<div id="mdl"></div>
@endsection
@section('js')
<script type="text/javascript">
    //Roles table
    $(document).ready( function(){
  var roles_table;
  DrawDatatable();
  function DrawDatatable(vendor='',reference_no='',payment_status='',shipping_status='',order_date='') {
  roles_table = $('#users').DataTable({
              processing: true,
              serverSide: true,
              "ajax": {
                url:"{{url('purchases/report')}}",
                data:{
                    vendor:vendor,
                    reference_no:reference_no,
                    payment_status:payment_status,
                    shipping_status:shipping_status,
                    order_date:order_date
                },
              },
              buttons:[
                    {
                      extend:"collection",
                      buttons:[
                          {
                            extend:'excelHtml5',
                            title:'{{Settings()->portal_name}}-Purchase Detail',
                            exportOptions: {
                            columns: [0,1,2,3,4,5,6,7,8],
                            search: 'applied',
                            order: 'applied',
                            },
                            footer:true,
                          },
                          {
                            extend:'print',
                            title:'<h2 class="text-center mb-2">{{Settings()->portal_name}}</h2><h4 class="text-center mb-5">Purchase Detail</h4>',
                            exportOptions: {
                            columns: [0,1,2,3,4,5,6,7,8],
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
                {data: 'vendor', name: 'vendor'},
                {data: 'order_date', name: 'order_date'},
                {data: 'reference_no', name: 'reference_no'},
                {data: 'purchase_total', name: 'purchase_total'},
                {data: 'payment_amount', name: 'payment_amount'},
                {data: 'due', name: 'due'},
                {data: 'payment_status', name: 'payment_status'},
                {data: 'shipping_status', name: 'shipping_status'},
                {data: 'added_by', name: 'added_by'},
            ]
          });
  }

      
      $(document).on('click','.show',function() {
        var lnk=$(this).data('href');

        $.ajax({
              url:lnk,
              type:"GET",
              success:function(data) {
                $("#mdl").html(data);
                $(".purchase-show").modal('show');
              },
              error:function() {

              }
        });

      });

  $(document).on('click',".payment-transactions",function() {
    
    var lnk=$(this).data('href');
    $.ajax({
      url:lnk,
      type:"GET",
      success:function(data) {
        $("#mdl").html(data);
        $(".payment-transactions").modal('show');
      },
      error:function() {
        alert('something went wrong');
      }
    });

  });


$(".filters").on('change input',function () {
      var vendor=$("#vendor").val();
      var reference_no=$("#reference_no").val();
      var payment_status=$("#payment_status").val();
      var shipping_status=$("#shipping_status").val();
      var order_date=$("#order_date").val();


      roles_table.destroy();
  DrawDatatable(vendor,reference_no,payment_status,shipping_status,order_date);
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
