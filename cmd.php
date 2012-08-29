<?php

/**
 * A bunch function to make CMD scripting easier.
 *
 * This is for PHP runed in the terminal (CLI).
 * One goal for these function is to allow the user to write shorter code.
 * Another goal is to allow the use to write fucked up'ed code like:
 *     @example: e('one') and e('two') and e(); ->
 *       "one
 *		  two
 *		 "
 * Note the `and` syntax.
 * Do you prefer `or` syntax? Change `defaultReturnValue` to false! Pros: Shorter; cons: fuckeduplogic. :D
 *
 * @author Sony? aka Sawny @4morefun.net
 * @todo 1) Create subpackegs
 * @todo 2) Add functions for easy SQLite mangement. Like:
 *				`SQLite::create('my_brand_new_database');
 *				 SQLite::*column* = new data
 *				 SQLite::*column*; //get data from *column*
 *				 SQLite::save(array('column' => 'value'))`
 */
 

 
// Define things
//--------------------------------------------
define("nl", PHP_EOL);
define("escChars", true); //If windows: set to false if you don't have ANSICON.
define("defaultReturnValue", true); //true = AND syntax, false = OR syntax. `e("Hi") AND e("wtf")` VS `e("Hi") OR e("WTF logics?!")`.
 

// Random shite
//--------------------------------------------
assert_options(ASSERT_ACTIVE,     1);
assert_options(ASSERT_WARNING,    0);
assert_options(ASSERT_QUIET_EVAL, 1);
assert_options(ASSERT_CALLBACK,   'assertCallback');

function assertCallback() {
    return false;
}



//--------------------------------------------
// Functions
//--------------------------------------------
 
//Short cut for echo $string . PHP_EOL;
//
//@example `e("First line", "Second line");` ->
//    "First line
//     Second line
//    "
//@example `e();` ->
//    "
//    "
function e() {

    echo (func_num_args() === 0) ? nl : ''; //Just print a line feed
	
    foreach(func_get_args() as $arg) { //Loop through all args, print them with a sufixing new line
	    echo $arg . nl;
	}
    
	return defaultReturnValue; //Allow the "AND" or the "OR" syntax. @example `e('Hi') AND e('this syntax') AND e('is fuckedup');`
}


 
// @example getArg(1) -> returns first arg that was sent via the command line. If no arg was set it will return false
// @example getArg(3, "Ange argument tre!") -> returns third arg that was sent via the command line.
//    If no arg was set it will print "Ange argument tre!" and STOP executiin.
// @example getArg(7, "Argument 7 måste vara sttöre än 10", '> 10') -> returns third arg that was sent via the command line.
function getArg($num, $errorMess = "", $condition = "")
{
    global $argv;
	
	//if condition inte har $1, kör $argv[$num] ." ". $condition
	//annars, gör om alla $1 till $argv[$num] och kör $condition
	
    if(isset($argv[$num]) AND $condition === "" OR
	      (isset($argv[$num]) AND
		   $condition != ""   AND
		   assert($argv[$num] ." ". $condition) === true))
	{
	    $arg = $argv[$num];

	    //If INT, then return a int, thx. :)
	    return (preg_match("~^[0-9]+$~", $arg)) ? intval($arg) : $arg;
	}
	elseif(empty($errorMess)) {
	    return false;
	}
	else {
	    exit($errorMess);
	}
}



//Sleep x milliseconds
function wait($ms = 100) {
    usleep($ms * 1000);
	
	return defaultReturnValue; //Allows fucked up AND syntax
}

function w8($ms = 100) { wait($ms); }



//Clear screen
function clear()
{
	if(escChars) {
		echo chr(27) ."[2J";
	}
	else {
		for ($i=0; $i < 500; $i++) { 
			echo nl;
		}
	}

	return defaultReturnValue;
}



//Prompt the user for something
function prompt($question, $validation = null, $defaultValue = null)
{
	while(true)
	{
		echo $question .' ';
		$usrInp = trim(fgets(STDIN));

		//Validation
		if(isset($validation) AND isset($defaultValue))
		{
			if(assert($usrInp .' '. $validation) !== true) { //Validation failed, return default value
				$usrInp = $defaultValue;
			}

			break 1;
		}
		elseif(isset($validation))
		{
			if(assert($usrInp .' '. $validation) === true) { //Ask untill the validation pass
				e();
				break 1;
			}
		}
		else {
			break 1; //Don't even care about what the user typed
		}
	}

	return $usrInp;
}



//Print new lines
function nl($i = 1) {
	while($i > 0) {
		echo nl;

		$i--;
	}

	return defaultReturnValue;
}


/**
 * Debug something
 *
 * @TODO: Colors
 * @TODO: Check if you can check resource type, and if its a file handler. Check if the file exist, can be writen to, readed etc.
 */
function debug($mess, $var = null)
{
	echo $mess . nl;
	
	if($var !== null)
	{
	    switch(gettype($var))
		{
		    case "array":
			case "object":
			    print_r($var);
			break;
			
			case "integer":
			case "double":
			case "boolean":
			    var_dump($var);
			break;
			
			/*case "string":
			    echo $var;
			break;*/
			
			case "resource":
			    echo get_resource_type($var);
			break;
			
			default:
			    var_dump($var);
			break;
		}
		
		echo nl;
	}
	
	return defaultReturnValue;
}

?>