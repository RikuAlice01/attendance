<?php
require_once '../classes/database.php';
require_once '../classes/user.php';
require_once '../classes/session.php';
require_once '../classes/student.php';
require_once '../classes/infos.php';
require_once '../classes/subjects.php';
require_once 'users.php';
$session = new Session();
if(!$session->is_loggedin())
{
	$session->message("โปรดเข้าสู่ระบบ");
	header('Location: login.php');
}
if(!empty($_POST['idsubjects'])) {
	$ch = new subjects();
	$ch->find_by_id($_POST['idsubjects']);
	$ch->delete();
	header('Location: ../management.php');
} else if(!empty($_POST['idstudent'])) {
	$ou = new Student();
	$ou->find_by_id($_POST['idstudent']);
	$ou->delete();
	header('Location: ../management.php?id='. $_POST['subjectsid']);
} else if(!empty($_POST['idregit'])&&!empty($_POST['subjectsid'])&&!empty($_POST['o_id'])) {
	$in = new Infos();
	$in->find_by_id_oid($_POST['o_id']);
	$in_data = $in->get_infos();
	$in->delete();
	$ou = new Regit();
	$ou->find_by_id($_POST['idregit']);
	$ou->delete();
	header('Location: ../management.php?id='. $_POST['subjectsid']);
} else if(!empty($_POST['regit'])&&!empty($_POST['subjectsid'])) {
	$ou = new Regit();
	$ou->find_by_id($_POST['regit']);
	$ou->delete();
	header('Location: ../reports.php?');
} else if(!empty($_POST['idinfo'])) {
	$in = new Infos();
	$in->find_by_id($_POST['idinfo']);
	$in_data = $in->get_infos();
	$in->delete();
	header('Location: ../reports.php?id='. $in_data['o_id']);    
}