<?php include '../../classes/salary.php' ?>
<?php
  $salary = new Salary();
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
              <input type="text" id="salary_employee" class="form-control" size=5>
            </td>
            <td>
              <select class="form-control col-sm-8" id="salary_department">
                <option selected value="">All</option>
                <?php
                  $show = $salary->show('t_Department');
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
              <select class="form-control col-sm-8" id="salary_position">
                <option selected value="">All</option>
                <?php
                  $show = $salary->show('t_Position');
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
              <select class="form-control col-sm-8" id="salary_year">
                <option selected value="">All</option>
                <?php
                  $show = $salary->show('t_Salary_year');
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
              <select class="form-control col-sm-8" id="salary_month">
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
    <h3 class="text-center display-block">Salary List</h3>
    <table id="list-salary" class="table table-striped">
      <thead class="thead-dark">
        <tr>
          <th scope="col">Ordinal</th>
          <th scope="col">Id</th>
          <th scope="col">Fullname</th>
          <th scope="col">Department</th>
          <th scope="col">Position</th>
          <th scope="col">Month</th>
          <th scope="col">Year</th>
          <th scope="col">Salary</th>
        </tr>
      </thead>
      <tbody id="body_salary">

          <!-- Chèn nội dung ajax ở đây -->

      </tbody>
    </table>
    <nav aria-label="Page navigation example">
      <ul class="pagination justify-content-center" id="salary-pagenumber">

        <!-- Chèn nội dung ajax ở đây -->

      </ul>
    </nav>
    <script>
      var index = 1;
      var amount = 5;
      var btnFilter = $("#btn-filter");
      $(document).ready(function(){
        var salary_employee = $("#salary_employee").val();
        var salary_department = $("#salary_department").val();
        var salary_position = $("#salary_position").val();
        var salary_year = $("#salary_year").val();
        var salary_month = $("#salary_month").val();
        $.get("page.php",
              {
                page: index,
                amount: amount,
                salary_employee: salary_employee,
                salary_department: salary_department,
                salary_position: salary_position,
                salary_year: salary_year,
                salary_month: salary_month
              },
              function(data){
                $("#body_salary").append(data);
        });

        $.get("page_number.php",
              {
                amount: amount,
                salary_employee: salary_employee,
                salary_department: salary_department,
                salary_position: salary_position,
                salary_year: salary_year,
                salary_month: salary_month
              },
              function(data){
          $("#salary-pagenumber").html(data);
        });

        // Cần nav.on() để load lại nav(nav là cha của page-link) trang sau khi gọi ajax
        $('nav').on('click','.page-link',function(e){
        	e.preventDefault();
          var salary_employee = $("#salary_employee").val();
          var salary_department = $("#salary_department").val();
          var salary_position = $("#salary_position").val();
          var salary_year = $("#salary_year").val();
          var salary_month = $("#salary_month").val();
          index = Number($(this).text());
          $("li").removeClass('active');
          $(this).parent().addClass('active');
          $.get("page.php",
                {
                  page:index,
                  amount: amount,
                  salary_employee: salary_employee,
                  salary_department: salary_department,
                  salary_position: salary_position,
                  salary_year: salary_year,
                  salary_month: salary_month
                },
                function(data){
                  $("#body_salary").html(data);
          });
        });

        $("#btn-filter").click(function(){
          index = 1;
          var salary_employee = $("#salary_employee").val();
          var salary_department = $("#salary_department").val();
          var salary_position = $("#salary_position").val();
          var salary_year = $("#salary_year").val();
          var salary_month = $("#salary_month").val();
          $.get("page.php",
                {
                  page:index,
                  amount: amount,
                  salary_employee: salary_employee,
                  salary_department: salary_department,
                  salary_position: salary_position,
                  salary_year: salary_year,
                  salary_month: salary_month
                },
                function(data){
            $("#body_salary").html(data);
          });
          $.get("page_number.php",
                {
                  amount: amount,
                  salary_employee: salary_employee,
                  salary_department: salary_department,
                  salary_position: salary_position,
                  salary_year: salary_year,
                  salary_month: salary_month
                },
                function(data){
            $("#salary-pagenumber").html(data);
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
