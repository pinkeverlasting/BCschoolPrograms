  <?php

  function database_error(){

    if (!$result) {
      die ('SQL Error: ' . mysqli_error($connection));
    }
  }

  function get_list_of_schools() {
    global $db;

    //select name and code from the table
    $sql = "SELECT schoolID, name, districtID, city FROM schools";
    //echo $sql;
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;

    database_error();
    //test

  }

  function get_list_of_programs(){
    global $db;
    $sql = "SELECT program_type, program_description, image_name FROM programs_type ORDER BY program_type";
    //send query to database and get the result
    $result = mysqli_query($db,$sql);
    confirm_result_set($result);
    return $result;
    database_error();

  }

  function get_list_of_districts(){
    global $db;
    $sql = "SELECT districtID, name FROM districts ORDER BY districtID";
    //send query to database and get the result
    $result = mysqli_query($db,$sql);
    confirm_result_set($result);
    return $result;
    database_error();

  }


  function get_list_of_cities() {
    global $db;

    //select name and code from the table
    $sql = "SELECT DISTINCT city FROM districts ORDER BY city";
    //echo $sql;
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
  }

    function get_district_id($cityInput) {
    global $db;

    //select name and code from the table
    $sql = "SELECT districtID FROM districts WHERE city = '$cityInput'";
    //echo $sql;
    $result = mysqli_query($db, $sql);

    /*
	Debug purposes
    if ($result) {
		  echo "successfully.";

		} else {
   		 echo "ERROR: Could not able to execute query. " . mysqli_error($db);

		}
	*/
	$number = mysqli_fetch_row($result);
	$number = $number[0];
	//confirm_result_set($result);
    return $number;
  }

  function username_exists($name) {
  	global $db;

    //select name and code from the table
    $sql = "SELECT username FROM members WHERE username = $name LIMIT 1";

    $result = mysqli_query($db, $sql);
    // For INSERT statements, $result is true/false
    if($result) {
      return true;  //username exists
    } else {
      return false; //username doesn't exist
    }

  }




  ?>
