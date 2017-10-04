<?PHP

	class home_ui {
		
		var $publicFunctions = array(
			'index' => true,
//			'aa' => true,
//			'' => true,
		);
		
		function __construct(){
			echo $GLOBALS['lasloSysGbs']['pageParts']->topStausBar();
			echo $GLOBALS['lasloSysGbs']['pageParts']->applicationsBar();
			echo $GLOBALS['lasloSysGbs']['pageParts']->applicationTitleBar();
			echo('<code><pre>');
			echo('lasloSysGbs');
			print_r($GLOBALS['lasloSysGbs']);
//			echo('Session<br>');
//			print_r($_SESSION);
		}
		

		function index(){
			echo('<h1>Home</h1>');
		}

	}
