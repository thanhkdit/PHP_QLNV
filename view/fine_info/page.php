<?php
  include '../../lib/database.php';
  $database = new Database();
  $where = $_GET['page'];
  $amount = $_GET['amount'];
  $employee = empty($_GET['fine_employee'])?'%':$_GET['fine_employee'];
  $department = empty($_GET['fine_department'])?'%':$_GET['fine_department'];
  $fine = empty($_GET['fine_fine'])?'%':$_GET['fine_fine'];
  $salaryMonth = empty($_GET['fine_month'])?'%':$_GET['fine_month'];
  $salaryYear = empty($_GET['fine_year'])?'%':$_GET['fine_year'];
  settype($page,"int");
  $amount = 5;
  $start = ($where - 1) * $amount;
  $rs = $database->filter_employee_fine_limit($employee, $department, $fine, $salaryMonth, $salaryYear, $start, $amount);
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
          <td class='py-3'>".$row["Fine_reason"]."</td>
          <td class='py-3'>".$row["Fine"]."</td>
          <td>
            <a href='?dlid=".$row["Ordinal"]."' onclick=\"return confirm('Are you want to delete?')\"><i class='fas fa-trash-alt btn btn-danger'></i></a>
          </td>
        </tr>
      ";
    }
  }

?>
