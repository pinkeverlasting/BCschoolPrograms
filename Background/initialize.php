<?php
  ob_start(); // output buffering is turned on

  //session_start(); // turn on sessions
  ////session_unset(); 
  //session_destroy();
 // session_start();

  // Assign the root URL to a PHP constant
  // * Do not need to include the domain
  // * Use same document root as webserver
  // * Can set a hardcoded value:
  // define("WWW_ROOT", '');
  // * Can dynamically find everything in URL up to "/main"
  $public_end = strpos($_SERVER['SCRIPT_NAME'], '/main') + 7;
  $doc_root = substr($_SERVER['SCRIPT_NAME'], 0, $public_end);
  //define("WWW_ROOT", $doc_root);

  //require_once('functions.php'); 
  require_once('database.php');  // include database functions & connections
  require_once('basic_functions.php'); // list of simple helpful functions
  require_once('query_functions.php'); // list of query functions
  require_once('form_functions.php'); // list of validations functions

  $db = db_connect();
  $errors = [];

?>
