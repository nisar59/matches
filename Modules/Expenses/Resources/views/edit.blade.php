@extends('layouts.template')
@section('title')
Expenses
@endsection
@section('content')
        <section class="section">
          <div class="section-body">           
            <form action="{{url('expenses/update/'.$data->id)}}" method="post" enctype="multipart/form-data">
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
                        <option value="{{$ecate}}" @if($data->expense_category==$ecate) selected @endif>{{$ecate}}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="form-group col-md-4">
                      <label>Reference No</label>
                      <input type="text" name="reference_no" value="{{$data->reference_no}}" class="form-control" placeholder="Reference No">
                    </div>
                    <div class="form-group col-md-4">
                      <label>Date</label>
                      <input type="text" name="expense_date" value="{{$data->expense_date}}" class="form-control datepicker" >
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group col-md-6">
                      <label>Total Amount</label>
                      <input type="number" min="1" name="amount" value="{{$data->amount}}" class="form-control" placeholder="Total Amount">
                    </div>                   
                    <div class="form-group col-md-6">
                      <label>Expense Note</label>
                      <textarea class="form-control" name="note" placeholder="Expense Note">{{$data->note}}</textarea>
                    </div>
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

</script>
@endsection
