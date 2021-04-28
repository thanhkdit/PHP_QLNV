<?php
  include '../../lib/database.php';
  $database = new Database();
  $amount =$_GET['amount'];
  $id = empty($_GET['workday_employeeId'])?'%':$_GET['workday_employeeId'];
  $employee = empty($_GET['workday_employee'])?'%':$_GET['workday_employee'];
  $department = empty($_GET['workday_department'])?'%':$_GET['workday_department'];
  $position = empty($_GET['workday_position'])?'%':$_GET['workday_position'];
  $rs = $database->filter_employee($id, $employee, '%', $department, $position, '%', '%', '%', '30000101', '1');
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
