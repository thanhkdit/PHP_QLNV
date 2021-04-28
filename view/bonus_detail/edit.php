<?php include '../../classes/bonus_detail.php' ?>
<?php
  $bonus_detail = new Bonus_detail();
  if(!isset($_GET['editid']) || $_GET['editid'] == NULL){
    echo "<script>window.location = 'list.php'</script>";
  }
  else{
    $bonusId = $_GET['editid'];

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
      $bonusReason = $_POST['bonusReason'];
      $bonus = $_POST['bonus'];

      $update = $bonus_detail->update_bonus_detail($bonusReason, $bonus, $bonusId);
    }
  }
?>
<?php include '../../inc/header.php' ?>
<div class="body row">
  <?php include '../../inc/sidebar.php' ?>
  <div class="content  col-10 col-sm-9 col-xl-10">
    <h3 class="text-center display-block">Edit Bonus Detail</h3>
    <?php
      if(isset($update)){
        echo $update;
      }
    ?>
    <?php
      $get_bonus_detail = $bonus_detail->get_bonus_detail_by_id($bonusId);
      if($get_bonus_detail){
        while($result = $get_bonus_detail->fetch_assoc()){
    ?>
    <form  id="update-bonusDetail" class="mx-auto" action="" method="post">
      <div class="form-group row">
        <label class="col-sm-4 col-form-label">Bonus Id</label>
        <div class="col-sm-4">
          <input type="text" disabled class="form-control" name="bonusId" value="<?php echo $bonusId; ?>">
        </div>
      </div>
      <div class="form-group row">
        <label class="col-sm-4 col-form-label">Bonus Name</label>
        <div class="col-sm-4">
          <input type="text" class="form-control" name="bonusReason" value="<?php echo $result['Bonus_reason']; ?>">
        </div>
      </div>
      <div class="form-group row">
        <label class="col-sm-4 col-form-label">Bonus</label>
        <div class="col-sm-4">
          <input type="number" class="form-control" name="bonus" min=10000 value="<?php echo $result['Bonus']; ?>">
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
