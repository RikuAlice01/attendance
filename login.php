<?php
require_once('classes/session.php');

$session = new Session();

if($session->is_loggedin())
{
	header('Location: management.php');
}

?>

<!DOCTYPE html>
<html lang="TH">

<head>
	<meta http-equiv=Content-Type content="text/html; charset=utf-8">
	<title>หน้าเข้าสู่ระบบ - ระบบเช็คชื่อ CHECK ATTENDANCE SYSTEM</title>

	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<meta name="apple-mobile-web-app-capable" content="yes"> 

	<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	<link href="css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css" />

	<link href="css/font-awesome.css" rel="stylesheet">
	<link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600" rel="stylesheet">

	<link href="css/style.css?v=<?php echo filemtime('css/style.css'); ?>" rel="stylesheet">
	<link href="css/pages/signin.css" rel="stylesheet" type="text/css">

</head>

<body>
	
	<div class="navbar navbar-fixed-top">

		<div class="navbar-inner">

			<div class="container">

				<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</a>

				<a class="brand" href="index.php">
					<a class="brand" href="index.php">
						<i class="shortcut-icon icon-qrcode"></i>
					ระบบเช็คชื่อ CHECK ATTENDANCE SYSTEM</a>		

					<div class="nav-collapse">
						<ul class="nav pull-right">

							<li class="">						
								<a href="signup.php" class="">
									ยังไม่มีบัญชี?
								</a>

							</li>

							<li class="">						
								<a href="index.php" class="">
									<i class="icon-chevron-left"></i>
									หน้าหลัก
								</a>

							</li>
						</ul>

					</div>

				</div>

			</div>

		</div>



		<div class="account-container">

			<div class="content clearfix">

				<form action="process/login.php" method="post">

					<h1>เข้าสู่ระบบ</h1>		

					<div class="login-fields">
						<?php 
						if ($session->message()) {
							echo '<div class="alert alert-info">
							<button type="button" class="close" data-dismiss="alert">
							&times;</button>';
							echo $session->message(); 
							echo "</div>";    
						}
						?> 

						<div class="field">
							<label for="username">Username</label>
							<input type="text" id="username" name="username" value="" placeholder="ผู้ใช้งาน" class="login username-field" required/>
						</div> <!-- /field -->

						<div class="field">
							<label for="password">Password</label>
							<input type="password" id="pass" name="pass" value="" placeholder="รหัสผ่าน" class="login password-field" required/>
						</div>

					</div>

					<div class="login-actions">

						<span class="login-checkbox">
							<input id="Field" name="Field" type="checkbox" class="field login-checkbox" value="First Choice" tabindex="4" />
							<label class="choice" for="Field">จดจำบัญชี</label>
						</span>

						<button class="button btn btn-success btn-large">เข้าสู่ระบบ</button>

					</div>



				</form>

			</div>

		</div>



		<div class="login-extra">
		</div>


		<script src="js/jquery-1.7.2.min.js"></script>
		<script src="js/bootstrap.js"></script>
		<script src="js/signin.js"></script>

	</body>

	</html>
