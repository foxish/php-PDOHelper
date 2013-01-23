<?php
include_once('database.base.php');
//MySqlDatabaseHelper::__construct(databasename, hostname, username, password, protocol [mysql, odbc, etc])
$dbObj = new MySqlDatabaseHelper('anirudhr_db', 'localhost','root', 'secretyeah', 'mysql');
$dbObj->query('SELECT * FROM status', Array(''));
$row = $dbObj->getRow(4);
var_dump($row);
$row = $dbObj->getNextRow();
var_dump($row);

$dbObj->query('INSERT INTO status VALUES(?, ?, ?, ?)', Array(null, null, 'new_insert', '1'));
$dbObj->query('DELETE FROM status WHERE id = ?', Array('2'));
$dbObj->query('UPDATE status SET message = ? WHERE id = ?', Array('ha ha', '3'));
var_dump($dbObj->getErrorList());
?>