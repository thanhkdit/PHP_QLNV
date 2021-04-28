<?php
  include '../../lib/session.php';
  Session::checkLogin();
  include '../../lib/database.php';
  include '../../helper/format.php';
?>
<?php
  class adminLogin{
    private $db;
    private $fm;

    public function __construct(){
      $this->db = new Database();
      $this->fm = new Format();
    }

    public function login_admin($user, $pass){
      $user = $this->fm->validation($user);
      $pass = $this->fm->validation($pass);

      $user = mysqli_real_escape_string($this->db->link, $user);
      $pass = mysqli_real_escape_string($this->db->link, $pass);

      if (empty($user) || empty($pass)){
        $alert = "User or Pass must be not empty";
        return $alert;
      }
      else{
        $query = "SELECT * FROM t_Login WHERE userId = '$user' AND password = '$pass' LIMIT 1";
        $result = $this->db->select($query);

        if($result != false){
          $value = $result->fetch_assoc();
          Session::set('adminlogin',true);
          Session::set('userid', $value['userId']);
          Session::set('username', $value['userName']);
          header('Location:index.php');
        }
        else{
          $alert = "User and Pass not match";
          return $alert;
        }
      }
    }
  }
?>
