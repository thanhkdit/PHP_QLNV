<?php
  include '../../lib/database.php';
?>
<?php
class Position{
  private $db;

  public function __construct(){
    $this->db = new Database();
  }

  public function insert_position($id, $name, $basicSalary){
    $id = mysqli_real_escape_string($this->db->link, $id);
    $name = mysqli_real_escape_string($this->db->link, $name);
    $basicSalary = mysqli_real_escape_string($this->db->link, $basicSalary);

    if (empty($id) || empty($name) || empty($basicSalary)){
      $alert = "<div class='alert alert-warning'>These fields must be not empty</div>";
      return $alert;
    }
    else if ($basicSalary <= 0){
      $alert = "<div class='alert alert-warning'>Basic salary > 0</div>";
      return $alert;
    }
    else{
      $sql = "INSERT INTO t_Position(Position_id,Position_name,Basic_salary) VALUES('$id', '$name', $basicSalary)";
      $result = $this->db->insert($sql);
      if($result){
        $alert = "<div class='alert alert-success'>Insert Position Successfully</div>";
        return $alert;
      }
      else{
        $alert = "<div class='alert alert-danger'>Insert Position Unsuccessfully</div>";
        return $alert;
      }
    }
  }

  public function update_position($name, $basicSalary, $id){
    $name = mysqli_real_escape_string($this->db->link, $name);
    $basicSalary = mysqli_real_escape_string($this->db->link, $basicSalary);

    if (empty($name) || empty($basicSalary)){
      $alert = "<div class='alert alert-warning'>These fields must be not empty</div>";
      return $alert;
    }
    else if ($basicSalary <= 0){
      $alert = "<div class='alert alert-warning'>Basic salary > 0</div>";
      return $alert;
    }
    else{
      $sql = "UPDATE t_Position SET Position_name = '$name', Basic_salary=$basicSalary WHERE Position_id = '$id'";
      $result = $this->db->update($sql);
      if ($result){
        $alert = "<div class='alert alert-success'>Update Position Successfully</div>";
        return $alert;
      }
      else{
        $alert = "<div class='alert alert-danger'>Update Position Unsuccessfully</div>";
        return $alert;
      }
    }
  }

  public function del_position($id){
    $sql = "DELETE FROM t_Position WHERE Position_id = '$id'";
    $result = $this->db->delete($sql);
    if ($result){
      $alert = "<div class='alert alert-success'>Delete Position Successfully</div>";
      return $alert;
    }
    else{
      $alert = "<div class='alert alert-danger'>Delete Position Unsuccessfully</div>";
      return $alert;
    }
  }

  public function get_position_by_id($id){
    $sql = "SELECT * FROM t_Position WHERE Position_id = '$id'";
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
