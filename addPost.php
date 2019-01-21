<?php
require_once ('connect.php');

class addPost
{
	
	private $query;
	private $Id;
	private $topicLink;
	private $usersArr;
	 private $IdT;
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
			 
				  $query = $newConn->connect() ->prepare("Select Id_t from Topic where topicLink = :topicLink");
				  $query->bindValue(':topicLink', $this->topicLink, PDO::PARAM_STR);
				  $query->execute();
			   if( $query->rowCount() )
			   {
				   $query = $query->fetch();
				    $this->IdT = $query['Id_t'];
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
	 
	  function createPost($postContent, $myId)
	 {
		 
		
		 try{ 
				  $newConn = new Connect(); 
			 
				  $query = $newConn->connect() ->prepare("Insert into Post(Id_pc ,PostContent,Data, Id_tR, Id_uR) values (NULL, :postContent, CURDATE(), :IdT, :id)");
				  $query->bindValue(':id', $myId, PDO::PARAM_STR);																										   
				  $query->bindValue(':IdT', $this -> IdT, PDO::PARAM_STR);
				    $query->bindValue(':postContent', $postContent, PDO::PARAM_STR);
				 
				  $query->execute();
			    
		 }
		 catch(PDOException $e)
			{ 
				$_SESSION['errorMessage'] =  "Sorry: Connect error:" . $e->getMessage();
				 
				//exit( "Sorry: Connect error:".$e->getMessage()); 
			}
		 
	 }
	 
	
	 
	  
}

session_start();

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
	
	$topicLink = $_POST['topicLink'];
	$postContent = $_POST['postContent'];
	 
		
		$id = $_SESSION['Id'];
		
		$addPost = new addPost();  
		$addPost -> selId($topicLink);	
		$addPost -> createPost($postContent, $id);			
	echo $_SESSION['errorMessage'];
	  header('Location: topicsU.php');
	 
	
	
		 
	
	
}
 
?>














