<?php
require_once('status.class.php');
$status = Status::getInstance();
$row = $status->getStatus();
var_dump($row);

?>