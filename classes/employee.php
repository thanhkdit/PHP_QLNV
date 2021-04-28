<?php
  include '../../lib/database.php';
?>
<?php
class Employee{
  private $db;

  public function __construct(){
    $this->db = new Database();
  }

  public function insert_employee($id, $fullname, $gender, $positionId, $departmentId, $levelId, $contractId, $type, $signDay, $expirationDate, $status){
    $id = mysqli_real_escape_string($this->db->link, $id);
    $fullname = mysqli_real_escape_string($this->db->link, $fullname);
    $gender = mysqli_real_escape_string($this->db->link, $gender);
    $positionId = mysqli_real_escape_string($this->db->link, $positionId);
    $departmentId = mysqli_real_escape_string($this->db->link, $departmentId);
    $levelId = mysqli_real_escape_string($this->db->link, $levelId);

    $contractId = mysqli_real_escape_string($this->db->link, $contractId);
    $type = mysqli_real_escape_string($this->db->link, $type);
    $signDay = mysqli_real_escape_string($this->db->link, $signDay);
    $expirationDate = mysqli_real_escape_string($this->db->link, $expirationDate);
    $status = mysqli_real_escape_string($this->db->link, $status);

    if (empty($id) || empty($fullname) || empty($gender) || empty($positionId) || empty($departmentId) || empty($levelId) || empty($contractId) || empty($type) || empty($signDay) || empty($expirationDate) || empty($status)){
      $alert = "<div class='alert alert-warning'>These fields must be not empty</div>";
      return $alert;
    }
    $show = $this->show('t_Information_of_employee');
    if($show){
      while($result = $show->fetch_assoc()){
        if($id == $result['Employee_id']){
          $alert = "<div class='alert alert-warning'>Employee Id was exsisted</div>";
        }
      }
    }
    $show = $this->show('t_Contract');
    if($show){
      while($result = $show->fetch_assoc()){
        if($contractId == $result['Contract_id']){
          $alert = $alert."<div class='alert alert-warning'>Contract id was exsisted</div>";
          return $alert;
        }
      }
    }
    if (isset($alert)){
      return $alert;
    }
    else{
      $sql = "INSERT INTO t_Information_of_employee(Employee_id,Fullname,Gender,Position_id,Department_id,Level_id) VALUES('$id', '$fullname', '$gender', '$positionId', '$departmentId', '$levelId')";
      $result = $this->db->insert($sql);
      if($result){
        $alert = "<div class='alert alert-success'>Insert Employee Successfully</div>";
      }
      else{
        $alert = "<div class='alert alert-danger'>Insert Employee Unsuccessfully</div>";
      }
      $sql1 = "INSERT INTO t_Contract(Contract_id,Employee_id,Type_of_contract,Sign_day,Expiration_date,Status) VALUES('$contractId', '$id', '$type', '$signDay', '$expirationDate','$status')";
      $result1 = $this->db->insert($sql1);
      if($result1){
        $alert = $alert."<div class='alert alert-success'>Insert Contract Successfully</div>";
        return $alert;
      }
      else{
        $alert = $alert."<div class='alert alert-danger'>Insert Contract Unsuccessfully</div>";
        return $alert;
      }
    }
  }

  public function update_employee($fullname, $gender, $positionId, $departmentId, $levelId, $id){
    $fullname = mysqli_real_escape_string($this->db->link, $fullname);
    $gender = mysqli_real_escape_string($this->db->link, $gender);
    $positionId = mysqli_real_escape_string($this->db->link, $positionId);
    $departmentId = mysqli_real_escape_string($this->db->link, $departmentId);
    $levelId = mysqli_real_escape_string($this->db->link, $levelId);

    if (empty($id) || empty($fullname) || empty($gender) || empty($positionId) || empty($departmentId) || empty($levelId)){
      $alert = "<div class='alert alert-warning'>These fields must be not empty</div>";
      return $alert;
    }
    else{
      $sql = "UPDATE t_Information_of_employee SET Fullname = '$fullname', Gender='$gender', Position_id='$positionId', Department_id='$departmentId', Level_id='$levelId' WHERE Employee_id = '$id'";
      $result = $this->db->update($sql);
      if($result){
        $alert = "<div class='alert alert-success'>Update Employee Successfully</div>";
        return $alert;
      }
      else{
        $alert = "<div class='alert alert-danger'>Update Employee Unsuccessfully</div>";
        return $alert;
      }
    }
  }

  public function del_employee($id){
    $sql = "DELETE FROM t_Information_of_employee WHERE Employee_id = '$id'";
    $result = $this->db->delete($sql);
    if ($result){
      $alert = "<div class='alert alert-success'>Delete Employee Successfully</div>";
      return $alert;
    }
    else{
      $alert = "<div class='alert alert-danger'>Delete Employee Unsuccessfully</div>";
      return $alert;
    }
  }

  public function get_employee_by_id($id){
    $sql = "SELECT * FROM t_Information_of_employee WHERE Employee_id = '$id'";
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
