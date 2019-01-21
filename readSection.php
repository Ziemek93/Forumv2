<?php
//session_start();
require_once('Connect.php');

class readSection
{
	private $sectionTitle; /// stworzyc klase do tworzenia dynamicznych widoków
 
	 
	 
	function __construct( )
	{
		 $_SESSION['errorMessage'] = "";
 
		   $this->sectionTitle = array();
 
	}
	 
	 function findSection()
	 {
		 try{
				  $newConn = new Connect(); 
			 
				  $query = $newConn->connect() ->prepare("select sectionTitle from Sections");
				   
				  $query->execute();
			   if($query->rowCount())
			   {
				   foreach ($query as $subject)
					{
						array_push( $this->sectionTitle, $subject['sectionTitle']);
					}
			   }
			   else
			   {
				$_SESSION['errorMessage'] = "Not Subjects Found";
				 
				   
			   }
		 }
		 catch(PDOException $e)
			{
				$_SESSION['errorMessage'] = "Sorry: Connect error:" . $e->getMessage();
			 		
			}
	 }
	 
		function resultArray($result) // changing db object to array
		{
			$tablica_wyn = array();
			for ($licznik = 0; $rzad = $result->fetch(); $licznik++)
			{
				$tablica_wyn[$licznik] = $rzad;
			}

			return $tablica_wyn;
		}
	 
	 	 function getTitle()
		 {
			 return $this->sectionTitle;
		 }
 
 
}

 

?>




