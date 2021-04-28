<?php include '../../classes/level.php' ?>
<?php
  $level = new Level();
  if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $levelId = $_POST['levelId'];
    $levelName = $_POST['levelName'];
    $coefficientsSalary = $_POST['coefficientsSalary'];

    $insert = $level->insert_level($levelId, $levelName, $coefficientsSalary);
  }
?>
<?php include '../../inc/header.php' ?>
<div class="body row">
  <?php include '../../inc/sidebar.php' ?>
  <div class="content  col-10 col-sm-9 col-xl-10">
    <h3 class="text-center display-block">Add New Level</h3>
    <?php
      if(isset($insert)){
        echo $insert;
      }
    ?>
    <form  id="add-level" class="mx-auto" action="add.php" method="post">
      <div class="form-group row">
        <label class="col-sm-4 col-form-label">Level Id</label>
        <div class="col-sm-4">
          <input type="text" class="form-control" id="add-levelId" name="levelId" onkeyup="checkLevel()">
        </div>
      </div>
      <div class="form-group row">
        <label class="col-sm-4 col-form-label">Level</label>
        <div class="col-sm-4">
          <input type="text" class="form-control" name="levelName">
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
