<?php
session_start();

$_SESSION['errorMessage'] = $_SESSION['errorMessage'] ?? ""; // dac do popupa
$_SESSION['expired'] = $_SESSION['expired'] ?? 0;
  
   
if (!isset($_SESSION['Id']) || !isset($_SESSION['login']) || !isset($_SESSION['password']) || $_SESSION['expired'] < time())
{
 header('Location: logout.php');
}	
else
{	
	if(!$_GET['s'])
	{
		 header('Location: indexU.php');
	}
	else
	{	 	 
		 echo $_SESSION['errorMessage']."  ";
		$chck = htmlspecialchars(strtr($_GET['s'],"-"," ") , ENT_QUOTES);
		$secArr = $_SESSION['sectT'];
		check($chck, $secArr);
		
		require_once('readTopics.php');
		require_once ('htmlBuilder.php');
		
		 
		 
		$asideMenu ="";
		
		 
		$admin = $_SESSION['admin'];
		
		 
		section( $chck, $admin);
		aside($admin);
		hababa();
		
		
			 
		print_r($_SESSION['expired'] - time());
		print_r($_SESSION['errorMessage']);
        $_SESSION['expired'] = time() + 600;
		
		 

 


		$Content = new Content($meta, $fonts, $csslinks, $jsLinks, $Title, $modal);
		$Content -> setHeader($buttons);
		$Content -> setAside($asideNum, $asideMenu);
		$Content -> setContent($section);
		$Content -> Show();

		
		
	}
}
	 
	 
	 function check($x, $y)
	{
		$i = 0;
		while ($i < count($y))
			{
				
				if($x == $y[$i])
				{
					return true;
				}
				 
				$i++;
			}
		 header('Location: index.php');
		
		
	}

 
	function section($chck, $admin)
	{
		global $section;
		
		$readTopics = new readTopics();
		 ;
		$readTopics -> findTopics($chck);
		 
		$topicArr = $readTopics -> getTopicsArr();
		$getNumOfT = $readTopics -> getNumOfT(); /// wincyj wywolan
		
		
			if($admin==0)
			{
				$container = "";
	 
			if ($getNumOfT > 0)
				{
				$i = 0;
				while ($i < $getNumOfT)
					{
						
						
					 
					$container .= "<li><a  href = 'topic.php?p=".$topicArr['topicLink'][$i]."'>".$topicArr['topicTitle'][$i]."</a> <div class = 'subtitle'><b>".$topicArr['topicOwner'][$i]." - ".$topicArr['topicDate'][$i]."</b></div></li>";
					$i++;
					}
				}		

				 
				  
					$section = " <h1 id = 'title'>".$chck."</h1>
						<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
						   tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
						   quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
						   consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
						   cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
						   proident, sunt in culpa qui officia deserunt mollit anim id est laborumLorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
						</p>
						<div class= 'indexList'>
						<ul>".$container
						."</ul>
						</div><div id='newPost'><a href = 'createTopic.php?sec=".strtr($chck," ","-")."' >Add new topic here</a></div>
						</div>";
			}
			else
			{
				
			$readTopics -> findOffTopics($chck);
			$topicOffArr = $readTopics -> getOffTopicsArr();
		 	$getNumOfDisabledT = $readTopics -> getNumOfDisabledT();	
				
				
			$container1 = "";
		 
				if ($getNumOfT > 0)
					{
					$i = 0;
					while ($i < $getNumOfT)
						{
						 
						$container1 .= "<li><a  href = 'topicU.php?tl=".$topicArr['topicLink'][$i]."'>".$topicArr['topicTitle'][$i]."</a> <div class = 'subtitle'><b>".$topicArr['topicOwner'][$i]." - ".$topicArr['topicDate'][$i]."</b></div></li>";
						$i++;
						}
					}		
			$container2 = ""; ///////////////////---------------------------------------------------
		 
				if ($getNumOfDisabledT > 0)
					{
					$i = 0;
					while ($i < $getNumOfDisabledT)
						{
						 
						$container2 .= "<li><a  href = 'topicU.php?tl=".$topicOffArr['topicLink'][$i]."'>".$topicOffArr['topicTitle'][$i]."</a> <div class = 'subtitle'><b>".$topicOffArr['topicOwner'][$i]." - ".$topicOffArr['topicDate'][$i]."</b></div></li>";
						$i++;
						}
					}	
					 
						$section = " <h1 id = 'title'>".$chck."</h1><div>
							<div onmouseover='hide()' class = 'brotherCol'><a>Topics</a></div><div onmouseover='hide()' class = 'brotherCol'><a>Topics to be verified</a></div>
							</div>
							<div id = 'firsthide'>
							<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
							   tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
							   quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
							   consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
							   cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
							   proident, sunt in culpa qui officia deserunt mollit anim id est laborumLorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
							</p>
							<div class= 'indexList'>
							<ul>".$container1
							."</ul>
							</div><div id='newPost'><a href = 'createTopic.php?sec=".strtr($chck," ","-")."' >Add new topic here</a></div>
					</div>
					
					<div id = 'secondhide'>
					<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
					   tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
					   quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
					   consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
					   cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
					   proident, sunt in culpa qui officia deserunt mollit anim id est laborumLorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
					</p>
					<div class= 'indexList'>
					<ul>".$container2."</ul>
					 </div>
					 </div>";
		}
	}
	
 

 
function aside($admin)
	{
		global $asideMenu;
		global $asideNum;
		 
		 
		 
				global $asideMenu;
		global $asideNum;
		 
		$login = $_SESSION['login'];
		 
		if($admin < 2)
		{
				
				$asideNum = 5;
				
				$asideMenu = array
				(
					 "menuName" => array(
						 0 => "Home",
						 1  => "Contact",
						 2  => "Messages",
						 3 => "Profile",
						 4 => "Rules"
					 ),
				
					 "menuHref" => array
					 (
						 0 => "#",
						 1 => "Contact.php",
						 2 => "Messages.php",
						 3 => "profile.php?lo=".$login,
						 4 => "Rules.php"
					 )
				);
		}
		else
		{
			$asideNum = 6;
			
			$asideMenu = array
			(
			 "menuName" => array(
				 0 => "Home",
				 1  => "Contact",
				 2  => "Messages",
				 3 => "Profile",
				 4 => "Rules",
				 5 => "Admin Panel" // - dla kazdej strony musze zrobic warunek czy ktos jest adminem, oszczedze na plikach tworzonych specjalnie
									// dla ladmin hadmin, post od razu z mozliwoscia edycji usuwania, wyswietalana podstrona bez niektorych uzytkownikow itd
			 ),
		
			 "menuHref" => array
			 (
				 0 => "indexU.php",
				 1 => "Contact.php",
				 2 => "messages.php",
				 3 => "profile.php?lo=".$login,
				 4 => "Rules.php",
				 5 => "adminPanel.php"
			 )
			);	
			
			
		}
		
		 
				 
	}
	
 
	
	function hababa()
	{
		global $modal;
		global $meta;
		global $fonts;
		global $jsLinks;
		global $csslinks;
		global $Title;
		global $buttons; 
		
		
		$buttons = "		<a class='button button1'  href='logout.php'   role='button' >Logout</a>";
		$meta = "
		<meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0' />";
		$fonts = "<link href='https://fonts.googleapis.com/css?family=Slabo+27px' rel='stylesheet'>";
		$jsLinks = "
			<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js'></script>\n  
            <script src='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js'></script>
			<script src='script.js'></script>";
		$csslinks = "<link rel='stylesheet' href='style.css?v=1.2' />\n";

		$modal ="";
		$Title = "Topics";
	}
	
 



 
 
 
 
?>