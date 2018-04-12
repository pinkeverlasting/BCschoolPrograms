<?php

	//This function inserts data into the database
	
	function setComments($db){
		
		//check if submit and if there's a message
		if(is_post() && $_POST['message'] != ""){
		
		//set the input vars
		$user['username'] = $_POST['username'] ?? '';
		$user['schoolID'] = $_POST['schoolID'] ?? ''; //so we know comment is for what school
		//date()- Displays the date, Y-m-d(Year,Month, Date) H:i:s(Hour, Minute, Second)
		$user['date'] = date('Y-m-d H:i:s') ?? '';
        $user['message'] = $_POST['message'] ?? '';


        //query for insert comments into database
        $sql = "INSERT INTO comments ";
	    $sql .= "(schoolID, username, date, message) ";
	    $sql .= "VALUES ";
	    $sql .= " ('". db_escape($db, $user['schoolID']) . "', ";
	    $sql .= "'". db_escape($db, $user['username']) .  "', ";
	    $sql .= "'". db_escape($db, $user['date']) .  "', ";
	    $sql .= "'". db_escape($db, $user['message']) .  "')";
    	$result = mysqli_query($db, $sql) or die('SQL Error: ' . mysqli_error($db)); //show error
		
			//if result is successful
	    	if($result) {
	          $new_id = mysqli_insert_id($db); //insert it into the db

			} else {
				echo "failed";
			}
		} else {
			
			//set user array for future submit use
			$user = [];
		
		}

	}
	
	
	//retrieves data from the database
	function getComments($db, $school){
		
		
		//select all comments that belong for this school
		$sql="SELECT * FROM comments WHERE schoolID = '$school'";
		
		// Creates a connection($conn), queries everthing selected from comments table
		$result= $db->query($sql) or die('SQL Error: ' . mysqli_error($db)); //error
		

		//while loop helps in echoing all results from the database at once
		while($row= $result->fetch_assoc()){
			
			//style div class comment box 
			echo "<div class='comment-box'> <p>";
				
				//print person who wrote this comment
				echo 'User: <h1>' .$row['username']. '</h1><br>';
				
				//print date message was written
				echo '<p>Date: </p><h4> '.$row['date']. "</h4><br>";
				
				// print the message / comment
				echo '<p>' .$row['message']. '</p><br>';
				
				//deletes user post form
				//has hidden values to send to deleteComments function
				//sends out school ID and message ID
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
	// has school id to know what to delete
	function deleteComments($db,$school){

		//if submit is clicked and the form delete exist then delete
		if(is_post() && isset($_POST['delete'])){
			//message id to know what message to delete
			$id= $_POST['id']; 

			//query for deleting a comment
			$sql = "DELETE FROM comments ";
		    $sql .= "WHERE id='" . db_escape($db, $id) . "' "; //delete using unique message id
		    $result = mysqli_query($db, $sql) or die('SQL Error: ' . mysqli_error($db)); //error
			
			//Redirects to the school's detail page
			header('Location: school_details.php?id='.$school);
		}
	}
	
