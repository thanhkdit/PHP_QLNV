<?php include '../../classes/bonus_info.php' ?>
<?php
  $bonusInfo = new Bonus_info();
  if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if (isset($_POST['btnSubmit'])) // Kiểm tra nút có giá trị dữ liệu
    {
        if($_POST['btnSubmit'] == '+')
        {
          $year = $_POST['year'];
          $insert = $bonusInfo->insert_year($year);
        }

        if($_POST['btnSubmit'] == 'Insert')
        {
          $employeeId = $_POST['employeeId'];
          $bonusId = $_POST['bonusId'];
          $salaryMonth = $_POST['salaryMonth'];
          $salaryYear = $_POST['salaryYear'];

          $insert = $bonusInfo->insert_bonus_info($employeeId, $bonusId, $salaryMonth, $salaryYear);
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
          <td><input type="number" class="form-control" name="year" size="5" placeholder="Year" min=1></td>
          <td>----</td>
          <td><input type="submit" class="btn btn-success" name="btnSubmit" value="+"></td>
        </tr>
      </table>
    </form>
    <h3 class="text-center display-block">Insert Bonus Infomation</h3>
    <?php
      if(isset($insert)){
        echo $insert;
      }
    ?>
    <form  id="add-bonusInfo" class="mx-auto" action="" method="post">
      <div class="form-group row">
        <label class="col-sm-4 col-form-label">Employee Id</label>
        <div class="col-sm-4">
          <input type="text" id="employee-select" class="input-select form-control col-sm-4" name="employeeId">
          <select class="form-control col-sm-8" onchange="showEmployee(this.value)">
            <option selected value="">Choose...</option>
            <?php
              $show = $bonusInfo->show('t_Information_of_employee');
              if($show){
                while($rs = $show->fetch_assoc()){
            ?>
            <option value="<?php echo $rs['Employee_id']?>"><?php echo $rs['Employee_id']." - ".$rs['Fullname']; ?></option>
            <?php
                }
              }
             ?>
          </select>
        </div>
      </div>
      <div class="form-group row">
        <label class="col-sm-4 col-form-label">Bonus Id</label>
        <div class="col-sm-4">
          <input type="text" id="bonus-select" class="input-select form-control col-sm-4" name="bonusId">
          <select class="form-control col-sm-8" onchange="showBonusInfo(this.value)">
            <option selected value="">Choose...</option>
            <?php
              $show = $bonusInfo->show('t_Bonus_detail');
              if($show){
                while($rs = $show->fetch_assoc()){
            ?>
            <option value="<?php echo $rs['Bonus_id']?>"><?php echo $rs['Bonus_id']." - ".$rs['Bonus_reason']; ?></option>
            <?php
                }
              }
             ?>
          </select>
        </div>
      </div>
      <div class="form-group row">
        <label class="col-sm-4 col-form-label">Salary Month</label>
        <div class="col-sm-4">
          <input type="number" class="form-control" name="salaryMonth" min=1 max=12>
        </div>
      </div>
      <div class="form-group row">
        <label class="col-sm-4 col-form-label">Salary Year</label>
        <div class="col-sm-4">
          <input type="number" id="year-select" class="input-select form-control col-sm-4" name="salaryYear" min=1>
          <select class="form-control col-sm-8" onchange="showYear(this.value)">
            <option selected value="">Choose...</option>
            <?php
              $show = $bonusInfo->show('t_Salary_year');
              if($show){
                while($rs = $show->fetch_assoc()){
            ?>
            <option value="<?php echo $rs['Salary_year']?>"><?php echo $rs['Salary_year']?></option>
            <?php
                }
              }
             ?>
          </select>
        </div>
      </div>
      <div class="mt-4 button">
        <input type="submit" class="btn btn-success ml-2" name="btnSubmit" value="Insert">
        <input type="reset" class="btn btn-warning ml-2" value="Reset">
        <a href="list.php" class="btn btn-secondary ml-2">Back</a>
      </div>
    </form>

  </div>
</div>
<?php include '../../inc/footer.php' ?>
