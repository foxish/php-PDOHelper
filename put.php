<?php
require_once('status.class.php');
$status = Status::getInstance();
$result = $status->putStatus(time(), 0, 20);//$status, $isProductive, $efficiency



?>