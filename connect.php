<?php
// connect to database
// first, instantiate MySQLi class
// order: localhost root password db_name
// use @ to block error report
// connect_error:null

$db = new MySQLi("127.0.0.1","root","12481632","homelessness");
if($db->connect_error){
	exit("cannot connect to the database");
}

// INERT INTO `table_name` SET `field_name1`='value1',`field_name2`='value2',...
// require_once('./connect.php');

// $sql="INSERT INTO `user` SET `email`='123456@gmail.com',`name`='123456',`password`='123456'";
// $result = $db->query($sql);
// if(result){
// 	echo "new row added.<br>";
// }else{
// 	echo "failure";
// }

?>