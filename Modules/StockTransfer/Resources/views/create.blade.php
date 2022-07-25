@extends('layouts.template')
@section('title')
Stock Transfer
@endsection
@section('content')
        <section class="section">
          <div class="section-body">

          <form action="{{url('stocktransfer/store/')}}" method="post" enctype="multipart/form-data">
              @csrf  
            <div class="row">  
              <div class="col-12 col-md-12">
                <div class="card card-primary">
                  <div class="card-header">
                    <h4>Stock Transfer</h4>
                  </div>
                  <div class="card-body">
                    <div class="row">                    
                      <div class="form-group col-md-3">
                      <label>Date</label>
                      <input type="text" name="transfer_date" class="form-control datepicker">
                    </div>
                    <div class="form-group col-md-3">
                      <label>Reference No</label>
                      <input type="text" name="transfer_reference_no" value="{{TransferReferenceNO()}}" class="form-control" placeholder="Reference No">
                    </div>

                    <div class="form-group col-md-3">
                      <label>From Warehouse Or Shop</label>
                      <select class="form-control select2" id="from_wherehouseshope_id" name="from_wherehouseshope_id">
                        @foreach($data['warehousesandshops'] as $ws)
                        <option value="{{$ws->id}}">{{$ws->name}}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="form-group col-md-3">
                      <label>To Warehouse Or Shop</label>
                      <select class="form-control select2" id="to_wherehouseshope_id" name="to_wherehouseshope_id">
                        @foreach($data['warehousesandshops'] as $ws)
                        <option value="{{$ws->id}}">{{$ws->name}}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                </div>
                </div>
                <div class="card card-primary">
                  <div class="card-header"></div>
                  <div class="card-body">
                  <div class="row">
                    <div class="col-md-8 offset-md-2 text-center">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <div class="input-group-text">
                            <i class="fas fa-search"></i>
                          </div>
                        </div>
                        <input type="text" class="form-control" placeholder="Enter Product name / SKU" id="product-search" name="">
                      </div>
                    </div>                    
                  </div>
                  <div class="col-md-12">
                    <div class="table-responsive">
                      <table class="table table-bordered table-sm">
                        <thead>
                          <th>Product Name</th>
                          <th>Product Quantity</th>
                          <th>Unit Cost</th>
                          <th>Net Cost</th>
                          <th class="text-center">Action</th>
                        </thead>
                        <tbody id="tablebody">
                        </tbody>
                      </table>
                    </div>
                    <table class="float-right">
                      <tr><th>Total Quantity:</th><td><input type="number" class="form-control readonly border-0" readonly id="total_quantity" value="0.00"  name="total_quantity"></td></tr>
                      <tr><th>Total Amount:</th><td><input type="number" class="form-control readonly border-0" readonly id="total_amount" value="0.00"  name="total_amount"></td></tr>
                    </table>
                  </div>
                  </div>
                  </div>
                </div>

                <div class="card card-primary">
                  <div class="card-header">
                    <h4>Additional detail</h4>
                  </div>
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-3">
                        <div class="form-group">
                          <label>Shipping Charges</label>
                          <input type="number" min="0.00" value="0.00" class="form-control" name="transfer_charges">
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label>Shipping Status</label>
                          <select class="form-control" name="shipping_status">
                            @foreach(ShippingStatus() as $key=> $ss)
                            <option value="{{$key}}">{{$ss}}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Additional Note</label>
                          <textarea class="form-control" name="additional_note"></textarea>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12 ">
                        <button type="submit" class="btn btn-primary pull-right">Submit</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              </div>
            </form>
          </div>
        </section>
@endsection
@section('js')

<script type="text/javascript">
$(document).ready(function() {
 var projects = [
 @foreach($data['products'] as $pro)
      {
        value: "{{$pro->id}}",
        label: "{{$pro->name}}",
      },
  @endforeach
    ];
    $( "#product-search" ).autocomplete({
    source: projects,
    minLength: 3,
    focus: function( event, ui ) {
        $(this).val( ui.item.label );
        return false;
      },
    select: function( event, ui ) {
          $(this).val(ui.item.label);
          if(ui.item.value==''){
            toastr
          }else{
          SearchProduct(ui.item.value);

          }
          $(this).val('');

        return false;
      },
    response: function(event, ui) {
        if (!ui.content.length) {
          error('No Product Found');

        }
    }
    });

  
function SearchProduct(id) {
  var whspid=$("#from_wherehouseshope_id").val();
  var existing=0;
  $(".products_ids").each(function () {
    if($(this).val()==id){
      console.log($(this).val());
    warning("product already added");
      existing=existing+1;
    }
  });

if(existing==0){
  $.ajax({
      url:"{{url('stocktransfer/search')}}",
      type:"POST",
      data:{_token:"{{csrf_token()}}", id:id, whspid:whspid},
      success:function(data) {
        if(data=='false'){
          error("Storck not found");
        }
        else{
          $("#tablebody").append(data);
          calculate_stock_transfer();
        }

      }
  });
}

}

function calculate_stock_transfer() {
        var total_qnty=0;
        var total_amnt=0;
        $("#tablebody tr").each(function() {
          var row=$(this);
          var qnty=row.find(".unit_quantity").val();
          var cost=row.find(".unit_cost").val();
          var net_cost=parseInt(qnty)*parseInt(cost);
          row.find(".net_cost").val(net_cost);
          total_qnty+=qnty;
          total_amnt+=net_cost;
        });

        $("#total_quantity").val(parseInt(total_qnty));
        $("#total_amount").val(parseFloat(total_amnt));

}


$(document).on("change",".unit_quantity", function(){
  calculate_stock_transfer();
});





});
</script>
@endsection
