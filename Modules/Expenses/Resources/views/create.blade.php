@extends('layouts.template')
@section('title')
Expenses
@endsection
@section('content')
        <section class="section">
          <div class="section-body">           
            <form action="{{url('expenses/store/')}}" method="post" enctype="multipart/form-data">
              @csrf  
            <div class="row">  
              <div class="col-12 col-md-12">
                <div class="card card-primary">
                  <div class="card-header">
                    <h4>Expenses</h4>
                  </div>
                  <div class="card-body">
                    <div class="row">
                    <div class="form-group col-md-4">
                      <label>Expense Category</label>
                      <select class="form-control select2" name="expense_category">
                        @foreach(ExpensesCategories() as $ecate)
                        <option value="{{$ecate}}">{{$ecate}}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="form-group col-md-4">
                      <label>Reference No</label>
                      <input type="text" name="reference_no" value="{{ExpenseReferenceNO()}}" class="form-control" placeholder="Reference No">
                    </div>
                    <div class="form-group col-md-4">
                      <label>Date</label>
                      <input type="text" name="expense_date" class="form-control datepicker" >
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group col-md-6">
                      <label>Total Amount</label>
                      <input type="number" min="1" name="amount" class="form-control" placeholder="Total Amount">
                    </div>
                    <div class="form-group col-md-6">
                      <label>Paid Amount</label>
                      <input type="number" min="0" name="paid" class="form-control" placeholder="Paid Amount">
                    </div>                    
                    <div class="form-group col-md-6">
                      <label>Expense Note</label>
                      <textarea class="form-control" name="note" placeholder="Expense Note"></textarea>
                    </div>
                    <div class="form-group col-md-6">
                      <label>Payment Method</label>
                      <select class="form-control payment_method select2" name="payment_method">
                        @foreach(PaymentMethods() as $key=> $pmt)
                        <option value="{{$key}}">{{$pmt['title']}}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="col-md-12 fields"></div>

                  </div>
                </div>
                  <div class="card-footer text-right">
                    <button class="btn btn-primary mr-1" type="submit">Submit</button>
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
