<?php
require_once ('htmlBuilder.php');
require_once ('readSection.php');

session_start();


$_SESSION['errorMessage'] = $_SESSION['errorMessage'] ?? ""; // dac do popupa
$_SESSION['expired'] = $_SESSION['expired'] ?? 0;
  
   
if (!isset($_SESSION['Id']) || !isset($_SESSION['login']) || !isset($_SESSION['password']) || $_SESSION['expired'] < time())
{
 header('Location: logout.php');
}	
else
{	
	 	
	$admin = $_SESSION['admin'];
	
		
		 
		
		print_r($_SESSION['expired'] - time());
		print_r($_SESSION['errorMessage']);
        $_SESSION['expired'] = time() + 600;
		 
		

		$readSection = new readSection();
		$readSection -> findSection();
		$sectionTitle =$readSection-> getTitle();
		
		$_SESSION['sectT'] = $sectionTitle ;
		
		$Title = "Main site";
		section($sectionTitle);
		
		hababa();
		aside($admin);


		$Content = new Content($meta, $fonts, $csslinks, $jsLinks, $Title, $modal);
		$Content -> setHeader($buttons);
		$Content -> setAside(count($asideMenu['menuName']), $asideMenu);
		$Content -> setContent($section);
		$Content -> Show();

 }
 
 
 
function section($sectionTitle)
	{
			$container = "";
	 global $section;
	 
			if (count($sectionTitle) > 0)
				{
				$i = 0;
				while ($i < count($sectionTitle))
					{
					
					$container .= "<li><a href = 'topicsU.php?s=".strtr($sectionTitle[$i]," ","-")."'>".$sectionTitle[$i]."</a></li>";
					$i++;
					}
			}		
			$section = " <h1 id = 'title'>Forum</h1>
				<p>Dane forum zrzesza fanów jak i użytkowników systemu Android. Hababababa</p>
				<div class= 'indexList'>
				<ul>".$container
				."</ul>
				</div>";
				
			 
		}
			
function aside($admin)
		{
			
			$myProfile = $_SESSION['login'];
			
		global $asideMenu;
		global $asideNum;
		 
		 
		 
				global $asideMenu;
		global $asideNum;
		 
		 
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
						 3 => "profile.php?lo=".$myProfile,
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
				  3 => "profile.php?lo=".$myProfile,
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
		 
		global $buttons; 
		
		
		$buttons = "		<a class='button button1'  href='logout.php'   role='button' >Logout</a>";
		$meta = "
		<meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0' />";
		$fonts = "<link href='https://fonts.googleapis.com/css?family=Slabo+27px' rel='stylesheet'>";
		$jsLinks = "
			<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js'></script>\n  
            <script src='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js'></script>";
		$csslinks = "<link rel='stylesheet' href='style.css?v=1.2' />\n";
		$modal = ""; 
		 
	}
	 
 	
?>

 
 
 