<?php
  include '../../lib/database.php';
  $database = new Database();
  $positionId = $_GET['positionId'];
  $sql = "SELECT Position_id FROM t_Position WHERE Position_id = '$positionId'";
  $rs = $database->select($sql);
  $check = false;
  if ($rs){
    while($row = $rs->fetch_assoc()){
      if ($positionId == $row["Position_id"]){
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
