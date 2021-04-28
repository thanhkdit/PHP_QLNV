<?php include '../../classes/workday.php' ?>
<?php
  $workday = new Workday();
  if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if (isset($_POST['btnSubmit'])) // Kiểm tra nút có giá trị dữ liệu
    {
        if($_POST['btnSubmit'] == '+')
        {
          $year = $_POST['year'];
          $insert = $workday->insert_year($year);
        }

        if($_POST['btnSubmit'] == 'Insert All')
        {
        $employeeId = empty($_GET['workday_employeeId'])?'%':$_GET['workday_employeeId'];
          $count = 0;
          $insert = "";
          $size = $_POST['size'];
          $workdayMonth = $_POST["workdayMonth"];
          $workdayYear = $_POST["workdayYear"];
          if ($workdayMonth == '' || $workdayYear == ''){
            $insert = $insert."<div class='alert alert-warning'>Please select Month and Year</div>";
          }
          for ($i = 1; $i <= $size; $i++){
            $employeeId = empty($_POST['employeeId'.$i])?'':$_POST['employeeId'.$i];
            $dayWorked = empty($_POST['dayWorked'.$i])?'':$_POST['dayWorked'.$i];
            $overTime = empty($_POST['overtime'.$i])?'':$_POST['overtime'.$i];
            if($dayWorked == '' || $employeeId == ''){
              continue;
            }
            if($overTime == ''){
              $overTime = 0;
            }
            $insert = $workday->insert_workday($employeeId, $dayWorked, $overTime, $workdayMonth, $workdayYear);
            $count++;
          }
          if ($workdayMonth != '' && $workdayYear != ''){
            $insert = $insert."<div class='alert alert-primary'>".$count." were inserted</div>";
          }
        }
    }
  }
?>
<?php include '../../inc/header.php' ?>
<div class="body row">
  <?php include '../../inc/sidebar.php' ?>
  <div class="content col-10 col-sm-9 col-xl-10">
    <form class="insert-year" method="post" action="">
      <table class="mt-3">
        <tr>
          <td><input type="text" class="form-control" name="year" size="5" placeholder="Year"></td>
          <td>----</td>
          <td><input type="submit" class="btn btn-success" name="btnSubmit" value="+"></td>
        </tr>
      </table>
    </form>
    <div class="filter">
      <h3 class="text-center display-block">Filter</h3>
      <table class="table">
        <thead class="thead-light">
          <tr>
            <th scope="col">Employee Id</th>
            <th scope="col">FullName</th>
            <th scope="col">Department</th>
            <th scope="col">Position</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody>
          <td>
            <input type="text" class="form-control" id="workday_employeeId" name="workday_employeeId">
          </td>
          <td>
            <input type="text" class="form-control" id="workday_employee" name="workday_employee">
          </td>
          <td>
            <select class="form-control col-sm-8" id="workday_department" name="workday_department">
              <option selected value="">All</option>
              <?php
                $show = $workday->show('t_Department');
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
            <select class="form-control col-sm-8" id="workday_position" name="workday_position">
              <option selected value="">All</option>
              <?php
                $show = $workday->show('t_Position');
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
            <button id="btn-filter" class="btn btn-success">Filter</button>
          </td>
        </tbody>
      </table>
    </div>
    <h3 class="text-center display-block">Insert Workday Infomation</h3>
    <?php
      if(isset($insert)){
        echo $insert;
      }
    ?>
    <form  id="insert-workday" class="mx-auto" action="" method="post">
      <table style="margin-bottom: 10px">
        <tr>
          <td style="padding-right: 10px">
            <label>Year:</label>
          </td>
          <td style="width: 150px">
            <select class="form-control col-sm-8" id="worday_year" name="workdayYear">
              <option selected value="">All</option>
              <?php
                $show = $workday->show('t_Salary_year');
                if($show){
                  while($result = $show->fetch_assoc()){
              ?>
              <option value="<?php echo $result['Salary_year']?>"><?php echo $result['Salary_year']?></option>
              <?php
                  }
                }
               ?>
            </select>
          </td>
          <td style="padding-right: 10px">
            <label>Month:</label>
          </td>
          <td style="width: 100px">
            <select class="form-control col-sm-8" id="workday_month" name="workdayMonth">
              <option selected value="">All</option>
              <?php
                for ($i=1; $i<=12; $i++){
              ?>
              <option value="<?php echo $i?>"><?php echo $i ?></option>
              <?php
                }
               ?>
            </select>
          </td>
        </tr>
      </table>

      <table id="add-workday" class="table table-striped">
        <thead class="thead-dark">
          <tr>
            <th scope="col">Ordinal</th>
            <th scope="col">Employee Id</th>
            <th scope="col">Fullname</th>
            <th scope="col">Department</th>
            <th scope="col">Position</th>
            <th scope="col">Day worked</th>
            <th scope="col">Overtime</th>
          </tr>
        </thead>
        <tbody id="body_add_workday">

          <!-- Chèn nội dung ajax ở đây -->

        </tbody>
      </table>
      <input type="submit" class="btn btn-success" name="btnSubmit" value="Insert All">
      <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-center" id="workday-pagenumber">

          <!-- Chèn nội dung ajax ở đây -->

        </ul>
      </nav>
    </form>

  </div>
</div>
<script>
  var index = 1;
  var amount = 5;
  var btnFilter = $("#btn-filter");
  $(document).ready(function(){
    var workday_employee = $("#workday_employee").val();
    var workday_department = $("#workday_department").val();
    var workday_position = $("#workday_position").val();
    var workday_employeeId = $("#workday_employeeId").val();
    $.get("page_add.php",
          {
            page:index,
            amount,
            workday_employeeId: workday_employeeId,
            workday_employee: workday_employee,
            workday_department: workday_department,
            workday_position: workday_position
          },
          function(data){
            $("#body_add_workday").append(data);
    });

    $.get("page_number_add.php",
          {
            amount,
            workday_employeeId: workday_employeeId,
            workday_employee: workday_employee,
            workday_department: workday_department,
            workday_position: workday_position
          },
          function(data){
      $("#workday-pagenumber").html(data);
    });

    // Cần nav.on() để load lại nav(nav là cha của page-link) trang sau khi gọi ajax
    $('nav').on('click','.page-link',function(e){
      e.preventDefault();
      var workday_employeeId = $("#workday_employeeId").val();
      var workday_employee = $("#workday_employee").val();
      var workday_department = $("#workday_department").val();
      var workday_position = $("#workday_position").val();
      index = Number($(this).text());
      $("li").removeClass('active');
      $(this).parent().addClass('active');
      $.get("page_add.php",
            {
              page:index,
              amount,
              workday_employeeId: workday_employeeId,
              workday_employee: workday_employee,
              workday_department: workday_department,
              workday_position: workday_position
            },
            function(data){
              $("#body_add_workday").html(data);
      });
    });

    $("#btn-filter").click(function(){
      index = 1;
      var workday_employeeId = $("#workday_employeeId").val();
      var workday_employee = $("#workday_employee").val();
      var workday_department = $("#workday_department").val();
      var workday_position = $("#workday_position").val();
      $.get("page_add.php",
            {
              page:index,
              amount,
              workday_employeeId: workday_employeeId,
              workday_employee: workday_employee,
              workday_department: workday_department,
              workday_position: workday_position
            },
            function(data){
        $("#body_add_workday").html(data);
      });
      $.get("page_number_add.php",
            {
              amount,
              workday_employeeId: workday_employeeId,
              workday_employee: workday_employee,
              workday_department: workday_department,
              workday_position: workday_position
            },
            function(data){
        $("#workday-pagenumber").html(data);
      });
    });
  });

</script>
<?php include '../../inc/footer.php' ?>
