<?php include '../../classes/department.php' ?>
<?php
  $department = new Department();
  if(!isset($_GET['editid']) || $_GET['editid'] == NULL){
    echo "<script>window.location = 'list.php'</script>";
  }
  else{
    $departmentId = $_GET['editid'];

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
      $departmentName = $_POST['departmentName'];
      $coefficientsSalary = $_POST['coefficientsSalary'];

      $update = $department->update_department($departmentName, $coefficientsSalary, $departmentId);
    }
  }
?>
<?php include '../../inc/header.php' ?>
<div class="body row">
  <?php include '../../inc/sidebar.php' ?>
  <div class="content  col-10 col-sm-9 col-xl-10">
    <h3 class="text-center display-block">Edit Department</h3>
    <?php
      if(isset($update)){
        echo $update;
      }
    ?>
    <?php
      $get_department = $department->get_department_by_id($departmentId);
      if($get_department){
        while($result = $get_department->fetch_assoc()){
    ?>
    <form  id="update-department" class="mx-auto" action="" method="post">
      <div class="form-group row">
        <label class="col-sm-4 col-form-label">Department Id</label>
        <div class="col-sm-4">
          <input type="text" disabled class="form-control" name="departmentId" value="<?php echo $departmentId; ?>">
        </div>
      </div>
      <div class="form-group row">
        <label class="col-sm-4 col-form-label">Department Name</label>
        <div class="col-sm-4">
          <input type="text" class="form-control" name="departmentName" value="<?php echo $result['Department_name']; ?>">
        </div>
      </div>
      <div class="form-group row">
        <label class="col-sm-4 col-form-label">Coeficients Salary</label>
        <div class="col-sm-4">
          <input type="number" class="form-control" name="coefficientsSalary" min=1 value="<?php echo $result['Coefficients_salary']; ?>">
        </div>
      </div>
      <?php
        }
      }
      ?>
      <div class="mt-4 button">
        <input type="submit" class="btn btn-success ml-2" value="Save">
        <input type="reset" class="btn btn-warning ml-2" value="Reset">
        <a href="list.php" class="btn btn-secondary ml-2">Back</a>
      </div>
    </form>

  </div>
</div>
<?php include '../../inc/footer.php' ?>
