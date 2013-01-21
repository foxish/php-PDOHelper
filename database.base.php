<?php
class MySqlDatabaseHelper {
	//name of base
	private $name = "MySqlDatabaseHelper";

	//database parameters
	private $dbproto;
	private $host;
	private $username;
	private $password;
	private $dbname;
	
	
	//utility class
	private $utilties;
	
	//instance of database-helper
	private $dbh;
	function __construct($dbname, $host, $username, $password, $dbproto) {
		$utilties = new Utilities();
		if($utilties->getValid($dbname, $host, $username, $password, $dbproto)){
			try{
				$dbh = new PDO($dbproto.":dbname=".$dbname.";host=".$host, $username, $password);
			}catch(Exception $ex){
				die($ex->getMessage()."<br/>");
			}
		}else{
			die("Cannot initialize $this->name <br/>");
		}
		echo "$this->name constructor<br />";
   }
   
    function __destruct() {
		echo "$this->name destructor<br />";
		unset($utilities);		
		unset($dbh);
   }
}

class Utilities{
	//default constructor
	function __construct(){
		//stub
	}
	
	//gets if all params passed are set. Can take any number of args
	function getValid(){
		for($i = 0; $i<func_num_args(); $i++){
			$arg = func_get_arg($i);
			if(!isset($arg))
				return false;
		}
		return true;
	}
}
/*class OtherSubClass extends MySqlDatabaseHelper {
    
}*/


?>