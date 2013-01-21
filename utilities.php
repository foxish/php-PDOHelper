<?php
	class Utilities{
		//default constructor
		function __construct(){
			//stub
		}
		function __destruct() {
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
?>