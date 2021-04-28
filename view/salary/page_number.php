<?php
  include '../../lib/database.php';
  $database = new Database();
  $amount =$_GET['amount'];
  $employee = empty($_GET['salary_employee'])?'%':$_GET['salary_employee'];
  $department = empty($_GET['salary_department'])?'%':$_GET['salary_department'];
  $position = empty($_GET['salary_position'])?'%':$_GET['salary_position'];
  $month = empty($_GET['salary_month'])?'%':$_GET['salary_month'];
  $year = empty($_GET['salary_year'])?'%':$_GET['salary_year'];
  $rs = $database->salary_in_month($employee, $department, $position, $month, $year);
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
