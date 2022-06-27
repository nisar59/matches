@extends('layouts.template')
@section('title')
Purchases
@endsection
@section('content')
        <section class="section">
          <div class="section-body">
            <div class="row">
              <div class="col-12">
                <div class="card card-primary">
                  <div class="card-header">
                    <h4 class="col-md-6">Purchases</h4>
                    <div class="col-md-6 text-right">
                    <a href="{{url('purchases/create')}}" class="btn btn-success">+</a>
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
<div id="mdl"></div>
@endsection
@section('js')
<script type="text/javascript">
    //Roles table
    $(document).ready( function(){
  var roles_table = $('#users').DataTable({
              processing: true,
              serverSide: true,
              ajax: "{{url('purchases')}}",
              buttons:[],
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
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
          });
      
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

      });
</script>
@endsection
