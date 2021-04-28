<?php
  include '../../lib/database.php';
  $database = new Database();
  $amount = $_GET['amount'];
  $employee = empty($_GET['fine_employee'])?'%':$_GET['fine_employee'];
  $department = empty($_GET['fine_department'])?'%':$_GET['fine_department'];
  $fine = empty($_GET['fine_fine'])?'%':$_GET['fine_fine'];
  $salaryMonth = empty($_GET['fine_month'])?'%':$_GET['fine_month'];
  $salaryYear = empty($_GET['fine_year'])?'%':$_GET['fine_year'];
  $rs = $database->filter_employee_fine($employee, $department, $fine, $salaryMonth, $salaryYear);
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
