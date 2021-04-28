<?php
  include '../../lib/database.php';
?>
<?php
class Fine_detail{
  private $db;

  public function __construct(){
    $this->db = new Database();
  }

  public function insert_fine_detail($fineReason, $fine){
    $fineReason = mysqli_real_escape_string($this->db->link, $fineReason);
    $fine = mysqli_real_escape_string($this->db->link, $fine);

    if (empty($fineReason) || empty($fine)){
      $alert = "<div class='alert alert-warning'>These fields must be not empty</div>";
      return $alert;
    }
    else if ($fine <= 0){
      $alert = "<div class='alert alert-warning'>Fine > 0</div>";
      return $alert;
    }
    else{
      $sql = "INSERT INTO t_Fine_detail(Fine_reason,Fine) VALUES('$fineReason', '$fine')";
      $result = $this->db->insert($sql);
      if($result){
        $alert = "<div class='alert alert-success'>Insert Fine detail Successfully</div>";
        return $alert;
      }
      else{
        $alert = "<div class='alert alert-danger'>Insert Fine detail Unsuccessfully</div>";
        return $alert;
      }
    }
  }

  public function update_fine_detail($fineReason, $fine, $fineId){
    $fineReason = mysqli_real_escape_string($this->db->link, $fineReason);
    $fine = mysqli_real_escape_string($this->db->link, $fine);

    if (empty($fineReason) || empty($fine) || empty($fineId)){
      $alert = "<div class='alert alert-warning'>These fields must be not empty</div>";
      return $alert;
    }
    else if ($fineId <= 0){
      $alert = "<div class='alert alert-warning'>Fine > 0</div>";
      return $alert;
    }
    else{
      $sql = "UPDATE t_Fine_detail SET Fine_reason='$fineReason', Fine=$fine WHERE Fine_id = '$fineId'";
      $result = $this->db->update($sql);
      if($result){
        $alert = "<div class='alert alert-success'>Update Fine detail Successfully</div>";
        return $alert;
      }
      else{
        $alert = "<div class='alert alert-danger'Update Fine detail Unsuccessfully</div>";
        return $alert;
      }
    }
  }

  public function del_fine_detail($fineId){
    $sql = "DELETE FROM t_Fine_detail WHERE Fine_id = '$fineId'";
    $result = $this->db->delete($sql);
    if ($result){
      $alert = "<div class='alert alert-success'>Delete Fine detail Successfully</div>";
      return $alert;
    }
    else{
      $alert = "<div class='alert alert-danger'>Delete Fine detail Unsuccessfully</div>";
      return $alert;
    }
  }

  public function get_fine_detail_by_id($fineId){
    $sql = "SELECT * FROM t_Fine_detail WHERE Fine_id = '$fineId'";
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
