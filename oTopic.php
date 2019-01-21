<?php
require_once ('connect.php');

class oTopic
{
	
	 
	private $Id;
	private $Id_section;
	private $content;
	private $title;
	
	private $topicId;
	
	function __construct()
	{	
		
		$_SESSION['errorMessage'] = "";
		
		 
		   
	}
 
	  
	 
	 function sectionId($sectionName)
	 {
		 $sectionName = htmlspecialchars($sectionName, ENT_QUOTES);
		 
		 try{ 
				  $newConn = new Connect(); 
			 
				  $query = $newConn->connect() ->prepare("select Id_s from Sections where sectionTitle = :sectionName");
				   $query->bindValue(':sectionName', $sectionName, PDO::PARAM_STR);
				  $query->execute();
				  
			    if( $query->rowCount() )
			   { 
		   
				 $query = $query->fetch();
				 $this -> Id_section = $query['Id_s'];
				 }
			   else
			   {	 
				  $_SESSION['errorMessage'] = "Something goes wrong in Section search";
				 
			   }  
			   
			   
		 }
		 catch(PDOException $e)
			{ 
				$_SESSION['errorMessage'] =  "Sorry: Connect error:" . $e->getMessage();
				echo $e->getMessage();
				 
				//exit( "Sorry: Connect error:".$e->getMessage()); 
			}
		 
	 }
	 
	 
	 function createTopic($content, $title, $myId)
	 {
		 
		
		 try{ 
				  $newConn = new Connect(); 
			 
				  $query = $newConn->connect() ->prepare("Insert into  Topic(Id_t ,Title,TopicContent,Data, topicLink, Bool,ID_sR, ID_uR) values (NULL, :title, :content, CURDATE(), UUID(), DEFAULT, :idSec, :id)");
				  $query->bindValue(':id', $myId, PDO::PARAM_STR);																										   
				  $query->bindValue(':idSec', $this -> Id_section, PDO::PARAM_STR);
				    $query->bindValue(':content', $content, PDO::PARAM_STR);
					  $query->bindValue(':title', $title, PDO::PARAM_STR);
				  $query->execute();
			    
		 }
		 catch(PDOException $e)
			{ 
				$_SESSION['errorMessage'] =  "Sorry: Connect error:" . $e->getMessage();
				 
				//exit( "Sorry: Connect error:".$e->getMessage()); 
			}
		 
	 }
	 
	 
	 function findTopicId($topicLink)
	 {
		 
		 	 try{ 
				  $newConn = new Connect(); 
			 
				  $query = $newConn->connect() ->prepare("select Id_t from Topic where topicLink = :topicLink");
				   $query->bindValue(':topicLink', $topicLink, PDO::PARAM_STR);
				  $query->execute();
				  
			    if( $query->rowCount() )
			   { 
		   
				 $query = $query->fetch();
				 $this -> topicId = $query['Id_t'];
				 }
			   else
			   {	 
				  $_SESSION['errorMessage'] = "Something goes wrong in Topic search";
				 
			   }  
			   
			   
		 }
		 catch(PDOException $e)
			{ 
				$_SESSION['errorMessage'] =  "Sorry: Connect error:" . $e->getMessage();
				echo $e->getMessage();
				 
				//exit( "Sorry: Connect error:".$e->getMessage()); 
			}
	 }
	 
	 function deleteTopic()
	 {
		 		  
		 
		 try{
				  
				  $newConn = new Connect(); 
			 
				  $query = $newConn->connect() ->prepare("DELETE from Post where Id_tR = :topicId");
				  $query->bindValue(':topicId', $this -> topicId, PDO::PARAM_STR);
				  $query->execute();
				  
				  
				  $query = $newConn->connect() ->prepare("DELETE from Topic where Id_t = :topicId");
				  $query->bindValue(':topicId', $this -> topicId, PDO::PARAM_STR);
				  $query->execute();
				  
			  
		 }
		 catch(PDOException $e)
			{ 
				$_SESSION['errorMessage'] =  "Sorry: Connect error:" . $e->getMessage();
				 
				//exit( "Sorry: Connect error:".$e->getMessage()); 
			}
	 }
	 
	  function acceptTopic()
	 {
		 		  
		 
		 try{
				  
				  $newConn = new Connect(); 
			 
				  $query = $newConn->connect() ->prepare("Update Topic SET BOOL = TRUE where Id_t = :topicId");
				  $query->bindValue(':topicId', $this -> topicId, PDO::PARAM_STR);
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
	
	if(isset($_POST['sec']) && isset($_POST['topicContent']) && isset($_POST['topicTitle']))
	{
		 $Id = $_SESSION['Id'];
		 $sectionName = htmlspecialchars($_POST['sec'], ENT_QUOTES);
		  $content = htmlspecialchars($_POST['topicContent'], ENT_QUOTES);
		   $title = htmlspecialchars($_POST['topicTitle'], ENT_QUOTES);
	 
		$oTopic = new oTopic();
		$oTopic -> sectionId($sectionName);
		$oTopic -> createTopic($content, $title, $Id);
		header('Location: topicsU.php');
	
	} 
	
	if(isset($_POST['topicLink']))
	{
		 
		 echo "DA";
		 
		 $topicLink = htmlspecialchars($_POST['topicLink'], ENT_QUOTES);
		  
	 
		$oTopic = new oTopic();
		$oTopic -> findTopicId($topicLink);//
		$oTopic -> deleteTopic();
		 
	
	} 
	
	
	
	if(isset($_POST['accept']))
	{
		 
		 $accept = htmlspecialchars($_POST['accept'], ENT_QUOTES);
		  
	 
		$oTopic = new oTopic();
		$oTopic -> findTopicId($accept);//
		$oTopic -> acceptTopic();
		 
	
	} 
		 
	
}

 
 
?>














