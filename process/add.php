<?php
require_once '../classes/database.php';
require_once '../classes/user.php';
require_once '../classes/session.php';
require_once '../classes/student.php';
require_once '../classes/regit.php';
require_once '../classes/subjects.php';
require_once 'users.php';
$session = new Session();
if(!empty($_POST['fstudent'])) {
	$ou = new Student();
	$register_data = array(
        'id_student' => ucfirst($_POST['idstudent']),
        'titlename' => ucfirst($_POST['titlestudent']),
        's_lastname' => ucfirst($_POST['lstudent']),
        's_firstname' => ucfirst($_POST['fstudent']),
        'qrcode' => $_POST['qrcode']
    );
	foreach ($register_data as $key => $value) {
		$ou->set_student($key,$value);
	}
	$ou->create();
   $id_student = new Student();
   $id_student->find_by_id_student(ucfirst($_POST['idstudent']),$_POST['subjects']);
   header('Location: ../management.php?id=' . $_POST['subjects']);
}
if(!empty($_POST['sid'])&&!empty($_POST['id'])) {
    $ou = new Regit();
    $register_data = array(

        'u_id' =>  $_SESSION["user_id"],
        'sub_id' =>  $_POST['id'],
        'id_student' =>  $_POST['sid']
    );
    foreach ($register_data as $key => $value) {
        $ou->set_regit($key,$value);
    }
    $ou->created();
    header('Location: ../management.php?id=' . $_POST['id']);
}
if(!empty($_POST['s_number'])) {
	$ch = new Subjects();
	$register_data = array(
		's_number' => ucfirst($_POST['s_number']),
		's_name' => ucfirst($_POST['s_name']),
        'u_id' => $_SESSION["user_id"]
    );
	foreach ($register_data as $key => $value) {
		$ch->set_subjects($key,$value);
	}
	$ch->create();
}
header('Location: ../management.php?id=' . $_POST['id']);