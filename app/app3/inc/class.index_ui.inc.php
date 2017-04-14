<?PHP

	class index_ui {
		
		//
		//	This is a list of functions that can be called directly by the user
		//
		var $publicFunctions = array(
			'index' => false,
#			'' => true,
#			'' => true,
		);
		
		function lasloConstruct(){
//			echo $GLOBALS['lasloSysGbs']['pageParts']->topStausBar();
//			echo $GLOBALS['lasloSysGbs']['pageParts']->applicationsBar();
			echo 'App3 index_ui<br>';
			$this->bo = lasloCreateObject('app3', 'index_bo');
		}
		
		function index(){
			echo 'App3 index<br>';
			echo(dirname(__DIR__));
		}
		
		
	}