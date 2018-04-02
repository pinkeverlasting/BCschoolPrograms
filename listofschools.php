
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


    $dis = get_list_of_districts();

    //error
    // if (!$res) {
    //   die ('SQL Error: ' . mysqli_error($connection));
    // }

    ?>
<h2> School List </h2>


    <?php
    $arr_dis = array();
    while($num = $dis->fetch_assoc()){

      $arr_dis[$num["districtID"]] = $num["name"];
    }

    //while the fetching the result
     ?>

         <!-- show product name  -->
         <?php


          foreach($arr_dis as $key => $value){

            echo "<h2>District #".$key.": ".$value."</h2>";

            $res = get_list_of_schools();

            while($row = $res->fetch_assoc()){

              if($key == $row["districtID"]){

                echo $row["name"];
                echo "<br>";
              }
            }


          }



?>


         <!-- put product code into url and in order to help get the specified product information in other page -->
       <!-- <a href="schoolsdetail.php?id=<?php //echo $row["schoolID"]; ?>">View</a> -->


   <?php //}

   db_disconnect($db);
     ?>


</body>
</html>
