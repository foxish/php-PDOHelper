<?php
class MySqlDatabaseHelper {
	//instance of database-helper
	private $dbh;
	private $table;
	private $utilties;
	function __construct($dbname, $host, $user_name, $password, $dbproto) {
		$utilties = new Utilities();
		if($utilties->getValid($dbname, $host, $user_name, $password, $dbproto)){
			try{
				$dsn = "$dbproto:dbname=$dbname;host=$host";
				$dbh = new PDO( $dsn, $user_name, $password);
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
	
	//override in child
	function select($query, $bindArray){
		$query = trim($query);
		if($this->utilties->startsWith($query, __FUNCTION__, false)){
			
		}
		else{
			print "malformed ". __FUNCTION__ . "<br/>" ;
		}
	}
	
	//override in implementation
	function insert(){
		
	}
	
	//override in implementation
	function update(){
		
	}
	
	//override in implementation
	function delete(){
		//stub
	}
	
	//override in implementation
	function raw_query(){
		//!careful
	}
	
}

class Utilities{
	//default constructor
	function __construct(){
		//stub
	}
	
	//gets if all params passed are set. Can take any number of args
	function getValid(/*multiple params*/){
		for($i = 0; $i<func_num_args(); $i++){
			$arg = func_get_arg($i);
			if(!isset($arg))
				return false;
		}
		return true;
	}
	function startsWith($haystack,$needle,$case=true)
	{
	   if($case)
		   return strpos($haystack, $needle, 0) === 0;

	   return stripos($haystack, $needle, 0) === 0;
	}

}
/*class OtherSubClass extends MySqlDatabaseHelper {
    
}*/


?>