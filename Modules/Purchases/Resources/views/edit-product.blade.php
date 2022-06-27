                <div class="accordion">
                  <div class="accordion-header" role="button" data-toggle="collapse" data-target="#panel-body-{{$data['pro']->id}}">
                          <h4>{{$data['pro']->name}}</h4>
                          <a href="javascript:void(0)" data-href="{{url('purchases/remove-pro/'.$pp->id)}}" class="removepro pull-right">
                            <i class="fas fa-expand-arrows-alt"></i>
                          </a>
                        </div>
                        <div class="accordion-body collapse" id="panel-body-{{$data['pro']->id}}" data-parent="#accordion">
                      <div class="table-responsive">
                      <table class="table table-bordered" id="users" style="width:100%;">
                        <thead>
                          <tr class="bg-success">
                            <th class="text-white" width="1%">#</th>
                            <th class="text-white" width="20%">Product Name</th>
                            <th class="text-white" width="10%">Pricing Unit</th>
                            <th class="text-white" width="10%">Quantity</th>
                            <th class="text-white" width="10%">Unit Cost</th>
                            <th class="text-white" width="10%">Net Cost</th>
                          </tr>
                        </thead>
                        <tbody> 
                          <tr>
                            <td>{{$data['pro']->id}} <input type="hidden" value="{{$data['pro']->id}}" name="product[]"> </td>
                            <td>{{$data['pro']->name}}</td>
                            <td>{{$data['pro']->UnitRel->name}}</td>
                            <td><input type="number"  min="1" name="quantity[]" class="form-control quantity" value="{{$pp->quantity}}"></td>
                            <td><input type="number"  name="price[]" class="form-control price" value="{{$pp->unit_cost}}"></td>
                            <td><input type="number"  name="pronet[]" readonly class="form-control border-0 pronet readonly" value="{{$pp->total_product_cost}}"></td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                      <div class="row">
                        <div class="col-md-12 text-center">
                          <a href="javascript:void(0)" data-link="{{url('purchases/add-sub-units/'.$data['pro']->id)}}" class="btn-link add-subunits">Add Sub Unit</a>
                        </div>
                        @foreach($pp->PurchasedProductsSBU as $ppsbu)
                        @php($data['proid']=$data['pro']->id)
                        @include('purchases::edit-sub-units', [$ppsbu, $data])

                        @endforeach
                      </div>
                    
                </div>
              </div>