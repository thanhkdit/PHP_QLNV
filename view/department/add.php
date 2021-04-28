<?php include '../../classes/department.php' ?>
<?php
  $department = new Department();
  if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $departmentId = $_POST['departmentId'];
    $departmentName = $_POST['departmentName'];
    $coefficientsSalary = $_POST['coefficientsSalary'];

    $insert = $department->insert_department($departmentId, $departmentName, $coefficientsSalary);
  }
?>
<?php include '../../inc/header.php' ?>
<div class="body row">
  <?php include '../../inc/sidebar.php' ?>
  <div class="content  col-10 col-sm-9 col-xl-10">
    <h3 class="text-center display-block">Add New Department</h3>
    <?php
      if(isset($insert)){
        echo $insert;
      }
    ?>
    <form  id="add-department" class="mx-auto" action="add.php" method="post">
      <div class="form-group row">
        <label class="col-sm-4 col-form-label">Department Id</label>
        <div class="col-sm-4">
          <input type="text" class="form-control" id="add-departmentId" name="departmentId" onkeyup="checkDepartment()">
        </div>
      </div>
      <div class="form-group row">
        <label class="col-sm-4 col-form-label">Department Name</label>
        <div class="col-sm-4">
          <input type="text" class="form-control" name="departmentName">
        </div>
      </div>
      <div class="form-group row">
        <label class="col-sm-4 col-form-label">Coeficients Salary</label>
        <div class="col-sm-4">
          <input type="number" class="form-control" name="coefficientsSalary" min=1>
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
