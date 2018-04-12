
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>

    <?php

    require('header.php');

    db_connect();
    $res = get_list_of_programs();
    ?>
<h2> Program List </h2>


    <?php
    //query string to get product's name and code
    //$query_str = "SELECT program_type, program_description, image_name FROM programs_type ORDER BY program_type";
    //send query to database and get the result
    //$res = $db->query($query_str);

    //while the fetching the result
    while ($row = $res->fetch_assoc()){ ?>

         <!-- show product name  -->
         <div id="program-card">
         <img src="images/<?php echo $row["image_name"];?>" width="500px"/>
         <h3><a href="program_details.php?id=<?php echo $row["program_type"]; ?>"><?php echo $row["program_type"]; ?></a></h3>
         <!-- put product code into url and in order to help get the specified product information in other page -->
         <br>

         <p><?php echo $row["program_description"];?></p>
       </div>

   <?php };
   db_disconnect($db);
     ?>


  <?php
    require('footer.php');
  ?>
