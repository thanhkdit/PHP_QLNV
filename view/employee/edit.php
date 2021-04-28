<?php include '../../classes/employee.php' ?>
<?php
  if(!isset($_GET['editid']) || $_GET['editid'] == NULL){
    echo "<script>window.location = 'list.php'</script>";
  }
?>
<?php
  $employeeId = $_GET['editid'];
  $employee = new Employee();
  if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $fullname = $_POST['fullname'];
    $gender = $_POST['gender'];
    $positionId = $_POST['positionId'];
    $departmentId = $_POST['departmentId'];
    $levelId = $_POST['levelId'];

    $update = $employee->update_employee($fullname, $gender, $positionId, $departmentId, $levelId, $employeeId);
  }
?>
<?php include '../../inc/header.php' ?>
<div class="body row">
  <?php include '../../inc/sidebar.php' ?>
  <div class="content  col-10 col-sm-9 col-xl-10">
    <h3 class="text-center display-block">Edit Employee</h3>
    <?php
      if(isset($update)){
        echo $update;
      }
    ?>
    <?php
      $get_employee = $employee->get_employee_by_id($employeeId);
      if($get_employee){
        while($result = $get_employee->fetch_assoc()){
    ?>
    <form  id="update-employee" class="mx-auto" action="" method="post">
      <div class="form-group row">
        <label class="col-sm-4 col-form-label">Employee Id</label>
        <div class="col-sm-4">
          <input disabled type="text" class="form-control" name="employeeId" value="<?php echo $employeeId ?>">
        </div>
      </div>
      <div class="form-group row">
        <label class="col-sm-4 col-form-label">Fullname</label>
        <div class="col-sm-4">
          <input type="text" class="form-control" name="fullname" value="<?php echo $result['Fullname'] ?>">
        </div>
      </div>
      <div class="form-group row">
        <label class="col-sm-4 col-form-label">Gender</label>
        <div class="col-sm-4">
          <select class="form-control" name="gender">
            <option value="Nam" <?php if ($result['Gender'] == 'Nam') echo "selected" ?>>Nam</option>
            <option value="Nữ" <?php if ($result['Gender'] == 'Nữ') echo "selected" ?>>Nữ</option>
            <option value="Khác" <?php if ($result['Gender'] == 'Khác') echo "selected" ?>>Khác</option>
          </select>
        </div>
      </div>
      <div class="form-group row">
        <label class="col-sm-4 col-form-label">Position Id</label>
        <div class="col-sm-4">
          <input type="text" id="position-select" class="input-select form-control col-sm-4" name="positionId"  value="<?php echo $result['Position_id'] ?>">
          <select class="form-control col-sm-8" onchange="showPosition(this.value)">
            <option selected value="">Choose...</option>
            <?php
              $show = $employee->show('t_Position');
              if($show){
                while($rs = $show->fetch_assoc()){
            ?>
            <option value="<?php echo $rs['Position_id']?>"><?php echo $rs['Position_id']." - ".$rs['Position_name']; ?></option>
            <?php
                }
              }
             ?>
          </select>
        </div>
      </div>
      <div class="form-group row">
        <label class="col-sm-4 col-form-label">Department Id</label>
        <div class="col-sm-4">
          <input type="text" id="department-select" class="input-select form-control col-sm-4" name="departmentId"  value="<?php echo $result['Department_id'] ?>">
          <select class="form-control col-sm-8" onchange="showDepartment(this.value)">
            <option selected value="">Choose...</option>
            <?php
              $show = $employee->show('t_Department');
              if($show){
                while($rs = $show->fetch_assoc()){
            ?>
            <option value="<?php echo $rs['Department_id']?>"><?php echo $rs['Department_id']." - ".$rs['Department_name']; ?></option>
            <?php
                }
              }
             ?>
          </select>
        </div>
      </div>
      <div class="form-group row">
        <label class="col-sm-4 col-form-label">Level Id</label>
        <div class="col-sm-4">
          <input type="text" id="level-select" class="input-select form-control col-sm-4" name="levelId"  value="<?php echo $result['Level_id'] ?>">
          <select class="form-control col-sm-8" onchange="showLevel(this.value)">
            <option selected value="">Choose...</option>
            <?php
              $show = $employee->show('t_Level');
              if($show){
                while($rs = $show->fetch_assoc()){
            ?>
            <option value="<?php echo $rs['Level_id']?>"><?php echo $rs['Level_id']." - ".$rs['Level']; ?></option>
            <?php
                }
              }
             ?>
          </select>
        </div>
      </div>

      <?php
        }
      }
       ?>
      <div class="mt-4 button">
        <input type="submit" class="btn btn-success ml-2" value="Update">
        <input type="reset" class="btn btn-warning ml-2" value="Reset">
        <a href="filter_list.php" class="btn btn-secondary ml-2">Back</a>
      </div>
    </form>

  </div>
</div>
<?php include '../../inc/footer.php' ?>
