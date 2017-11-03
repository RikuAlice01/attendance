<?php
require_once('../classes/session.php');
$session = new Session();
if(!$session->is_loggedin())
{
  $session->message("โปรดเข้าสู่ระบบ");
  header('Location: login.php');
}
$_SESSION["last_date"]="";
include("connect.php");
if(empty($_POST["oldpassword"])||empty($_POST["newpassword"])||empty($_POST["renewpassword"])){
	echo "<script language=\"JavaScript\">";
	echo "alert('กรอกข้อมูลไม่ครบ');window.location='change_password.php';";
	echo "</script>";
	exit();
}else{
	if($_POST["newpassword"]!=$_POST["renewpassword"]){
		echo "<script language=\"JavaScript\">";
		echo "alert('รหัสผ่านใหม่ไม่ตรงกัน');window.location='../change.php';";
		echo "</script>";
		exit();
	}else{
		$oldpassword = mysqli_real_escape_string($con,md5($_POST['oldpassword']));
		$strSQL = "SELECT * FROM user WHERE  u_id = '".$_SESSION["user_id"]."'and u_password = '".$oldpassword."';";
		$objQuery = mysqli_query($con,$strSQL);
		$objResult = mysqli_fetch_array($objQuery);
		if(!$objResult)
		{
			$data="รหัสผ่านไม่ถูกต้อง\\n";
			echo "<script language=\"JavaScript\">";
			echo "alert(\"$data\");window.location='change_password.php';";
			echo "</script>";
			exit();
		}else{
			$newpassword = mysqli_real_escape_string($con,md5($_POST['newpassword']));	
			$sql = "UPDATE user SET u_password ='".$newpassword."' WHERE u_id = '".$_SESSION["user_id"]."';";
			$query = mysqli_query($con,$sql);
			if($query) {
				echo "<script language=\"JavaScript\">";
				echo "alert('บันทึกสำเร็จ');window.location='../process/logout.php';";
				echo "</script>";
				exit();
			}else{
				echo "<script language=\"JavaScript\">";
				echo "alert('บันทึกไม่สำเร็จ');window.location='../index.php';";
				echo "</script>";
				exit();   
			}
		mysqli_close($con);
		}

	}
}

?>