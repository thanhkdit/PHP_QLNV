<?php include '../../classes/adminlogin.php' ?>
<?php
  $class = new adminlogin();
  if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $user = $_POST['user'];
    $pass = $_POST['pass'];
    $login_check = $class->login_admin($user, $pass);
  }
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../../css/view/login.css">
    <link rel="stylesheet" href="../../Fontawesome/css/all.css">
  </head>
  <body>
    <div class="container">
      <section class="login col-9 col-lg-6 mx-auto">
        <div class="card">
          <div class="card-header">
            <h3 class="text-center">Sign in</h3>
          </div>

          <div class="card-body">
            <form method="post" id="loginForm">
              <div class="input-group form-group">
                <div class="input-group-prepend">
                  <span class="iconuser input-group-text"><i class="fas fa-user"></i></span>
                </div>
                <input type="text" name="user" class="form-control" placeholder="username">
              </div>

              <div class="input-group form-group">
                <div class="input-group-prepend">
                  <span class="iconkey input-group-text"><i class="fas fa-key"></i></span>
                </div>
                <input type="password" name="pass" class="form-control" placeholder="password">
              </div>

              <span style="color: red; display: block">
                <?php
                  if(isset($login_check)){
                    echo "<i class='fas fa-exclamation-triangle'></i>&ensp;";
                    echo $login_check;
                  }
                ?>
              </span>

              <div class="d-flex justify-content-end">
                <input type="submit" value="Login" class="btn btn-info btn-sm mr-2">
                <input type="reset" value="Cancel" class="btn btn-info btn-sm">
              </div>
            </form>
          </div>

          <div class="card-footer">
            <span>Don't have an account? I don't care</span>
          </div>
        </div>
      </section>
    </div>
  </body>
</html>
