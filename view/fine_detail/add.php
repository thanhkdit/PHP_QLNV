<?php include '../../classes/fine_detail.php' ?>
<?php
  $fine_detail = new Fine_detail();
  if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $fineName = $_POST['fineName'];
    $fine = $_POST['fine'];

    $insert = $fine_detail->insert_fine_detail($fineName, $fine);
  }
?>
<?php include '../../inc/header.php' ?>
<div class="body row">
  <?php include '../../inc/sidebar.php' ?>
  <div class="content  col-10 col-sm-9 col-xl-10">
    <h3 class="text-center display-block">Add New Fine Detail</h3>
    <?php
      if(isset($insert)){
        echo $insert;
      }
    ?>
    <form  id="add-fineDetail" class="mx-auto" action="add.php" method="post">
      <div class="form-group row">
        <label class="col-sm-4 col-form-label">Fine Name</label>
        <div class="col-sm-4">
          <input type="text" class="form-control" name="fineName">
        </div>
      </div>
      <div class="form-group row">
        <label class="col-sm-4 col-form-label">Fine</label>
        <div class="col-sm-4">
          <input type="number" class="form-control" name="fine" min=10000>
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
