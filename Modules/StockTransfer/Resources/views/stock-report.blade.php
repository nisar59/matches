@extends('layouts.template')
@section('title')
Stock Transfer Report
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
                    <div class="form-group col-md-4">
                      <label>Date</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <div class="input-group-text">
                            <i class="fas fa-calendar"></i>
                          </div>
                        </div>
                        <input type="text" id="transfer_date" placeholder="Select Date Range" autocomplete="off" class="form-control filters daterange">
                      </div>
                    </div> 
                    <div class="form-group col-md-4">
                        <label>Reference No:</label>
                        <input type="text" class="form-control filters" id="reference_no" placeholder="Reference No">
                    </div>
                    <div class="form-group col-md-4">
                      <label>Shipping Status:</label>
                      <select id="shipping_status" class="form-control filters select2">
                        <option value="">Select</option>
                        @foreach(ShippingStatus() as $key=> $shipping)
                        <option value="{{$key}}">{{$shipping}}</option>
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
                    <h4 class="col-md-6">Stock Transfer Report</h4>
                    <div class="col-md-6 text-right">
                    <span id="buttons">
                    <a href="javascript:void(0)" class="btn btn-primary" id="dropdownMenuButton2"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-th-list"></i> Action</a>
                        <div class="dropdown-menu bg-primary">
                        <a class="dropdown-item has-icon text-light" id="excelexport" href="javascript:void(0)"><i class="fas fa-file-excel"></i> Export to excel</a>
                        <a class="dropdown-item has-icon text-light" id="printexport" href="javascript:void(0)"><i class="far fa-file"></i> Print</a>
                        <a class="dropdown-item has-icon text-light" href="{{url('stocktransfer/export-pdf')}}"><i class="fas fa-file-pdf"></i> Export to PDf</a>
                      </div>
                    </span>   
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-sm table-striped table-hover" id="users" style="width:100%;">
                        <thead>
                          <tr>
                            <th>Date</th>
                            <th>Reference No</th>
                            <th>Quantity</th>
                            <th>Shipping Charges</th>
                            <th>Total Amount</th>                            
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
function DrawDatatable(reference_no='',shipping_status='',transfer_date='') {
 roles_table = $('#users').DataTable({
              processing: true,
              serverSide: true,
                "ajax": {
                  url:"{{url('stocktransfer')}}",
                  data:{
                      reference_no:reference_no,
                      shipping_status:shipping_status,
                      transfer_date:transfer_date,
                  },
                },
                buttons:[
                      {
                        extend:"collection",
                        buttons:[
                            {
                              extend:'excelHtml5',
                              title:'{{Settings()->portal_name}}-Stock Transfer Report',
                              exportOptions: {
                              columns: [0,1,2,3,4,5,6],
                              search: 'applied',
                              order: 'applied',
                              },
                              footer:true,
                            },
                            {
                              extend:'print',
                              title:'<h2 class="text-center mb-2">{{Settings()->portal_name}}</h2><h4 class="text-center mb-5">Stock Transfer Report</h4>',
                              exportOptions: {
                              columns: [0,1,2,3,4,5,6],
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
                {data: 'transfer_date', name: 'transfer_date'},
                {data: 'transfer_reference_no', name: 'transfer_reference_no'},
                {data: 'transfer_quantity', name: 'transfer_quantity'},
                {data: 'transfer_charges', name: 'transfer_charges'},
                {data: 'transfer_total', name: 'transfer_total'},
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

$("#printexport").on('click', function() {
    roles_table.button('.buttons-print').trigger();
});      
$("#excelexport").on('click', function() {
    roles_table.button('.buttons-excel').trigger();
});


$(".filters").on('change input',function () {
      var reference_no=$("#reference_no").val();
      var shipping_status=$("#shipping_status").val();
      var transfer_date=$("#transfer_date").val();


      roles_table.destroy();
  DrawDatatable(reference_no,shipping_status,transfer_date);
});


});
</script>
@endsection
