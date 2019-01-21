<?php
session_start();

if(!$_GET['p'])
{
	 header('Location: index.php');
}
else
{
	$topicLink = htmlspecialchars($_GET['p'], ENT_QUOTES);
	
	if (isset($_SESSION['Id']) && isset($_SESSION['login']) && isset($_SESSION['password']) && $_SESSION['expired'] > time())
	{
		 header('Location: topicU.php?tl='.$topicLink.'');
	}
	
	
	echo $_SESSION['errorMessage'];
	
	 
	
	require_once("readTopics.php");
	require_once("readPosts.php");
	require_once ("htmlBuilder.php");
	$readTopics = new readTopics();
	$readTopics -> findTopic($topicLink);
	$topicArr = $readTopics -> getTopicArr();
	 
	
	$readPosts = new readPosts($topicLink);
	$readPosts -> findPosts();
	$postArr = $readPosts -> getPostArr();
	$getNumOfP = $readPosts -> getNumOfT();
	
	
	$_SESSION['topicArr'] = $topicArr ;
	aside();
	 	 $Title = $topicArr['topicTitle'];
    
	hababa();	
	
	section($postArr, $topicArr, $getNumOfP);
 	 

	$Content = new Content($meta, $fonts, $csslinks, $jsLinks, $Title, $modal);
	$Content -> setHeader($buttons);
	$Content -> setAside($asideNum, $asideMenu);
	$Content -> setContent($section);
	$Content -> Show();

	
	
}
function hababa()
	{
		 
		global $meta;
		global $fonts;
		global $jsLinks;
		global $csslinks;
		global $buttons;
		global $modal;
		
		
		$buttons = "		<a class='button button1'  href='logout.php'   role='button' >Logout</a>";
		 
		 $meta = "
				<meta charset='UTF-8'>
				<meta name='viewport' content='width=device-width, initial-scale=1.0' />";
		$fonts = "<link href='https://fonts.googleapis.com/css?family=Slabo+27px' rel='stylesheet'>";
		$jsLinks = "
				<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js'></script>\n  
				<script src='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js'></script>
				<script src='topic.js'></script>";
		$csslinks = "<link rel='stylesheet' href='style.css?v=1.2' />\n";

		
		 
		$modal = "      <!-- The Modal -->
      <div class='modal fade' id='registr'>
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
                        <form action='reg.php' class='container' method= 'post'>
                           <div class='form-group'>
                              <input name = 'name' type='text' placeholder='Name' class='form-control  mt-2' required>
                              <input name = 'login' type='text' placeholder='Login' class='form-control  mt-2' required>
                           </div>
                           <div class='form-group'>
                              <input name = 'password' type='password'  placeholder='Password' class='form-control  mt-2' required>
                              <input type='password' placeholder='Password' class='form-control  mt-2' required>
                              <select  name = 'sex' class='form-control  mt-2'>
                                 <option selected>Man</option>
                                 <option value='1'>Women</option>
                                 <option value='2'>Idk</option>
                              </select>
                           </div>
                           <div class='form-group form-check  mt-2' >
                              <label class='form-check-label '>
                              <input class='form-check-input' type='checkbox' required> Akceptuje regulamin.
                              </label>
                           </div>
                           <button type='submit' class='button  '>Submit</button>
                        </form>
                     </div>
                  </div>
               </div>
               <!-- Modal footer -->
            </div>
         </div>
      </div>
      <!-- The Modal -->
      <div class='modal fade' id='login'>
         <div class='modal-dialog modal-lg modal-dialog-centered'>
            <div class='modal-content'>
               <!-- Modal Header -->
               <div class='modal-header'>
                  <h4 class='modal-title'>Login</h4>
                  <button type='button' class='close' data-dismiss='modal'>&times;</button>
               </div>
               <!-- Modal body -->
               <div class='modal-body'>
                  <div class='container'>
                     <div class='card-body'>
                        <form action='login.php' class='container' method= 'post'>
                           <div class='form-group'>
                              <input name = 'login' type='text' placeholder='Login' class='form-control  mt-2' required>
                              <input name = 'password' type='password'  placeholder='Password' class='form-control  mt-2' required>
                           </div>
                           <button type='submit' class='button'>Submit</button>
                        </form>
                     </div>
                  </div>
               </div>
               <!-- Modal footer -->
            </div>
         </div>
      </div>";
		
	}

function section($postArr, $topicArr, $getNumOfP)
{		
	global $section;
	
	
	$container = "";
	 
		if ($getNumOfP > 0)
			{
			$i = 0;
			while ($i < $getNumOfP)
				{
				//$container .= "<li><a  href = 'profile.php?t=".$postArr['postOwner'][$i]."'>".$postArr['postContent'][$i]."</a> <div class = 'subtitle'><b>".$postArr['postDate'][$i]." - ".$postArr['postOwner'][$i]."</b></div></li>";
				$container .= "<li><a>".$postArr['postContent'][$i]."</a> <div class = 'subtitle'><b>".$postArr['postDate'][$i]." - ".$postArr['postOwner'][$i]."</b></div></li>";
				$i++;            
				}
			}	
			
	$section = " <div id ='post'>
				<h1 id = 'title'>".$topicArr['topicTitle']."</h1>
				<p>".$topicArr['topicContent']."</p>
				<a href = '#' class = 'postDateUser'>".$topicArr['topicOwner']." - ".$topicArr['topicDate']."</a>
				</div>
				<div class= 'indexList'>
				<ul>".$container
				."</ul>
				</div>
				";
				 //<div id='newPost'><a href = '#' >Add new post here</a></div> connected
	
}				
 
function aside()
	{
		global $asideNum;
		global $asideMenu;
		
		
		$asideNum = 3;
		$asideMenu = array
		(
			 "menuName" => array(
				 0 => "Home",
				 1  => "Contact",
				 2 => "Rules"
			 ),
			 "menuHref" => array
			 (
				 0 => "#",
				 1 => "Contact.php",
				 2 => "Rules.php"
			 )
		);

			
	}
 
		
?>