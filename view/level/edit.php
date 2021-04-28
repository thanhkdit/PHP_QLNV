<?php include '../../classes/level.php' ?>
<?php
  $level = new Level();
  if(!isset($_GET['editid']) || $_GET['editid'] == NULL){
    echo "<script>window.location = 'list.php'</script>";
  }
  else{
    $levelId = $_GET['editid'];

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
      $levelName = $_POST['levelName'];
      $coefficientsSalary = $_POST['coefficientsSalary'];

      $update = $level->update_level($levelName, $coefficientsSalary, $levelId);
    }
  }
?>
<?php include '../../inc/header.php' ?>
<div class="body row">
  <?php include '../../inc/sidebar.php' ?>
  <div class="content  col-10 col-sm-9 col-xl-10">
    <h3 class="text-center display-block">Edit Level</h3>
    <?php
      if(isset($update)){
        echo $update;
      }
    ?>
    <?php
      $get_level = $level->get_level_by_id($levelId);
      if($get_level){
        while($result = $get_level->fetch_assoc()){
    ?>
    <form  id="update-level" class="mx-auto" action="" method="post">
      <div class="form-group row">
        <label class="col-sm-4 col-form-label">Level Id</label>
        <div class="col-sm-4">
          <input type="text" disabled class="form-control" name="levelId" value="<?php echo $levelId; ?>">
        </div>
      </div>
      <div class="form-group row">
        <label class="col-sm-4 col-form-label">Level</label>
        <div class="col-sm-4">
          <input type="text" class="form-control" name="levelName" value="<?php echo $result['Level']; ?>">
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
