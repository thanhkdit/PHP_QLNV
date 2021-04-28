<?php
  include '../../lib/database.php';
?>
<?php
class Salary{
  private $db;

  public function __construct(){
    $this->db = new Database();
  }

  public function show($table){
    $sql = "SELECT * FROM $table";
    $result = $this->db->select($sql);
    return $result;
  }

  public function salary_in_month($employee, $department, $position, $salaryMonth, $salaryYear){
    $result = $this->db->salary_in_month($employee, $department, $position, $salaryMonth, $salaryYear);
    return $result;
  }

  public function salary_in_month_limit($employee, $department, $position, $salaryMonth, $salaryYear, $start, $amount){
    $result = $this->db->salary_in_month_limit($employee, $department, $position, $salaryMonth, $salaryYear, $start, $amount);
    return $result;
  }

  public function total_salary($department, $salaryMonth, $salaryYear){
    $result = $this->db->total_salary($department, $salaryMonth, $salaryYear);
    return $result;
  }
}
?>
