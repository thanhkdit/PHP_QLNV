<?php
  include '../../lib/database.php';
  $database = new Database();
  $amount = $_GET['amount'];
  $id = empty($_GET['employee_id'])?'%':$_GET['employee_id'];
  $employee = empty($_GET['employee_employee'])?'%':$_GET['employee_employee'];
  $gender = empty($_GET['employee_gender'])?'%':$_GET['employee_gender'];
  $department = empty($_GET['employee_department'])?'%':$_GET['employee_department'];
  $position = empty($_GET['employee_position'])?'%':$_GET['employee_position'];
  $level = empty($_GET['employee_level'])?'%':$_GET['employee_level'];
  $type = empty($_GET['employee_type'])?'%':$_GET['employee_type'];
  $status = empty($_GET['employee_status'])?'%':$_GET['employee_status'];
  if ($status == '2'){
    $status = '0';
  }
  $expirationDate = empty($_GET['employee_expirationDate'])?'30000101':$_GET['employee_expirationDate'];
  $contractId = '%';
  $rs = $database->filter_employee($id, $employee, $gender, $department, $position, $level, $contractId, $type, $expirationDate, $status);
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
