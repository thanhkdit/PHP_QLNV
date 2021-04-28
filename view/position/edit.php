<?php include '../../classes/position.php' ?>
<?php
  $position = new Position();
  if(!isset($_GET['editid']) || $_GET['editid'] == NULL){
    echo "<script>window.location = 'list.php'</script>";
  }
  else{
    $positionId = $_GET['editid'];

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
      $positionName = $_POST['positionName'];
      $basicSalary = $_POST['basicSalary'];

      $update = $position->update_position($positionName, $basicSalary, $positionId);
    }
  }
?>
<?php include '../../inc/header.php' ?>
<div class="body row">
  <?php include '../../inc/sidebar.php' ?>
  <div class="content  col-10 col-sm-9 col-xl-10">
    <h3 class="text-center display-block">Edit Position</h3>
    <?php
      if(isset($update)){
        echo $update;
      }
    ?>
    <?php
      $get_position = $position->get_position_by_id($positionId);
      if($get_position){
        while($result = $get_position->fetch_assoc()){
    ?>
    <form  id="update-position" class="mx-auto" action="" method="post">
      <div class="form-group row">
        <label class="col-sm-4 col-form-label">Position Id</label>
        <div class="col-sm-4">
          <input type="text" disabled class="form-control" name="positionId" value="<?php echo $positionId; ?>">
        </div>
      </div>
      <div class="form-group row">
        <label class="col-sm-4 col-form-label">Position Name</label>
        <div class="col-sm-4">
          <input type="text" class="form-control" name="positionName" value="<?php echo $result['Position_name']; ?>">
        </div>
      </div>
      <div class="form-group row">
        <label class="col-sm-4 col-form-label">Basic Salary</label>
        <div class="col-sm-4">
          <input type="number" class="form-control" name="basicSalary" min=10000 value="<?php echo $result['Basic_salary']; ?>">
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
