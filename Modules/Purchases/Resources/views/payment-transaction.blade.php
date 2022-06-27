        <div class="modal modal-primary fade payment-transactions"  tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
          aria-hidden="true">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">Transactions Detail</h5>
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
                  <div class="col-md-6">
                    <h5>Transactions</h5>
                  </div>
                  <div class="col-md-6">
                    @if($data->payment_status!='paid')
                    <a href="" class="btn btn-primary btn-sm pull-right">Add Payment</a>
                    @endif
                  </div>
                    <div class="col-md-12">
                    <div class="table-responsive">
                      <table class="table table-bordered table-sm">
                        <tr class="bg-primary bg-white">
                          <th>Date</th>
                          <th>Amount</th>
                          <th>Method</th>
                          <th>note</th>
                          <th>Action</th>
                        </tr>
                        <tbody>
                          @foreach($data->PurchaseTransaction as $pt)
                          <td>{{$pt->paid_on}}</td>
                          <td>{{$pt->payment_amount}}</td>
                          <td>{{$pt->method}}</td>
                          <td>{{$pt->note}}</td>
                          <td>
                            <a href="javascript:void(0)" data-href="{{url('purchases/remove-transaction/'.$pt->id)}}" class="btn btn-danger btn-sm remove-transaction"><i class="fas fa-trash-alt"></i></a>
                          </td>
                          @endforeach
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              <div class="row">
                <div class="col-md-12">
                  <table class="pull-right" width="25%">
                   <tr><th>Total:</th><td>{{$data->purchase_total}}</td></tr>
                   <tr><th>Paid:</th><td>{{$data->payment_amount}}</td></tr>
                   @if($data->payment_status!='paid')
                   <tr><th>Due:</th><td>{{$data->due}}</td></tr>
                   @endif
                  </table>
                </div>
              </div>
              </div>
            </div>
          </div>
        </div>
      </div>