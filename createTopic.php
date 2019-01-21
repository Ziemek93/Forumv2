 <?php
 session_start();

$_SESSION['errorMessage'] = $_SESSION['errorMessage'] ?? ""; // dac do popupa
$_SESSION['expired'] = $_SESSION['expired'] ?? 0;
  
   
if (!isset($_SESSION['Id']) || !isset($_SESSION['login']) || !isset($_SESSION['password']) || $_SESSION['expired'] < time() || !$_GET['sec'] )
{
 header('Location: index.php');
}	
else
{
 
 
require_once ('htmlBuilder.php');

$admin = $_SESSION['admin'];
 
$chck = htmlspecialchars(strtr($_GET['sec'],"-"," "), ENT_QUOTES);
 

section($chck);
aside($admin);
hababa();
 


	
 
 


$Content = new Content($meta, $fonts, $csslinks, $jsLinks, $Title, $modal);
$Content -> setHeader($buttons);
$Content -> setAside($asideNum, $asideMenu);
$Content -> setContent($section);
$Content -> Show();

 
}

	function section($chck)
	{
		global $section;
		
			$section = "
			<h1 id = 'title'>Create topic</h1>
			<div class= 'indexList'>
				<div class = 'messTextDiv'>
					<form action='oTopic.php'  method= 'post' >
					<input type = 'hidden' name = 'sec' value = '".$chck."' />
						<textarea name='topicTitle' cols='50' rows='1' placeholder = 'Title'></textarea>  
						<textarea name='topicContent' cols='500' rows='20' placeholder = 'Tekst'></textarea>  
						<button class='button button3' type='submit'>Send</button>
					</form>	 
				</div>
			</div>";
	}
	
 

 
function aside($admin)
	{
		global $asideMenu;
		global $asideNum;
		  
		if( $admin < 2)
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
						 3 => "Profile.php",
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
				 3 => "profile.php",
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
		
		
		
				$modal = "";
			$meta = " <meta charset='UTF-8'>
				  <meta name='viewport' content='width=device-width, initial-scale=1.0' />";
			$fonts = "<link href='https://fonts.googleapis.com/css?family=Slabo+27px' rel='stylesheet'>";

			$jsLinks = "<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js'></script>\n  
						<script src='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js'></script>";
						
			$csslinks = "<link rel='stylesheet' href='style.css?v=1.1' />\n";

			$Title = "Main site";
			$buttons = " <a class='button button1'  href='logout.php'   role='button' >Logout</a>";
	}
	
 
?>


 