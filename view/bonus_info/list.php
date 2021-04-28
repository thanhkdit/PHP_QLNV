<?php include '../../classes/bonus_info.php' ?>
<?php
  $bonus = new Bonus_info();
  if(isset($_GET['delid'])){
    $id = $_GET['delid'];
    $deleted = $bonus->del_bonus_info($id);
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
              <th scope="col">Bonus</th>
              <th scope="col">Year</th>
              <th scope="col">Month</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
            <td>
              <input type="text" id="bonus_employee" name="bonus_employee" class="form-control" size=5>
            </td>
            <td>
              <select class="form-control col-sm-8" id="bonus_department" name="bonus_department" class="form-control">
                <option selected value="">All</option>
                <?php
                  $show = $bonus->show('t_Department');
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
              <select class="form-control col-sm-8" id="bonus_bonus" name="bonus_bonus">
                <option selected value="">All</option>
                <?php
                  $show = $bonus->show('t_Bonus_detail');
                  if($show){
                    while($result = $show->fetch_assoc()){
                ?>
                <option value="<?php echo $result['Bonus_id']?>"><?php echo $result['Bonus_id']." - ".$result['Bonus_reason']; ?></option>
                <?php
                    }
                  }
                 ?>
              </select>
            </td>
            <td>
              <select class="form-control col-sm-8" id="bonus_year" name="bonus_year">
                <option selected value="">All</option>
                <?php
                  $show = $bonus->show('t_Salary_year');
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
              <select class="form-control col-sm-8" id="bonus_month" name="bonus_month">
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
    <h3 class="text-center display-block">Bonus List</h3>
    <?php
      if(isset($deleted)){
        echo $deleted;
      }
    ?>
    <table id="list-bonusInfo" class="table table-striped">
      <thead class="thead-dark">
        <tr>
          <th scope="col">Ordinal</th>
          <th scope="col">Id</th>
          <th scope="col">Fullname</th>
          <th scope="col">Department</th>
          <th scope="col">Position</th>
          <th scope="col">Bonus's reason</th>
          <th scope="col">Bonus</th>
          <th scope="col">Action</th>
        </tr>
      </thead>
      <tbody id="body_bonus">

        <!-- Chèn nội dung ajax ở đây -->

      </tbody>
    </table>
    <nav aria-label="Page navigation example">
      <ul class="pagination justify-content-center" id="bonus-pagenumber">

        <!-- Chèn nội dung ajax ở đây -->

      </ul>
    </nav>
    <script>
      var index = 1;
      var amount = 5;
      var btnFilter = $("#btn-filter");
      $(document).ready(function(){
        var bonus_employee = $("#bonus_employee").val();
        var bonus_department = $("#bonus_department").val();
        var bonus_bonus = $("#bonus_bonus").val();
        var bonus_year = $("#bonus_year").val();
        var bonus_month = $("#bonus_month").val();
        $.get("page.php",
              {
                page:index,
                amount,
                bonus_employee: bonus_employee,
                bonus_department: bonus_department,
                bonus_bonus: bonus_bonus,
                bonus_year: bonus_year,
                bonus_month: bonus_month
              },
              function(data){
                $("#body_bonus").append(data);
        });

        $.get("page_number.php",
              {
                amount,
                bonus_employee: bonus_employee,
                bonus_department: bonus_department,
                bonus_bonus: bonus_bonus,
                bonus_year: bonus_year,
                bonus_month: bonus_month
              },
              function(data){
          $("#bonus-pagenumber").html(data);
        });

        // Cần nav.on() để load lại nav(nav là cha của page-link) trang sau khi gọi ajax
        $('nav').on('click','.page-link',function(e){
          e.preventDefault();
          var bonus_employee = $("#bonus_employee").val();
          var bonus_department = $("#bonus_department").val();
          var bonus_bonus = $("#bonus_bonus").val();
          var bonus_year = $("#bonus_year").val();
          var bonus_month = $("#bonus_month").val();
          index = Number($(this).text());
          $("li").removeClass('active');
          $(this).parent().addClass('active');
          $.get("page.php",
                {
                  page:index,
                  amount,
                  bonus_employee: bonus_employee,
                  bonus_department: bonus_department,
                  bonus_bonus: bonus_bonus,
                  bonus_year: bonus_year,
                  bonus_month: bonus_month
                },
                function(data){
                  $("#body_bonus").html(data);
          });
        });

        $("#btn-filter").click(function(){
          index = 1;
          var bonus_employee = $("#bonus_employee").val();
          var bonus_department = $("#bonus_department").val();
          var bonus_bonus = $("#bonus_bonus").val();
          var bonus_year = $("#bonus_year").val();
          var bonus_month = $("#bonus_month").val();
          $.get("page.php",
                {
                  page:index,
                  amount,
                  bonus_employee: bonus_employee,
                  bonus_department: bonus_department,
                  bonus_bonus: bonus_bonus,
                  bonus_year: bonus_year,
                  bonus_month: bonus_month
                },
                function(data){
            $("#body_bonus").html(data);
          });
          $.get("page_number.php",
                {
                  amount,
                  bonus_employee: bonus_employee,
                  bonus_department: bonus_department,
                  bonus_bonus: bonus_bonus,
                  bonus_year: bonus_year,
                  bonus_month: bonus_month
                },
                function(data){
            $("#bonus-pagenumber").html(data);
          });
        });
      });

      // Thực hiện function sau khi ajax dừng lại, không thực hiện khi vừa tải trang(ajax chưa đuợc gọi) (document.ready)

      // $( document ).ajaxStop(function() {
      //   $(".page-link").click(function(){
      //     var bonus_employee = $("#bonus_employee").val();
      //     var bonus_department = $("#bonus_department").val();
      //     var bonus_bonus = $("#bonus_bonus").val();
      //     var bonus_year = $("#bonus_year").val();
      //     var bonus_month = $("#bonus_month").val();
      //     index = Number($(this).text());
      //     $("li").removeClass('active');
      //     $(this).parent().addClass('active');
      //     $.get("page.php",
      //           {
      //             page:index,
      //             bonus_employee: bonus_employee,
      //             bonus_department: bonus_department,
      //             bonus_bonus: bonus_bonus,
      //             bonus_year: bonus_year,
      //             bonus_month: bonus_month
      //           },
      //           function(data){
      //             $("#body_bonus").html(data);
      //     });
      //   });
      // });
    </script>
  </div>
</div>
<?php include '../../inc/footer.php' ?>
