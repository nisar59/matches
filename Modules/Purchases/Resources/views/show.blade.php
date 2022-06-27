        <div class="modal modal-primary fade purchase-show"  tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
          aria-hidden="true">
          <div class="modal-dialog modal-xl">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">Purchase Detail</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <hr class="w-100"></hr>
              <div class="modal-body">
                <div class="row">
                  <div class="col-md-6">
                    <strong>Vendor: </strong>{{$data->VendorDetail->name}}<br>
                    <strong>Phone: </strong>{{$data->VendorDetail->phone_no}}
                  </div>
                  <div class="col-md-6 text-right">
                    <strong>Reference No: </strong>{{$data->reference_no}}<br>
                    <strong>Order Date: </strong>{{$data->order_date}}
                  </div>
                </div>
                  <hr class="w-100"></hr>
                  <div class="row">
                    <div class="col-md-12">
                    <h5>Products Detail</h5>
                  
                    <div class="table-responsive">
                    <table class="table table-sm table-bordered" style="width:100%;">
                      <tr class="bg-success text-white text-center">
                      <th>#</th>
                      <th>Product Name</th>
                      <th>Unit Cost</th>
                      <th>Quantity</th>
                      <th>Total Product Cost</th>
                    </tr>
                    <tbody>
                      @php($i=1)
                      @foreach($data->PurchasedProducts as $pp)
                      <tr class="text-center">
                        <td>{{$i++}}</td>
                        <td>{{ProductName($pp->product_name)}}</td>
                        <td>{{$pp->unit_cost}}</td>
                        <td>{{$pp->quantity}}</td>
                        <td>{{$pp->total_product_cost}}</td>
                      </tr>
                      @endforeach
                    </tbody>
                    </table>
                </div>
              </div>
                  </div>

            <div class="row">
              <div class="col-md-12">
                <table class="pull-right" width="25%">
                 <tr style="border-top: 1px solid silver;"><th>Gross Total:</th><td>{{$data->gross_total}}</td></tr>
                 <tr><th>Discount(-):</th><td>{{$data->net_discount}}</td></tr>
                 <tr><th>Shipping Charges(+):</th><td>{{$data->shipping_charges}}</td></tr>
                 <tr style="border-top: 1px solid silver;"><th>Net Total:</th><td>{{$data->purchase_total}}</td></tr>
                 <tr><th>Paid:</th><td>{{$data->payment_amount}}</td></tr>
                </table>
              </div>
            </div>

          <div class="row">
            <div class="col-md-6">
              <h5>Transactions</h5>
              <div class="table-responsive">
                <table class="table table-bordered table-sm">
                  <tr class="bg-success bg-white">
                    <th>Date</th>
                    <th>Amount</th>
                    <th>Method</th>
                    <th>note</th>
                  </tr>
                  <tbody>
                    @foreach($data->PurchaseTransaction as $pt)
                    <td>{{$pt->paid_on}}</td>
                    <td>{{$pt->payment_amount}}</td>
                    <td>{{$pt->method}}</td>
                    <td>{{$pt->note}}</td>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <strong>Payment Status:</strong> {{ucFirst($data->payment_status)}}
              <button class="btn btn-primary print pull-right">Print</button>
            </div>
          </div>

          </div>
        </div>
      </div>
    </div>
  </div>