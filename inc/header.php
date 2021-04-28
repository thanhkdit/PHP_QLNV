<?php
  include '../../lib/session.php';
  Session::checkSession();
?>

<?php
  header("Cache-Control: no-cache, must-revalidate");//Tang tinh bao mat (vd: sau khi logout -> ko lưu dữ liệu trang trước)
  header("Pragma: no-cache");
  header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); //Thoi gian song cua cookies
  header("Cache-Control: max-age=3600");         //Thoi gian du lieu duoc luu tru trong bo nho dem
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quan Ly Nhan Vien</title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/inc/header.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="../../css/inc/sidebar.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="../../css/inc/footer.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="../../css/view/index.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="../../css/view/department.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="../../css/view/contract.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="../../css/view/level.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="../../css/view/bonus_info.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="../../css/view/bonus_detail.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="../../css/view/fine_info.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="../../css/view/fine_detail.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="../../css/view/employee.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="../../css/view/position.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="../../css/check_data_input/check.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="../../Fontawesome/css/all.css?v=<?php echo time(); ?>">
    <script src="../../bootstrap/js/jquery-3.5.1.slim.min.js"></script>
    <script src="../../bootstrap/js/jquery-3.5.1.min.js"></script>
    <script src="../../bootstrap/js/bootstrap.min.js"></script>
    <script src="../../bootstrap/js/bootstrap.js"></script>
</head>
<body>
  <section class="header">
    <div class="info">
      <h2>Nhóm 20</h2>
      <div class="members">
        <span>Thành viên:</span>
        <div class="member">
          <span>Kiều Đăng Thành - 188062</span>
          <span>Tô Thị Thu - 197162</span>
          <span>Trần Thanh Duy - 41162</span>
        </div>
      </div>

    </div>
    <div class="title">
      <img src="../../imgs/logo.jpg" alt="">
      <div class="text">
        <h1>Quản Lý Nhân Viên</h1>
        <span>Dòng này</span>
        <span>Để cho đỡ trống</span>
      </div>
    </div>
    <div class="user">
      <span>Hello: <?php echo Session::get('username') ?></span>
      <?php
        if (isset($_GET['action']) && $_GET['action'] == 'logout'){
          Session::destroy();
        }
      ?>
      <a href="?action=logout">Logout</a>
    </div>
  </section>
