 <!-- General JS Scripts -->
  <script src="{{asset('assets/js/app.min.js')}}"></script>
  <!-- JS Libraies -->
  <script src="{{asset('assets/bundles/apexcharts/apexcharts.min.js')}}"></script>
  <script src="{{asset('assets/bundles/select2/dist/js/select2.full.min.js')}}"></script>
  <!-- Page Specific JS File -->
  <script src="{{asset('assets/js/page/index.js')}}"></script>
  <!-- Template JS File -->
  <script src="{{asset('assets/js/scripts.js')}}"></script>
  <!-- Custom JS File -->
  <script src="{{asset('assets/js/custom.js')}}"></script>
  <script src="{{asset('assets/js/functions.js')}}"></script>

<script src="{{asset('assets/bundles/datatables/datatables.min.js')}}"></script>
  <script src="{{asset('assets/bundles/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js')}}"></script>
  <script src="{{asset('assets/bundles/jquery-ui/jquery-ui.min.js')}}"></script>
  <!-- Page Specific JS File -->
  <script src="{{asset('assets/bundles/bootstrap-daterangepicker/daterangepicker.js')}}"></script>

  <script src="{{asset('assets/js/page/datatables.js')}}"></script>

  <script src="{{asset('assets/bundles/izitoast/js/iziToast.min.js')}}"></script>

  <script type="text/javascript">




  $(document).ready(function(){

    $(".layout-color input:radio").change(function () {
       var val=$(this).val();

       $.ajax({
        url:"{{url('settings/theme')}}",
        method:"POST",
        data:{data:val, field:'layout', _token:"{{csrf_token()}}"},
        success:function(data){
          console.log(data);
        }

       });
    });



    $(".sidebar-color input:radio").change(function () {
      var val=$(this).val();
       $.ajax({
        url:"{{url('settings/theme')}}",
        method:"POST",
        data:{data:val, field:'sidebar', _token:"{{csrf_token()}}"},
        success:function(data){
          console.log(data);
        }

       });
    });



  $(".choose-theme li").on("click", function () {
    var val=$(this).attr("title");
    $.ajax({
        url:"{{url('settings/theme')}}",
        method:"POST",
        data:{data:val, field:'theme', _token:"{{csrf_token()}}"},
        success:function(data){
          console.log(data);
        }

       });
  });



 $("#mini_sidebar_setting").on("change", function () {
    var val = $(this).is(":checked") ? "checked" : "unchecked";
 $.ajax({
        url:"{{url('settings/theme')}}",
        method:"POST",
        data:{data:val, field:'mini', _token:"{{csrf_token()}}"},
        success:function(data){
          console.log(data);
        }

       });
  });


  $("#sticky_header_setting").on("change", function () {
  var val = $(this).is(":checked") ? "checked" : "unchecked";
 $.ajax({
        url:"{{url('settings/theme')}}",
        method:"POST",
        data:{data:val, field:'sticky', _token:"{{csrf_token()}}"},
        success:function(data){
          console.log(data);
        }

       });

  });


  $(".btn-restore-theme").on("click", function () {
 $.ajax({
        url:"{{url('settings/restorydefault')}}",
        method:"POST",
        data:{_token:"{{csrf_token()}}"},
        success:function(data){
          console.log(data);
        }

       });

  });

  });



</script>