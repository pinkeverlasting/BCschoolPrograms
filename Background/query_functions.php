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

  function get_cities() {
    global $db;

    //select name and code from the table
    $sql = "SELECT DISTINCT city FROM schools ORDER BY city";
    //echo $sql;
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;

    database_error();
    //test

  }

  function get_list_of_schools_by_district($district,$id) {
    global $db;

    //select name and code from the table
    $sql = "SELECT DISTINCT schools.schoolID, schools.name FROM schools INNER JOIN programs_in_schools ON schools.schoolID = programs_in_schools.schoolID WHERE schools.districtID = $district AND programs_in_schools.program_type = '$id'";
    //echo $sql;
    $result = mysqli_query($db, $sql) or die('SQL Error: ' . mysqli_error($db));
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

    function get_program_details($id) {
    global $db;

    //select name and code from the table
    $sql = "SELECT program_type, program_description, image_name FROM programs_type WHERE program_type = '$id'";

    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
    database_error();

  }

  function get_list_of_districts(){
    global $db;
    $sql = "SELECT districtID, name, city FROM districts ORDER BY districtID";
    //send query to database and get the result
    $result = mysqli_query($db,$sql);
    confirm_result_set($result);
    return $result;
    database_error();

  }

   function get_list_of_districts_order_city(){
    global $db;
    $sql = "SELECT districtID, name, city FROM districts ORDER BY city";
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


  function get_list_of_programs_by_school($id){
    global $db;
   
    //prevent duplicates
    $sql = "SELECT DISTINCT program_type FROM programs_in_schools WHERE schoolID = '$id'";
    //send query to database and get the result
    $result = mysqli_query($db,$sql);
    confirm_result_set($result);
    return $result;
    database_error();

  }

  function get_profile($username) {
    global $db;
   
    //prevent duplicates
    $sql = "SELECT first_name, last_name, email, city, districtID FROM profile WHERE username = '$username'";
    //send query to database and get the result
    $result = mysqli_query($db,$sql);
    confirm_result_set($result);
    return $result;
    database_error();
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

  function get_school_details($id) {
  	global $db;

    //select name and code from the table
    $sql = "SELECT * FROM schools WHERE schoolID = $id";

    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;

  }

    function get_city_with_ID($id) {
    global $db;

    //select name and code from the table
    $sql = "SELECT city FROM districts WHERE districtID = '$id'";

    $result = mysqli_query($db, $sql) or die('SQL Error: ' . mysqli_error($db));
    confirm_result_set($result);
    return $result;

  }




  ?>
