<?php
Class Database{
  private $host = "localhost";
  private $user = "root";
  private $pass = "";
  private $dbname = "qlnv";

  public $link;
  public $error;

  public function __construct(){
    $this->connectDB();
  }

  public function connectDB(){
    $this->link = new mysqli($this->host, $this->user, $this->pass, $this->dbname);
    if(!$this->link){
      $this->error = "Connection failed".$this->connect_error;
      return false;
    }
  }

  // Select or Read data
  public function select($query){
    $result = $this->link->query($query);
    if($result->num_rows > 0){
      return $result;
    }
    else{
      return false;
    }
  }

  // Insert data
  public function insert($query){
    $insert_row = $this->link->query($query);
    if($insert_row){
      return $insert_row;
    }
    else{
      return false;
    }
  }

  // Update data
  public function update($query){
    $update_row = $this->link->query($query);
    if($update_row){
      return $update_row;
    }
    else{
      return false;
    }
  }

  // Delete data
  public function delete($query){
    $delete_row = $this->link->query($query);
    if($delete_row){
      return $delete_row;
    }
    else{
      return false;
    }
  }

  // Proc
  public function filter_employee($id, $employee, $gender, $department, $position, $level, $contractId, $contract, $expirationDate, $status){
    $sql = "CALL Filter_employee('$id', '$employee', '$gender', '$department', '$position', '$level', '$contractId', '$contract', '$expirationDate', '$status')";
    $result = $this->link->query($sql);
    if($result){
      return $result;
    }
    else{
      return false;
    }
  }

  public function filter_employee_limit($id, $employee, $gender, $department, $position, $level, $contractId, $contract, $expirationDate, $status, $start, $amount){
    $sql = "CALL Filter_employee_limit('$id', '$employee', '$gender', '$department', '$position', '$level', '$contractId', '$contract', '$expirationDate', '$status', $start, $amount)";
    $result = $this->link->query($sql);
    if($result){
      return $result;
    }
    else{
      return false;
    }
  }

  public function filter_employee_bonus($employee, $department, $bonus, $salaryMonth, $salaryYear){
    $sql = "CALL Filter_employee_bonus('$employee', '$department', '$bonus', '$salaryMonth', '$salaryYear')";
    $result = $this->link->query($sql);
    if($result){
      return $result;
    }
    else{
      return false;
    }
  }

  public function filter_employee_bonus_limit($employee, $department, $bonus, $salaryMonth, $salaryYear, $start, $amount){
    $sql = "CALL Filter_employee_bonus_limit('$employee', '$department', '$bonus', '$salaryMonth', '$salaryYear', '$start', '$amount')";
    $result = $this->link->query($sql);
    if($result){
      return $result;
    }
    else{
      return false;
    }
  }

  public function filter_employee_fine($employee, $department, $fine, $salaryMonth, $salaryYear){
    $sql = "CALL Filter_employee_fine('$employee', '$department', '$fine', '$salaryMonth', '$salaryYear')";
    $result = $this->link->query($sql);
    if($result){
      return $result;
    }
    else{
      return false;
    }
  }

  public function filter_employee_fine_limit($employee, $department, $fine, $salaryMonth, $salaryYear, $start, $amount){
    $sql = "CALL Filter_employee_fine_limit('$employee', '$department', '$fine', '$salaryMonth', '$salaryYear', '$start', '$amount')";
    $result = $this->link->query($sql);
    if($result){
      return $result;
    }
    else{
      return false;
    }
  }

  public function filter_employee_workday($employee, $department, $position, $salaryMonth, $salaryYear){
    $sql = "CALL Filter_employee_workday('$employee', '$department', '$position', '$salaryMonth', '$salaryYear')";
    $result = $this->link->query($sql);
    if($result){
      return $result;
    }
    else{
      return false;
    }
  }

  public function filter_employee_workday_limit($employee, $department, $position, $salaryMonth, $salaryYear, $start, $amount){
    $sql = "CALL Filter_employee_workday_limit('$employee', '$department', '$position', '$salaryMonth', '$salaryYear', $start, $amount)";
    $result = $this->link->query($sql);
    if($result){
      return $result;
    }
    else{
      return false;
    }
  }

  public function salary_in_month($employee, $department, $position, $salaryMonth, $salaryYear){
    $sql = "CALL Salary_in_month('$employee', '$department', '$position', '$salaryMonth', '$salaryYear')";
    $result = $this->link->query($sql);
    if($result){
      return $result;
    }
    else{
      return false;
    }
  }

  public function salary_in_month_limit($employee, $department, $position, $salaryMonth, $salaryYear, $start, $amount){
    $sql = "CALL Salary_in_month_limit('$employee', '$department', '$position', '$salaryMonth', '$salaryYear', '$start', '$amount')";
    $result = $this->link->query($sql);
    if($result){
      return $result;
    }
    else{
      return false;
    }
  }

  public function total_salary($department, $salaryMonth, $salaryYear){
    $sql = "CALL Total_salary('$department', '$salaryMonth', '$salaryYear')";
    $result = $this->link->query($sql);
    if($result){
      return $result;
    }
    else{
      return false;
    }
  }
}
?>
