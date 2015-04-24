<?PHP

	class common {
		
		function common(){
			
		}
		
		function logout(){
			// remove all session variables
			session_unset();

			// destroy the session
			session_destroy(); 
			echo '<meta http-equiv="refresh" content="0; url=index.php" />';
			
		}
		
	}