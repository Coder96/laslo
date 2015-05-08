<?PHP

	class pageparts {
		
		function pageparts(){
			
		}
		
		function applicationsBar(){

			$retString = '
<div id=applicationsBar >
	<A HREF="index.php" target="_blank">
		<img border=0 title="Logo" alt="Logo" src="img/logo.png"></img>
		Logo
	</A>
</div>
<div class=applicationsBarItem >
	<A HREF="index.php?action=home.home_ui.index">
		<img border=0 title="Home" alt="Home" src="home/img/navbar.png"></img>
		Home
	</A>
</div>
';
			foreach($GLOBALS['lasloSystemGlobals']['user']['applications'] as $key => $value){
				$retString .= '
<div class=applicationsBarItem id="'.$value['sal_NameId'].'_'.$value['sal_Order'].'">
	<A HREF="index.php?action='.$value['sal_NameId'].'.index_ui.index">
		<img border=0 title="'.$value['sal_Description'].'" alt="'.$value['sal_Description'].'" src="'.$value['sal_NameId'].'/img/applicationIcon.png"></img>
		'.$value['sal_Name'].'
	</A>
</div>
';
			}
			$retString .= '
<div>
	<A HREF="index.php?action=logout">
		<img border=0 title="Logout" alt="Logout" src="img/logout.png"></img>
		Logout
	</A>
</div>
';
			return $retString;
		}
		
		function topStausBar(){
			$retString = '
<div id=topStatusBar>
	<div><A HREF="index.php?action=preferences">Preferences</A></div>
	<div><A HREF="index.php?action=logout">Logout</A></div>
	<div>User Name</div>
	<div>Date</div>
</div>
			';
			return $retString;
		}
		
	}
