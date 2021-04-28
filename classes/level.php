<?php
  include '../../lib/database.php';
?>
<?php
class Level{
  private $db;

  public function __construct(){
    $this->db = new Database();
  }

  public function insert_level($id, $name, $coefficientsSalary){
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
      $sql = "INSERT INTO t_Level(Level_id,Level,Coefficients_salary) VALUES('$id', '$name', $coefficientsSalary)";
      $result = $this->db->insert($sql);
      if($result){
        $alert = "<div class='alert alert-success'>Insert Level Successfully</div>";
        return $alert;
      }
      else{
        $alert = "<div class='alert alert-danger'>Insert Level Unsuccessfully</div>";
        return $alert;
      }
    }
  }

  public function update_level($name, $coefficientsSalary, $id){
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
      $sql = "UPDATE t_Level SET Level = '$name', Coefficients_salary=$coefficientsSalary WHERE Level_id = '$id'";
      $result = $this->db->update($sql);
      if ($result){
        $alert = "<div class='alert alert-success'>Update Level Successfully</div>";
        return $alert;
      }
      else{
        $alert = "<div class='alert alert-danger'>Update Level Unsuccessfully</div>";
        return $alert;
      }
    }
  }

  public function del_level($id){
    $sql = "DELETE FROM t_Level WHERE Level_id = '$id'";
    $result = $this->db->delete($sql);
    if ($result){
      $alert = "<div class='alert alert-success'>Delete Level Successfully</div>";
      return $alert;
    }
    else{
      $alert = "<div class='alert alert-danger'>Delete Level Unsuccessfully</div>";
      return $alert;
    }
  }

  public function get_level_by_id($id){
    $sql = "SELECT * FROM t_Level WHERE Level_id = '$id'";
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
