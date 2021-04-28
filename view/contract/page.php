<?php
  include '../../lib/database.php';
  $database = new Database();
  $where = $_GET['page'];
  $amount = $_GET['amount'];
  $employeeId = empty($_GET['employeeId'])?'%':$_GET['employeeId'];
  $contractId = empty($_GET['contractId'])?'%':$_GET['contractId'];
  settype($page,"int");
  $start = ($where - 1) * $amount;
  $rs = $database->filter_employee_limit($employeeId, '%', '%', '%', '%', '%', $contractId, '%', '30000101', '%', $start, $amount);
  $i = $start;
  if ($rs){
    while($row = $rs->fetch_assoc()){
      $i++;
      echo "
        <tr>
          <td class='py-3'>".$i."</td>
          <td class='py-3'>".$row["Contract_id"]."</td>
          <td class='py-3'>".$row["Employee_id"]."</td>
          <td class='py-3'>".$row["Type_of_contract"]."</td>
          <td class='py-3'>".$row["Sign_day"]."</td>
          <td class='py-3'>".$row["Expiration_date"]."</td>
          <td class='py-3'>".$row["Status"]."</td>
          <td>
            <a href='edit.php?editid=".$row["Contract_id"]."'><i class='fas fa-pencil-alt btn btn-primary'></i></a>
            <a href='?delid=".$row["Contract_id"]."' onclick=\"return confirm('Are you want to delete?')\"><i class='fas fa-trash-alt btn btn-danger'></i></a>
          </td>
        </tr>
      ";
    }
  }

?>
