<?php include '../../classes/fine_detail.php' ?>
<?php
  $fine_detail = new Fine_detail();
  if(!isset($_GET['editid']) || $_GET['editid'] == NULL){
    echo "<script>window.location = 'list.php'</script>";
  }
  else{
    $fineId = $_GET['editid'];

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
      $fineReason = $_POST['fineReason'];
      $fine = $_POST['fine'];

      $update = $fine_detail->update_fine_detail($fineReason, $fine, $fineId);
    }
  }
?>
<?php include '../../inc/header.php' ?>
<div class="body row">
  <?php include '../../inc/sidebar.php' ?>
  <div class="content  col-10 col-sm-9 col-xl-10">
    <h3 class="text-center display-block">Edit Fine Detail</h3>
    <?php
      if(isset($update)){
        echo $update;
      }
    ?>
    <?php
      $get_fine_detail = $fine_detail->get_fine_detail_by_id($fineId);
      if($get_fine_detail){
        while($result = $get_fine_detail->fetch_assoc()){
    ?>
    <form  id="update-fineDetail" class="mx-auto" action="" method="post">
      <div class="form-group row">
        <label class="col-sm-4 col-form-label">Fine Id</label>
        <div class="col-sm-4">
          <input type="text" disabled class="form-control" name="fineId" value="<?php echo $fineId; ?>">
        </div>
      </div>
      <div class="form-group row">
        <label class="col-sm-4 col-form-label">Fine Name</label>
        <div class="col-sm-4">
          <input type="text" class="form-control" name="fineReason" value="<?php echo $result['Fine_reason']; ?>">
        </div>
      </div>
      <div class="form-group row">
        <label class="col-sm-4 col-form-label">Fine</label>
        <div class="col-sm-4">
          <input type="number" class="form-control" name="fine" min=10000 value="<?php echo $result['Fine']; ?>">
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
