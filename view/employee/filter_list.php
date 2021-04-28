<?php include '../../classes/employee.php' ?>
<?php
  $employee = new Employee();
  if(isset($_GET['delid'])){
    $id = $_GET['delid'];
    $deleted = $employee->del_employee($id);
  }
?>
<?php include '../../inc/header.php' ?>
<div class="body row">
  <?php include '../../inc/sidebar.php' ?>
  <div class="content  col-10 col-sm-9 col-xl-10">
      <h3 class="text-center display-block">Filter</h3>
      <table class="table">
        <thead class="thead-light">
          <tr>
            <th scope="col">Employee Id</th>
            <th scope="col">Employee's Name</th>
            <th scope="col">Gender</th>
            <th scope="col">Department</th>
            <th scope="col">Position</th>
            <th scope="col">Level</th>
            <th scope="col">Type of Contract</th>
            <th scope="col">Expiration Date</th>
            <th scope="col">Status Contract</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody>
          <td>
            <input type="text" id="employee_id" name="employee_employeeId" class="form-control" size=5>
          </td>
          <td>
            <input type="text" id="employee_employee" name="employee_employee" class="form-control" size=5>
          </td>
          <td>
            <select class="form-control col-sm-8" id="employee_gender">
              <option selected value="">All</option>
              <option value="Nam">Nam</option>
              <option value="Nữ">Nữ</option>
              <option value="Khác">Khác</option>
            </select>
          </td>
          <td>
            <select class="form-control col-sm-8" id="employee_department">
              <option selected value="">All</option>
              <?php
                $show = $employee->show('t_Department');
                if($show){
                  while($result = $show->fetch_assoc()){
              ?>
              <option value="<?php echo $result['Department_id']?>"><?php echo $result['Department_id']." - ".$result['Department_name']; ?></option>
              <?php
                  }
                }
               ?>
            </select>
          </td>
          <td>
            <select class="form-control col-sm-8" id="employee_position">
              <option selected value="">All</option>
              <?php
                $show = $employee->show('t_Position');
                if($show){
                  while($result = $show->fetch_assoc()){
              ?>
              <option value="<?php echo $result['Position_id']?>"><?php echo $result['Position_id']." - ".$result['Position_name']; ?></option>
              <?php
                  }
                }
               ?>
            </select>
          </td>
          <td>
            <select class="form-control col-sm-8" id="employee_level">
              <option selected value="">All</option>
              <?php
                $show = $employee->show('t_Level');
                if($show){
                  while($result = $show->fetch_assoc()){
              ?>
              <option value="<?php echo $result['Level_id']?>"><?php echo $result['Level_id']." - ".$result['Level']; ?></option>
              <?php
                  }
                }
               ?>
            </select>
          </td>
          <td>
            <select class="form-control col-sm-8" id="employee_type">
              <option selected value="">All</option>
              <option value="Dài hạn">Dài hạn</option>
              <option value="Ngắn hạn">Ngắn hạn</option>
              <option value="Khác">All</option>
            </select>
          </td>
          <td>
            <input type="date" id="employee_expirationDate">
          </td>
          <td>
            <select class="form-control col-sm-8" id="employee_status">
              <option selected value="">All</option>
              <option value="1">Effective</option>
              <option value="2">Invalid</option>
            </select>
          </td>
          <td>
            <button id="btn-filter" class="btn btn-success">Filter</button>
          </td>
        </tbody>
      </table>
    <h3 class="text-center display-block">Employee List</h3>
    <?php
      if(isset($deleted)){
        echo $deleted;
      }
    ?>
    <table id="list-employee" class="table table-striped">
      <thead class="thead-dark">
        <tr>
          <th scope="col">Ordinal</th>
          <th scope="col">Employee Id</th>
          <th scope="col">Fullname</th>
          <th scope="col">Gender</th>
          <th scope="col">Position</th>
          <th scope="col">Department</th>
          <th scope="col">Level</th>
          <th scope="col">Action</th>
        </tr>
      </thead>
      <tbody id="body_employee">

        <!-- Chèn nội dung ajax ở đây -->

      </tbody>
    </table>
    <nav aria-label="Page navigation example">
      <ul class="pagination justify-content-center" id="employee-pagenumber">

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
    var employee_id = $("#employee_id").val();
    var employee_employee = $("#employee_employee").val();
    var employee_department = $("#employee_department").val();
    var employee_position = $("#employee_position").val();
    var employee_level = $("#employee_level").val();
    var employee_gender = $("#employee_gender").val();
    var employee_type = $("#employee_type").val();
    var employee_status = $("#employee_status").val();
    var employee_expirationDate = $("#employee_expirationDate").val();
    $.get("page.php",
          {
            page: index,
            amount: amount,
            employee_id: employee_id,
            employee_employee: employee_employee,
            employee_department: employee_department,
            employee_position: employee_position,
            employee_level: employee_level,
            employee_type: employee_type,
            employee_status: employee_status,
            employee_gender: employee_gender,
            employee_expirationDate: employee_expirationDate
          },
          function(data){
            $("#body_employee").append(data);
    });

    $.get("page_number.php",
          {
            amount: amount,
            employee_id: employee_id,
            employee_employee: employee_employee,
            employee_department: employee_department,
            employee_position: employee_position,
            employee_level: employee_level,
            employee_type: employee_type,
            employee_status: employee_status,
            employee_gender: employee_gender,
            employee_expirationDate: employee_expirationDate
          },
          function(data){
      $("#employee-pagenumber").html(data);
    });

    // Cần nav.on() để load lại nav(nav là cha của page-link) trang sau khi gọi ajax
    $('nav').on('click','.page-link',function(e){
      e.preventDefault();
      var employee_id = $("#employee_id").val();
      var employee_employee = $("#employee_employee").val();
      var employee_department = $("#employee_department").val();
      var employee_position = $("#employee_position").val();
      var employee_level = $("#employee_level").val();
      var employee_gender = $("#employee_gender").val();
      var employee_type = $("#employee_type").val();
      var employee_status = $("#employee_status").val();
      var employee_expirationDate = $("#employee_expirationDate").val();
      index = Number($(this).text());
      $("li").removeClass('active');
      $(this).parent().addClass('active');
      $.get("page.php",
            {
              page:index,
              amount: amount,
              employee_id: employee_id,
              employee_employee: employee_employee,
              employee_department: employee_department,
              employee_position: employee_position,
              employee_level: employee_level,
              employee_type: employee_type,
              employee_status: employee_status,
              employee_gender: employee_gender,
              employee_expirationDate: employee_expirationDate
            },
            function(data){
              $("#body_employee").html(data);
      });
    });

    $("#btn-filter").click(function(){
      index = 1;
      var employee_id = $("#employee_id").val();
      var employee_employee = $("#employee_employee").val();
      var employee_department = $("#employee_department").val();
      var employee_position = $("#employee_position").val();
      var employee_level = $("#employee_level").val();
      var employee_gender = $("#employee_gender").val();
      var employee_type = $("#employee_type").val();
      var employee_status = $("#employee_status").val();
      var employee_expirationDate = $("#employee_expirationDate").val();
      $.get("page.php",
            {
              page:index,
              amount: amount,
              employee_id: employee_id,
              employee_employee: employee_employee,
              employee_department: employee_department,
              employee_position: employee_position,
              employee_level: employee_level,
              employee_type: employee_type,
              employee_status: employee_status,
              employee_gender: employee_gender,
              employee_expirationDate: employee_expirationDate
            },
            function(data){
        $("#body_employee").html(data);
      });
      $.get("page_number.php",
            {
              amount: amount,
              employee_id: employee_id,
              employee_employee: employee_employee,
              employee_department: employee_department,
              employee_position: employee_position,
              employee_level: employee_level,
              employee_type: employee_type,
              employee_status: employee_status,
              employee_gender: employee_gender,
              employee_expirationDate: employee_expirationDate
            },
            function(data){
        $("#employee-pagenumber").html(data);
      });
    });
  });

  // Thực hiện function sau khi ajax dừng lại, không thực hiện khi vừa tải trang(ajax chưa đuợc gọi) (document.ready)

  // $( document ).ajaxStop(function() {
  //   $(".page-link").click(function(){
  //     var fine_employee = $("#fine_employee").val();
  //     var fine_department = $("#fine_department").val();
  //     var fine_fine = $("#fine_fine").val();
  //     var fine_year = $("#fine_year").val();
  //     var fine_month = $("#fine_month").val();
  //     index = Number($(this).text());
  //     $("li").removeClass('active');
  //     $(this).parent().addClass('active');
  //     $.get("page.php",
  //           {
  //             page:index,
  //             fine_employee: fine_employee,
  //             fine_department: fine_department,
  //             fine_fine: fine_fine,
  //             fine_year: fine_year,
  //             fine_month: fine_month,
  //           },
  //           function(data){
  //             $("#body_fine").html(data);
  //     });
  //   });
  // });
</script>
<?php include '../../inc/footer.php' ?>
