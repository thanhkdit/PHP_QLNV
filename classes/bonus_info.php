<?php
  include '../../lib/database.php';
?>
<?php
class Bonus_info{
  private $db;

  public function __construct(){
    $this->db = new Database();
  }

  public function insert_bonus_info($employeeId, $bonusId, $salaryMonth, $salaryYear){
    $employeeId = mysqli_real_escape_string($this->db->link, $employeeId);
    $bonusId = mysqli_real_escape_string($this->db->link, $bonusId);
    $salaryMonth = mysqli_real_escape_string($this->db->link, $salaryMonth);
    $salaryYear = mysqli_real_escape_string($this->db->link, $salaryYear);

    if (empty($employeeId) || empty($bonusId) || empty($salaryMonth) || empty($salaryYear)){
      $alert = "<div class='alert alert-warning'>These fields must be not empty</div>";
      return $alert;
    }
    else{
      $salaryId = "";
      $sql = "SELECT Salary_id FROM t_Salary_month WHERE $salaryMonth = Salary_month and $salaryYear = Salary_year";
      $rs = $this->db->select($sql);
      if ($rs){
        while ($row = $rs->fetch_assoc()){
          $salaryId = $row['Salary_id'];
        }
      }
      $sql = "INSERT INTO t_Bonus_info(Employee_id,Bonus_id,Salary_id) VALUES('$employeeId', '$bonusId', $salaryId)";
      $result = $this->db->insert($sql);
      if($result){
        $alert = "<div class='alert alert-success'>Insert Bonus Info Successfully</div>";
        return $alert;
      }
      else{
        $alert = "<div class='alert alert-danger'>Insert Fine Info Unsuccessfully</div>";
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

  public function show_bonus_info(){
    $sql = "SELECT * FROM t_Bonus_info";
    $result = $this->db->select($sql);
    return $result;
  }

  public function update_bonus_info($employeeId, $bonusId, $salaryId, $ordinal){
    $employeeId = mysqli_real_escape_string($this->db->link, $employeeId);
    $bonusId = mysqli_real_escape_string($this->db->link, $bonusId);
    $salaryId = mysqli_real_escape_string($this->db->link, $salaryId);

    if (empty($employeeId) || empty($bonusId) || empty($salaryId)){
      $alert = "<div class='alert alert-warning'>These fields must be not empty</div>";
      return $alert;
    }
    else{
      $sql = "UPDATE t_Bonus_info SET Employee_id = '$employeeId', Bonus_id='$bonusId', Salary_id=$salaryId WHERE Ordinal = $ordinal";
      $result = $this->db->update($sql);
      if($result){
        $alert = "<div class='alert alert-success'>Update Bonus Info Successfully</div>";
        return $alert;
      }
      else{
        $alert = "<div class='alert alert-danger'Update Bonus Info Unsuccessfully</div>";
        return $alert;
      }
    }
  }

  public function del_bonus_info($ordinal){
    $sql = "DELETE FROM t_Bonus_info WHERE Ordinal = '$ordinal'";
    $result = $this->db->delete($sql);
    if ($result){
      $alert = "<div class='alert alert-success'>Delete Bonus Info Successfully</div>";
      return $alert;
    }
    else{
      $alert = "<div class='alert alert-danger'>Delete Bonus Info Unsuccessfully</div>";
      return $alert;
    }
  }

  public function get_bonus_info_by_id($ordinal){
    $sql = "SELECT * FROM t_Bonus_info WHERE Ordinal = $ordinal";
    $result = $this->db->select($sql);
    return $result;
  }

  public function show($table){
    $sql = "SELECT * FROM $table";
    $result = $this->db->select($sql);
    return $result;
  }

  public function filter_employee_bonus($employee, $department, $bonus, $salaryMonth, $salaryYear){
    $result = $this->db->filter_employee_bonus($employee, $department, $bonus, $salaryMonth, $salaryYear);
    return $result;
  }

  public function filter_employee_bonus_limit($employee, $department, $bonus, $salaryMonth, $salaryYear, $start, $amount){
    $result = $this->db->filter_employee_bonus_limit($employee, $department, $bonus, $salaryMonth, $salaryYear, $start, $amount);
    return $result;
  }
}
?>
