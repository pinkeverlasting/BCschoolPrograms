<?php
  ob_start(); // output buffering is turned on

  session_start(); // turn on sessions

  // Assign the root URL to a PHP constant
  // * Do not need to include the domain
  // * Use same document root as webserver
  // * Can set a hardcoded value:
  // define("WWW_ROOT", '');
  // * Can dynamically find everything in URL up to "/main"
  $public_end = strpos($_SERVER['SCRIPT_NAME'], '/main') + 7;
  $doc_root = substr($_SERVER['SCRIPT_NAME'], 0, $public_end);
  define("WWW_ROOT", $doc_root);

  //require_once('functions.php'); 
  require_once('database.php');  // include database functions & connections

  $db = db_connect();
  $errors = [];

?>
