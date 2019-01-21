<?php
require_once ('connect.php');

class Login
{
	private $login;
	private $password;
	private $query;
	private $admin;
	private $Login;
	private $bool;
	
	function __construct($login, $password)
	{	
		$_SESSION['getInfo'] = "";
		$_SESSION['errorMessage'] = "gut";
		
		 $this->login = htmlspecialchars($login, ENT_QUOTES);
		  $this->password = htmlspecialchars($password, ENT_QUOTES);
		  $this->bool = FALSE;
		  
		   
	}
	 
	 function query()//
	 {
		 try{
			 $Check = new Check();
				  $newConn = new Connect(); 
			 
				  $this->query = $newConn->connect() ->prepare("Select Id_u, Password, Admin, Sex, Name from Users where Login = :login ");
				  $this->query->bindValue(':login', $this->login, PDO::PARAM_STR);
				  $this->query->execute();
			   if( $this->query->rowCount())
			   {
				   $this->query = $this->query->fetch();
				   //$_SESSION['getInfo'] = .;
				   
				  $this -> bool = $Check -> CheckPasswd($this->password, $this->query['Password']);  
			   }
			   else
			   {	 
				  $_SESSION['errorMessage'] = "Wrong login or password";
				   header('Location: index.php');
				   exit();
			   }
		 }
		 catch(PDOException $e)
			{ 
				$_SESSION['errorMessage'] =  "Sorry: Connect error:" . $e->getMessage();
				header('Location: index.php');
				//exit( "Sorry: Connect error:".$e->getMessage());
				
			}
		 
	 }
	 
	 function setSession() /// check to login
	 {
		 if($this->bool)
		 {
			 $_SESSION['name'] = $this->query['Name'];
			$_SESSION['Id'] = $this->query['Id_u'];
			$_SESSION['login'] = $this->login;
			$_SESSION['password'] = $this->password;
			$_SESSION['admin'] = $this->query['Admin'];
			$_SESSION['sex'] = $this->query['Sex'];
			$_SESSION['expired'] = time() + 600;
			$_SESSION['errorMessage'] = "gutbool";
			//echo '  gut passwd  ';
			header('Location: indexU.php');
			exit(); 	
		 }
		 else
		 { 
			// echo "Wrong login or password";
			$_SESSION['errorMessage'] = "Wrong login or password".password_hash($this->query['Password'], PASSWORD_ARGON2I); 
			header('Location: index.php');
			exit(); 
		 }
	 }
	  
}

 class Check
{
	
	
	function CheckPasswd($stringOne, $stringTwo)
	{
			  if (password_verify($stringOne, $stringTwo)) 
			{

				return TRUE;
			}
			else return FALSE;
	}

}

 session_start();
$login = htmlspecialchars($_POST['login'], ENT_QUOTES);
$password = htmlspecialchars($_POST['password'], ENT_QUOTES);

$Login = new Login($login, $password);
$Login -> query();
$Login -> setSession(); 

?>














