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
  <h1>Discover New Programs</h1>

<!-- display any errors -->
  <!--<?php //echo display_errors($errors); ?>-->
<section id="selection" class="section">
  <h2 class="headline">Search by:</h2>
    <div class="search-option">
      
<a href="http://somelink.com">
      <div class="option-card">
        <img src="images/Programs.jpg" alt="Programs Photo">
        <div class="card-info">
          <h3 class="card-name">List of Youth Program</h3>
          <h4 class="card-title">Discover all the types of youth programs provided in BC.</h4>
        </div>
      </div></a>

<a href="http://food.com">
      <div class="option-card">
        <img src="images/district.jpg" alt="district Photo">
        <div class="card-info">
          <h3 class="card-name">By School District</h3>
          <h4 class="card-title">Find programs by School District</h4>
        </div>
      </div></a>
      </div>
      </section>

 
</div>
