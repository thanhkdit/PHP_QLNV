<?php
  include '../../lib/database.php';
  $database = new Database();
  $employeeId = $_GET['employeeId'];
  $sql = "SELECT Employee_id FROM t_Information_of_employee WHERE Employee_id = '$employeeId'";
  $rs = $database->select($sql);
  $check = false;
  if ($rs){
    while($row = $rs->fetch_assoc()){
      if ($employeeId == $row["Employee_id"]){
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
