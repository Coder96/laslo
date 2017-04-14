<?PHP

	class index_ui {
		
		//
		//	This is a list of functions that can be called directly by the user
		//
		var $publicFunctions = array(
#			'index' => true,
			'aa' => true,
#			'' => true,
		);
		
		function index_ui(){
			echo $GLOBALS['lasloSysGbs']['pageParts']->topStausBar();
			echo $GLOBALS['lasloSysGbs']['pageParts']->applicationsBar();
			echo 'App2 index_ui<br>';
			$this->bo = lasloCreateObject('app2', 'index_bo');
		}
		
		function index(){
			echo 'App2 index<br>';
			echo(dirname(__DIR__));
		}
		
		
	}