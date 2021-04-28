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
    $result = $this->link->query($query) or die ($this->link->error.__LINE__);
    if($result->num_rows > 0){
      return $result;
    }
    else{
      return false;
    }
  }

  // Insert data
  public function insert($query){
    $insert_row = $this->link->query($query) or die($this->link->error.__LINE__);
    if($insert_row){
      return $insert_row;
    }
    else{
      return false;
    }
  }

  // Update data
  public function update($query){
    $update_row = $this->link->query($query) or die($this->link->error.__LINE__);
    if($update_row){
      return $update_row;
    }
    else{
      return false;
    }
  }

  // Delete data
  public function delete($query){
    $delete_row = $this->link->query($query) or die($this->link->error.__LINE__);
    if($delete_row){
      return $delete_row;
    }
    else{
      return false;
    }
  }

  // Proc
  public function filter_employee($employee, $department, $position, $level, $contract, $status){
    $employee = empty($employee)?"%":$employee;
    $department = empty($department)?"%":$department;
    $position = empty($position)?"%":$position;
    $level = empty($level)?"%":$level;
    $contract = empty($contract)?"%":$contract;
    $status = empty($status)?"%":$status;

    $sql = "CALL Filter_employee($employee, $department, $position, $level, $contract, $status)";
    $result = $this->link->query($sql) or die($this->link->error.__LINE__);
    if($result->num_rows > 0){
      return $result;
    }
    else{
      return false;
    }
  }

  public function filter_employee_bonus($employee, $department, $bonus, $salaryMonth, $salaryYear){
    $employee = empty($employee)?"%":$employee;
    $department = empty($department)?"%":$department;
    $bonus = empty($bonus)?"%":$bonus;
    $salaryYear = empty($salaryYear)?"%":$salaryYear;
    $salaryMonth = empty($salaryMonth)?"%":$salaryMonth;

    $sql = "CALL Filter_employee_bonus('$employee', '$department', '$bonus', '$salaryMonth', '$salaryYear')";
    $result = $this->link->query($sql) or die($this->link->error.__LINE__);
    if($result->num_rows > 0){
      return $result;
    }
    else{
      return false;
    }
  }

  public function filter_employee_bonus_limit($employee, $department, $bonus, $salaryMonth, $salaryYear, $start, $amount){
    $employee = empty($employee)?"%":$employee;
    $department = empty($department)?"%":$department;
    $bonus = empty($bonus)?"%":$bonus;
    $salaryYear = empty($salaryYear)?"1":$salaryYear;
    $salaryMonth = empty($salaryMonth)?"2019":$salaryMonth;

    $sql = "CALL Filter_employee_bonus_limit('$employee', '$department', '$bonus', '$salaryMonth', '$salaryYear', '$start', '$amount')";
    $result = $this->link->query($sql) or die($this->link->error.__LINE__);
    if($result->num_rows > 0){
      return $result;
    }
    else{
      return false;
    }
  }

  public function filter_employee_fine($employee, $department, $fine, $salaryMonth, $salaryYear){
    $employee = empty($employee)?"%":$employee;
    $department = empty($department)?"%":$department;
    $fine = empty($bonus)?"%":$fine;
    $salaryYear = empty($salaryYear)?"%":$salaryYear;
    $salaryMonth = empty($salaryMonth)?"%":$salaryMonth;

    $sql = "CALL Filter_employee_fine($employee, $department, $fine, $salaryMonth, $salaryYear)";
    $result = $this->link->query($sql) or die($this->link->error.__LINE__);
    if($result->num_rows > 0){
      return $result;
    }
    else{
      return false;
    }
  }

  public function salary_in_month($employee, $department, $salaryMonth, $salaryYear){
    $employee = empty($employee)?"%":$employee;
    $department = empty($department)?"%":$department;
    $salaryMonth = empty($salaryMonth)?"%":$salaryMonth;
    $salaryYear = empty($salaryYear)?"%":$salaryYear;

    $sql = "CALL Salary_in_month($employee, $department, $salaryMonth, $salaryYear)";
    $result = $this->link->query($sql) or die($this->link->error.__LINE__);
    if($result->num_rows > 0){
      return $result;
    }
    else{
      return false;
    }
  }
}
?>
