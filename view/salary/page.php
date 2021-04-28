<?php
  include '../../lib/database.php';
  $database = new Database();
  $where = $_GET['page'];
  $amount =$_GET['amount'];
  $employee = empty($_GET['salary_employee'])?'%':$_GET['salary_employee'];
  $department = empty($_GET['salary_department'])?'%':$_GET['salary_department'];
  $position = empty($_GET['salary_position'])?'%':$_GET['salary_position'];
  $month = empty($_GET['salary_month'])?'%':$_GET['salary_month'];
  $year = empty($_GET['salary_year'])?'%':$_GET['salary_year'];
  settype($page,"int");
  $start = ($where - 1) * $amount;
  $rs = $database->salary_in_month_limit($employee, $department, $position, $month, $year, $start, $amount);
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
          <td class='py-3'>".$row["Salary_month"]."</td>
          <td class='py-3'>".$row["Salary_year"]."</td>
          <td class='py-3'>".$row["Salary"]."</td>
        </tr>
      ";
    }
  }
?>
