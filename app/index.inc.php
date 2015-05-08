<?PHP

$GLOBALS['lasloSystemGlobals']['rootDir'] = dirname(__DIR__);

require_once($GLOBALS['lasloSystemGlobals']['rootDir'] . '/app/config/config.inc.php'); 

require_once($GLOBALS['lasloSystemGlobals']['rootDir'] . '/app/baseapi/inc/basefunctions.inc.php');

require_once($GLOBALS['lasloSystemGlobals']['rootDir'] . '/app/baseapi/inc/medoo.min.inc.php');

$GLOBALS['lasloSystemGlobals']['db']['connection'] = new medoo(array(
	// required
	'server' 				=> $GLOBALS['lasloSystemGlobals']['db']['host'],
	'database_type' => $GLOBALS['lasloSystemGlobals']['db']['type'],
	'port' 					=> $GLOBALS['lasloSystemGlobals']['db']['port'],
	'database_name' => $GLOBALS['lasloSystemGlobals']['db']['name'],
	'username' 			=> $GLOBALS['lasloSystemGlobals']['db']['user'],
	'password' 			=> $GLOBALS['lasloSystemGlobals']['db']['pass'],
	'charset' 			=> $GLOBALS['lasloSystemGlobals']['db']['charset'],
	// driver_option for connection, read more from http://www.php.net/manual/en/pdo.setattribute.php
	'option' => array(
		PDO::ATTR_CASE => PDO::CASE_NATURAL
	)
));

if(getUrlVar('action') == 'logout'){
	logout();
}


if(isLoggedIn()){
#	echo('Logged in');
	#$GLOBALS['egw']->common =& CreateObject('phpgwapi.common');
	 $pageParts = '';
	
	loadUserAppList($GLOBALS['lasloSystemGlobals']['user']['sulIndexId']);
	
	$GLOBALS['lasloSystemGlobals']['pageParts'] = createObject('baseapi','pageparts');

	if(isset($_GET['action']) && preg_match('/^[a-zA-Z0-9_]+\.[a-zA-Z0-9_]+\.[a-zA-Z0-9_]+$/', $_GET['action'])){
		list($calledApp,$calledClass,$calledMethod) = explode('.',getUrlVar('action'));
		$GLOBALS['lasloSystemGlobals']['calledApplication'] = array(
			'application'	=> $calledApp,
			'class'  			=> $calledClass,
			'method'			=> $calledMethod
		);
	} else {
		$GLOBALS['lasloSystemGlobals']['calledApplication'] = array(
			'application'	=> 'home',
			'class'  			=> 'home_ui',
			'method'			=> 'index'
			);
			// now check user group for default applicaion and goto that application.
			
			/*
			$GLOBALS['laslo']['calledApplication'] = array(
			'application'	=> 'group default',
			'class'  			=> 'group default',
			'method'			=> 'group default'
			*/
	}
		//
		// check user has access to this application if not allowed send to home application
		//
		if(!isUserAllowedApplication($GLOBALS['lasloSystemGlobals']['calledApplication']['application'])){
			$GLOBALS['lasloSystemGlobals']['calledApplication'] = array(
			'application'	=> 'home',
			'class'  			=> 'home_ui',
			'method'			=> 'index'
			);
		}

	$calledApplication = createObject(
		$GLOBALS['lasloSystemGlobals']['calledApplication']['application'],
		$GLOBALS['lasloSystemGlobals']['calledApplication']['class']
		);
	
	$calledApplication->$GLOBALS['lasloSystemGlobals']['calledApplication']['method']();

	$GLOBALS['lasloSystemGlobals']['flags'] = array(
		'showheader'   => false,
		'shownavbar'   => false
	);
	
#	print_r($GLOBALS['lasloSystemGlobals']);
	
} else {
	promptLogin();
}

