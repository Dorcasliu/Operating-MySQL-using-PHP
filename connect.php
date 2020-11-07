<?php
// connect to database
// first, instantiate MySQLi class
// order: localhost root password db_name
// use @ to block error report

$db = new mysqli("localhost","root","","db_name");
if($db->connect_error){
	echo $db->connect_error;
}
echo "connect successful";
// var_dump($db->connect_error);


// $db = new MySQLi();
// $result = @$db->connect("localhost","root","","car");
// var_dump($result);

// if($db->close()){
// 	echo "bye";
// }else{
// 	echo "error";
// }
?>