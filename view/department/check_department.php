<?php
  include '../../lib/database.php';
  $database = new Database();
  $departmentId = $_GET['departmentId'];
  $sql = "SELECT Department_id FROM t_Department WHERE Department_id = '$departmentId'";
  $rs = $database->select($sql);
  $check = false;
  if ($rs){
    while($row = $rs->fetch_assoc()){
      if ($departmentId == $row["Department_id"]){
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
