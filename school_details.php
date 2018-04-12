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

<h1> <?php echo $name?></h1>
<div id="content">

<p> <?php echo 'Address: ' .$address ?></p>
<p> <?php echo 'City: ' .$city ?></p>
<p> <?php echo 'Postal: ' .$postal ?></p>
<p> <?php echo 'Phone: ' .$phone ?></p>
<p> <?php echo 'Email: ' .$email ?></p>
<br/><br/>
<p> <?php echo 'Principal: ' .$principal ?></p>
<p> <?php echo 'Grades Offered: ' .$grade ?></p>
<p> <?php echo 'School Id: ' .$schoolID ?></p>
<p> <?php echo 'District Number: ' .$districtID ?></p>

<h3 id="school-title"> Programs Offered: </h3>

<?php
  echo "<div id=\"school-list\">";
  echo "<ul>";
    while ($rows = $res->fetch_assoc()) {
          //echo $rows['program_type'];
        echo "<li>";
         echo '<a href="program_details.php?id=' .$rows["program_type"]. '">' .$rows["program_type"]. '</a>';
         echo '<br>';
         echo "</li>";
		}
  echo "</ul>";
  echo "</div>";
    ?>

<a href="listofschools.php" class="button">Back to Model List</a>
<a href="addtowatchlist.php?id=<?php echo $schoolID;?>" class="button" > Add to Watch List</a>

<?php
db_disconnect($db) ?>

</div>

 <div id="display" class="myCustom1">
       <?php require('main.php'); ?>
 </div>

  <?php
    require('footer.php');
  ?>
