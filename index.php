<?php require_once('Background/initialize.php');

// there can be multiple errors so errors is an array
$errors = [];
$email = '';
$password = '';



?>

<!-- HTML START  -->
<link rel="stylesheet" href="style.css">
<!-- Set page title -->
<?php $page_title = 'Youth Programs in BC '; ?>

<!-- include the header -->
<?php include('header.php'); ?>

<div id="content">
  <img src="images/header.jpg" id="header-img" alt="BC classrooms"/>

  <h2>Discover New Programs</h2>
  <h2>Search By</h2>

<!-- display any errors -->
  <!--<?php //echo display_errors($errors); ?>-->
<section id="selection" class="section">
    <div class="search-option">

<a href="listofprograms.php">
      <div class="option-card">
        <img src="images/programs.png" alt="Programs Photo" id="index-img">
        <div class="card-info">
          <h3 class="card-name">List of Youth Program</h3>
          <h4 class="card-title">Discover youth programs provided in BC.</h4>
        </div>
      </div></a>

<a href="listofschools.php">
      <div class="option-card">
        <img src="images/districts.png" alt="District Photo" id="index-img">
        <div class="card-info">
          <h3 class="card-name">By School District</h3>
          <h4 class="card-title">Find programs by School District</h4>
        </div>
      </div></a>
      </div>
      </section>


</div>
