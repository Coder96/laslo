<?php

	class pageparts {
		
		function pageparts(){
			
		}
		
		function applicationsBar(){

			$retString = '
<div id=applicationsBar  class="w3-cell-row">
	<div id=app0 class="w3-container  w3-cell" >
		<A HREF="index.php" target="_blank">
			<div>
				<img border=0 title="Logo" alt="Logo" src="baseapps/img/logo.png"></img>
			</div>
			<div>
				Logo
			</div>
		</A>
	</div>
	<div   class="w3-container  w3-cell" >
		<A HREF="index.php?action=home.home_ui.index">
			<div>
				<img border=0 title="Home" alt="Home" src="baseapps/img/navbar.png"></img>
			</div>
			<div>
				Home
			</div>
		</A>
	</div>
	';
				foreach($GLOBALS['lasloSysGbs']['user']['applications'] as $key => $value){
					$retString .= '
	<div class="w3-container  w3-cell" id="'.$value['sal_NameId'].'_'.$value['sal_Order'].'">
		<A HREF="index.php?action='.$value['sal_NameId'].'.index_ui.index">
			<div>
			 <img border=0 title="'.$value['sal_Description'].'" alt="'.$value['sal_Description'].'" src="'.$value['sal_NameId'].'/img/applicationIcon.png"></img>
			</div>
			<div>
			 '.$value['sal_Name'].'
			</div>
		</A>
	</div>
	';
				}
				$retString .= '
	<div class="w3-container  w3-cell" >
		<A HREF="index.php?action=logout">
			<div>
				<img border=0 title="Logout" alt="Logout" src="baseapps/img/logout.png"></img>
			</div>
			<div>
				Logout
			</div>
		</A>
	</div>
</div>
<hr>
';
			return $retString;
		}
		
		function applicationTitleBar(){
			$retString = '
<div id=applicationTitleBar class="w3-cell-row">
	<div class="w3-container w3-cell">
'. $GLOBALS['lasloSysGbs']['calledApplication']['applicationTitle'] .'
	</div>
</div>
<hr>
			';
			return $retString;
		}
		
		function topStausBar(){
			$retString = '
<div id=topStatusBar class="w3-cell-row">
	<div class="w3-container  w3-cell w3-left-align" ><A HREF="index.php?action=preferences">Preferences</A></div>
	<div class="w3-container  w3-cell w3-left-align" ><A HREF="index.php?action=logout">Logout</A></div>
	<div class="w3-container  w3-cell w3-right-align" >User Name</div>
	<div class="w3-container  w3-cell w3-right-align" >Date</div>
</div>
<hr>
			';
			return $retString;
		}
		
		function footerBar(){
						$retString = '
<hr>
<div id=footerBar class="w3-cell-row">
	<div id=footerBar class="w3-cell-row">
		<div class="w3-container  w3-cell w3-left-align" >Misc Row 1 Col 1</div>
		<div class="w3-container  w3-cell w3-left-align" >Misc Row 1 Col 2</div>
	</div>
	<div id=footerBar class="w3-cell-row">
		<div class="w3-container  w3-cell w3-left-align" >Misc Row 2 Col 1</div>
		<div class="w3-container  w3-cell w3-left-align" >Misc Row 2 Col 2</div>
</div>
			';
			return $retString;
		}
	}
