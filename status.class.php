<?php
/*
new status->set, new status->get
via pdo using databasehelper class
singleton pattern
*/
require_once('utilities.php');
require_once('database.base.php');
require_once('dbconf.php');

class Status{
	private $dbh;
	private static $status; //instance of this class
	const MAX_HOURS = 15;
	
	//get single instance, caching object
	public static function getInstance() {
		if (is_null(self::$status)) {
			self::$status = new Status();
		}
		return self::$status;
	}
	
	//private constructor
	private function __construct() {
		global $DBNAME, $HOST, $USERNAME, $PASSWORD, $PROTOCOL; //use the global values
		$this->dbh = new SqlDatabaseHelper($DBNAME, $HOST, $USERNAME, $PASSWORD, $PROTOCOL);
	}
	
	function __destruct() {
		//stub
	}
	
	//gets latest update from database
	function getStatus(){
		$query = 'SELECT * FROM `status` ORDER BY `id` DESC LIMIT 1';
		$this->dbh->query($query, Array(''));
		$row = $this->dbh->getNextRow();
		$time = $this->processTime($row['timestamp'])
		if($time != 0){
			//all fine
		
		}else{
			//error
			return null;
		}
	}
	
	//updates status at database
	function putStatus($status, $isProductive){
		//perform checks
	
	
		$query = 'INSERT INTO status VALUES(?, ?, ?, ?)';
		$this->dbh->query($query, Array(null, null, $status, $isProductives));
	}
	
	function processTime($time){
		$unix_time = strtotime($time);
		
		//check if newer-time already exists
		if($unix_time > time())
			return 0;
		
		$hourdiff = round((time() - strtotime($time)/3600), 0);
		//cannot do a single task for more than 15 hours
		if($hourdiff > MAX_HOURS)
			return $unix_time + MAX_HOURS*3600;
		else
			return $unix_time;
	}


}
?>