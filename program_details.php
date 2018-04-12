<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <title></title>
  <script
  src="http://code.jquery.com/jquery-1.12.4.js"
  integrity="sha256-Qw82+bXyGq6MydymqBxNPYTaUXXq7c8v3CwiYwLLNXU="
  crossorigin="anonymous">    
</script>
<script type="text/javascript" src="js/global.js"></script>
</head>
<body>

  <?php
    //initialize headers, sessions and databases
  require('Background/initialize.php');
  require('header.php');
  db_connect();

   //get the program name from the URLs
    	$id = $_GET['id']; //program name
      $type = '';

     //call function to get image name in array
      $get_photo = get_names_of_programs($id); 

  ?>

  <!-- submit form to itself along with the program name -->
  <form action='program_details.php?id=<?php echo $id;?>' method="POST">

    <?php

        //get program details (descriptions etc) using program name
    $result = get_program_details($id);

        //error
      if (!$result) {  //this array stores program details
       die ('SQL Error: ' . mysqli_error($db));
     } else {

       while($row = mysqli_fetch_array($result)) {
        //save the data into variables for later
         $name = $row['program_type'];
         $description = $row['program_description'];
       }
     }

      //if user is logged in
      if(isset($_SESSION['username'])){
           
           $username = trim($_SESSION['username']);

           // get array of profile details (emails, id etc) using username
           $res = get_profile($username);

             // if error           
             if (!$res) {
               
               die ('SQL Error: ' . mysqli_error($db));  // display error
             
             // if the dropbox value selection is blank or if user hasn't click on it
             } else if (!isset($_POST['districtSelect']) || $_POST['districtSelect'] == "") {

                //loop over profile and get user's city and district perferences
                while($rows = mysqli_fetch_array($res)) {
                  $city = $rows['city'];
                  $district = $rows['districtID'];
                }

             //this means user has picked a new district or city in dropdown
             } else {

                $district = $_POST['districtSelect']; //set selected district as perferance 
                $getCity = get_city_with_ID($district); //get the city the district is located in
                
                //retrive city data and set as preference
                while($rowC = mysqli_fetch_array($getCity)) {
                  $city = $rowC['city'];;
                }
            }

        //get array with all the new perference data
        //get a list of schools that's in district and offer program id
        $r = get_list_of_schools_by_district($district, $id) or die ('SQL Error: ' . mysqli_error($connection));

      //if not logged
      } else if (!isset($_SESSION['username'])) {

        //guest has selected a district option and the option isn't blank
        if (isset($_POST['districtSelect']) && !$_POST['districtSelect'] == "") {

          //set selection as perferance
          $district = $_POST['districtSelect'];
          $getCity = get_city_with_ID($district);

          while($rowC = mysqli_fetch_array($getCity)) {
            $city = $rowC['city'];;
          }

          //get array with all the new perference data
          //get a list of schools that's in district and offer program id
          $r = get_list_of_schools_by_district($district, $id) or die ('SQL Error: ' . mysqli_error($connection));
    }
  }


// function for loading the dropdown with options
// recieves the array with all the filtered data, the perfered district and city 
  function load_district($district, $city, $r) {
    //title 
    echo "<h2>District #".$district." in ".$city."</h2>";

    //print school name along with URL with their ids on url
    while($rowD = mysqli_fetch_array($r)) {
      echo '<a href="school_details.php?id=' .$rowD['schoolID']. '">'.$rowD['name'].'</a>';
      echo "<br>";
    }

  }

 ?>


 <div id="content">

  <?php 
  //get the photo name file and display it
  while ($row = $get_photo->fetch_assoc()){ ?>
    <img src="images/<?php echo $row["image_name"];?>" width="500px"/>
  <?php  }

  //program details / descriptions
  ?>
  <h1> <?php echo $name?></h1>
  <h4> <?php echo 'Description: '?></h4>
  <p> <?php echo $description ?></p>

  <?php

  //array for dropdown, get a list of districts that ordered by their cities alphabetically 
  $dropdown = get_list_of_districts_order_city();

  //if user is not logged in 
  if (!isset($_SESSION['username'])){

    //tell user to select a district
    echo "<h2> Select a District to see Program's Offerings: </h2>";
  
  }
  ?>

  <!-- dropdown box for district selection (submit via to this page) -->
  <select name="districtSelect" onchange="this.form.submit();">
    <option value=""> -- select city -- </option> <!-- blank option value -->
    
    <?php
    //loop through the dropdown array and populate it with the data
    while ($ro = $dropdown->fetch_assoc()) {
      
      //if the previously selected district, matches, 
      //default value is the previously selected district    
      if ($district == $ro["districtID"]) {
        //select this value 
        echo '<option value="' .$ro["districtID"]. '" selected>' .$ro["name"].' (District ' .$ro["districtID"].') </option>';
      } else {
        //else keep poplating it
       echo '<option value="' .$ro["districtID"]. '">' .$ro["name"].' (District ' .$ro["districtID"].') </option>';
     }
     echo '<br>';
   }
   ?>

 </select>
</br>

<?php
    
    //if user is logged in
    if(isset($_SESSION['username'])){
      
      //school name in distrct
      echo "<h1> Availability in Your Area </h1>";
      echo load_district($district,$city,$r);  //print schools in the district

    } else if (isset($_POST['districtSelect']) && !$_POST['districtSelect'] == "") {
      //else if guest (not logged) had selected a district and it's not a blank option
      echo load_district($district,$city,$r); //print schools in the district
    } else {
      //else there no offerings
      echo '<h4> No Offerings Found </h4>';
    }

?>

<a href="listofprograms.php" class="button">Back to Programs</a>
<a href="addtowatchlist.php?type=<?php echo $name;?>" class="button"> Add to Watch List</a>


</div>

  <?php
    require('footer.php');
  ?>
