<?php
session_start();




$_SESSION['errorMessage'] = $_SESSION['errorMessage'] ?? "Nothing"; // dac do popupa
$_SESSION['expired'] = $_SESSION['expired'] ?? 0;
 
if (isset($_SESSION['Id']) && isset($_SESSION['login']) && isset($_SESSION['password']) && $_SESSION['expired'] < time())
{
	 header('Location: indexU.php');
}		 
else{
 
	echo $_SESSION['errorMessage'];
		
	if(!$_GET['s'])
	{
		 header('Location: index.php');
	}
	else
	{	 	
		 
		
		echo $_SESSION['errorMessage'];
		$chck = htmlspecialchars(strtr($_GET['s'],"-"," ") , ENT_QUOTES);
		$secArr = $_SESSION['sectT'];
		check($chck, $secArr);
		
		require_once("readTopics.php");
		require_once ('htmlBuilder.php');
		
		$readTopics = new readTopics();
		$readTopics -> findTopics($chck);
		$topicArr = $readTopics -> getTopicsArr();
		$getNumOfT = $readTopics -> getNumOfT();
		$_SESSION['topicArr'] = $topicArr ;
		

		
		
		$buttons = "
				<button class='button button1' data-toggle='modal' data-target='#login'>Login</button>
				<button class='button button2' data-toggle='modal' data-target='#registr'>Register</button>";
		$meta = "
			<meta charset='UTF-8'>
			<meta name='viewport' content='width=device-width, initial-scale=1.0' />";
		$modal = setModal();
		$asideMenu = aside(); 
		$fonts = "<link href='https://fonts.googleapis.com/css?family=Slabo+27px' rel='stylesheet'>"; 
		$jsLinks = "
				<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js'></script>\n  
				<script src='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js'></script>";
		$csslinks = "<link rel='stylesheet' href='style.css?v=1.1' />\n";

		$Title = "Topics";


		$section = section($topicArr, $getNumOfT, $chck);	


		$Content = new Content($meta, $fonts, $csslinks, $jsLinks, $Title, $modal);
		$Content -> setHeader($buttons);
		$Content -> setAside(3, $asideMenu);
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
	function aside()
		{
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

				return $asideMenu;
		}
	function section($topicArr, $getNumOfT, $chck)
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
						</div>";
						return $section;
		}
	function setModal()
		{		$modal = "      <!-- The Modal -->
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
	  
	  return $modal;
}
	
	
	
?>