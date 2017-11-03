<?php
require_once('classes/session.php');
require_once('classes/user.php');
require_once('classes/subjects.php');
require_once('classes/infos.php');
require_once('classes/regit.php');
require_once('classes/student.php');
require_once('includes/functions.php');
$session = new Session();
if(!$session->is_loggedin())
{
  $session->message("โปรดเข้าสู่ระบบ");
  header('Location: login.php');
}
$_SESSION["last_date"]="";
$ut= new User();
$ut->find_by_id($session->get_user_id());

$ut_data= $ut->get_user();
$subjectss=subjects::subjectss();
?>

<script>
  function startTime() {
    var today = new Date();
    var h = today.getHours();
    var m = today.getMinutes();
    var s = today.getSeconds();
    m = checkTime(m);
    s = checkTime(s);
    document.getElementById('txt').innerHTML =
    h + ":" + m + ":" + s;
    var t = setTimeout(startTime, 500);
  }
  function checkTime(i) {
    if (i < 10) {i = "0" + i};
    return i;
  }
</script>
<!DOCTYPE html>
<html lang="th">
<head>
  <meta http-equiv=Content-Type content="text/html; charset=utf-8">
  <title>ระบบเช็คชื่อ CHECK ATTENDANCE SYSTEM</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="css/bootstrap-responsive.min.css" rel="stylesheet">
  <link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600"
  rel="stylesheet">
  <link href="css/font-awesome.css" rel="stylesheet">
  <link href="css/style.css?v=<?php echo filemtime('css/style.css'); ?>" rel="stylesheet">
  <link href="css/pages/dashboard.css" rel="stylesheet">

  <script src="js/jquery-1.7.2.min.js"></script> 
  <script src="js/excanvas.min.js"></script> 
  <script src="js/bootstrap.js"></script>
  <script src="js/base.js"></script> 
  <script type="text/javascript" src="js/adapter.min.js"></script>
  <script type="text/javascript" src="js/vue.min.js"></script>
  <script type="text/javascript" src="js/instascan.min.js"></script>
  <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
  </head>
  <body onload="startTime()">
    <div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container"> <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"><span
          class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span> </a>
          <a class="brand" href="index.php">
            <i class="shortcut-icon icon-qrcode"></i>
          ระบบเช็คชื่อ CHECK ATTENDANCE SYSTEM</a>
          <div class="nav-collapse">
            <ul class="nav pull-right">
              <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><i
                class="icon-user"></i> <?php echo $ut_data['username']; ?></a>
              </li>
            </ul>
          </div> 
        </div>
      </div>
    </div>
    <div class="subnavbar">
      <div class="subnavbar-inner">
        <div class="container">
          <ul class="mainnav">
            <li class="active"><a href="index.php"><i class="icon-dashboard"></i><span>การจัดการ</span> </a> </li>
            <li><a href="reports.php"><i class="icon-list-alt"></i><span>รายชื่อ</span> </a> </li>
          </ul>
        </div>
      </div>
    </div>