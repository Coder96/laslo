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
			$GLOBALS['lasloSystemGlobals']['pageParts']->applicationBar();
			echo 'App2 index_ui<br>';
			$this->bo = createObject('app2', 'index_bo');
		}
		
		function index(){
			echo 'App2 index<br>';
			echo(dirname(__DIR__));
		}
		
		
	}