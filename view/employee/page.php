<?php
  include '../../lib/database.php';
  $database = new Database();
  $where = $_GET['page'];
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
  settype($page,"int");
  $start = ($where - 1) * $amount;
  $rs = $database->filter_employee_limit($id, $employee, $gender, $department, $position, $level, $contractId, $type, $expirationDate, $status, $start, $amount);
  $i = $start;
  if ($rs){
    while($row = $rs->fetch_assoc()){
      $i++;
      echo "
        <tr>
          <td class='py-3'>".$i."</td>
          <td class='py-3'>".$row["Employee_id"]."</td>
          <td class='py-3'>".$row["Fullname"]."</td>
          <td class='py-3'>".$row["Gender"]."</td>
          <td class='py-3'>".$row["Department_name"]."</td>
          <td class='py-3'>".$row["Position_name"]."</td>
          <td class='py-3'>".$row["Level"]."</td>
          <td>
            <a href='edit.php?editid=".$row['Employee_id']."'><i class='fas fa-pencil-alt btn btn-primary'></i></a>
            <a href='?delid=".$row['Employee_id']."' onclick=\"return confirm('Are you want to delete?')\"><i class='fas fa-trash-alt btn btn-danger'></i></a>
          </td>
        </tr>
      ";
    }
  }

?>
