<?PHP

echo ' <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css"> ';

session_start();
$GLOBALS['lasloSysGbs']['rootDir'] = dirname(__DIR__);

require_once($GLOBALS['lasloSysGbs']['rootDir'] . '/app/config/config.inc.php');

require_once($GLOBALS['lasloSysGbs']['rootDir'] . '/app/baseapi/inc/basefunctions.inc.php');

require_once($GLOBALS['lasloSysGbs']['rootDir'] . '/app/baseapi/inc/medoo.php');

$GLOBALS['lasloSysGbs']['common'] = lasloCreateObject('baseapi','common');

$GLOBALS['lasloSysGbs']['db']['connection'] = new medoo(array(
	// required
	'server' 				=> $GLOBALS['lasloSysGbs']['db']['host'],
	'database_type' => $GLOBALS['lasloSysGbs']['db']['type'],
	'port' 					=> $GLOBALS['lasloSysGbs']['db']['port'],
	'database_name' => $GLOBALS['lasloSysGbs']['db']['name'],
	'username' 			=> $GLOBALS['lasloSysGbs']['db']['user'],
	'password' 			=> $GLOBALS['lasloSysGbs']['db']['pass'],
	'charset' 			=> $GLOBALS['lasloSysGbs']['db']['charset'],
	// driver_option for connection, read more from http://www.php.net/manual/en/pdo.setattribute.php
	'option' => array(
		PDO::ATTR_CASE => PDO::CASE_NATURAL
	)
));

if(lasloGetUrlVar('action') == 'logout'){
	$GLOBALS['lasloSysGbs']['common']->logout();
}


if(lasloIsLoggedIn()){
	$pageParts = '';
	//
	// At this pont the user should be logged in
	//
	$GLOBALS['lasloSysGbs']['user']['applications'] = lasloloadUserAppList($GLOBALS['lasloSysGbs']['user']['sulIndexId']);
	
	$GLOBALS['lasloSysGbs']['pageParts'] = lasloCreateObject('baseapi','pageparts');
	//
	// Check that action is valid alpha numeric
	//
	if(isset($_GET['action']) && preg_match('/^[a-zA-Z0-9_]+\.[a-zA-Z0-9_]+\.[a-zA-Z0-9_]+$/', $_GET['action'])){

		list($calledApp,$calledClass,$calledMethod) = explode('.',lasloGetUrlVar('action'));
		$GLOBALS['lasloSysGbs']['calledApplication'] = array(
			'application'	=> $calledApp,
			'class'  			=> $calledClass,
			'method'			=> $calledMethod
		);
	} else {
		$GLOBALS['lasloSysGbs']['calledApplication'] = lasloReturnDefaultAppArray();
	}
	//
	// check user has access to this application if not allowed send to users default application
	//
	if(!lasloIsUserAllowedApplication($GLOBALS['lasloSysGbs']['calledApplication']['application'])){
		$GLOBALS['lasloSysGbs']['calledApplication'] = lasloReturnDefaultAppArray();
	}
	//
	//	Lets create our object 
	//
	$calledApplication = lasloCreateObject(
		$GLOBALS['lasloSysGbs']['calledApplication']['application'],
		$GLOBALS['lasloSysGbs']['calledApplication']['class']
		);
	//
	// Check that the index exsists
	//
	// Check that method can be called from out side world. 
	//
	// This is not for if the method is private or public
	//
	
	$applicationRejected = false;
	if(isset($calledApplication->publicFunctions[$GLOBALS['lasloSysGbs']['calledApplication']['method']])){
		if($calledApplication->publicFunctions[$GLOBALS['lasloSysGbs']['calledApplication']['method']] === true){
//
//	Alowed to run method.
//
			foreach($GLOBALS['lasloSysGbs']['user']['applications'] as $key => $value){
				if($value['sgal_salNameId'] == $GLOBALS['lasloSysGbs']['calledApplication']['application']){
					$GLOBALS['lasloSysGbs']['calledApplication']['applicationTitle'] = $value['sgal_salNameId'];
					break;
				}
			}
			if(method_exists($calledApplication, 'lasloConstruct')){
				$calledApplication->lasloConstruct();
			}
			$code = '$calledApplication->'. $GLOBALS['lasloSysGbs']['calledApplication']['method'] .'();';	
			eval($code);
			echo $GLOBALS['lasloSysGbs']['pageParts']->footerBar();
			$applicationRejected = false;
		} else {
			$applicationRejected = true;
		}
	} else {
		$applicationRejected = true;
	}
	if($applicationRejected === true){
		unset($calledApplication);
		lalsoRunDefaultApp();
	}
	
	
//	print_r($GLOBALS['lasloSysGbs']['calledApplication']);

} else {
	lasloPromptLogin();
}
