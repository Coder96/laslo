<?PHP

	class home_ui {
		
		function home_ui(){
			echo $GLOBALS['lasloSystemGlobals']['pageParts']->topStausBar();
			echo $GLOBALS['lasloSystemGlobals']['pageParts']->applicationsBar();
			echo('<code><pre>');
			echo("GLOBALS['lasloSystemGlobals']<br>");
			print_r($GLOBALS['lasloSystemGlobals']);
			echo('Session<br>');
			print_r($_SESSION);
		}
		
		function index(){
			echo('<h1>Home</h1>');	
		}
		
	}