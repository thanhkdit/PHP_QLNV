<?php include '../../classes/position.php' ?>
<?php
  $position = new Position();
  if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $positionId = $_POST['positionId'];
    $positionName = $_POST['positionName'];
    $basicSalary = $_POST['basicSalary'];

    $insert = $position->insert_position($positionId, $positionName, $basicSalary);
  }
?>
<?php include '../../inc/header.php' ?>
<div class="body row">
  <?php include '../../inc/sidebar.php' ?>
  <div class="content  col-10 col-sm-9 col-xl-10">
    <h3 class="text-center display-block">Add New Position</h3>
    <?php
      if(isset($insert)){
        echo $insert;
      }
    ?>
    <form  id="add-position" class="mx-auto" action="add.php" method="post">
      <div class="form-group row">
        <label class="col-sm-4 col-form-label">Position Id</label>
        <div class="col-sm-4">
          <input type="text" class="form-control" id="add-positionId" name="positionId" onkeyup="checkPosition()">
        </div>
      </div>
      <div class="form-group row">
        <label class="col-sm-4 col-form-label">Position Name</label>
        <div class="col-sm-4">
          <input type="text" class="form-control" name="positionName">
        </div>
      </div>
      <div class="form-group row">
        <label class="col-sm-4 col-form-label">Basic Salary</label>
        <div class="col-sm-4">
          <input type="number" class="form-control" name="basicSalary" min=10000>
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
