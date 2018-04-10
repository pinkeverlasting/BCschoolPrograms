<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    </head>
  <body>

    <?php
    require('Background/initialize.php');

    require('header.php');
    db_connect();

    //get the id from the URLs
	$id = $_GET['id'];

	//get the data using the ID
	$result = get_school_details($id);
	$res = get_list_of_programs_by_school($id);

	//error
	if (!$result) {
      die ('SQL Error: ' . mysqli_error($connection));
    }

    	//let's just store all the data into vars
    	while($row = mysqli_fetch_array($result)) {
    	$districtID = $row['districtID'];
			$schoolID = $row['schoolID'];
			$name = $row['name'];
			$address = $row['address'];
			$city = $row['city'];
			$postal = $row['postal_code'];
			$principal = $row['principal_name'];
			$grade = $row['grade_range'];
			$phone = $row['phone'];
			$email = $row['email'];
    	}

    ?>


<div id="content">    
<h1> <?php echo $name?></h1>
<h4> <?php echo 'Address: ' .$address ?></h4>
<h4> <?php echo 'City: ' .$city ?></h4>
<h4> <?php echo 'Postal: ' .$postal ?></h4>
<h4> <?php echo 'Phone: ' .$phone ?></h4>
<h4> <?php echo 'Email: ' .$email ?></h4>
<br/><br/>
<h3> <?php echo 'Principal: ' .$principal ?></h3>
<h3> <?php echo 'Grades Offered: ' .$grade ?></h3>
<h3> <?php echo 'School Id: ' .$schoolID ?></h3>
<h3> <?php echo 'District Number: ' .$districtID ?></h3>

<h1> Programs Offered: </h1>

<?php
    while ($rows = $res->fetch_assoc()) {
          //echo $rows['program_type'];
         echo '<a href="program_details.php?id=' .$rows["program_type"]. '">' .$rows["program_type"]. '</a>';
         echo '<br>';
		} ?>

</div>