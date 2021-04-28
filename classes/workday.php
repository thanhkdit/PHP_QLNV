<?php
  include '../../lib/database.php';
?>
<?php
class Workday{
  private $db;

  public function __construct(){
    $this->db = new Database();
  }

  public function insert_workday($employeeId, $dayWorked, $overTime, $salaryMonth, $salaryYear){
    $employeeId = mysqli_real_escape_string($this->db->link, $employeeId);
    $dayWorked = mysqli_real_escape_string($this->db->link, $dayWorked);
    $overTime = mysqli_real_escape_string($this->db->link, $overTime);
    $salaryMonth = mysqli_real_escape_string($this->db->link, $salaryMonth);
    $salaryYear = mysqli_real_escape_string($this->db->link, $salaryYear);

    if (empty($employeeId) || empty($dayWorked) || empty($overTime) || empty($salaryMonth) || empty($salaryYear)){
      $alert = "<div class='alert alert-warning'>These fields must be not empty</div>";
      return $alert;
    } else {
      $salaryId = "";
      $sql = "SELECT Salary_id FROM t_Salary_month WHERE $salaryMonth = Salary_month and $salaryYear = Salary_year";
      $rs = $this->db->select($sql);
      if ($rs){
        while ($row = $rs->fetch_assoc()){
          $salaryId = $row['Salary_id'];
        }
      }
      $sql = "INSERT INTO t_Workday(Employee_id,Salary_id,Day_worked,Overtime) VALUES('$employeeId', $salaryId, $dayWorked, '$overTime')";
      $result = $this->db->insert($sql);
      if($result){
        $alert = "<div class='alert alert-success'>Insert Workday Successfully</div>";
        return $alert;
      }
      else{
        $alert = "<div class='alert alert-danger'>Insert Workday Unsuccessfully</div>";
        return $alert;
      }
    }
  }


  public function insert_year($year){
    $year = mysqli_real_escape_string($this->db->link, $year);

    if (empty($year)){
      $alert = "<div class='alert alert-warning'>These fields must be not empty</div>";
      return $alert;
    }
    else{
      $sql = "INSERT INTO t_Salary_year(Salary_year) VALUES('$year')";
      $result = $this->db->insert($sql);
      if($result){
        $alert = "<div class='alert alert-success'>Insert Year Info Successfully</div>";
        return $alert;
      }
      else{
        $alert = "<div class='alert alert-danger'>Insert Year Info Unsuccessfully</div>";
        return $alert;
      }
    }
  }

  public function update_workday($employeeId, $salaryId, $dayWorked, $overTime, $ordinal){
    $employeeId = mysqli_real_escape_string($this->db->link, $employeeId);
    $salaryId = mysqli_real_escape_string($this->db->link, $salaryId);
    $dayWorked = mysqli_real_escape_string($this->db->link, $dayWorked);
    $overTime = mysqli_real_escape_string($this->db->link, $overTime);

    if (empty($employeeId) || empty($salaryId) || empty($dayWorked) || empty($overTime)){
      $alert = "<div class='alert alert-warning'>These fields must be not empty</div>";
      return $alert;
    }
    else{
      $sql = "UPDATE t_Workday SET Employee_id = '$employeeId', Salary_id=$salaryId, Day_worked=$dayWorked, Overtime=$overTime WHERE Ordinal = $ordinal";
      $result = $this->db->update($sql);
      if($result){
        $alert = "<div class='alert alert-success'>Update Workday Successfully</div>";
        return $alert;
      }
      else{
        $alert = "<div class='alert alert-danger'>Update Workday Unsuccessfully</div>";
        return $alert;
      }
    }
  }

  public function del_workday($ordinal){
    $sql = "DELETE FROM t_Workday WHERE Ordinal = $ordinal";
    $result = $this->db->delete($sql);
    if ($result){
      $alert = "<div class='alert alert-success'>Delete Workday Successfully</div>";
      return $alert;
    }
    else{
      $alert = "<div class='alert alert-danger'>Delete Workday Unsuccessfully</div>";
      return $alert;
    }
  }

  public function get_workday_by_id($id){
    $sql = "SELECT * FROM t_Workday WHERE Ordinal = '$ordinal'";
    $result = $this->db->select($sql);
    return $result;
  }

  public function show($table){
    $sql = "SELECT * FROM $table";
    $result = $this->db->select($sql);
    return $result;
  }

  public function filter_employee($employee, $department, $position, $level, $contract, $status){
    $result = $this->db->filter_employee($employee, $department, $position, $level, $contract, $status);
    return $result;
  }

  public function filter_employee_workday($employee, $department, $position, $salaryMonth, $salaryYear){
    $result = $this->db->filter_employee_workday($employee, $department, $position, $salaryMonth, $salaryYear);
    return $result;
  }

  public function filter_employee_workday_limit($employee, $department, $position, $salaryMonth, $salaryYear, $start, $amount){
    $result = $this->db->filter_employee_workday_limit($employee, $department, $position, $salaryMonth, $salaryYear, $start, $amount);
    return $result;
  }
}
?>
