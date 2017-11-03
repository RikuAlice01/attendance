<?php
require_once('classes/session.php');

$session = new Session();

if($session->is_loggedin())
{
	header('Location: management.php');
}

?>
<!DOCTYPE html>
<html lang="th">

<head>
	<meta http-equiv=Content-Type content="text/html; charset=utf-8">
	<title>ระบบเช็คชื่อ CHECK ATTENDANCE SYSTEM</title>

	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<meta name="apple-mobile-web-app-capable" content="yes"> 

	<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	<link href="css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css" />
	
	<link href="css/font-awesome.css" rel="stylesheet">
	<link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600" rel="stylesheet">

	<link href="css/style.css?v=<?php echo filemtime('css/style.css'); ?>" rel="stylesheet">

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
					<i class="shortcut-icon icon-qrcode"></i>
				ระบบเช็คชื่อ CHECK ATTENDANCE SYSTEM</a>					

			</div> 

		</div> 

	</div>



	<div class="container">

		<div class="row">

			<div class="span12">

				<div class="error-container">
					<h2>ยินดีต้อนรับเข้าสู่ระบบ</h2>
					<br>
					<div>
						<?php
						echo '<img src="qrs/qrcodescan.png" />';
						?>
						<br><br>
					</div>
					<div class="error-details">
						เว็บไซต์สำหรับการจัดการการเข้าเรียน
						<br>
						<br>รายวิชา 523495 COMPUTER ENGINEERING PROJECT I
						<br>โครงงานวิศวกรรมคอมพิวเตอร์ 1	
						<br>
						<br>
						<br>จัดทำโดย
						<br>B5720651 นายสิทธิชัย สิริฤทธิกุลชัย
						<br>
						<br>
						<br>อาจารย์ที่ปรึกษา:	ผู้ช่วยศาสตราจารย์ ดร.ปรเมศวร์ ห่อแก้ว
						<br>
						<br>
						<br>สำนักวิศวกรรมศาสตร์ สาขาวิศวกรรมคอมพิวเตอร์
						<br>มหาวิทยาลัยเทคโนโลยีสุรนารี

					</div>			
					<div class="error-actions">
						<a href="login.php" class="btn btn-large btn-primary">
							&nbsp;
							เข้าสู่ระบบ						
							<i class="icon-chevron-right"></i>
						</a>

					</div>

				</div> 		

			</div> 

		</div> 

	</div> 


	<script src="js/jquery-1.7.2.min.js"></script>
	<script src="js/bootstrap.js"></script>
</body>

</html>
