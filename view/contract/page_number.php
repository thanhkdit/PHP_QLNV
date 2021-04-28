<?php
  include '../../lib/database.php';
  $database = new Database();
  $amount = $_GET['amount'];
  $employeeId = empty($_GET['employeeId'])?'%':$_GET['employeeId'];
  $contractId = empty($_GET['contractId'])?'%':$_GET['contractId'];
  $rs = $database->filter_employee($employeeId, '%', '%', '%', '%', '%', $contractId, '%', '30000101', '%');
  if ($rs){
    $num = $rs->num_rows;
      $totalPage = ceil($num / $amount);
      echo "<li class='page-item active'><button class='page-link'>1</button></li>";
      for ($i = 1;$i<$totalPage;$i++){
        echo "<li class='page-item'><button class='page-link'>".($i+1)."</button></li>";
      }
    }
  else{
    echo "<p class='alert alert-warning'>Khong co du lieu</p>";
  }

?>
