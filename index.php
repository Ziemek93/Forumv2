<?php
require_once ('htmlBuilder.php');
require_once ('readSection.php');

session_start();


$_SESSION['errorMessage'] = $_SESSION['errorMessage'] ?? "Nothing"; // dac do popupa
$_SESSION['expired'] = $_SESSION['expired'] ?? 0;
 
if (isset($_SESSION['Id']) && isset($_SESSION['login']) && isset($_SESSION['password']) && $_SESSION['expired'] > time())
{
	 header('Location: indexU.php'); // cos nie gra bo nie przekierowuje, zrobic potem znikanie w topicsU
}		 
else{
	
 
	
 
	echo $_SESSION['errorMessage'];
	
	 $meta = "
		<meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0' />";
	 $buttons = "
			<button class='button button1' data-toggle='modal' data-target='#login'>Login</button>
            <button class='button button2' data-toggle='modal' data-target='#registr'>Register</button>";
	$fonts = "<link href='https://fonts.googleapis.com/css?family=Slabo+27px' rel='stylesheet'>";

	$jsLinks = "
				<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js'></script>\n  
				<script src='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js'></script>";
				
	$csslinks = "<link rel='stylesheet' href='style.css?v=1.1' />\n";
  
 
	
	
 	$readSection = new readSection();
	$readSection -> findSection();
	$sectionTitle =$readSection-> getTitle();
	
	
	$_SESSION['sectT'] = $sectionTitle ; 
	
	$Title = "Main site";
	$modal = setModal();
	$section = section($sectionTitle);
	$asideMenu = aside();
	 






	$Content = new Content($meta, $fonts, $csslinks, $jsLinks, $Title, $modal);
	$Content -> setHeader($buttons);
	$Content -> setAside(3, $asideMenu);
	$Content -> setContent($section);
	$Content -> Show();



}


	
	function section($sectionTitle)
		{
			 
			$container = "";
	 
		if (count($sectionTitle) > 0)
			{
			$i = 0;
			while ($i < count($sectionTitle))
				{
				 
				$container .= "<li><a href = 'topics.php?s=".strtr($sectionTitle[$i]," ","-")."'>".$sectionTitle[$i]."</a></li>";
				$i++;
				}
			}		

			
	return $section = " <h1 id = 'title'>Forum</h1>
				<p>Dane forum zrzesza fanów jak i użytkowników systemu Android. Hababababa</p>
				<div class= 'indexList'>
				<ul>".$container
				."</ul>
				</div>";
		}
			
	function setModal()
	{
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
							<form action='register.php' class='container' method= 'post'>
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
 
 
?>

 
 
 