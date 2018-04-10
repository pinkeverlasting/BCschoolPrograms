<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <script
  src="http://code.jquery.com/jquery-1.12.4.js"
  integrity="sha256-Qw82+bXyGq6MydymqBxNPYTaUXXq7c8v3CwiYwLLNXU="
  crossorigin="anonymous"></script>
  <script type="text/javascript" src="js/global.js"></script>
    </head>
  <body>

    <?php
    require('Background/initialize.php');
    require('header.php');
    db_connect();

    //get the id from the URLs
	 $id = $_GET['id'];
   $type = '';

  ?>

    <form action='program_details.php?id=<?php echo $id;?>' method="POST">

  <?php

	//get the data using the ID
	$result = get_program_details($id);


  if(isset($_SESSION['username'])){
           $username = trim($_SESSION['username']);
      	   $res = get_profile($username);

           if (!$res) {
           die ('SQL Error: ' . mysqli_error($connection));
           } else if (!isset($_POST['districtSelect']) || $_POST['districtSelect'] == "") {

            //let's just store all the data into vars
            while($rows = mysqli_fetch_array($res)) {
              $city = $rows['city'];
              $district = $rows['districtID'];
            }
          } else {
            $district = $_POST['districtSelect'];
            $getCity = get_city_with_ID($district);
            while($rowC = mysqli_fetch_array($getCity)) {
                $city = $rowC['city'];;
              }
          }

              $r = get_list_of_schools_by_district($district, $id) or die ('SQL Error: ' . mysqli_error($connection));

    } else if (!isset($_SESSION['username'])) {

    if (isset($_POST['districtSelect']) && !$_POST['districtSelect'] == "") {

            $district = $_POST['districtSelect'];
            $getCity = get_city_with_ID($district);

            while($rowC = mysqli_fetch_array($getCity)) {
                $city = $rowC['city'];;
              }

            $r = get_list_of_schools_by_district($district, $id) or die ('SQL Error: ' . mysqli_error($connection));
        }
    }


    function load_district($district, $city, $r) {
        echo "<h2>District #".$district." in ".$city."</h2>";

        while($rowD = mysqli_fetch_array($r)) {
          echo '<a href="school_details.php?id=' .$rowD['name']. '">'.$rowD['name'].'</a>';
          echo "<br>";
        }

    }

    	//error
    	if (!$result) {
         die ('SQL Error: ' . mysqli_error($connection));
         } else {

        	//let's just store all the data into vars
        	while($row = mysqli_fetch_array($result)) {
        	$name = $row['program_type'];
    			$description = $row['program_description'];
        	}
        }

    ?>


<div id="content">
<h1> <?php echo $name?></h1>
<h4> <?php echo 'Description: '?></h4>
<p> <?php echo $description ?></p>

<?php
    $dropdown = get_list_of_districts_order_city();

     if (!isset($_SESSION['username'])){
    echo "<h2> Select a District to see Program's Offerings: </h2>";
  }
?>

<select name="districtSelect" onchange="this.form.submit();">
<option value=""> -- select city -- </option>

<?php
 while ($ro = $dropdown->fetch_assoc()) {
          //echo $rows['program_type'];
        if ($district == $ro["districtID"]) {
          echo '<option value="' .$ro["districtID"]. '" selected>' .$ro["name"].' (District ' .$ro["districtID"].') </option>';
        } else {
         echo '<option value="' .$ro["districtID"]. '">' .$ro["name"].' (District ' .$ro["districtID"].') </option>';
        }
         echo '<br>';
    }
 ?>

</select>


</br>

<?php
    if(isset($_SESSION['username'])){
        //school name in distrct
        echo "<h1> Availability in Your Area </h1>";
        echo load_district($district,$city,$r);

    } else if (isset($_POST['districtSelect']) && !$_POST['districtSelect'] == "") {
      echo load_district($district,$city,$r);
    }

?>

<a href="listofprograms.php">Back to Model List</a>
<a href="addtowatchlist.php?type=<?php echo $name;?>"> Add to Watch List</a>


</div>
