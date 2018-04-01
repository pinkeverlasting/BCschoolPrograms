<?php

//show header of the page
require('header.php');

//unset user's email session to empty
unset($_SESSION['username']);

//redirect to log in page
header("Location: login.php");



 ?>
