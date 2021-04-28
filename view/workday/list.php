<?php include '../../classes/workday.php' ?>
<?php
  $workday = new Workday();
  if(isset($_GET['delid'])){
    $id = $_GET['delid'];
    $deleted = $workday->del_workday($id);
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
              <th scope="col">Employee's Name</th>
              <th scope="col">Department</th>
              <th scope="col">Position</th>
              <th scope="col">Year</th>
              <th scope="col">Month</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
            <td>
              <input type="text" id="workday_employee" name="workday_employee" class="form-control" size=5>
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
              <select class="form-control col-sm-8" id="workday_year" name="workday_year">
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
            <td>
              <select class="form-control col-sm-8" id="workday_month" name="workday_month">
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
            <td>
              <button id="btn-filter" class="btn btn-success">Filter</button>
            </td>
          </tbody>
        </table>
      </div>
    <h3 class="text-center display-block">Workday List</h3>
    <?php
      if(isset($deleted)){
        echo $deleted;
      }
    ?>
    <table id="list-workday" class="table table-striped">
      <thead class="thead-dark">
        <tr>
          <th scope="col">Ordinal</th>
          <th scope="col">Id</th>
          <th scope="col">Fullname</th>
          <th scope="col">Department</th>
          <th scope="col">Position</th>
          <th scope="col">Day worked</th>
          <th scope="col">Overtime</th>
          <th scope="col">Month</th>
          <th scope="col">Year</th>
          <th scope="col">Action</th>
        </tr>
      </thead>
      <tbody id="body_workday">

        <!-- Chèn nội dung ajax ở đây -->

      </tbody>
    </table>
    <nav aria-label="Page navigation example">
      <ul class="pagination justify-content-center" id="workday-pagenumber">

        <!-- Chèn nội dung ajax ở đây -->

      </ul>
    </nav>
    <script>
      var index = 1;
      var amount = 5;
      var btnFilter = $("#btn-filter");
      $(document).ready(function(){
        var workday_employee = $("#workday_employee").val();
        var workday_department = $("#workday_department").val();
        var workday_position = $("#workday_position").val();
        var workday_year = $("#workday_year").val();
        var workday_month = $("#workday_month").val();
        $.get("page_list.php",
              {
                page: index,
                amount: amount,
                workday_employee: workday_employee,
                workday_department: workday_department,
                workday_position: workday_position,
                workday_year: workday_year,
                workday_month: workday_month
              },
              function(data){
                $("#body_workday").append(data);
        });

        $.get("page_number_list.php",
              {
                amount: amount,
                workday_employee: workday_employee,
                workday_department: workday_department,
                workday_position: workday_position,
                workday_year: workday_year,
                workday_month: workday_month
              },
              function(data){
          $("#workday-pagenumber").html(data);
        });
        // Cần nav.on() để load lại nav(nav là cha của page-link) trang sau khi gọi ajax
        $('nav').on('click','.page-link',function(e){
        	e.preventDefault();
          var workday_employee = $("#workday_employee").val();
          var workday_department = $("#workday_department").val();
          var workday_position = $("#workday_position").val();
          var workday_year = $("#workday_year").val();
          var workday_month = $("#workday_month").val();
          index = Number($(this).text());
          $("li").removeClass('active');
          $(this).parent().addClass('active');
          $.get("page_list.php",
                {
                  page:index,
                  amount: amount,
                  workday_employee: workday_employee,
                  workday_department: workday_department,
                  workday_position: workday_position,
                  workday_year: workday_year,
                  workday_month: workday_month
                },
                function(data){
                  $("#body_workday").html(data);
          });
        });

        $("#btn-filter").click(function(){
          index = 1;
          var workday_employee = $("#workday_employee").val();
          var workday_department = $("#workday_department").val();
          var workday_position = $("#workday_position").val();
          var workday_year = $("#workday_year").val();
          var workday_month = $("#workday_month").val();
          $.get("page_list.php",
                {
                  page:index,
                  amount: amount,
                  workday_employee: workday_employee,
                  workday_department: workday_department,
                  workday_position: workday_position,
                  workday_year: workday_year,
                  workday_month: workday_month
                },
                function(data){
            $("#body_workday").html(data);
          });
          $.get("page_number_list.php",
                {
                  amount: amount,
                  workday_employee: workday_employee,
                  workday_department: workday_department,
                  workday_position: workday_position,
                  workday_year: workday_year,
                  workday_month: workday_month
                },
                function(data){
            $("#workday-pagenumber").html(data);
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
  </div>
</div>
<?php include '../../inc/footer.php' ?>
