<?php
  include '../../lib/database.php';
  $database = new Database();
  $amount =$_GET['amount'];
  $employee = empty($_GET['workday_employee'])?'%':$_GET['workday_employee'];
  $department = empty($_GET['workday_department'])?'%':$_GET['workday_department'];
  $position = empty($_GET['workday_position'])?'%':$_GET['workday_position'];
  $month = empty($_GET['workday_month'])?'%':$_GET['workday_month'];
  $year = empty($_GET['workday_year'])?'%':$_GET['workday_year'];
  $rs = $database->filter_employee_workday($employee, $department, $position, $month, $year);
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
