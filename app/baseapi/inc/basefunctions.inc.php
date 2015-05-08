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
	// this will stop php with a 500, if the class does not exist or there are errors in it 
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

function getUrlVar($varName, $varType='all'){
	$retVar = '';
	if($varType == 'all'){
		if(isset($_GET[$varName])){
			$retVar = $_GET[$varName];
		} else {
			if(isset($_POST[$varName])){
				$retVar = $_POST[$varName];
			}
		}
	} elseif($varType == 'get'){
		if(isset($_GET[$varName])){
			$retVar = $_GET[$varName];
		}
	} elseif($varType == 'post'){
		if(isset($_POST[$varName])){
			$retVar = $_POST[$varName];
		}
	}
	return $retVar;
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
	
	if(isset($_POST['userId'])){
	
		$user = $GLOBALS['lasloSystemGlobals']['db']['connection']->select('sysUserList','sulIndexId',array('sulUserId[=]'=>getUrlVar('userId')));	
		if(count($user) == 1){
			$_SESSION["userId"] = $user[0]['sulIndexId'];
		} else {
			echo "Invalid credentials.";
		}
	}
	
	if(isset($_SESSION["userId"])) {
		loadUserArray($_SESSION["userId"]);
		return true;
	}
	return false;
}

function loadUserArray($userIndexId){
	
	$user = $GLOBALS['lasloSystemGlobals']['db']['connection']->select('sysUserList','*',array('sulIndexId[=]'=>$userIndexId));	
	
	$GLOBALS['lasloSystemGlobals']['user']['sulIndexId'] 						= $user[0]['sulIndexId'];
	$GLOBALS['lasloSystemGlobals']['user']['sulUserId'] 						= $user[0]['sulUserId'];
	$GLOBALS['lasloSystemGlobals']['user']['sulPasswordId'] 				= $user[0]['sulPasswordId'];
	$GLOBALS['lasloSystemGlobals']['user']['sulLastLogin'] 					= $user[0]['sulLastLogin'];
	$GLOBALS['lasloSystemGlobals']['user']['sulLastLoginFrom'] 			= $user[0]['sulLastLoginFrom'];
	$GLOBALS['lasloSystemGlobals']['user']['sulLastPasswordChange'] = $user[0]['sulLastPasswordChange'];
	$GLOBALS['lasloSystemGlobals']['user']['sulAccountStatus'] 			= $user[0]['sulAccountStatus'];
	$GLOBALS['lasloSystemGlobals']['user']['sulAccountType'] 				= $user[0]['sulAccountType'];
}


function isLoginSessionExpired() {
	$login_session_duration = 10; // global var
	$current_time = time(); 
	if(isset($_SESSION['loggedintime']) and isset($_SESSION["userId"])){  
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
function promptLogin(){
	echo('
<html>
	<head>
		<title>Login</title>
	</head>
	<body>
		<form method="post" action="index.php">
			Username: <input type="text" name="userId" /><br>
			Password: <input type="text" name="password" /><br>
			<input type="submit" value="Let me in" /><br>
		</form>
	</body>
</html>
	');
}

function isUserAllowedApplication($application){
	
	foreach($GLOBALS['lasloSystemGlobals']['user']['applications'] as $key => $value){
		foreach($value as $key2 => $value2){
			if($key2 == 'sal_NameId' AND $value2 == $application){
				return true;
			}
		}
	}
	return false;
}

function loadUserAppList($userId){
	
	$GLOBALS['lasloSystemGlobals']['user']['applications'] = $GLOBALS['lasloSystemGlobals']['db']['connection']->select(
		'sysUserGroupList',
		array(
			'[>]sysGroupApplicationList' 	=> array('sugl_sglIndexid' => 'sgal_sglIndexId'),
			'[>]sysApplicationList' 			=> array('sysGroupApplicationList.sgal_salNameId' => 'sal_NameId')
		),
		'*',
		array(
			'sugl_sulIndexId[=]' => $userId,
			'ORDER' => 'sal_Order',
			'GROUP' => 'sal_NameId'
		)
	);
	#echo('<code><pre>');
	#print_r($apps);
}