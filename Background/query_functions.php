  <?php

  function database_error(){

    if (!$result) {
      die ('SQL Error: ' . mysqli_error($connection));
    }
  }

  function get_list_of_schools() {
    global $db;

    //select name and code from the table
    $sql = "SELECT schoolID, name, districtID FROM schools";
    //echo $sql;
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;

    database_error();

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

  ?>
