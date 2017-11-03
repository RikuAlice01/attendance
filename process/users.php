<?php
require_once(__DIR__.'/../classes/database.php');
require_once(__DIR__.'/../classes/user.php');
require_once(__DIR__.'/../classes/session.php');
global $id;
function user_exists($username)
{
	global $db;
	$sql = 'SELECT u_id FROM user WHERE username = :username';
	$re=$db->query($sql,array("username"=>$username));
	$resultat=$re->fetch();

	if (empty($resultat)) {
		return false;
	} else {
		$GLOBALS['id'] = $resultat['u_id'];
		return true;
	}
}
function user_active($username)
{
	global $db;
	$sql = 'SELECT u_id FROM user WHERE username = ? AND u_verification = ?';
	$re=$db->query($sql,array($username, 1));
	$resultat=$re->fetch();
	if (empty($resultat)) {
		return false;
	} else {
		return true;
	}
}
