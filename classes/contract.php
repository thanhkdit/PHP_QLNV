<?php
  include '../../classes/employee.php';
?>
<?php
class Contract{
  private $db;

  public function __construct(){
    $this->db = new Database();
  }

  public function insert_contract($id, $employeeId, $type, $signDay, $expirationDate, $status){
    $id = mysqli_real_escape_string($this->db->link, $id);
    $employeeId = mysqli_real_escape_string($this->db->link, $employeeId);
    $type = mysqli_real_escape_string($this->db->link, $type);
    $signDay = mysqli_real_escape_string($this->db->link, $signDay);
    $expirationDate = mysqli_real_escape_string($this->db->link, $expirationDate);
    $status = mysqli_real_escape_string($this->db->link, $status);

    if (empty($id) || empty($employeeId) || empty($type) || empty($signDay) || empty($expirationDate)){
      $alert = "<div class='alert alert-warning'>These fields must be not empty</div>";
      return $alert;
    }
    else{
      $show = $this->show('t_Contract');
      if($show){
        while($result = $show->fetch_assoc()){
          if($id == $result['Contract_id']){
            $alert = "<div class='alert alert-warning'>Contract id was exsisted</div>";
            return $alert;
          }
        }
      }
    }
    $sql = "INSERT INTO t_Contract(Contract_id,Employee_id,Type_of_contract,Sign_day,Expiration_date, Status) VALUES('$id', '$employeeId', '$type', '$signDay', '$expirationDate','$status')";
    $result = $this->db->insert($sql);
    if($result){
      $alert = "<div class='alert alert-success'>Insert Contract Successfully</div>";
      return $alert;
    }
    else{
      $alert = "<div class='alert alert-danger'>Insert Contract Unsuccessfully</div>";
      return $alert;
    }
  }

  public function update_contract($employeeId, $type, $signDay, $expirationDate, $id){
    $employeeId = mysqli_real_escape_string($this->db->link, $employeeId);
    $type = mysqli_real_escape_string($this->db->link, $type);
    $signday = mysqli_real_escape_string($this->db->link, $signDay);
    $expirationDate = mysqli_real_escape_string($this->db->link, $expirationDate);

    if (empty($id) || empty($employeeId) || empty($type) || empty($signDay) || empty($expirationDate)){
      $alert = "<div class='alert alert-warning'>These fields must be not empty</div>";
      return $alert;
    }
    else{
      $sql = "UPDATE t_Contract SET Employee_id = '$employeeId', Type_of_contract='$type', Sign_day='$signDay', Expiration_date='$expirationDate' WHERE Contract_id = '$id'";
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

  public function del_contract($id){
    $sql = "DELETE FROM t_Contract WHERE Contract_id = '$id'";
    $result = $this->db->delete($sql);
    if ($result){
      $alert = "<div class='alert alert-success'>Delete Contract Successfully</div>";
      return $alert;
    }
    else{
      $alert = "<div class='alert alert-danger'>Delete Contract Unsuccessfully</div>";
      return $alert;
    }
  }

  public function get_contract_by_id($id){
    $sql = "SELECT * FROM t_Contract WHERE Contract_id = '$id'";
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
