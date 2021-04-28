<?php
  include '../../lib/database.php';
?>
<?php
class Fine_info{
  private $db;

  public function __construct(){
    $this->db = new Database();
  }

  public function insert_fine_info($employeeId, $fineId, $salaryMonth, $salaryYear){
    $employeeId = mysqli_real_escape_string($this->db->link, $employeeId);
    $fineId = mysqli_real_escape_string($this->db->link, $fineId);
    $salaryMonth = mysqli_real_escape_string($this->db->link, $salaryMonth);
    $salaryYear = mysqli_real_escape_string($this->db->link, $salaryYear);

    if (empty($employeeId) || empty($fineId) || empty($salaryMonth) || empty($salaryYear)){
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
      $sql = "INSERT INTO t_Fine_info(Employee_id,Fine_id,Salary_id) VALUES('$employeeId', '$fineId', $salaryId)";
      $result = $this->db->insert($sql);
      if($result){
        $alert = "<div class='alert alert-success'>Insert Fine Info Successfully</div>";
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

  public function update_fine_info($employeeId, $fineId, $salaryId, $ordinal){
    $employeeId = mysqli_real_escape_string($this->db->link, $employeeId);
    $fineId = mysqli_real_escape_string($this->db->link, $fineId);
    $salaryId = mysqli_real_escape_string($this->db->link, $salaryId);

    if (empty($employeeId) || empty($fineId) || empty($salaryId)){
      $alert = "<div class='alert alert-warning'>These fields must be not empty</div>";
      return $alert;
    }
    else{
      $sql = "UPDATE t_Fine_info SET Employee_id = '$employeeId', Fine_id='$fineId', Salary_id=$salaryId WHERE Ordinal = $ordinal";
      $result = $this->db->update($sql);
      if($result){
        $alert = "<div class='alert alert-success'>Update Fine Info Successfully</div>";
        return $alert;
      }
      else{
        $alert = "<div class='alert alert-danger'Update Fine Info Unsuccessfully</div>";
        return $alert;
      }
    }
  }

  public function del_fine_info($ordinal){
    $sql = "DELETE FROM t_Fine_info WHERE Ordinal = $ordinal";
    $result = $this->db->delete($sql);
    if ($result){
      $alert = "<div class='alert alert-success'>Delete Fine Info Successfully</div>";
      return $alert;
    }
    else{
      $alert = "<div class='alert alert-danger'>Delete Fine Info Unsuccessfully</div>";
      return $alert;
    }
  }

  public function get_fine_info_by_id($id){
    $sql = "SELECT * FROM t_Fine_info WHERE Ordinal = $ordinal";
    $result = $this->db->select($sql);
    return $result;
  }

  public function show($table){
    $sql = "SELECT * FROM $table";
    $result = $this->db->select($sql);
    return $result;
  }

  public function filter_employee_fine($employee, $department, $fine, $salaryMonth, $salaryYear){
    $result = $this->db->filter_employee_fine($employee, $department, $fine, $salaryMonth, $salaryYear);
    return $result;
  }

  public function filter_employee_fine_limit($employee, $department, $fine, $salaryMonth, $salaryYear, $start, $amount){
    $result = $this->db->filter_employee_fine_limit($employee, $department, $fine, $salaryMonth, $salaryYear, $start, $amount);
    return $result;
  }
}
?>
