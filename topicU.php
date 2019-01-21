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


	if(!$_GET['tl'] || !(preg_match('/^(?! )[0-9a-zA-Z-]*$/', $_GET['tl'])) )
	{
		 header('Location: topicsU.php');
	}
	else
	{	
		 

		echo $_SESSION['errorMessage'];
		$topicLink = htmlspecialchars($_GET['tl'], ENT_QUOTES);
		 
		
		require_once("readTopics.php");
		require_once("readPosts.php");
		require_once ("htmlBuilder.php");
		require_once ("CheckThings.php");
		$readTopics = new readTopics();
		$readTopics -> findTopic($topicLink);
		$topicArr = $readTopics -> getTopicArr();
		 
		
		$readPosts = new readPosts($topicLink);
		$readPosts -> findPosts();
		$postArr = $readPosts -> getPostArr();
		$getNumOfP = $readPosts -> getNumOfT();
		
		
		$_SESSION['topicArr'] = $topicArr ;
		$Title = $topicArr['topicTitle'];
			 
		 $admin = $_SESSION['admin'];
		 
		aside($admin);
		 
			 
		
		 
		hababa($Title);
		
		section($postArr, $topicArr, $getNumOfP, $topicLink);
		 

		$Content = new Content($meta, $fonts, $csslinks, $jsLinks, $Title, $modal);
		$Content -> setHeader($buttons);
		$Content -> setAside($asideNum, $asideMenu);
		$Content -> setContent($section);
		$Content -> Show();

		
		
	}
}

 


function section($postArr, $topicArr, $getNumOfP, $topicLink)
{	


	global $section;
	
	

    $topicOptions = "";
	$acceptButton = "";
	 
	 
		 
	$CheckThings = new CheckThings();
	$CheckThings -> selId($topicLink);
	$topicOwner = $CheckThings -> getId();
	
	if( ($_SESSION['admin'] > 1) || $_SESSION['Id'] == $topicOwner )
	{
		 
	$topicOptions = "<button class = 'topicOptions1' id = 'delete' ><a>Delete - all drop </a></button>";
	$acceptButton = "<button class = 'topicOptions2' id = 'edit' type='submit' > <a   >Edit</a></button> ";
	if($topicArr['topicActive'] == FALSE){$acceptButton = "<button class = 'topicOptions2' id = 'accept' type='submit' > <a   >Accept</a></button>";}
	}
	 
	 
	$container = "";
	 
		if ($getNumOfP > 0)
			{
			$i = 0;
			while ($i < $getNumOfP)
				{
				//$container .= "<li><a  href = 'profile.php?t=".$postArr['postOwner'][$i]."'>".$postArr['postContent'][$i]."</a> <div class = 'subtitle'><b>".$postArr['postDate'][$i]." - ".$postArr['postOwner'][$i]."</b></div></li>";
				$container .= "<li><a href = 'profile.php?lo=".$postArr['postOwner'][$i]."'>".$postArr['postContent'][$i]."</a> <div class = 'subtitle'><b>".$postArr['postDate'][$i]." - ".$postArr['postOwner'][$i]."</b></div></li>";
				$i++;            
				}
			}	
			
	$section = " <div id ='post'>
				<h1 id = 'title'>".$topicArr['topicTitle']."</h1>
				<p>".$topicArr['topicContent']."</p><div>"
				.$topicOptions.$acceptButton.
				"</div><a href = 'profile.php?lo=".$topicArr['topicOwner']."' class = 'postDateUser'>".$topicArr['topicOwner']." - ".$topicArr['topicDate']."</a>
				</div>
				<div class= 'indexList'>
				<ul>".$container
				."</ul>
				</div>
				<div id='newPost'><a href = 'createPost.php?sec=".$topicLink."'  >Add new post here</a></div>
				";
				 //<div id='newPost'><a href = '#' >Add new post here</a></div> connected
	 
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
function hababa($Title)
	{
		global $modal;
		global $meta;
		global $fonts;
		global $jsLinks;
		global $csslinks;
		global $Title;
		global $buttons;
		
		
		$buttons = "		<a class='button button1'  href='logout.php'   role='button' >Logout</a>";
		 $modal = "";
		 $meta = "
				<meta charset='UTF-8'>
				<meta name='viewport' content='width=device-width, initial-scale=1.0' />";
		$fonts = "<link href='https://fonts.googleapis.com/css?family=Slabo+27px' rel='stylesheet'>";
		$jsLinks = "
				<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js'></script>\n  
				<script src='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js'></script>
				<script src='topic.js'></script>";
		$csslinks = "<link rel='stylesheet' href='style.css?v=1.2' />\n";

		
		 
		
		
	}

		
?>