<?PHP
/**
 * Return an object from a class file
 *
 * Parm 1 Application name - this wil corrilate with the direcory name
 * Parm 2 Classname this will match with the file name class.<Classname>.inc.php
 * Parm 3 ...n passed to class
 *
 */
function &createObject($appName, $className){
	$classFileName = $GLOBALS['lasloSystemGlobals']['rootDir'].'/app/'.$appName.'/inc/class.'.$className.'.inc.php';
	if (!file_exists($classFileName)){
		echo(__FUNCTION__."($className) file $classFileName not found!");
		exit();
	}
	// this will stop php with a 500, if the class does not exist or there are errors in it (syntax error go into the error_log)
	require_once($classFileName);
	$args = func_get_args();
	if(count($args) == 2 ){
		$obj = new $className;
	} else {
		$code = '$obj = new ' . $className . '(';
		foreach($args as $n => $arg){
			if ($n > 1){
				$code .= ($n > 2 ? ',' : '') . '$args[' . $n . ']';
			}
		}
		$code .= ');';
		eval($code);
	}
	if (!is_object($obj)){
		echo "<p>CreateObject('app, $class'): instanciate class faild!<br /></p>\n";
	}
	return $obj;
}
/*
*
*	checks to see if terminal is logged in
*
*
*/
function isLoggedIn(){
	//
	// need to add cockies too.
	//
	session_start();
	$message="";
	if(isset($_POST['user_id'])){
		if($_POST['user_id'] == 'user1') {
			$_SESSION["user_id"] = 1001;
			$_SESSION["user_name"] = 'user1';
			
		} elseif($_POST['user_id'] == 'user2') {
			$_SESSION["user_id"] = 1002;
			$_SESSION["user_name"] = 'user2';
			
		} elseif($_POST['user_id'] == 'user3') {
			$_SESSION["user_id"] = 1003;
			$_SESSION["user_name"] = 'user3';
			
		} else {
			echo "Invalid Username or Password!";
		}
	}
#	print_r($_SESSION);
	// remove all session variables
//session_unset();

// destroy the session
//session_destroy(); 
	
	if(isset($_SESSION["user_id"])) {
		return true;
	}
	return false;
}

function isLoginSessionExpired() {
	$login_session_duration = 10; // global var
	$current_time = time(); 
	if(isset($_SESSION['loggedintime']) and isset($_SESSION["user_id"])){  
		if(((time() - $_SESSION['loggedintime']) > $login_session_duration)){ 
			return true; 
		} 
	}
	return false;
}
/*
*
*	brings up the login prompt.
*
*
*/
function PromptLogin(){
	echo('
<html>
	<head>
		<title>Login</title>
	</head>
	<body>
		<form method="post" action="index.php">
			Username: <input type="text" name="user_id" /><br>
			Password: <input type="text" name="password" /><br>
			<input type="submit" value="Let me in" /><br>
		</form>
	</body>
</html>
	');
}

function isUserAllowedApplication($userId, $application){
	//
	// This will come from the database  user profile and groups the user belongs to.
	//
	
	if($userId == 1001 AND ($application == 'app1' OR $application == 'app2' OR $application == 'app3' )){
		return true;
	} elseif($userId == 1002 AND ($application == 'app1' OR $application == 'app2' )){
		return true;
	} elseif($userId == 1003 AND ( $application == 'app2' OR $application == 'app3' )){
		return true;
	} elseif($application == 'baseapi' OR $application == 'home') {
		return true;
	} else {
		return false;
	}
	return false;
}

