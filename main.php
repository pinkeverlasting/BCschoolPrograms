<?php
	//Sets the timezone, Vancouver since we are in Vancouver
	date_default_timezone_set('America/Vancouver');
	
	//Include database connection etc
	require('Background/initialize.php');
	
	//Include functions page file
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

<?php

	//get the school id from the URLs
	$id = $_GET['id'];
	
	//This code checks if user is logged in or not
	if(isset($_SESSION['username'])){
		
		//echo 'You are logged in ' .$_SESSION['username']. ', Yay!';
		$username = $_SESSION['username'];  //set username to user's name
	}
	else{
		$username = "Anonymous"; //else they are anonymous
	}
?>

<br> <br>

<?php 

	// Comments form section
		echo "<form method='post' action='".setComments($db)."'>";  //call set Comments funtion when submit
		echo "<input type='hidden' name='schoolID' value='".$id."'>"; //save vars school id / username for forms
		echo "<input type='hidden' name='username' value='".$username."'>"; // as hidden vars from user
		echo "<textarea name='message'></textarea><br>"; //area for messages
		echo "<button type='submit' class='button' name='commentSubmit'> Comment </button>"; //submit button
		echo "</form> <br>";

	//get comments from the database, and display the comments
		getComments($db, $id);
	
?>
</body>
</html>