<?PHP

	class pageparts {
		
		function pageparts(){
			
		}
		
		function navigationBar(){
			//
			// This list would be generated from the user group list.
			//
			echo('
<div><A HREF="index.php">Logo</A></div>
<div><A HREF="index.php?action=baseapi.home_ui.index">home</A></div>
');
			if($_SESSION["user_id"] == 1001 ){
				echo('
<div><A HREF="index.php?action=app1.index_ui.index">app1</A></div>
<div><A HREF="index.php?action=app2.index_ui.index">app2</A></div>
<div><A HREF="index.php?action=app3.index_ui.index">app3</A></div>
');
			} elseif($_SESSION["user_id"] == 1002 ){
				echo('
<div><A HREF="index.php?action=app1.index_ui.index">app2</A></div>
<div><A HREF="index.php?action=app2.index_ui.index">app3</A></div>
');
			} elseif($_SESSION["user_id"] == 1003 ){
				echo('
<div><A HREF="index.php?action=app2.index_ui.index">app2</A></div>
<div><A HREF="index.php?action=app3.index_ui.index">app3</A></div>
');
			} else {
		
			}
			echo('
<div><A HREF="index.php?action=baseapi.common.logout">logout</A></div>
');
		}
		
	}
