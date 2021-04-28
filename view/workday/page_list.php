<?php
  include '../../lib/database.php';
  $database = new Database();
  $where = $_GET['page'];
  $amount =$_GET['amount'];
  $employee = empty($_GET['workday_employee'])?'%':$_GET['workday_employee'];
  $department = empty($_GET['workday_department'])?'%':$_GET['workday_department'];
  $position = empty($_GET['workday_position'])?'%':$_GET['workday_position'];
  $month = empty($_GET['workday_month'])?'%':$_GET['workday_month'];
  $year = empty($_GET['workday_year'])?'%':$_GET['workday_year'];
  settype($page,"int");
  $start = ($where - 1) * $amount;
  $rs = $database->filter_employee_workday_limit($employee, $department, $position, $month, $year, $start, $amount);
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
          <td class='py-3'>".$row["Day_worked"]."</td>
          <td class='py-3'>".$row["Overtime"]."</td>
          <td class='py-3'>".$row["Salary_month"]."</td>
          <td class='py-3'>".$row["Salary_year"]."</td>
          <td>
            <a href='?delid=".$row["Ordinal"]."' onclick=\"return confirm('Are you want to delete?')\"><i class='fas fa-trash-alt btn btn-danger'></i></a>
          </td>
        </tr>
      ";
    }
  }
?>
