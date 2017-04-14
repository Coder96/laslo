<?PHP
/**
 * Return an object from a class file
 *
 * Parm 1 Application name - this wil corrilate with the direcory name
 * Parm 2 Classname this will match with the file name class.<Classname>.inc.php
 * Parm 3 ...n passed to class
 *
 */
function &lasloCreateObject($appName, $className){
	$classFileName = $GLOBALS['lasloSysGbs']['rootDir'].'/app/'.$appName.'/inc/class.'.$className.'.inc.php';
	if (!file_exists($classFileName)){
		echo(__FUNCTION__."($className) file $classFileName not found!");
		exit();
	}
	// this will stop php with a 500, if the class does not exist or there are errors in it
//echo("class $classFileName");
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

function lasloGetUrlVar($varName, $varType='all'){
	$retVar = '';
	$varType = strtolower($varType);
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
function lasloIsLoggedIn(){
	//
	// need to add cockies too.
	//
	//session_start();
	$message="";
#	if(isset($_POST['userId'])){echo $_POST['userId'] .' id sent<br>';}
	if(isset($_POST['userId'])){

		$user = $GLOBALS['lasloSysGbs']['db']['connection']->select('sysUserList','*',array('sulUserId[=]'=>lasloGetUrlVar('userId')));
		if(count($user) == 1){
//			var_dump($user);
			$_SESSION["userId"] = $user[0]['sulIndexId'];
		} else {
			echo "Invalid credentials.";
		}
	}
#	if(isset($_SESSION["userId"])) {echo 'id set<br>';}
	if(isset($_SESSION["userId"])) {
		lasloLoadUserArray($_SESSION["userId"]);
		return true;
	}
	return false;
}

function lasloLoadUserArray($userIndexId){

	$user = $GLOBALS['lasloSysGbs']['db']['connection']->select('sysUserList','*',array('sulIndexId[=]'=>$userIndexId));

	$GLOBALS['lasloSysGbs']['user']['sulIndexId'] 						= $user[0]['sulIndexId'];
	$GLOBALS['lasloSysGbs']['user']['sulUserId'] 							= $user[0]['sulUserId'];
	$GLOBALS['lasloSysGbs']['user']['sulPasswordId'] 					= $user[0]['sulPasswordId'];
	$GLOBALS['lasloSysGbs']['user']['sulLastLogin'] 					= $user[0]['sulLastLogin'];
	$GLOBALS['lasloSysGbs']['user']['sulLastLoginFrom'] 			= $user[0]['sulLastLoginFrom'];
	$GLOBALS['lasloSysGbs']['user']['sulLastPasswordChange']	= $user[0]['sulLastPasswordChange'];
	$GLOBALS['lasloSysGbs']['user']['sulAccountStatus'] 			= $user[0]['sulAccountStatus'];
	$GLOBALS['lasloSysGbs']['user']['sulAccountType'] 				= $user[0]['sulAccountType'];
}


function lasloIsLoginSessionExpired() {
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
function lasloPromptLogin(){
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

function lasloIsUserAllowedApplication($application){

	foreach($GLOBALS['lasloSysGbs']['user']['applications'] as $key => $value){
		foreach($value as $key2 => $value2){
			if($key2 == 'sal_NameId' AND $value2 == $application){
				return true;
			}
		}
	}
	return false;
}

function lasloloadUserAppList($userId){

	return $GLOBALS['lasloSysGbs']['db']['connection']->select(
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

function lasloReturnHomeAppArray(){
	return array(
			'application'	=> 'baseapps',
			'class'  			=> 'home_ui',
			'method'			=> 'index'
			);
}

function lasloReturnDefaultAppArray(){
	
	//
	// Check user preferences
	//
	
	//
	// Check Group options
	//
	
	//
	// Return default App
	//
	
	return lasloReturnHomeappArray();	
}
//
// Just runs the default app if all else fails.
//
function lalsoRunDefaultApp(){
	$GLOBALS['lasloSysGbs']['calledApplication'] = lasloReturnDefaultAppArray();
		$calledApplication = lasloCreateObject(
			$GLOBALS['lasloSysGbs']['calledApplication']['application'],
			$GLOBALS['lasloSysGbs']['calledApplication']['class']
		);
		$code = '$calledApplication->'. $GLOBALS['lasloSysGbs']['calledApplication']['method'] .'();';	
		eval($code);
}


