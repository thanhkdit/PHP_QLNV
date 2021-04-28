<?php
  include '../../lib/database.php';
  $database = new Database();
  $where = $_GET['page'];
  $amount = $_GET['amount'];
  $employee = empty($_GET['bonus_employee'])?'%':$_GET['bonus_employee'];
  $department = empty($_GET['bonus_department'])?'%':$_GET['bonus_department'];
  $bonus = empty($_GET['bonus_bonus'])?'%':$_GET['bonus_bonus'];
  $salaryMonth = empty($_GET['bonus_month'])?'%':$_GET['bonus_month'];
  $salaryYear = empty($_GET['bonus_year'])?'%':$_GET['bonus_year'];
  settype($page,"int");
  $start = ($where - 1) * $amount;
  $rs = $database->filter_employee_bonus_limit($employee, $department, $bonus, $salaryMonth, $salaryYear, $start, $amount);
  $i = $start;
  if ($rs){
    while($row = $rs->fetch_assoc()){
      $i++;
      echo "
        <tr>
          <td class='py-3'>".$i."</td>
          <td class='py-3'>".$row["Employee_id"]."</td>
          <td class='py-3'>".$row["Fullname"]."</td>
          <td class='py-3'>".$row["Department_name"]."</td>
          <td class='py-3'>".$row["Position_name"]."</td>
          <td class='py-3'>".$row["Bonus_reason"]."</td>
          <td class='py-3'>".$row["Bonus"]."</td>
          <td>
            <a href='?delid=".$row["Ordinal"]."' onclick=\"return confirm('Are you want to delete?')\"><i class='fas fa-trash-alt btn btn-danger'></i></a>
          </td>
        </tr>
      ";
    }
  }

?>
