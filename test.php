<?php
session_start();
ob_start();
header("Content-type: application/json");

$postSet = (int)!($_SERVER['REQUEST_METHOD'] == 'POST');

$arr = array();
$arr[0] = "Mark Reed";
$arr[1] = "34";
$arr[2] = "Australia";

//print json_encode($postSet);//$arr[$_POST['ids']], $arr[$_POST['idf']]);
  $date = date('Y-m-d H:i:s');
echo $date;


?>