<?PHP

	class home_ui {
		
		function home_ui(){
			$GLOBALS['lasloSystemGlobals']['pageParts']->navigationBar();
#			echo('<code><pre>');
#			var_dump($GLOBALS['lasloSystemGlobals']);
		}
		
		function index(){
			echo('<h1>Home</h1>');	
		}
		
	}