        <div class="modal modal-primary fade purchase-show"  tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
          aria-hidden="true">
          <div class="modal-dialog modal-xl">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">Stock Transfer Detail</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <hr class="w-100"></hr>
              <div class="modal-body">
                <div class="row">
                  <div class="col-md-4">
                    <strong>From: </strong>{{WarehousesAndShopsName($data->fromwarehouse_id)}}
                  </div>
                  <div class="col-md-4">
                    <strong>To: </strong>{{WarehousesAndShopsName($data->towarehouse_id)}}
                  </div>
                  <div class="col-md-4 text-right">
                    <strong>Reference No: </strong>{{$data->transfer_reference_no}}<br>
                    <strong>Date: </strong>{{$data->transfer_date}}<br>
                    <strong>Added By: </strong>{{User($data->added_by)}}
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
                      @foreach($data->StockTransfered as $stk)
                      <tr class="text-center">
                        <td>{{$i++}}</td>
                        <td>{{ProductName($stk->product_id)}}</td>
                        <td>{{$stk->unit_cost}}</td>
                        <td>{{$stk->quantity}}</td>
                        <td>{{$stk->total_product_cost}}</td>
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
                 <tr><th>Shipping Charges(+):</th><td>{{$data->transfer_charges}}</td></tr>
                 <tr style="border-top: 1px solid silver;"><th>Net Total:</th><td>{{$data->transfer_total}}</td></tr>
                </table>
              </div>
              <div class="col-md-12 mt-5">
                <hr>
                <a href="" class="btn btn-success pull-right">Print</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>