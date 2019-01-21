<?php
require_once ('connect.php');

class findUser
{
	
	private $name;
	private $sex;
	 
	
	function __construct( )
	{	
		$_SESSION['getInfo'] = "";
		$_SESSION['errorMessage'] = "";
		
		 
		   
	}
	 
	
	 function search($Login)
	 {
		 
		 
		 try{ 
				  $newConn = new Connect(); 
			 
				  $query = $newConn->connect() ->prepare("Select Name, Sex from Users where Login = :login");
				  $query->bindValue(':login', $Login, PDO::PARAM_STR);
				  $query->execute();
			   if( $query->rowCount() )
			   {
				  
				 $query = $query->fetch();
				 $this -> name = $query['Name'];
				 $this -> sex = $query['Sex'];
				 
				 
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
	 
 
	 
	 
	 function getName()
	 {
		 return $this->name;
	 }
	 
	 function getSex()
	 {
		 return $this->sex;
	 }
	 
	 
	  
}



 
	
	 
		$login = htmlspecialchars($otherLogin, ENT_QUOTES);
		
		$findUser = new findUser();  
		$findUser -> search($login);
        $Name = $findUser -> getName();		
		$Sex = $findUser -> getSex();		
	//echo $_SESSION['errorMessage'];
	 
	
		 
	
 
 
?>









