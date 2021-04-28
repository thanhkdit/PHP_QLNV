<?php include '../../classes/contract.php' ?>
<?php
  $contract = new Contract();
  if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $contractId = $_POST['contractId'];
    $employeeId = $_POST['employeeId'];
    $contractType = $_POST['contractType'];
    $signDay = $_POST['signDay'];
    $expirationDate = $_POST['expirationDate'];
    $status = $_POST['status'];

    $insert = $contract->insert_contract($contractId, $employeeId, $contractType, $signDay, $expirationDate, $status);
  }
?>
<?php include '../../inc/header.php' ?>
<div class="body row">
  <?php include '../../inc/sidebar.php' ?>
  <div class="content  col-10 col-sm-9 col-xl-10">
    <h3 class="text-center display-block">Add New Contract</h3>
    <?php
      if(isset($insert)){
        echo $insert;
      }
    ?>
    <form  id="add-contract" class="mx-auto" action="add.php" method="post">
      <div class="form-group row">
        <label class="col-sm-4 col-form-label">Contract Id</label>
        <div class="col-sm-4">
          <input type="text" class="form-control" id="add-contractId" name="contractId" onkeyup="checkContract()">
        </div>
      </div>
      <div class="form-group row">
        <label class="col-sm-4 col-form-label">Employee Id</label>
        <div class="col-sm-4">
          <input type="text" id="contract-select" class="input-select form-control col-sm-4" name="employeeId" value="">
          <select class="form-control col-sm-8" onchange="showContract(this.value)">
            <option selected value="">Choose...</option>
            <?php
              $show = $contract->show('t_Information_of_employee');
              if($show){
                while($result = $show->fetch_assoc()){
            ?>
            <option value="<?php echo $result['Employee_id']?>"><?php echo $result['Employee_id']." - ".$result['Fullname']; ?></option>
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
          <input type="date" class="form-control" name="signDay">
        </div>
      </div>
      <div class="form-group row">
        <label class="col-sm-4 col-form-label">Expiration Date</label>
        <div class="col-sm-4">
          <input type="date" class="form-control" name="expirationDate">
        </div>
      </div>
      <div class="form-group row">
        <label class="col-sm-4 col-form-label">Status</label>
        <div class="col-sm-4">
          <select class="form-control" name="status">
            <option type="number" value=1 selected>1 - Effective</option>
            <option type="number" value=0>0 - Invalid</option>
          </select>
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
