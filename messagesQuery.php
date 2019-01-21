<?php
require_once ('connect.php');

class messagesQuery
{
	
	private $query;
	private $friendId;
	private $convId;
	private $id;
	public $convWithArr;
	private $lastMessage;
	
	private $messageArr;
	
	function __construct( $id)
	{	
		$_SESSION['getInfo'] = "";
		$_SESSION['errorMessage'] = "";
		
 		$this->id = $id;
		 
		   
	}
	
	function createConv() // creating conversion // tworzy czasami po pare, paredziesiac nowych i je pomija, wtf
	{
				$content = " "; // byle jaka wiadomosc by byla tworzona od razu konwersacja
		try{ 
				$newConn = new Connect(); 
				//$newConn ->  connect() ->setAttribute(PDO::ATTR_AUTOCOMMIT, 0);
				//$newConn -> connect() -> beginTransaction();
				
				$query = $newConn->connect() ->prepare("Insert into Conversation(Id_c) VALUES (NULL)");
				$query->execute();
					 
				$query = $newConn->connect() ->prepare("SELECT MAX(Id_c) as Id_c FROM Conversation");
				$query->execute();
					 
				//$newConn ->  connect() ->commit();
				//$newConn ->  connect() ->setAttribute(PDO::ATTR_AUTOCOMMIT, 1);  
					//INSERT INTO MyTable(Name, Address, PhoneNo) OUTPUT INSERTED.ID VALUES ('Yatrix', '1234 Address Stuff', '1112223333')
				  
			   if( $query->rowCount() )
			   {
				   $query = $query->fetch();
				    $this->convId = $query['Id_c'];
					//print_r( $query['Id_c']);
					$this -> addMessage($content);
			   }
			   else
			   {	 
				  $_SESSION['errorMessage'] = "Something goes wrong in create Conv";
				  //header('Location: messages.php');
				  exit();
			   }
		 }
		 catch(PDOException $e)
			{ 
				$_SESSION['errorMessage'] =  "cC Sorry: Connect error:" . $e->getMessage();
				//header('Location: messages.php');
				exit( "cC Sorry: Connect error:".$e->getMessage()); 
			}
	}
	
	function findFriendId($friendLogin) // first - active friend , conversation id - poki co z czytuje wszystkich uzytkownikow, takze jest troche inna funkcja pod spodem
	{ 
		 
		try{ 
				  $newConn = new Connect(); 
				  $query = $newConn->connect() ->prepare("Select Id_u from Users where Login = '$friendLogin'"); // zmienic na binda
				  
				  
				  $query->execute();
			   if( $query->rowCount() )
			   {
				   $query = $query->fetch();
				   $this->friendId = $query['Id_u']; 
			   }
			   else
			   {	 
				  $_SESSION['errorMessage'] = "Something goes wrong in friend search";
				  //header('Location: index.php');
				  exit();
			   }
			    $uId = $this->id;
			    $fId = $this->friendId;
			   
			   //next query \/
			      $query = $newConn->connect() ->prepare("Select DISTINCT Id_cR from Messages where (sentBy = $uId AND receivedBy = $fId) OR (sentBy = $fId AND receivedBy = $uId)"); 
		 
				  $query->execute();
									
					 		
			   if( $query->rowCount() )
			   {
				   $query = $query->fetch(); 
				   $this->convId = $query['Id_cR'];
				  // $_SESSION['errorMessage'] .= "conv ".$this->convId;
				  // echo "Id_cR = ".$this->convId;
			   }
			   else
			   {	 
				$this -> createConv();
				//echo "New conv";
				  //?
			   }
		 }
		 catch(PDOException $e)
			{ 
				$_SESSION['errorMessage'] =  "Friend messages  - Sorry: Connect error:" . $e->getMessage();
				//header('Location: index.php');
				exit( "fFi Sorry: Connect error:".$e->getMessage()); 
			}
	}
	
 
	
	 function searchMess($lastMessage) // tutaj
	 {
	 
		  //$this->topicArr = array('Id_message', 'content_message', 'sentby_message', 'receivedby_message', 'owner');
		  $this->messageArr = array(
						  "Id_message" => array(),
						  "content_message" => array(),
						  "sentby_message" => array(),
						  "receivedby_message"=> array(),
						  "date_message"=> array(),
						  "owner"=> array()
						  );
		 //commit
		 try{ 
		 
				  $newConn = new Connect(); 
				  $dateQuery;
				 //rozwalam metode ponizej na dwa - na jutro, teraz za zajebany jestem
			   $dateQuery = $newConn->connect() ->prepare("Select MAX(Data) as Data from Messages where  Id_cR = :convId"); // date for later
			   $dateQuery->bindValue(':convId', $this->convId, PDO::PARAM_STR);
				$dateQuery->execute();
				$dateQuery = $dateQuery->fetch();
			
					
			   $query = $newConn->connect() ->prepare("Select Id_m, MessageContent, sentBy, receivedBy, Data from Messages where Data > :lastMessage AND Id_cR = :convId");// poszczegolne konw
				  $query->bindValue(':lastMessage', $lastMessage, PDO::PARAM_STR);
				   $query->bindValue(':convId', $this->convId, PDO::PARAM_STR);
			 
				  
				  
					
				  $query->execute();
			   if( $query->rowCount() )
			   {
				   
				   $this -> lastMessage = $dateQuery['Data'];
				   foreach ($query as $subject)
					{
						 
						array_push( $this->messageArr['Id_message'], $subject['Id_m']);
						array_push( $this->messageArr['content_message'], $subject['MessageContent']);
						array_push( $this->messageArr['sentby_message'], $subject['sentBy']);
						array_push( $this->messageArr['receivedby_message'], $subject['receivedBy']);
						 
				  
						if($subject['sentBy'] == $this->id)
					   {
						//  echo "1";
						   array_push( $this->messageArr['owner'], 'i');
						   
					   }
					   else
					   {
						//echo "2";
						   array_push( $this->messageArr['owner'], 'he');
						  
					   }
					}
				   
				   
				   
				    
					//print_r($query['MessageContent']."\n");
					
				   
				   //echo "search message Succesful";
			   }
			   
			   else
			   {	 
				  $_SESSION['errorMessage'] = "Something goes wrong in searchMP";
				  //header('Location: index.php');
				  exit();
			   }
		 }
		 catch(PDOException $e)
			{ 
				$_SESSION['errorMessage'] =  "Messages - Sorry: Connect error: " . $e->getMessage();
				//header('Location: messages.php');
				exit( "sM Sorry: Connect error:".$e->getMessage()); 
			}
	 }
	 
	 function searchUs()//
	 {	 
	 $id = $this -> id;
	   $this->convWithArr = []; //array('Login');
	 
		 $this->topicArr = array('Id_message', 'content_message', 'sentby_message', 'receivedby_message', 'date_message', 'owner');
		 //commit
		 try{ 
				  $newConn = new Connect(); 
				  
				  $query = $newConn->connect() ->prepare("Select Login from Users"); // konwersacje z \./  // poprawic, z czytuje wszystkich uzytkownikow potem wiadomosci mimo ze nie ma wybranej konw.
				  //$query->bindValue(':id',  $this -> id, PDO::PARAM_INT);     // sprobowac zwezic dwa zapytania DISTINCT
				   			 
				  $query->execute();
				 
				if($query->rowCount())
			   {
				   foreach ($query as $subject)
					{
						//array_push( $this->convWithArr, $subject['Login']);
					  //array_push( $this->convWithArr, $subject['Login']);
						// echo $subject['Login'];
						$this->convWithArr[] =  $subject['Login'];
					}
					
					 // print_r($this->convWithArr);
			   }    
			   
			   else
			   {	 
				  $_SESSION['errorMessage'] = "Something goes wrong with Users searching";
				  //header('Location: index.php');
				  exit();
			   }
			   
			  
		 }
		 catch(PDOException $e)
			{ 
				$_SESSION['errorMessage'] =  " Users - Sorry: Connect error: " . $e->getMessage();
				//header('Location: messages.php');
				exit( "sU Sorry: Connect error:".$e->getMessage()); 
			}
		 
	 }
	 
	 function addMessage($content)//
	 {
		 
		 $date = date('Y-m-d H:i:s');
		 
		 try{
				  
				  $newConn = new Connect(); 
					 
				  $query = $newConn->connect() ->prepare("Insert into  Messages(Id_m ,MessageContent, Data, Id_cR, sentBy, receivedBy) values 
																(NULL,:content, '$date', :convId, :id, :friendId)");
				 
				  
				 $query->bindValue(':id', $this->id, PDO::PARAM_STR);
				  $query->bindValue(':friendId', $this->friendId, PDO::PARAM_STR);
				  $query->bindValue(':content', $content, PDO::PARAM_STR);
				  $query->bindValue(':convId', $this->convId, PDO::PARAM_STR);
				  $query->execute();
			   
			     
		 }
		 catch(PDOException $e)
			{ 
				$_SESSION['errorMessage'] =  "aM Sorry: Connect error: " . $e->getMessage();
				//header('Location: index.php');
				exit( "aM Sorry: Connect error:".$e->getMessage()); 
			}
		 
	 }
	 
	 function getmessArr()
	 {
		 return $this->messageArr;
	 }
	 
	 function getlastM()
	 {
		  return $this->lastMessage;
	 }
	   
}

session_start();
ob_start();
header("Content-type: application/json");

 
$id = $_SESSION['Id'];

$friendLogin;

$messagesQuery = new messagesQuery($id); //id
$messagesQuery -> searchUs();

$conv =  $messagesQuery -> convWithArr;

 

//print_r($x);
//print_r($messageArr);
 
 $postSet = (int)($_SERVER['REQUEST_METHOD'] == 'POST');
 
//$friendLogin = 'Niekowalski';

	
		 
switch($postSet) 
{
	case 0:
	print json_encode([
          
			'convWithA' =>$conv,
			'errorMessage' => $_SESSION['errorMessage']
			
           ]);
	exit;
	
	case 1:
	
	if( isset($_POST["friendLogin"]))
	{
		if(!isset($_POST["content"]))
		{
			  
			 $friendLogin = $_POST["friendLogin"];
			///$friendLogi = $_POST['friendLogi'];  
			$lastMessage = $_POST['lastMessage'] ?? '0000-00-00'; //? 
			$messagesQuery -> findFriendId($friendLogin);
			$messagesQuery ->  searchMess($lastMessage);
			$messageArr = $messagesQuery -> getmessArr();
			$newM = true;
			
			 
			
			print json_encode(
					[
				 
					'Id_messageA' => $messageArr['Id_message'],
					'content_messageA' => $messageArr['content_message'],//
					'sentby_messageA' => $messageArr['sentby_message'],
					'receivedby_messageA' => $messageArr['receivedby_message'],
					'ownerA' => $messageArr['owner'],//
					  'lastMessage' => $messagesQuery -> getLastM(),//
					'errorMessage' => $_SESSION['errorMessage']
					//'convWithA' =>$conv
				   ]  );
				 //  print_r($messageArr['Id_message']);
				
				/*print_r($messageArr);
				 print_r(" x ".$messageArr['Id_message']."\n");
				 print_r(" x ".$messageArr['content_message']."\n");
				 print_r(" x ".$messageArr['sentby_message']."\n");
				 print_r(" x ".$messageArr['receivedby_message']."\n");
				 print_r(" Owner ".$messageArr['owner']."\n");
				 print_r(" Date ".$messageArr['date_message']."\n");
				  print_r(" ErrorMessage ".$messageArr['errorMessage']."\n");
				 print_r(" ConvWith ".$conv."\n");
				*/ 
			 
			 
			 
		 }
		if(isset($_POST["content"]))
		{
			 
			$friendLogin = $_POST["friendLogin"];
			echo " findFriendId ";
			$messagesQuery -> findFriendId($friendLogin);
			$content = $_POST["content"];
			 
			$messagesQuery -> addMessage($content);
			 
			  
		}
	exit;
	}
	//echo $_SESSION['errorMessage']." haba";
}
 



 
// wczytywanie konwersacji <odswiez> -> (po kliku na nick) -> wczytanie danej konwersacji <odswiez> -> wtedy moge wysylac wiadomosci
?>
