<?PHP

	class index_ui {
		
		//
		//	This is a list of functions that can be called directly by the user
		//
		var $publicFunctions = array(
			'index' => true,
#			'' => true,
#			'' => true,
		);
		
		function index_ui(){
			$GLOBALS['lasloSystemGlobals']['pageParts']->navigationBar();
			echo 'App1 index_ui<br>';
			$this->bo = createObject('app1', 'index_bo');
		}
		
		function index(){
			echo 'App1 index<br>';
			echo(dirname(__DIR__));
		}
		
		
	}