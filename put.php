<?php
require_once('status.class.php');
require_once('auth.class.php');

if(!(isset($_GET['message']) && isset($_GET['productive']) && isset($_GET['efficiency']) && isset($_GET['auth']))){
	die('Parameters Missing');
}

//check validity
$message = $_GET['message'];
$productive = $_GET['productive'];
$efficiency = $_GET['efficiency'];
$auth = $_GET['auth'];

//construct object instances
$statusObj = Status::getInstance();
$authObj = new Auth($auth);

//authenticate and output
if($authObj->validateUser()){
	$statusObj->putStatus(strval($message), intval($productive),floatval($efficiency));
	echo "Authentication Succeeded<br/>";
}else{
	echo "Authentication Failed<br/>";
}
?>