<?php
// process uploaded file: text and picture 
// first, you need to check if user has clicked the 
// submit button
session_start();
// include 'index.php';
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
	
	if($shell==$_COOKIE['security']){
		// echo "welcome!<br/>";
		// echo "{$array['email']}";
	}else{
		exit("error.<a href='./login.php'>login</a>");
	}
}else{
	exit("Please log in first.<a href='./login.php'>log in</a>");
}

// if(empty($_COOKIE['switch'])){  //after upload successful, user refresh the current page 
// 	exit("upload request denied");
// }

// if($_COOKIE['switch']=='on'){
// 	setcookie('swicth','',time()-1,"/");
// }else{
// 	exit("illegal operation");
// }
// if(!empty($_POST['submit'])){
// 	if($_FILES['upload']['error']==0){
// 		// var_dump($_FILES);
// 		switch($_FILES['upload']['type']){
// 			case "image/jpeg":
// 			  echo "file type accepted.<br>";
// 			  break;
// 			case "image/png":
// 			  echo "file type accepted.<br>";
// 			  break;
// 			default:
// 			  // illegal type, shut down the program
// 			  exit("illegal file type");
// 		}
// 		// new file name
// 		// get file name extension
// 		$array = explode(".", $_FILES['upload']['name']);
// 		$file_name_extension = array_pop($array);
// 		$new_file_name = time().rand(1000,9999).'.'.$file_name_extension;
		
// 		// new directories
// 		//./2015/06/23
// 		$new_file_destination = './'.date('Y').'./'.date('m').'./'.date('d');
// 		if(!is_dir($new_file_destination)){
// 			mkdir($new_file_destination,0755, true);
// 			$destination = $new_file_destination.'/'.$new_file_destination;
// 		}else{
// 			$destination = $new_file_destination.'/'.$new_file_destination;
// 		}
// 		//$destination = "./destination".$_FILES['upload']['name']
// 		if(move_uploaded_file($_FILES['upload']['tmp_name'], $destination)){
// 			require_once('./connect.php');
// 			$sql="INSERT INTO `picture` SET `url`='{$destination}',`campaign_id`='{$_COOKIE['id']}'";
// 			$db-query($sql);
			
// 			if($db->error){
// 				exit("SQL ERROR!");
// 			}
			
// 			$db->close();
// 			echo "file uploaded";
// 		}else{
// 			echo "failure";
// 		}
// 	}else{
// 		if($_FILES['upload']['error']==2 || $_FILES['upload']['error']==3){
// 			echo "file too big, please select a small one.<br>";
// 		}else{
// 			echo "this file is partially uploaded.<br/>";
// 		}
// 	}	
// }



$status = $statusMsg = ''; 
if(isset($_POST["submit"])){ 
    $status = 'error'; 
    if(!empty($_FILES["upload"]["name"])) { 
        // Get file info 
        $pictureName = basename($_FILES["upload"]["name"]); 
        $pictureType = pathinfo($pictureName, PATHINFO_EXTENSION); 
		 
		$date_time=date('Y-m-d H:i:s');
		$textInput=htmlspecialchars($_POST['campaign_text']);
		// $textName = mysqli_real_escape_string($db, $_POST['text']);


        // Allow certain file formats 
        $allowTypes = array('jpg','png','jpeg','gif'); 
        if(in_array($pictureType, $allowTypes)){          
			// require_once('./connect.php');

			$email = $_SESSION['userEmail']; //get the current email
			$sql="INSERT INTO `campaign` SET `email`='{$email}', `post_time`='{$date_time}', `post_text`='{$textInput}'";
			$db->query($sql);

			// get campaign_id
            // Insert image content into database 
			$post_id=mysqli_insert_id($db);
			$image = $_FILES['upload']['tmp_name']; 
            $imgContent = addslashes(file_get_contents($image)); 
			$insert="INSERT INTO `picture` SET `campaign_id`='{$post_id}',`img`='{$imgContent}'";
			$db->query($insert);


             
            if($insert){ 
                $status = 'success'; 
				$statusMsg = "File uploaded successfully."; 
				$db->close();
				
            }else{ 
                $statusMsg = "File upload failed, please try again."; 
            }  
        }else{ 
            $statusMsg = 'Sorry, only JPG, JPEG, PNG, & GIF files are allowed to upload.'; 
        } 
    }else{ 
        $statusMsg = 'Please select an image file to upload.'; 
    } 
} 
// Display status message 
echo $statusMsg; 

	

?>