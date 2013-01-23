<?php
include_once('utilities.php');
class MySqlDatabaseHelper {
	//instance of database-helper
	private $dbh;
	private $sth = null;
	private $utilties;

	function __construct($dbname, $host, $username, $password, $dbproto) {
		$this->utilties = new Utilities();
		if($this->utilties->getValid($dbname, $host, $username, $password, $dbproto)){
			try{
				$this->dbh = new PDO($dbproto.":dbname=".$dbname.";host=".$host, $username, $password);
			}catch(Exception $ex){
				die($ex->getMessage()."<br/>");
			}
		}else{
			die("Cannot initialize " .__CLASS__ ."<br/>");
		}
		echo __CLASS__ . " constructor<br />";
	}
	function __destruct() {
		echo __CLASS__ ." destructor<br />";
		unset($this->utilities);
		unset($dbh);
	}
	
	//override in implementation
	function query($query, $bindArray){
		$query = trim($query);
		$this->sth = $this->dbh->prepare($query);
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
	
	function getErrorList(){
		if(!$this->sth)
			return $this->sth->errorInfo();
	}
}
/*class OtherSubClass extends MySqlDatabaseHelper {
    
}*/
?>