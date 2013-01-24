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
	private $timeZone = 'Asia/Calcutta';
	
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
		$this->setTimeZones();
	}
	
	function setTimeZones(){
		//set PHP timezone
		date_default_timezone_set($this->timeZone);
		$this->dbh->query("SET SESSION time_zone = '+5:30'", Array());
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
		$result = $this->dbh->getNextRow();
		
		
		//get timestamp
		$timeElapsed = $this->getTimeElapsed(strtotime($result['timestamp']));
		
		//add timeElapsed field
		if($timeElapsed === -1){
			$result['message'] = "Error";
			$result['timeElapsed'] = 0;
		}
		elseif($timeElapsed === -2){
			$result['message'] = "Unknown";
			$result['timeElapsed'] = 0;
		}else{
			$result['timeElapsed'] = $timeElapsed;
		}
		
		//use productive array
		if($result['productive'] == 1){
			$result['available'] = "No*";
		}else{
			$result['available'] = "Yes";
		}
		
		//format timestamp
		$result['timestamp'] = date('h:i A @ d-m-Y', strtotime($result['timestamp'])); 
		
		//format timeElapsed
		$time = intval($result['timeElapsed']);
		$result['timeElapsed'] = $this->secsToTime($time);
		
		return $result;
	}
	
	//updates status at database
	function putStatus($message, $isProductive, $efficiency){
		//perform checks
		assert($isProductive == 0 or $isProductive == 1);
		assert($efficiency < 100);
		if(Utilities::getValid($message, $isProductive, $efficiency)){
			$query = 'INSERT INTO status VALUES(?, ?, ?, ?, ?)';
			$this->dbh->query($query, Array(null, null, $message, $isProductive, $efficiency));
		}	
	}
		
	function getTimeElapsed($time){		
		//check if newer-time already exists
		$timeDiff = time() - $time;
		if($timeDiff < 0)
			return -1; //error condition, should never happen

		//cannot do a single task for more than MAX_HOURS hours, impossibru!
		if($timeDiff > self::MAX_HOURS * 3600)
			//show unknown task
			return -2;
		else
			return $timeDiff;
	}
	//converts seconds to hh:mm:ss (http://stackoverflow.com/a/3534705/)
	function secsToTime($seconds) {
		$t = round($seconds);
		return sprintf('%02d:%02d', ($t/3600),($t/60%60));
	}
}
?>