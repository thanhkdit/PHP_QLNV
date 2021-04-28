<?php include '../../classes/contract.php' ?>
<?php
  $contract = new Contract();
  if(isset($_GET['delid'])){
    $id = $_GET['delid'];
    $deleted = $contract->del_contract($id);
  }
?>
<?php include '../../inc/header.php' ?>
<div class="body row">
  <?php include '../../inc/sidebar.php' ?>
  <div class="content  col-10 col-sm-9 col-xl-10">
    <div class="filter">
      <h3 class="text-center display-block">Filter</h3>
      <table class="table">
        <thead class="thead-light">
          <tr>
            <th scope="col">Employee Id</th>
            <th scope="col">Contract Id</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody>
          <td>
            <input type="text" id="employeeId" name="employeeId" class="form-control">
          </td>
          <td>
            <input type="text" id="contractId" name="contractId" class="form-control">
          </td>
          <td>
            <button id="btn-filter" class="btn btn-success">Filter</button>
          </td>
        </tbody>
      </table>
    </div>
    <h3 class="text-center display-block">Contract List</h3>
    <?php
      if(isset($deleted)){
        echo $deleted;
      }
    ?>
    <table id="list-contract" class="table table-striped">
      <thead class="thead-dark">
        <tr>
          <th scope="col">Ordinal</th>
          <th scope="col">Contract Id</th>
          <th scope="col">Employee Id</th>
          <th scope="col">Type Of Contract</th>
          <th scope="col">Sign Day</th>
          <th scope="col">Expiration Date</th>
          <th scope="col">Status</th>
          <th scope="col">Action</th>
        </tr>
      </thead>
      <tbody id="body_contract">

        <!-- Chèn nội dung ajax ở đây -->

      </tbody>
    </table>
    <nav aria-label="Page navigation example">
      <ul class="pagination justify-content-center" id="contract-pagenumber">

        <!-- Chèn nội dung ajax ở đây -->

      </ul>
    </nav>
  </div>
</div>
<script>
  var index = 1;
  var amount = 5;
  var btnFilter = $("#btn-filter");
  $(document).ready(function(){
    var employeeId = $("#employeeId").val();
    var contractId = $("#contractId").val();
    $.get("page.php",
          {
            page:index,
            amount,
            employeeId: employeeId,
            contractId: contractId,
          },
          function(data){
            $("#body_contract").append(data);
    });

    $.get("page_number.php",
          {
            amount,
            employeeId: employeeId,
            contractId: contractId,
          },
          function(data){
      $("#contract-pagenumber").html(data);
    });

    // Cần nav.on() để load lại nav(nav là cha của page-link) trang sau khi gọi ajax
    $('nav').on('click','.page-link',function(e){
      e.preventDefault();
      var employeeId = $("#employeeId").val();
      var contractId = $("#contractId").val();
      index = Number($(this).text());
      $("li").removeClass('active');
      $(this).parent().addClass('active');
      $.get("page.php",
            {
              page:index,
              amount,
              employeeId: employeeId,
              contractId: contractId,
            },
            function(data){
              $("#body_contract").html(data);
      });
    });

    $("#btn-filter").click(function(){
      index = 1;
      var employeeId = $("#employeeId").val();
      var contractId = $("#contractId").val();
      $.get("page.php",
            {
              page:index,
              amount,
              employeeId: employeeId,
              contractId: contractId,
            },
            function(data){
        $("#body_contract").html(data);
      });
      $.get("page_number.php",
            {
              amount,
              employeeId: employeeId,
              contractId: contractId,
            },
            function(data){
        $("#contract-pagenumber").html(data);
      });
    });
  });

  // Thực hiện function sau khi ajax dừng lại, không thực hiện khi vừa tải trang(ajax chưa đuợc gọi) (document.ready)

  // $( document ).ajaxStop(function() {
  //   $(".page-link").click(function(){
  //     var contract_employee = $("#contract_employee").val();
  //     var contract_department = $("#contract_department").val();
  //     var contract_contract = $("#contract_contract").val();
  //     var contract_year = $("#contract_year").val();
  //     var contract_month = $("#contract_month").val();
  //     index = Number($(this).text());
  //     $("li").removeClass('active');
  //     $(this).parent().addClass('active');
  //     $.get("page.php",
  //           {
  //             page:index,
  //             contract_employee: contract_employee,
  //             contract_department: contract_department,
  //             contract_contract: contract_contract,
  //             contract_year: contract_year,
  //             contract_month: contract_month
  //           },
  //           function(data){
  //             $("#body_contract").html(data);
  //     });
  //   });
  // });
</script>
<?php include '../../inc/footer.php' ?>
