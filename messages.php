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

		if($_SESSION['admin']==2)
		{
			$asideMenu = asideA();
		}
		else
		{
			$asideMenu = asideU();
		}	
		 
	  	 	   
		//echo $_SESSION['errorMessage'];
		$_SESSION['expired'] = time() + 1200; 
		 
	 
		require_once ("htmlBuilder.php");
	 
		
		
		 
		
			 
		 
		 
			 
		
		$buttons = "		<a class='button button1'  href='logout.php'   role='button' >Logout</a>";
		 $modal = "";
		 $meta = "
				<meta charset='UTF-8'>
				<meta name='viewport' content='width=device-width, initial-scale=1.0' />";
		$fonts = "<link href='https://fonts.googleapis.com/css?family=Slabo+27px' rel='stylesheet'>";
		$jsLinks = "
				<script  src='https://code.jquery.com/jquery-3.3.1.min.js'
				integrity='sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8='
				crossorigin='anonymous'></script>
				<script src='messages.js'></script>\n 
				<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js'></script>\n  
				<script src='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js'></script>";
		$csslinks = "<link rel='stylesheet' href='style.css?v=1.2' />\n";

		
		$Title = 'Messages';
		 	
		
		$section = section( );
		 

		$Content = new Content($meta, $fonts, $csslinks, $jsLinks, $Title, $modal);
		$Content -> setHeader($buttons);
		$Content -> setAside(3, $asideMenu);
		$Content -> setContent($section);
		$Content -> Show();

		
		
	 
}

 


function section()
{	
    
	
	
	  
	 
			
	$section = " <h1 id = 'title'>Messages</h1>
		<div class ='whiteback'>
			<div id ='messUsers' class = 'col1 hoverul scrollinVerti'>
				<h1 class = 'subtitle'>Convesation</h1>  
				 
			</div>
			<a id = 'activeU' ></a>
			<div class = 'col2 scrollinVerti' id = 'messContent'>
				 
			</div>
			<div class = 'messTextDiv'>
				 <form action='#'>
						<textarea id = 'content' name='message' cols='50' placeholder='Message'></textarea>  
						<button id ='send' class='button button3' type='submit'>Send</button>
				 </form>	 
			</div>
		</div>
				";
				 //<div id='newPost'><a href = '#' >Add new post here</a></div> connected
	return $section;
}				
 
function asideU()
	{
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
				 0 => "indexU.php",
				 1 => "Contact.php",
				 2 => "Messages.php",
				 3 => "Profile.php",
				 4 => "Rules.php"
			 )
		);

			return $asideMenu;
	}
	
function asideA()
	{
		$asideMenu = array
		( 
			 "menuName" => array(
				 0 => "Home",
				 1  => "Contact",
				 2  => "Messages",
				 3 => "Profile",
				 4 => "Admin panel",
				 5 => "Rules"
			 ),
		
			 "menuHref" => array
			 (
				 0 => "indexU.php",
				 1 => "Contact.php",
				 2 => "Messages.php",
				 3 => "Profile.php",
				 4 => "adminPanel.php",
				 5 => "Rules.php"
			 )
		);	

			return $asideMenu;
	}


		
?>