<?php
session_start();

$_SESSION['errorMessage'] = $_SESSION['errorMessage'] ?? ""; // dac do popupa
$_SESSION['expired'] = $_SESSION['expired'] ?? 0;
  
   
if (!isset($_SESSION['Id']) || !isset($_SESSION['login']) || !isset($_SESSION['password']) || $_SESSION['expired'] < time() || $_SESSION['admin']!=2)
{
 header('Location: index.php');
}	
else
{

		 
		 
	  	 	   
		//echo $_SESSION['errorMessage'];
		$_SESSION['expired'] = time() + 3600; 
		 
	 
		require_once ("htmlBuilder.php");
		require_once ("checkThings.php");
		
		$id = htmlspecialchars($_SESSION['Id'], ENT_QUOTES);
		 
		$CheckThings = new CheckThings(); //id
		$CheckThings -> allUsers($id);			
		
		$usersArr = $CheckThings -> getAllUsers();		
		 			
					
		
			
		$modal ="";
		$fonts = "<link href='https://fonts.googleapis.com/css?family=Slabo+27px' rel='stylesheet'>";

		$jsLinks = "<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js'></script>\n  
					<script src='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js'></script>
					<script src='adminPanel.js'></script>";
					
		$csslinks = "<link rel='stylesheet' href='style.css?v=1.1' />\n";

		$Title = "Admin Panel";
		$buttons = " <a class='button button1'  href='logout.php'   role='button' >Logout</a>";
		$aside = "<li><a href='#'>Home</a></li>\n
						  <li><a href='#'>Contact</a></li>\n
						  <li><a href='#'>Rules</a></li>\n";
		$meta = " <meta charset='UTF-8'>
			     <meta name='viewport' content='width=device-width, initial-scale=1.0' />";
				 
		$asideMenu = aside();		
		$section = section($usersArr);
				 
		$Content = new Content($meta, $fonts, $csslinks, $jsLinks, $Title, $modal);
		$Content -> setHeader($buttons);
		$Content -> setAside(5, $asideMenu);
		$Content -> setContent($section);
		$Content -> Show();

}


function section($usersArr)
{
	
	$x = "";
	$arr = array(1, 2, 3, 4);
	foreach($usersArr['Login'] as $value) 
	{
		$x .= "<div class = 'profileNick' ><a>".$value."</a></div>";
		  
	}
	
	 
	 
				 
				 
	
	 
	
	
	$section = "
					 <h1 id = 'title'>Admin panel</h1>
				 
				 <div class = 'whiteback'> 
					 <div class = 'apanelCol1 scrollinVerti'>".$x."
					 </div >
					  <div class = 'apanelCol2'>
					  <button id ='delete' class='button button3' type='submit'>Delete User</button>
					  <button id ='promote' class='button button3' type='submit'>Promote User</button>
					    
					  </div>
				 </div>";
	
	return $section;
}


 function aside()
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


 