<?php
require_once('classes/session.php');
require_once('process/users.php');

$session = new Session();

if($session->is_loggedin())
{
	header('Location: gestion.php');
}

?>

<!DOCTYPE html>
<html lang="TH">

<head>
	<meta http-equiv=Content-Type content="text/html; charset=utf-8">
	<title>ลงทะเบียน - ระบบเช็คชื่อ CHECK ATTENDANCE SYSTEM</title>

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
								<a href="login.php" class="">
									มีบัญชีแล้ว
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



		<div class="account-container register">

			<div class="content clearfix">

				<form action="process/register.php" method="post">

					<h1>ลงทะเบียนใช้งาน</h1>

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

						<p>สร้างบัญชีของคุณ:</p>
						<div class="field">
							<label for="firstname">คำนำหน้า:</label>
							<input type="text" id="titlename" name="firstname" value="" placeholder="คำนำหน้า" class="login" />
						</div>

						<div class="field">
							<label for="firstname">ชื่อ:</label>
							<input type="text" id="firstname" name="firstname" value="" placeholder="ชื่อ" class="login" />
						</div>

						<div class="field">
							<label for="lastname">นามสุกล:</label>
							<input type="text" id="lastname" name="lastname" value="" placeholder="นามสุกล" class="login" />
						</div> 

						<div class="field">
							<label for="email">E-mail:</label>
							<input type="text" id="email" name="email" value="" placeholder="E-mail" class="login"/>
						</div> 

						<div class="field">
							<label for="password">Password:</label>
							<input type="password" id="password" name="password" value="" placeholder="Password" class="login"/>
						</div> 

						<div class="field">
							<label for="confirm_password">Re-Password:</label>
							<input type="password" id="confirm_password" name="confirm_password" value="" placeholder="Re-Password" class="login"/>
						</div> 

					</div> 

					<div class="login-actions">

						<button class="button btn btn-primary btn-large">ลงทะเบียน</button>

					</div> 

				</form>

			</div>

		</div> 

		<script src="js/jquery-1.7.2.min.js"></script>
		<script src="js/bootstrap.js"></script>

		<script src="js/signin.js"></script>

	</body>

	</html>
