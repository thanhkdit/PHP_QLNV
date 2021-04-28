<?php
  include '../../lib/database.php';
  $database = new Database();
  $levelId = $_GET['levelId'];
  $sql = "SELECT Level_id FROM t_Level WHERE Level_id = '$levelId'";
  $rs = $database->select($sql);
  $check = false;
  if ($rs){
    while($row = $rs->fetch_assoc()){
      if ($levelId == $row["Level_id"]){
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
