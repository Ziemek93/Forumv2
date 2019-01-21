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


	if(!$_GET['lo'] || !(preg_match('/^(?! )[0-9a-zA-Z-]*$/', $_GET['lo'])) )
	{
		 header('Location: topicsU.php');
	}
	else
	{	
		 

		echo $_SESSION['errorMessage'];
		$otherLogin = htmlspecialchars($_GET['lo'], ENT_QUOTES);
		 
	 
		require_once ("htmlBuilder.php");
		 
		
		 
		 
			 
		 $admin = $_SESSION['admin'];
		 
		aside($admin);
		 
			 
		
		 
		hababa();
		
		section($otherLogin);
		 

		$Content = new Content($meta, $fonts, $csslinks, $jsLinks, $Title, $modal);
		$Content -> setHeader($buttons);
		$Content -> setAside($asideNum, $asideMenu);
		$Content -> setContent($section);
		$Content -> Show();

		
		
	}
}

 


function section($otherLogin)
{	
	
	$login = $_SESSION['login'];
	
	 

	global $section;
	
	if($login == $otherLogin)
	{
			
	$section = " <h1 id = 'title'>Profile</h1>  
			 <div  class = 'co1 profileData'>
		 <a  href = '#' onclick='hide()'><img src='https://i.imgur.com/kNNhDxF.jpg' alt='My profile'  class='profileImage'></a>
				<ul >
                  <li><a >".$_SESSION['login']."</a></li>
                  <li><a >".$_SESSION['name']."</a></li>
				  <li><a >".$_SESSION['sex']."</a></li>
               </ul>
		</div>
		<div  class = 'co2 profileData'>
			  <ul >
                  <li><a  data-toggle='modal' data-target='#chPassword' >Change password</a></li>
				  <li id = 'delete' class ='colorBad'><a href = '#'>Delete account-".$login."</a></li>
               </ul>
	     </div>";
				 //<div id='newPost'><a href = '#' >Add new post here</a></div> connected
	}
	else{
		require_once ("findUser.php");
		
		
		$section = "<h1 id = 'title'>Profile</h1>  
			 <div  class = 'profileData  '>
		 <a href = '#' ><img src='https://i.imgur.com/kNNhDxF.jpg' alt='My profile'  class='profileImage'></a>
				<ul >
                  <li><a >".$otherLogin."</a></li>
                  <li><a >".$Name."</a></li>
				  <li><a >".$Sex."</a></li>
               </ul>
		</div>";
		
		
	}
	 
}				
 
function aside($admin)
	{
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
				<script src='profile.js'></script>";
		$csslinks = "<link rel='stylesheet' href='style.css?v=1.2' />\n";

		
		  $modal = "      <!-- The Modal -->
      <div class='modal fade' id='chPassword'>
         <div class='modal-dialog modal-lg modal-dialog-centered'>
            <div class='modal-content'>
               <!-- Modal Header -->
               <div class='modal-header'>
                  <h4 class='modal-title'>Registration</h4>
                  <button type='button' class='close' data-dismiss='modal'>&times;</button>
               </div>
               <!-- Modal body -->
               <div class='modal-body'>
                  <div class='container'>
                     <div class='card-body'>
                        <form action='checkThings.php' class='container' method= 'post'>
                           
                           <div class='form-group'>
                              <input name = 'password' type='password'  placeholder='New Password' class='form-control' required>
                              
                               
                           </div>
                            
                           <button type='submit' class='button  '>Submit</button>
                        </form>
                     </div>
                  </div>
               </div>
               <!-- Modal footer -->
            </div>
         </div>
      </div>"
      ;
		
		
	}

		
?>