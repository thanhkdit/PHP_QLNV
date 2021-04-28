<?php
  include '../../lib/database.php';
  $database = new Database();
  $contractId = $_GET['contractId'];
  $sql = "SELECT Contract_id FROM t_Contract WHERE Contract_id = '$contractId'";
  $rs = $database->select($sql);
  $check = false;
  if ($rs){
    while($row = $rs->fetch_assoc()){
      if ($contractId == $row["Contract_id"]){
        echo "taken";
        $check = true;
        break;
      }
    }
  }
  if (!$check){
    echo "not_taken";
  }

?>
