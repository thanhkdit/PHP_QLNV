<?php
  include '../../lib/database.php';
?>
<?php
class Bonus_detail{
  private $db;

  public function __construct(){
    $this->db = new Database();
  }

  public function insert_bonus_detail($bonusReason, $bonus){
    $bonusReason = mysqli_real_escape_string($this->db->link, $bonusReason);
    $bonus = mysqli_real_escape_string($this->db->link, $bonus);

    if (empty($bonusReason) || empty($bonus)){
      $alert = "<div class='alert alert-warning'>These fields must be not empty</div>";
      return $alert;
    }
    else if ($bonus <= 0){
      $alert = "<div class='alert alert-warning'>Bonus > 0</div>";
      return $alert;
    }
    else{
      $sql = "INSERT INTO t_Bonus_detail(Bonus_reason,Bonus) VALUES('$bonusReason', '$bonus')";
      $result = $this->db->insert($sql);
      if($result){
        $alert = "<div class='alert alert-success'>Insert Bonus detail Successfully</div>";
        return $alert;
      }
      else{
        $alert = "<div class='alert alert-danger'>Insert Bonus detail Unsuccessfully</div>";
        return $alert;
      }
    }
  }

  public function show_bonus_detail(){
    $sql = "SELECT * FROM t_Bonus_detail";
    $result = $this->db->select($sql);
    return $result;
  }

  public function update_bonus_detail($bonusReason, $bonus, $bonusId){
    $bonusReason = mysqli_real_escape_string($this->db->link, $bonusReason);
    $bonus = mysqli_real_escape_string($this->db->link, $bonus);

    if (empty($bonusReason) || empty($bonus) || empty($bonusId)){
      $alert = "<div class='alert alert-warning'>These fields must be not empty</div>";
      return $alert;
    }
    else if ($bonus <= 0){
      $alert = "<div class='alert alert-warning'>Bonus > 0</div>";
      return $alert;
    }
    else{
      $sql = "UPDATE t_Bonus_detail SET Bonus_reason='$bonusReason', Bonus=$bonus WHERE Bonus_id = '$bonusId'";
      $result = $this->db->update($sql);
      if($result){
        $alert = "<div class='alert alert-success'>Update Bonus detail Successfully</div>";
        return $alert;
      }
      else{
        $alert = "<div class='alert alert-danger'Update Bonus detail Unsuccessfully</div>";
        return $alert;
      }
    }
  }

  public function del_bonus_detail($bonusId){
    $sql = "DELETE FROM t_Bonus_detail WHERE Bonus_id = '$bonusId'";
    $result = $this->db->delete($sql);
    if ($result){
      $alert = "<div class='alert alert-success'>Delete Bonus detail Successfully</div>";
      return $alert;
    }
    else{
      $alert = "<div class='alert alert-danger'>Delete Bonus detail Unsuccessfully</div>";
      return $alert;
    }
  }

  public function get_bonus_detail_by_id($bonusId){
    $sql = "SELECT * FROM t_Bonus_detail WHERE Bonus_id = '$bonusId'";
    $result = $this->db->select($sql);
    return $result;
  }
}
?>
