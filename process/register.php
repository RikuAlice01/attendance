<?php
	require_once(__DIR__.'/../classes/database.php');
	require_once(__DIR__.'/../classes/user.php');
	require_once(__DIR__.'/../classes/session.php');
	require_once(__DIR__.'/users.php');
  	$session = new Session();
  	$valid = true;
	if (!empty($_POST)) {
	  $requiredFields = array('titlename','firstname', 'lastname', 'email', 'password', 'confirm_password');
	  foreach ($_POST as $key => $value) {
	    if (empty($value) && in_array($key, $requiredFields)) {
	      $session->message('กรอกข้อมูลไม่ครบ.');
	      $valid = false;
	      header('Location: ../signup.php');
	    }
	  }
	if(!$session->is_there_any_msg()) {
	  if (user_exists($_POST['email'])) {
	    $session->message('ผิดพลาด \'adresse email: ' . $_POST['email'] . ' มีการใช้งานโดยสมาชิกคนอื่นแล้ว');
	    $valid = false;
	    header('Location: ../signup.php');
	  }
	  if (strlen($_POST['password']) < 6) {
	    $session->message('รหัสผ่านต้องมีอักขระตั้งแต่ 6 ตัวขึ้นไป');
	    $valid = false;
	    header('Location: ../signup.php');
	  }
	  if ($_POST['password'] !== $_POST['confirm_password']) {
	    $session->message('รหัสผ่านที่ป้อนไม่ตรงกัน');
	    $valid = false;
	    header('Location: ../signup.php');
	  }
	}
}
  	if ($valid) {
		$register_data = array(
			'titlename' => ucfirst($_POST['titlename']),
			'u_lastname' => ucfirst($_POST['lastname']),
			'u_firstname' => ucfirst($_POST['firstname']),
			'username' => $_POST['email'],
			'u_password' => md5($_POST['password']),
			'u_verification' => 1,
		);
		$_SESSION['data'] = $register_data;
		$_SESSION['code'] = $emailcode;
		$ut = new User();
		foreach ($register_data as $key => $value) {
			$ut->set_user($key,$value);
		}
		if ($ut->create()) {
			header('Location: ../login.php');
		} else {
			var_dump($ut);
		}
	}
