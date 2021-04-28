<?php include '../../classes/contract.php' ?>
<?php
  if(!isset($_GET['editid']) || $_GET['editid'] == NULL){
    echo "<script>window.location = 'list.php'</script>";
  }
?>
<?php
  $contractId = $_GET['editid'];
  $contract = new Contract();
  if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $employeeId = $_POST['employeeId'];
    $contractType = $_POST['contractType'];
    $signDay = $_POST['signDay'];
    $expirationDate = $_POST['expirationDate'];

    $update = $contract->update_contract($employeeId, $contractType, $signDay, $expirationDate, $contractId);
  }
?>
<?php include '../../inc/header.php' ?>
<div class="body row">
  <?php include '../../inc/sidebar.php' ?>
  <div class="content  col-10 col-sm-9 col-xl-10">
    <h3 class="text-center display-block">Edit Contract</h3>
    <?php
      if(isset($update)){
        echo $update;
      }
    ?>
    <?php
      $get_contract = $contract->get_contract_by_id($contractId);
      if($get_contract){
        while($result = $get_contract->fetch_assoc()){
    ?>
    <form  id="update-contract" class="mx-auto" action="" method="post">
      <div class="form-group row">
        <label class="col-sm-4 col-form-label">Contract Id</label>
        <div class="col-sm-4">
          <input disabled type="text" class="form-control" name="contractId" value="<?php echo $contractId ?>">
        </div>
      </div>
      <div class="form-group row">
        <label class="col-sm-4 col-form-label">Employee Id</label>
        <div class="col-sm-4">
          <input type="text" id="employee-select" class="input-select form-control col-sm-4" name="employeeId"  value="<?php echo $result['Employee_id'] ?>">
          <select class="form-control col-sm-8" onchange="showEmployee(this.value)">
            <option selected value="">Choose...</option>
            <?php
              $show = $contract->show('t_Information_of_employee');
              if($show){
                while($rs = $show->fetch_assoc()){
            ?>
            <option value="<?php echo $rs['Employee_id']?>"><?php echo $rs['Employee_id']." - ".$rs['Fullname']; ?></option>
            <?php
                }
              }
             ?>
          </select>
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
          <input type="date" class="form-control" name="signDay" value="<?php echo $result['Sign_day'] ?>">
        </div>
      </div>
      <div class="form-group row">
        <label class="col-sm-4 col-form-label">Expiration Date</label>
        <div class="col-sm-4">
          <input type="date" class="form-control" name="expirationDate" value="<?php echo $result['Expiration_date'] ?>">
        </div>
      </div>
      <?php
        }
      }
       ?>
      <div class="mt-4 button">
        <input type="submit" class="btn btn-success ml-2" value="Update">
        <input type="reset" class="btn btn-warning ml-2" value="Reset">
        <a href="list.php" class="btn btn-secondary ml-2">Back</a>
      </div>
    </form>

  </div>
</div>
<?php include '../../inc/footer.php' ?>
