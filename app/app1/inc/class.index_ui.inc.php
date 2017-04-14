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
	//
	//
//	function __construct(){
//	}
	//
	// This will run if the method is allowed to run from the out side world.
	//		Put any output in here.
	//
	function lasloConstruct(){
		echo $GLOBALS['lasloSysGbs']['pageParts']->topStausBar();
		echo $GLOBALS['lasloSysGbs']['pageParts']->applicationsBar();
		echo 'App1 index_ui<br>';
		//$this->bo = lasloCreateObject('app1', 'index_bo');
	}	
	
	function index(){
		echo 'App1 index<br>';
		echo(dirname(__DIR__));
	}
	
	
}