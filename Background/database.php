<?php

//database infomation
define("DB_SERVER", "localhost");
define("DB_USER", "root");
define("DB_PASS", "");
define("DB_NAME", "BCschoolprograms");


//connect to db
function db_connect() {
    $connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
    confirm_db_connect();
    return $connection;
  }

//disconnect from db
  function db_disconnect($connection) {
    if(isset($connection)) {
      mysqli_close($connection);
    }
  }

  //Escapes special characters in a string for use in a SQL statement
  // consider the current charset of the connection

  function db_escape($connection, $string) {
    return mysqli_real_escape_string($connection, $string);
  }

//check db connection and errors
  function confirm_db_connect() {
    if(mysqli_connect_errno()) {
      $msg = "Database connection failed: ";
      $msg .= mysqli_connect_error();
      $msg .= " (" . mysqli_connect_errno() . ")";
      exit($msg);
    }
  }

  function confirm_result_set($result_set) {
    if (!$result_set) {
    	exit("Database query failed.");
    }
  }


?>