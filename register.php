<?php

require_once('Connect.php');
class Register
{
    private $login;
    private $password;
    private $sex;
    private $Login;
    private $name;
    private $bool;
    
    function __construct($login, $password, $sex, $name)
    {
        $_SESSION['getInfo']      = "";
        $_SESSION['errorMessage'] = "gut";
        
        $this->name     = htmlspecialchars($name, ENT_QUOTES);
        $this->login    = htmlspecialchars($login, ENT_QUOTES);
        $this->password = password_hash(htmlspecialchars($password, ENT_QUOTES), PASSWORD_ARGON2I);
         
        $this->bool = FALSE;
        $this->sex  = htmlspecialchars($sex, ENT_QUOTES); // --poprawic--
		 $_SESSION['errorMessage'] = $this->name."  ".$this->login ;
		 
    }
    
    function query() //
    {
        try {
            $Check   = new Check();
            $newConn = new Connect();
            $admin = 0;
			
            $query = $newConn->connect()->prepare("INSERT INTO Users (Id_u, Name, Login, Password, Admin, sex) VALUES (NULL, :name, :login, :password, :admin, :sex)");
            $query ->bindValue(':name', $this->name, PDO::PARAM_STR);
            $query->bindValue(':login', $this->login, PDO::PARAM_STR);
            $query->bindValue(':password', $this->password, PDO::PARAM_STR);
			$query->bindValue(':admin', $admin, PDO::PARAM_INT);
            $query->bindValue(':sex', $this->sex, PDO::PARAM_STR);
            //$_SESSION['errorMessage'] = "Dddddddddddddddddd";
            
          //  $query->setAttribute(PDO::ATTR_AUTOCOMMIT, 0);
           //  $query->beginTransaction();
            $query->execute();
            
           // $query->commit();
            //$connect->rollBack();
            //$query->setAttribute(PDO::ATTR_AUTOCOMMIT, 1);
            header('Location: index.php');
            exit();
        }
        catch (PDOException $e) 
		{
            $_SESSION['errorMessage'] = "Sorry: Connect error:" . $e->getMessage();
            header('Location: index.php');
            //exit( "Sorry: Connect error:".$e->getMessage());
            
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


$login    = htmlspecialchars($_POST['login'], ENT_QUOTES);
$name     = htmlspecialchars($_POST['name'], ENT_QUOTES);
$password = htmlspecialchars($_POST['password'], ENT_QUOTES);
$sex      = htmlspecialchars($_POST['sex'], ENT_QUOTES);

$Register = new Register($login, $password, $sex, $name );
$Register -> query();



?>