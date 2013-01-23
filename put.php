<?php
require_once('status.class.php');
require_once('utilities.php');

if(!(isset($_GET['message']) && isset($_GET['productive']) && isset($_GET['efficiency']) && isset($_GET['auth']))){
	die('Parameters Missing');
}

$message = $_GET['message'];
$productive = $_GET['productive'];
$efficiency = $_GET['efficiency'];

/*logic to authenticate device */
//$auth = $_GET['auth'];



/*end of logic to authenticate device */
$status = Status::getInstance();
$status->putStatus(strval($message), intval($productive), floatval($efficiency));



?>