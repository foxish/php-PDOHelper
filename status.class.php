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
	/*
	pass back array of the following values:
	(current_task_name   #could be task-name, blank when no task running, unknown when (time elapsed in task > 15)
	time_last_updated    #whether or not valid, return unabridged (timestamp)
	time elapsed in task #hours, =MIN(current_time - time_last_updated, MAX_HOURS) (
	productive           #interruptions allowed?
	efficiency           #snapshot of efficiency
	*/
	function getStatus(){
		$query = 'SELECT * FROM `status` ORDER BY `id` DESC LIMIT 1';
		$this->dbh->query($query, Array());
		$row = $this->dbh->getNextRow();
		
		$time = strtotime($row['timestamp']);
		$timeElapsed = $this->getTimeElapsed($time);
		
		$message = $row['message'];
		if($timeElapsed == -1){
			$message = "unknown";
		}else if($timeElapsed == 0){
			$message = "none";
		}
		
		$result = Array($message, $time, $timeElapsed, $row['productive'], $row['efficiency']);
	}
	
	//updates status at database
	function putStatus($status, $isProductive, $efficiency){
		//perform checks
	
	
		$query = 'INSERT INTO status VALUES(?, ?, ?, ?, ?)';
		$this->dbh->query($query, Array(null, null, $status, $isProductive, $efficiency));
	}
	
	function getTimeElapsed($time){		
		//check if newer-time already exists
		$timeDiff = time() - $time;
		if($timeDiff < 0)
			return 0; //error condition, should never happen

		//cannot do a single task for more than MAX_HOURS hours
		if($timeDiff > MAX_HOURS*3600)
			//show unknown task
			return -1;
		else
			return round($timeDiff, 0);
	}


}
?>