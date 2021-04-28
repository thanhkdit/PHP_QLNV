<?php
  include '../../lib/database.php';
?>
<?php
class Department{
  private $db;

  public function __construct(){
    $this->db = new Database();
  }

  public function insert_department($id, $name, $coefficientsSalary){
    $id = mysqli_real_escape_string($this->db->link, $id);
    $name = mysqli_real_escape_string($this->db->link, $name);
    $coefficientsSalary = mysqli_real_escape_string($this->db->link, $coefficientsSalary);

    if (empty($id) || empty($name) || empty($coefficientsSalary)){
      $alert = "<div class='alert alert-warning'>These fields must be not empty</div>";
      return $alert;
    }
    else if ($coefficientsSalary <= 0){
      $alert = "<div class='alert alert-warning'>Coefficients salary > 0</div>";
      return $alert;
    }
    else{
      $sql = "INSERT INTO t_Department(Department_id,Department_name,Coefficients_salary) VALUES('$id', '$name',  $coefficientsSalary)";
      $result = $this->db->insert($sql);
      if($result){
        $alert = "<div class='alert alert-success'>Insert Department Successfully</div>";
        return $alert;
      }
      else{
        $alert = "<div class='alert alert-danger'>Insert Department Unsuccessfully</div>";
        return $alert;
      }
    }
  }

  public function update_department($name, $coefficientsSalary, $id){
    $name = mysqli_real_escape_string($this->db->link, $name);
    $coefficientsSalary = mysqli_real_escape_string($this->db->link, $coefficientsSalary);

    if (empty($name) || empty($coefficientsSalary)){
      $alert = "<div class='alert alert-warning'>These fields must be not empty</div>";
      return $alert;
    }
    else if ($coefficientsSalary <= 0){
      $alert = "<div class='alert alert-warning'>Coefficients salary > 0</div>";
      return $alert;
    }
    else{
      $sql = "UPDATE t_Department SET Department_name = '$name', Coefficients_salary=$coefficientsSalary WHERE Department_id = '$id'";
      $result = $this->db->update($sql);
      if ($result){
        $alert = "<div class='alert alert-success'>Update Department Successfully</div>";
        return $alert;
      }
      else{
        $alert = "<div class='alert alert-danger'>Update Department Unsuccessfully</div>";
        return $alert;
      }
    }
  }

  public function del_department($id){
    $sql = "DELETE FROM t_Department WHERE Department_id = '$id'";
    $result = $this->db->delete($sql);
    if ($result){
      $alert = "<div class='alert alert-success'>Delete Department Successfully</div>";
      return $alert;
    }
    else{
      $alert = "<div class='alert alert-danger'>Delete Department Unsuccessfully</div>";
      return $alert;
    }
  }

  public function get_department_by_id($id){
    $sql = "SELECT * FROM t_Department WHERE Department_id = '$id'";
    $result = $this->db->select($sql);
    return $result;
  }

  public function show($table){
    $sql = "SELECT * FROM $table";
    $result = $this->db->select($sql);
    return $result;
  }
}
?>
