<?php
  include '../../lib/database.php';
  $database = new Database();
  $where = $_GET['page'];
  $amount =$_GET['amount'];
  $employeeId = empty($_GET['workday_employeeId'])?'%':$_GET['workday_employeeId'];
  $fullname = empty($_GET['workday_employee'])?'%':$_GET['workday_employee'];
  $department = empty($_GET['workday_department'])?'%':$_GET['workday_department'];
  $position = empty($_GET['workday_position'])?'%':$_GET['workday_position'];
  settype($page,"int");
  $start = ($where - 1) * $amount;
  $rs = $database->filter_employee_limit($employeeId, $fullname, '%', $department, $position, '%', '%', '%', '30000101', '1', $start, $amount);
  $i = $start;
  if ($rs){
    while($row = $rs->fetch_assoc()){
      $i++;
      echo "
        <tr>
          <td class='py-3'>".$i."<input type='text' hidden name='size' value='".$amount."'></td>
          <td class='py-3'>".$row["Employee_id"]."<input type='text' hidden name='employeeId"."$i"."' value='".$row["Employee_id"]."'></td>
          <td class='py-3'>".$row["Fullname"]."</td>
          <td class='py-3'>".$row["Department_name"]."</td>
          <td class='py-3'>".$row["Position_name"]."</td>
          <td class='py-3'><input type=number name='dayWorked".$i."' size=5 class='form-control' min=0 max=31></td>
          <td class='py-3'><input type=number name='overtime".$i."' size=5 class='form-control' min=0 max=100></td>
        </tr>
      ";
    }
  }
  echo "<tr><td><input type=hidden value='".$i."' name='size'></td></tr>"
?>
