<?php
  include '../../lib/database.php';
  $database = new Database();
  $department = empty($_GET['salary_department'])?'%':$_GET['salary_department'];
  $month = empty($_GET['salary_month'])?'%':$_GET['salary_month'];
  $year = empty($_GET['salary_year'])?'%':$_GET['salary_year'];
  $rs = $database->total_salary($department, $month, $year);
  $i = 0;
  $sum = 0;
  if ($rs){
    while($row = $rs->fetch_assoc()){
      $i++;
      $sum = $sum + $row["Total_salary"];
      echo "
        <tr>
          <td class='py-3'>".$i."</td>
          <td class='py-3'>".$row["Department_name"]."</td>
          <td class='py-3'>".$row["Total_salary"]."</td>
        </tr>
      ";
    }
    echo "
      <tr>
        <td class='alert alert-primary'>Statistical</td>
        <td class='alert alert-primary' style='text-align: right;'>Total:</td>
        <td class='alert alert-primary'>".$sum."</td>
      </tr>
    ";
  }
?>
