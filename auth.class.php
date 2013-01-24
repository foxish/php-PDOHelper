<?php
require_once('utilities.php');
class Auth{
	private $userAuth = null;
	const SALT = "";
	const PEPPER = "";
	
	function __construct($userAuth){
		if(Utilities::getValid($userAuth))
			$this->userAuth = $userAuth;
		else
			die("Invalid parameter passed to __CLASS__");
	}
	function __destruct(){
		//stub
	}
	

	function validateUser(){
	
		return false;
	}

}
?>