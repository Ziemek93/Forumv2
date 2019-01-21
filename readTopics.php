<?php
//session_start();
require_once('Connect.php');

class readTopics
{
	 
	
	 private $topicsArr;  
	 private $topicArr;
	 private $topicLink;
	private $topicsOffArr;
	private $sectionTitle;
	 
	 
	function __construct()
	{
		 $_SESSION['errorMessage'] = "";
		 ;
 
		 
 
	}
	 
	 function findTopics($sectionTitle)
	 
	 {	$this->sectionTitle = $sectionTitle;
		 $this->topicsArr = array
		 (
		     "topicId" => array(),
			 "topicDate" => array(),
			 "topicTitle" => array(),
			 "topicOwner" => array(),
			 "topicActive" => array(),
			 "topicLink" => array()
			  
		 );
		 
		  
		 try{
				  $newConn = new Connect(); 
			 
 
				  $query = $newConn->connect() ->prepare("select Id_t, Title, TopicContent, Data, Bool, Id_uR,  topicLink from Topic where Bool = 1 and Id_sR = (select Id_s from sections where sectionTitle = :sectionTitle)"); // dodac warunek boola z rana
				  $query->bindValue(':sectionTitle', $this->sectionTitle, PDO::PARAM_STR); 
				  $query->execute();
			   if($query->rowCount())
			   {
				   foreach ($query as $subject)
					{
						array_push( $this->topicsArr['topicId'], $subject['Id_t']);
						array_push( $this->topicsArr['topicDate'], $subject['Data']);
						array_push( $this->topicsArr['topicTitle'], $subject['Title']);
						array_push( $this->topicsArr['topicOwner'], $subject['Id_uR']);
						array_push( $this->topicsArr['topicActive'], $subject['Bool']);
						array_push( $this->topicsArr['topicLink'], $subject['topicLink']);
						 
					}
			   }
			   else
			   {
				$_SESSION['errorMessage'] = "NOT TOPICS FOUND in section '".$this->sectionTitle."'";
				 
				   
			   }
		 }
		 catch(PDOException $e)
			{
				$_SESSION['errorMessage'] = "Sorry: Connect error:" . $e->getMessage();
			 		
			}
	 }
	 
	 function findOffTopics($sectionTitle)
	 
	 {	$this->sectionTitle = $sectionTitle;
		 $this->topicsOffArr = array
		 (
		     "topicId" => array(),
			 "topicDate" => array(),
			 "topicTitle" => array(),
			 "topicOwner" => array(),
			 "topicActive" => array(),
			 "topicLink" => array()
			  
		 );
		 
		  
		 try{
				  $newConn = new Connect(); 
			  
				  $query = $newConn->connect() ->prepare("select Id_t, Title, Bool, Id_uR, Data, topicLink from Topic where Bool = 0 and Id_sR = (select Id_s from sections where sectionTitle = :sectionTitle)"); // dodac warunek boola z rana
				  $query->bindValue(':sectionTitle', $this->sectionTitle, PDO::PARAM_STR); 
				  $query->execute();
			   if($query->rowCount())
			   {
				   foreach ($query as $subject)
					{
						array_push( $this->topicsOffArr['topicId'], $subject['Id_t']);
						array_push( $this->topicsOffArr['topicDate'], $subject['Data']);
						array_push( $this->topicsOffArr['topicTitle'], $subject['Title']);
						array_push( $this->topicsOffArr['topicOwner'], $subject['Id_uR']);
						array_push( $this->topicsOffArr['topicActive'], $subject['Bool']);
						array_push( $this->topicsOffArr['topicLink'], $subject['topicLink']); 
					} 	
			   } 
			   else
			   {
				$_SESSION['errorMessage'] = "NOT UNREGISTRED TOPICS FOUND in section '".$this->sectionTitle."'";
				 
				   
			   }
		 }
		 catch(PDOException $e)
			{
				$_SESSION['errorMessage'] = "Sorry: Connect error:" . $e->getMessage();
			 		
			}
	 }
	 
	 function findTopic($topicLink)
	{	
		$this->topicLink = $topicLink;
		$this->topicArr = array('topicId', 'topicDate', 'topicTitle', 'topicOwner', 'topicActive', 'topicLink', 'topicContent');
		
		 try{
				  $newConn = new Connect(); 
			 
				  $query = $newConn->connect() ->prepare("select Id_t, TopicContent, Title, Bool, Id_uR, Data from Topic where topicLink = :topicLink"); // dodac warunek boola
				  $query->bindValue(':topicLink', $this->topicLink, PDO::PARAM_INT); 
				  $query->execute(); 
				  
			   if($query->rowCount())
			   {	
				    $query = $query->fetch();
					 
					 
				   $this->topicArr = array
					 (
					
						 "topicId" => $query['Id_t'],
						 "topicDate" =>  $query['Data'],
						 "topicTitle" =>  $query['Title'],
						 "topicOwner" =>  $query['Id_uR'],
						 "topicActive" =>  $query['Bool'],
						 "topicContent" =>  $query['TopicContent']
						
					 );
				       
			   }
			   else
			   {
				$_SESSION['errorMessage'] = "TOPIC NOT FOUND'".$this->sectionTitle."'";
				 
				   
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
	 
	 	 function getTopicsArr()
		 {
			 return $this->topicsArr;
		 }
		  function getTopicArr()
		 {
			 return $this->topicArr;
		 }
		   function getOffTopicsArr()
		 {
			 return $this->topicsOffArr;
		 }
		 function getNumOfT()
		 {
			 return  count($this->topicsArr['topicId']);
		 }
		  function getNumOfDisabledT()
		 {
			 return  count($this->topicsOffArr['topicId']);
		 }
		
}

?>




