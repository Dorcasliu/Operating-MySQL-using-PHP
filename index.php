<?php
// this is a personal homepage
session_start();
if(isset($_COOKIE['id']) && isset($_COOKIE['security'])){
	$id = addslashes($_COOKIE['id']);
	$sql="SELECT * FROM `user` WHERE `email`='{$id}'";
	require_once('./connect.php');
	$result=$db->query($sql);
	
	if($db->error){
		exit("ERROR!");
	}
	if($result->num_rows===0){
		exit("illegal operation.<a href='./login.php'>log in</a>");
	}
	
	//id is real
	$array = $result->fetch_array();
	$result->free();
	$shell = md5($_COOKIE['id'].$array['password']."the_third_string");
	// $db->close();
        
	if($shell===$_COOKIE['security']){
		// echo "welcome!<br/>";
        // echo "{$array['name']}";
	}else{
		exit("error.<a href='./login.php'>login</a>");
	}
}else{
	exit("Please log in first.<a href='./login.php'>log in</a>");
}

$_SESSION['userEmail'] = $array['email'];
setcookie("switch","on",0,"/");
?>

<a href='./logout.php'>log out</a>
<hr>
<form action="./upload_campaign.php" method="POST" enctype="multipart/form-data">
  <label for="campaign">Input champaign text:</label><br/>
  <textarea id="campaign" name="campaign_text" rows="5" cols="50"></textarea><br/>
  <input type="hidden" name="MAX_FILE_SIZE" value="30000000"/>
  <input type="file" name="upload" value="" />
  <input type="submit" name="submit" value="submit" />
</form>