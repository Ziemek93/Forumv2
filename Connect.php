<?php

class Connect
{
	
	private $configArr = array('dbName','host','user','password');
	private $connect;
	private $dsn;
	 
	
	function Connect()
	{
		return $this->connect = new PDO($this->dsn, $this->configArr['user'], $this->configArr['password'], [PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
	}
	 
	function __construct()
	{	
		 //session_start();
		 
		$this->configArr['dbName'] = 'forumo';
		$this->configArr['host'] = 'localhost';
		$this->configArr['user'] = 'root';
		$this->configArr['password'] = '';
		
		$this->dsn = 'mysql:host=' . $this->configArr['host'] . ';dbname=' . $this->configArr['dbName'] . ';charset=utf8';	
	}
	
	function setOtherConn ($dbName, $host, $user, $password) // for other conn config
	{
		$this->$configArr['dbName'] = $dbName;
		$this->$configArr['host'] = $host;
		$this->$configArr['user'] = $user;
		$this->$configArr['password'] = $password;
		
		$this->$dsn = 'mysql:host=' . $configArr['host'] . ';dbname=' . $configArr['dbName'] . ';charset=utf8';	
	}
	
  
}

?>