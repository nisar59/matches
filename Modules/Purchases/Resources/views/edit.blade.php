@extends('layouts.template')
@section('title')
Purchases
@endsection
@section('content')
        <section class="section">
          <div class="section-body">

          <form action="{{url('purchases/update/'.$data['purchase']->id)}}" method="post" enctype="multipart/form-data">
              @csrf  
            <div class="row">  
              <div class="col-12 col-md-12">
                <div class="card card-primary">
                  <div class="card-header">
                    <h4>Purchases</h4>
                  </div>
                  <div class="card-body">
                    <div class="row">
                    <div class="form-group col-md-4">
                      <label>Vendor</label>
                      <select name="vendor" class="form-control select2">
                        <option value="">Select</option>
                        @foreach($data['vendors'] as $vendor)
                        <option value="{{$vendor->id}}" @if($data['purchase']->vendor==$vendor->id) selected @endif>{{$vendor->name}}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="form-group col-md-4">
                      <label>Reference No</label>
                      <input type="text" name="reference_no" value="{{$data['purchase']->reference_no}}" class="form-control" placeholder="Reference No">
                    </div>
                    <div class="form-group col-md-4">
                      <label>Order Date</label>
                      <input type="date" name="order_date" value="{{$data['purchase']->order_date}}" class="form-control datepicker">
                    </div>
                    <div class="form-group col-md-4">
                      <label>Warehouse Or Shop</label>
                      <select class="form-control" name="warehousesandshops_id">
                        @foreach($data['warehousesandshops'] as $ws)
                        <option value="{{$ws->id}}" @if($ws->id==$data['purchase']->warehousesandshops_id) selected @endif>{{$ws->name}}</option>
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
                    <div id="accordion">
                        @foreach($data['purchase']->PurchasedProducts as $pp)

                        @php($data['pro']=$pp->ProductRel)

                        @include('purchases::edit-product',[$data, $pp])
                        @endforeach
                    </div>
                  </div>
                  <hr>
                  <div class="col-md-12">
                    <table width="25%" class="pull-right">
                      <tr>
                      <th class="text-right" width="60%">Total Items:</th>
                      <td width="40%"><input type="text" value="{{$data['purchase']->total_items}}" readonly class="form-control total_items border-0 readonly" name="total_items"></td>
                    </tr>
                    <tr>
                      <th class="text-right" width="60%">Gross Total:</th>
                      <td width="40%"><input type="text" value="{{$data['purchase']->gross_total}}" readonly class="form-control gross_total border-0 readonly" name="gross_total"></td>
                    </tr>
                    </table>
                  </div>
                  </div>
                  </div>
                </div>
                <div class="card card-primary">
                  <div class="card-header"></div>
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-3">
                        <div class="form-group">
                          <label>Discount Type</label>
                          <select class="form-control discount_type" name="discount_type">
                            <option value="">Select</option>
                            <option value="fixed" @if($data['purchase']->discount_type=='fixed') selected @endif>Fixed</option>
                            <option value="percentage" @if($data['purchase']->discount_type=='percentage') selected @endif>Percentage</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label>Discount Value</label>
                          <input type="number" name="discount_value" value="{{$data['purchase']->discount_value}}" class="form-control discount_value" placeholder="Discount value">
                        </div>
                      </div>
                      <div class="col-md-6">
                    <table width="40%" class="pull-right">
                    <tr>
                      <th class="text-right" width="1%">Discount:</th>
                      <td width="2%"><input type="text" value="{{$data['purchase']->net_discount}}" readonly class="form-control net_discount border-0 readonly" name="net_discount"></td>
                    </tr>
                    </table>
                      </div>
                    </div>
                    <hr>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Shipping Status</label>
                          <select class="form-control" name="shipping_status">
                            @foreach(ShippingStatus() as $key=> $ss)
                            <option value="{{$key}}" @if($data['purchase']->shipping_status==$key) selected @endif>{{$ss}}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Shipping Address</label>
                          <input type="text" name="shipping_address" value="{{$data['purchase']->shipping_address}}" class="form-control" placeholder="Shipping Address">
                        </div>
                      </div>
                    </div>
                    <hr>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Shipping Details:</label>
                          <textarea class="form-control" name="shipping_detail" placeholder="Shipping Details">{{$data['purchase']->shipping_detail}}</textarea>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>(+) Additional Shipping charges:</label>
                          <input type="number" class="form-control shipping_charges" value="{{$data['purchase']->shipping_charges}}" name="shipping_charges">
                        </div>
                      </div>
                      <hr>
                      <div class="col-md-12">
                    <table width="20%" class="pull-right">
                    <tr>
                      <th class="text-right" width="2%">Purchase total:</th>
                      <td width="2%"><input type="text" value="{{$data['purchase']->purchase_total}}" readonly class="form-control purchase_total border-0 readonly" name="purchase_total"></td>
                    </tr>
                    </table>
                      </div>
                      <hr>
                    </div>
                    <hr>
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

<script src="{{asset('assets/js/purchase.js')}}"></script>



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
  $.ajax({
      url:"{{url('purchases/search')}}",
      type:"POST",
      data:{_token:"{{csrf_token()}}", id:id},
      success:function(data) {
        $("#accordion").append(data);
        calculate_total();
      }
  });
}


$(document).on('change', '.payment_method',function(){
  var k=$(this).val();
  $.ajax({
      url:"{{url('purchases/payment-methods-fields')}}",
      type:"POST",
      data:{_token:"{{csrf_token()}}", k:k},
      success:function(data) {
        $(".fields").html(data);

      }
  });
});




});
</script>
@endsection
