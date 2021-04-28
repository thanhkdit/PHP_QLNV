<?php
  include '../../lib/database.php';
  $database = new Database();
  $amount = $_GET['amount'];
  $employee = empty($_GET['bonus_employee'])?'%':$_GET['bonus_employee'];
  $department = empty($_GET['bonus_department'])?'%':$_GET['bonus_department'];
  $bonus = empty($_GET['bonus_bonus'])?'%':$_GET['bonus_bonus'];
  $salaryMonth = empty($_GET['bonus_month'])?'%':$_GET['bonus_month'];
  $salaryYear = empty($_GET['bonus_year'])?'%':$_GET['bonus_year'];
  $rs = $database->filter_employee_bonus($employee, $department, $bonus, $salaryMonth, $salaryYear);
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
