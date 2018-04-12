<?php
	//date_default_timezone_set()- Sets the timezone you want to get the date in
	date_default_timezone_set('Africa/Nairobi');
	
	//Include database connection
	require('Background/initialize.php');
	
	//Include functins page file
	include 'comments.php';
	
	//Starts the session
	//session_start();
?>

<!DOCTYPE html>
<html>
<head>
<meta charset='utf-8'>
<link rel="stylesheet" href="style.css">
</head>
<body>
	<!-- The form belows allow the user to login and logout before updating or deleting any comments in the website-->
<?php

	//get the id from the URLs
	$id = $_GET['id'];
	
	//This code checks if user is logged in or logout
	if(isset($_SESSION['username'])){
		
		//echo 'You are logged in ' .$_SESSION['username']. ', Yay!';
		$username = $_SESSION['username'];
	}
	else{
		$username = "Anonymous";
	}
?>

<br> <br>

<!--date()- Displays the date, Y-m-d(Year,Month, Date) H:i:s(Hour, Minute, Second) -->
<?php //<input type='hidden' name='uid' value='Anonymous'>
//Inorder to see the form inside the PHP code, use echo"";
echo "<form method='post' action='".setComments($db)."'>
		<input type='hidden' name='schoolID' value='".$id."'>
		<input type='hidden' name='username' value='".$username."'>
		<textarea name='message'></textarea><br>
		<button type='submit' class='button' name='commentSubmit'> Comment </button>
	  </form> <br>";

//The function below is used to get comments from the database
getComments($db, $id);
?>
</body>
</html>