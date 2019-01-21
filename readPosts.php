<?php
//session_start();
require_once('Connect.php');

class readPosts
{
	 
	
	private $postArr;  
	
 
	private $topicLink;
	 
	 
	function __construct($topicLink)
	{
		 $_SESSION['errorMessage'] = "";
		 $this->topicLink = $topicLink;
 
		 $this->postArr = array
		 (
		     "Id_pc" => array(),
			 "postDate" => array(),
			 "postContent" => array(),
			 "postOwner" => array(),
		 );
 
	}
	 
	 function findPosts()
	 {
		 try{
				  $newConn = new Connect(); 
					
				  $query = $newConn->connect() ->prepare("select Id_pc, PostContent, Id_tR, Id_uR, Data from Post where Id_tR = (select Id_t from Topic where topicLink = :topicLink)"); // dodac warunek boola
				  $query->bindValue(':topicLink', $this->topicLink, PDO::PARAM_INT); 
				  $query->execute();
			   if($query->rowCount())
			   {
				   foreach ($query as $subject)
					{
						 
						array_push( $this->postArr['Id_pc'], $subject['Id_pc']);
						array_push( $this->postArr['postContent'], $subject['PostContent']);
						array_push( $this->postArr['postOwner'], $subject['Id_uR']);
						array_push( $this->postArr['postDate'], $subject['Data']);	 
					}
			   }
			   else
			   {
				$_SESSION['errorMessage'] = "NOT POSTS FOUND in topic";
				 
				   
			   }
		 }
		 catch(PDOException $e)
			{
				$_SESSION['errorMessage'] = "Sorry: Connect error:" . $e->getMessage();
			 		
			}
	 }
	 
	 
	 
	 
	 
		function resultArray($result) // changing db object to array - not used
		{
			$tablica_wyn = array();
			for ($licznik = 0; $rzad = $result->fetch(); $licznik++)
			{
				$tablica_wyn[$licznik] = $rzad;
			}

			return $tablica_wyn;
		}
	 
	 	 function getPostArr()
		 {
			 return $this->postArr;
		 }
		 function getNumOfT()
		 {
			 return  count($this->postArr['Id_pc']);
		 }
 
}

?>




