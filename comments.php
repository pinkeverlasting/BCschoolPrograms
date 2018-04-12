<?php

	//This function inserts data into the database
	function setComments($db){
		//Returns true if commentSubmit button is clicked
		if(is_post() && isset($_POST['message'])){
		
		$user['username'] = $_POST['username'] ?? '';
		$user['schoolID'] = $_POST['schoolID'] ?? '';
		$user['date'] = date('Y-m-d H:i:s') ?? '';
        $user['message'] = $_POST['message'] ?? '';


        //$sql= "INSERT INTO comments (uid, date, message) VALUES('wichan','$date','$message')";
        $sql = "INSERT INTO comments ";
	    $sql .= "(schoolID, username, date, message) ";
	    $sql .= "VALUES ";
	    $sql .= " ('". db_escape($db, $user['schoolID']) . "', ";
	    $sql .= "'". db_escape($db, $user['username']) .  "', ";
	    $sql .= "'". db_escape($db, $user['date']) .  "', ";
	    $sql .= "'". db_escape($db, $user['message']) .  "')";
    	$result = mysqli_query($db, $sql) or die('SQL Error: ' . mysqli_error($db));
		
    	if($result) {
          $new_id = mysqli_insert_id($db); //insert it into the db

		} else {
			echo "failed";
		}

			$user = [];
			$user["schoolID"] = '';
			$user["username"] = '';
	        $user["date"] = '';
	        $user["message"] = '';
		
		}
	}
	
	//This function retrieves data from the database
	function getComments($db, $school){
		
			
		$sql="SELECT * FROM comments WHERE schoolID = '$school'";
		
		// Creates a connection($conn) and then queries everthing selected from comments table
		$result= $db->query($sql) or die('SQL Error: ' . mysqli_error($db));
		
		//$result->fetch_assoc()- Fetches result row from the database as an array
		//while loop means that everytime we have a result row from the database, it loops until there is no more left
		//while loop helps in echoing all results from the database at once
		while($row= $result->fetch_assoc()){
			//div class comment box is used to style the comment box
			echo "<div class='comment-box'> <p>";
				
				//$row['uid']- Echoes name of the user from the database
				echo 'User: <h1>' .$row['username']. '</h1><br>';
				
				//$row['date']- Echoes date from the database
				echo '<p>Date: </p><h4> '.$row['date']. "</h4><br>";
				
				//$row['message']- Echoes message from the database
				//nl2br()- Is a function that converts nl to break statements
				echo '<p>' .$row['message']. '</p><br>';
				
				//The 1st form below deletes user post
				//The 2nd form below takes information to the next page and updates the database
			echo "</p> 
				<form class= 'delete-form' method = 'POST' action = '".deleteComments($db,$school)."'>
					<input type='hidden' name='id' value='".$row['id']."'>
					<input type='hidden' name='delete' value='delete'>
					<button name='commentDelete' class='button'> Delete </button>
				</form>
			
			</div>";
		}
	}

	
	//Function for deleting comments
	function deleteComments($db,$school){
		if(is_post() && isset($_POST['delete'])){
			$id= $_POST['id'];

			$sql = "DELETE FROM comments ";
		    $sql .= "WHERE id='" . db_escape($db, $id) . "' ";
		    $result = mysqli_query($db, $sql) or die('SQL Error: ' . mysqli_error($db));
			
			//Redirects to the front page
			header('Location: school_details.php?id='.$school);
		}
	}
	

	
	//logout function
	function userLogout(){
		if(isset($_POST['logoutSubmit'])){
			//Starts the session
			session_start();
			//Destroys the session
			session_destroy;
			header("Location:main.php");
			exit();
		}
	}

