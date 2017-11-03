<?php
require_once'../classes/database.php';
require_once'../classes/user.php';
require_once'../classes/session.php';
require_once'users.php';
$session = new Session();
if (!empty($_POST)) {
   $username = trim($_POST['username']);
   $pass = trim($_POST['pass']);
}
if (empty($_POST['username']) || empty($_POST['pass'])) {
   $session->message( 'โปรดป้อนชื่อผู้ใช้และรหัสผ่านของคุณ');
   header('Location: ../login.php');
}
elseif (!user_exists($username)) {
   $session->message( 'รหัสนี้ไม่ถูกต้องคุณได้ลงทะเบียนแล้วหรือยัง?');
   header('Location: ../login.php');
}
elseif (!user_active($username)) {
  $_SESSION['username'] = $username;
  $session->message('คุณยังไม่ได้เปิดใช้งานบัญชีของคุณ');
  header('Location: ../login.php');
} else {
  $ut = new User();
  $login = $ut->authenticate($username, $pass);
  if (!$login) {
      $session->message( 'การเข้าสู่ระบบไม่สำเร็จ / รหัสผ่านไม่ถูกต้อง');
      header('Location: ../login.php');
  } else {
    $data=$ut->get_user();
    $session->login($data["u_id"],true);
    $session->remember_me();
    header('Location: ../management.php');
}
}
?>