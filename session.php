<?php
session_start();
if($_GET['city'] !== '' ) {
    // save values from header to session
    $_SESSION['city'] = $_GET['city'];
    echo $_SESSION['city'];

}else{
  unset($_SESSION['city']);
}
?>
