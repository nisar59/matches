@extends('layouts.template')
@section('title')
Expenses
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
                    <div class="form-group col-md-2">
                      <label>Expense Category</label>
                      <select class="form-control select2 filters" id="expense_category">
                        <option value="">Select</option>
                        @foreach(ExpensesCategories() as $ecate)
                        <option value="{{$ecate}}">{{$ecate}}</option>
                        @endforeach
                      </select>
                    </div>
                      <div class="form-group col-md-3">
                        <label>Reference No:</label>
                        <input type="text" class="form-control filters" id="reference_no" placeholder="Reference No">
                      </div>
                    <div class="form-group col-md-3">
                      <label>Payment Status:</label>
                      <select id="payment_status" class="form-control filters select2">
                        <option value="">Select</option>
                       <option value="paid">Paid</option>
                       <option value="partial">Partial</option>
                       <option value="due">Due</option>

                      </select>
                    </div>
                    <div class="form-group col-md-4">
                      <label>Date</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <div class="input-group-text">
                            <i class="fas fa-calendar"></i>
                          </div>
                        </div>
                        <input type="text" id="expense_date" value="" placeholder="Select Date Range" autocomplete="off" class="form-control filters daterange">
                      </div>
                    </div>                    
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-12">
                <div class="card card-primary">
                  <div class="card-header">
                    <h4 class="col-md-6">Expenses</h4>
                    <div class="col-md-6 text-right">
                    <a href="{{url('expenses/create')}}" class="btn btn-success">+</a>
                    <span id="buttons">
                    <a href="javascript:void(0)" class="btn btn-primary" id="dropdownMenuButton2"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-th-list"></i> Action</a>
                        <div class="dropdown-menu bg-primary">
                        <a class="dropdown-item has-icon text-light" id="excelexport" href="javascript:void(0)"><i class="fas fa-file-excel"></i> Export to excel</a>
                        <a class="dropdown-item has-icon text-light" id="printexport" href="javascript:void(0)"><i class="far fa-file"></i> Print</a>
                        <a class="dropdown-item has-icon text-light" href="{{url('expenses/export-pdf')}}"><i class="fas fa-file-pdf"></i> Export to PDf</a>
                      </div>
                    </span>
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-striped table-hover" id="users" style="width:100%;">
                        <thead>
                          <tr>                            
                            <th>Date</th>
                            <th>Reference No</th>
                            <th>Category</th>
                            <th>Amount</th>
                            <th>Paid</th>
                            <th>Due</th>
                            <th>Payment Status</th>
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
@endsection
@section('js')
<script type="text/javascript">
    //Roles table
$(document).ready( function(){
  var roles_table;
  DrawDatatable();
  function DrawDatatable(expense_category='',reference_no='',payment_status='',expense_date='') {

  roles_table = $('#users').DataTable({
              processing: true,
              serverSide: true,
              "ajax": {
                url:"{{url('expenses')}}",
                data:{
                    expense_category:expense_category,
                    reference_no:reference_no,
                    payment_status:payment_status,
                    expense_date:expense_date
                },
              },
                buttons:[
                      {
                        extend:"collection",
                        buttons:[
                            {
                              extend:'excelHtml5',
                              title:'{{Settings()->portal_name}}-Expenses Detail',
                              exportOptions: {
                              columns: [0,1,2,3,4,5,6],
                              search: 'applied',
                              order: 'applied',
                              },
                              footer:true,
                            },
                            {
                              extend:'print',
                              title:'<h2 class="text-center mb-2">{{Settings()->portal_name}}</h2><h4 class="text-center mb-5">Expenses Detail</h4>',
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
                {data: 'expense_date', name: 'expense_date'},
                {data: 'reference_no', name: 'reference_no'},
                {data: 'expense_category', name: 'expense_category'},
                {data: 'amount', name: 'amount'},
                {data: 'paid', name: 'paid'},
                {data: 'due', name: 'due'},
                {data: 'payment_status', name: 'payment_status'},
                {data: 'added_by', name: 'added_by'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
          });
  }


$(".filters").on('change input',function () {
      var expense_category=$("#expense_category").val();
      var reference_no=$("#reference_no").val();
      var payment_status=$("#payment_status").val();
      var expense_date=$("#expense_date").val();


      roles_table.destroy();
  DrawDatatable(expense_category,reference_no,payment_status,expense_date);
});


$("#printexport").on('click', function() {
    roles_table.button('.buttons-print').trigger();
});      
$("#excelexport").on('click', function() {
    roles_table.button('.buttons-excel').trigger();
});






});
</script>
@endsection
