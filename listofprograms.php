
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
    $res = get_list_of_programs();  //get array data for list of programs names, descriptions and images
    ?>
<h2> Program List </h2>


    <?php

    //loop the array 
    while ($row = $res->fetch_assoc()){ ?>

         <!-- use html to stylize  -->
         <div id="program-card">
         <!-- display image  -->
         <img src="images/<?php echo $row["image_name"];?>" width="500px"/> 
         <!-- link users to the programs details page and add program's name to url end  --> 
         <h3><a href="program_details.php?id=<?php echo $row["program_type"]; ?>"><?php echo $row["program_type"]; ?></a></h3>
         <br>
        <!-- display the description for the program  -->
         <p><?php echo $row["program_description"];?></p>
       </div>

   <?php };
      db_disconnect($db);
   ?>


  <?php
    require('footer.php');
  ?>
