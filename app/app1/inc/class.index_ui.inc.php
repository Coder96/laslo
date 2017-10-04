<?PHP

class index_ui {
		
	//
	//	This is a list of functions that can be called directly by the user
	//		Not ment to stop other classes from calling any methods.
	//
	var $publicFunctions = array(
		'index' => true,
//			'aa' => true,
//			'' => true,
	);
	//
	// This is run when the object is created.
	//
//	function __construct(){
//	}
	//
	// This will only auto run if:
	//	1. The called method is called from the browser. 
	//	2. The called method is allowed to be called from the brower.
	//	3. The user is allowed to call the called method.
	//		Put any output in here.
	//
	function lasloConstruct(){
	//	$GLOBALS['lasloSysGbs']['calledApplication']['applicationTitle'] = 'if you want to change the title';
		echo $GLOBALS['lasloSysGbs']['pageParts']->topStausBar();
		echo $GLOBALS['lasloSysGbs']['pageParts']->applicationsBar();
		echo $GLOBALS['lasloSysGbs']['pageParts']->applicationTitleBar();
		echo 'App1 index_ui<br>';
		//$this->bo = lasloCreateObject('app1', 'index_bo');
	}	
	
	function index(){
		echo 'App1 index<br>';
		echo(dirname(__DIR__));
	}
	
	
}