<?php
/*
Does raw queries using PDO. Will add more as the need arises
This serves as the base-class.
*/

require_once('utilities.php');
class SqlDatabaseHelper {
	//instance of database-helper
	private $pdo;
	private $sth = null;

	//constructor
	function __construct($dbname, $host, $username, $password, $dbproto) {
		if(Utilities::getValid($dbname, $host, $username, $password, $dbproto)){
			try{
				$this->pdo = new PDO($dbproto.":dbname=".$dbname.";host=".$host, $username, $password);
			}catch(Exception $ex){
				die($ex->getMessage()."<br/>");
			}
		}else{
			die("Cannot initialize " .__CLASS__ ."<br/>");
		}
	}
	
	function __destruct() {
		
	}
	
	//override in implementation
	function query($query, $bindArray){
		$query = trim($query);
		$this->sth = $this->pdo->prepare($query);
		$this->sth->execute($bindArray);
	}
	
	//returns one row indexed by $id
	function getRow($id){
		$resultArray = $this->getRows();
		return $resultArray[$id];
	}
	
	//returns all rows
	function getRows(){
		$resultArray = $this->sth->fetchAll();
		return $resultArray;
	}
	
	//gets next row, for iteration
	function getNextRow(){
		if($this->sth != null){
			return $this->sth->fetch(PDO::FETCH_ASSOC);
		}
	}
	
	//get error list (!!verify)
	function getErrorList(){
		if(!$this->sth)
			return $this->sth->errorInfo();
	}
}
?>