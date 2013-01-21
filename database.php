<?php
include_once('database.base.php');
//MySqlDatabaseHelper::__construct(databasename, hostname, username, password, protocol [mysql, odbc, etc])
$dbObj = new MySqlDatabaseHelper('anirudhr_db', 'localhost','root', 'secretyeah', 'mysql');
$dbObj->query('SELECT * FROM status', Array(''));
$row = $dbObj->getNextRow();
var_dump($row);
//$obj = new BaseClass();
//$obj = new SubClass();
//$obj = new OtherSubClass();
?>