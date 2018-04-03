
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


    $dis = get_list_of_districts();
    $pro = get_list_of_programs();



    ?>
<h2> School List </h2>




     <h3>Filter</h3>
     <?php
     $arr_dis = array();
     echo "District:";
     echo "<select name=\"order\">";
     while($num = $dis->fetch_assoc()){

       $arr_dis[$num["districtID"]] = $num["name"];

       echo "<option value=\"".$num['districtID']."\">".$num['name']."</option>";

     }

     echo "</select>";
     //while the fetching the result
      ?>

      Type of School:
      <select>
          <option value="Elementary">Elementary School</option>
          <option value="Secondary">Secondary School</option>
      </select>


      <?php
        echo "<br>";
        echo "Programs Included:";
        while($gram = $pro->fetch_assoc()){

          echo "<input type=\"checkbox\" name=\"".$gram["program_type"]."\">".$gram["program_type"];


        }

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
