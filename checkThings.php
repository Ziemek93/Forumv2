<?php
require_once ('connect.php');

class CheckThings
{
	
	private $query;
	private $Id;
	private $topicLink;
	private $usersArr;
	
	function __construct( )
	{	
		$_SESSION['getInfo'] = "";
		$_SESSION['errorMessage'] = "";
		
		 
		   
	}
	 
	 function selId($topicLink)//
	 {
		  $this->topicLink = htmlspecialchars($topicLink, ENT_QUOTES);
		 
		 try{ 
				  $newConn = new Connect(); 
			 
				  $query = $newConn->connect() ->prepare("Select Id_uR from Topic where topicLink = :topicLink");
				  $query->bindValue(':topicLink', $this->topicLink, PDO::PARAM_STR);
				  $query->execute();
			   if( $query->rowCount() )
			   {
				   $query = $query->fetch();
				    $this->Id = $query['Id_uR'];
			   }
			   else
			   {	 
				  $_SESSION['errorMessage'] = "Something goes wrong";
				  
				  exit();
			   }
		 }
		 catch(PDOException $e)
			{ 
				$_SESSION['errorMessage'] =  "Sorry: Connect error:" . $e->getMessage();
				 
				//exit( "Sorry: Connect error:".$e->getMessage()); 
			}
		 
	 }
	 
	 
	 function allUsers($myId)
	 {
		 $this->usersArr = array(
						  "Id_u" => array(),
						  "Login" => array()
						  );
		 
		 try{ 
				  $newConn = new Connect(); 
			 
				  $query = $newConn->connect() ->prepare("Select Id_u, Login from Users");
				  $query->bindValue(':id', $myId, PDO::PARAM_STR);
				  $query->execute();
			   if( $query->rowCount() )
			   {
				  
				 foreach ($query as $subject)
					{
						 
						array_push( $this->usersArr['Id_u'], $subject['Id_u']);
						array_push( $this->usersArr['Login'], $subject['Login']); 
		 
					} 
			   }
			   else
			   {	 
				  $_SESSION['errorMessage'] = "Something goes wrong - Can't find any user";
				  
				  exit();
			   }
		 }
		 catch(PDOException $e)
			{ 
				$_SESSION['errorMessage'] =  "Sorry: Connect error:" . $e->getMessage();
				 
				//exit( "Sorry: Connect error:".$e->getMessage()); 
			}
		 
	 }
	 
	 function deleteUser($login)//
	 {
		  $this->login = htmlspecialchars($login, ENT_QUOTES);
		 
		 try{
				  
				  $newConn = new Connect(); 
			 
				  $query = $newConn->connect() ->prepare("DELETE from Users where Login = :login");
				  $query->bindValue(':login', $this->login, PDO::PARAM_STR);
				  $query->execute();
			  
		 }
		 catch(PDOException $e)
			{ 
				$_SESSION['errorMessage'] =  "Sorry: Connect error:" . $e->getMessage();
				  
				//exit( "Sorry: Connect error:".$e->getMessage()); 
			}
		 
	 }
	 
	 function promoUser($login)//
	 {
		  $this->login = htmlspecialchars($login, ENT_QUOTES);
		 
		 try{
				  
				  $newConn = new Connect(); 
			 
				  $query = $newConn->connect() ->prepare("UPDATE Users
															SET Admin = 1
															WHERE Login = :login;");
				  $query->bindValue(':login', $this->login, PDO::PARAM_STR);
				  $query->execute();
			  
		 }
		 catch(PDOException $e)
			{ 
				$_SESSION['errorMessage'] =  "Sorry: Connect error:" . $e->getMessage();
				header('Location: index.php');
				//exit( "Sorry: Connect error:".$e->getMessage()); 
			}
		 
	 }
	 
 
	 
	 
	 function getAllUsers()
	 {
		 return $this->usersArr;
	 }
	 
	 function getId()
	 {
		 return $this->Id;
	 }
	 
	 
	  
}



if($_SERVER['REQUEST_METHOD'] == 'POST')
{
	
	
	
	if(isset($_POST['deleteHim']))
	{
		
		$login = htmlspecialchars($_POST['deleteHim'], ENT_QUOTES);
		
		$CheckThings = new CheckThings();  
		$CheckThings -> deleteUser($login);			
	echo $_SESSION['errorMessage'];
	}
	
	if(isset($_POST['promoHim']))
	{
		
		$login = htmlspecialchars($_POST['promoHim'], ENT_QUOTES);
		
		$CheckThings = new CheckThings();  
		$CheckThings -> promoUser($login);			
	
	}
	
	
		 
	
	
}
 
?>














