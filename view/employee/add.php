<?php include '../../classes/employee.php' ?>
<?php
  $employee = new Employee();
  if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $employeeId = isset($_POST['employeeId'])?$_POST['employeeId']:"";
    $fullname = isset($_POST['fullname'])?$_POST['fullname']:"";
    $gender = isset($_POST['gender'])?$_POST['gender']:"";
    $positionId = isset($_POST['positionId'])?$_POST['positionId']:"";
    $departmentId = isset($_POST['departmentId'])?$_POST['departmentId']:"";
    $levelId = isset($_POST['levelId'])?$_POST['levelId']:"";
    $contractId = isset($_POST['contractId'])?$_POST['contractId']:"";
    $contractType = isset($_POST['contractType'])?$_POST['contractType']:"";
    $signDay = isset($_POST['signDay'])?$_POST['signDay']:"";
    $expirationDate = isset($_POST['expirationDate'])?$_POST['expirationDate']:"";
    $status = isset($_POST['status'])?$_POST['status']:"";

    $insert = $employee->insert_employee($employeeId, $fullname, $gender, $positionId, $departmentId, $levelId, $contractId, $contractType, $signDay, $expirationDate, $status);
  }
?>
<?php include '../../inc/header.php' ?>
<div class="body row">
  <?php include '../../inc/sidebar.php' ?>
  <div class="content  col-10 col-sm-9 col-xl-10">
    <h3 class="text-center display-block">Add New Employee</h3>
    <?php
      if(isset($insert)){
        echo $insert;
      }
    ?>
    <form  id="add-employee" class="mx-auto" action="add.php" method="post">
      <div class="form-group row">
        <label class="col-sm-4 col-form-label">Employee Id</label>
        <div class="col-sm-4">
          <input type="text" class="form-control" id="add-employeeId" name="employeeId" onkeyup="checkEmployee()">
        </div>
      </div>
      <div class="form-group row">
        <label class="col-sm-4 col-form-label">Fullname</label>
        <div class="col-sm-4">
          <input type="text" class="form-control" name="fullname">
        </div>
      </div>
      <div class="form-group row">
        <label class="col-sm-4 col-form-label">Gender</label>
        <div class="col-sm-4">
          <select class="form-control" name="gender">
            <option selected value="">Choose...</option>
            <option value="Nam">Nam</option>
            <option value="Nữ">Nữ</option>
            <option value="Khác">Khác</option>
          </select>
        </div>
      </div>
      <div class="form-group row">
        <label class="col-sm-4 col-form-label">Position Id</label>
        <div class="col-sm-4">
          <input type="text" id="position-select" class="input-select form-control col-sm-4" name="positionId" value="">
          <select class="form-control col-sm-8" onchange="showPosition(this.value)">
            <option selected value="">Choose...</option>
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
        </div>
      </div>
      <div class="form-group row">
        <label class="col-sm-4 col-form-label">Department Id</label>
        <div class="col-sm-4">
          <input type="text" id="department-select" class="input-select form-control col-sm-4" name="departmentId" value="">
          <select class="form-control col-sm-8" onchange="showDepartment(this.value)">
            <option selected value="">Choose...</option>
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
        </div>
      </div>
      <div class="form-group row">
        <label class="col-sm-4 col-form-label">Level Id</label>
        <div class="col-sm-4">
          <input type="text" id="level-select" class="input-select form-control col-sm-4" name="levelId" value="">
          <select class="form-control col-sm-8" onchange="showLevel(this.value)">
            <option selected value="">Choose...</option>
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
        </div>
      </div>
      <div class="form-group row">
        <label class="col-sm-4 col-form-label">Contract Id</label>
        <div class="col-sm-4">
          <input type="text" class="form-control" name="contractId" id="add-contractId" onkeyup="checkContract()">
        </div>
      </div>
      <div class="form-group row">
        <label class="col-sm-4 col-form-label">Type Of Contract</label>
        <div class="col-sm-4">
          <select class="form-control" name="contractType">
            <option value="" selected>Choose...</option>
            <option value="Không xác định thời hạn">Không xác định thời hạn</option>
            <option value="Có xác định thời hạn">Có xác định thời hạn</option>
            <option value="Hợp đồng thời vụ">Hợp đồng thời vụ</option>
          </select>
        </div>
      </div>
      <div class="form-group row">
        <label class="col-sm-4 col-form-label">Sign Day</label>
        <div class="col-sm-4">
          <input type="date" class="form-control" name="signDay">
        </div>
      </div>
      <div class="form-group row">
        <label class="col-sm-4 col-form-label">Expiration Date</label>
        <div class="col-sm-4">
          <input type="date" class="form-control" name="expirationDate">
        </div>
      </div>
      <div class="form-group row">
        <label class="col-sm-4 col-form-label">Status</label>
        <div class="col-sm-4">
          <select class="form-control" name="status">
            <option type="number" value=1 selected>1 - Effective</option>
            <option type="number" value=0>0 - Invalid</option>
          </select>
        </div>
      </div>
      <div class="mt-4 button">
        <input type="submit" class="btn btn-success ml-2" value="Add">
        <input type="reset" class="btn btn-warning ml-2" value="Reset">
        <a href="list.php" class="btn btn-secondary ml-2">Back</a>
      </div>
    </form>

  </div>
</div>
<?php include '../../inc/footer.php' ?>
