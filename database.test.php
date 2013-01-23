<?php
include_once('database.base.php');
//MySqlDatabaseHelper::__construct(databasename, hostname, username, password, protocol [mysql, odbc, etc])

echo "<b>Constructing new DatabaseHelper</b><br/><br/>";
$dbObj = new SqlDatabaseHelper('anirudhr_db', 'localhost','root', 'secretyeah', 'mysql');

echo "<br/><b>Executing SELECT statement</b><br/><br/>";
$dbObj->query('SELECT * FROM status', Array(''));

echo "<br/><b>Getting all rows</b><br/>";
$rows = $dbObj->getRows();
var_dump($rows);

echo "<br/><b>Getting one row at a time</b><br/>";
//$row = $dbObj->getRow(5);
$row = $dbObj->getNextRow();
var_dump($row);

echo "<br/><b>Executing INSERT statement</b><br/>";
$dbObj->query('INSERT INTO status VALUES(?, ?, ?, ?)', Array(null, null, 'new_insert', '1'));

echo "<br/><b>Executing DELETE statement</b><br/>";
$dbObj->query('DELETE FROM status WHERE id = ?', Array('2'));

echo "<br/><b>Executing UPDATE statement</b><br/>";
$dbObj->query('UPDATE status SET message = ? WHERE id = ?', Array('ha ha', '3'));

echo "<br/><b>Getting Error List</b><br/>";
var_dump($dbObj->getErrorList());
?>