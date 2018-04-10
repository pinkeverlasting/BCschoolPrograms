
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

    $dis = get_list_of_districts();
    $pro = get_list_of_programs();
/*SELECT DISTINCT programs_in_schools.schoolID, programs_in_schools.program_type, schools.districtID FROM programs_in_schools INNER JOIN schools ON programs_in_schools.schoolID = schools.schoolID WHERE programs_in_schools.program_type = 'ELL' AND schools.districtID = 5*/



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

            echo "<input type=\"checkbox\" id=\"checkbox\" value=\"".$gram["program_type"]."\">".$gram["program_type"];


          }


          if(!isset($_SESSION['username'])){

            foreach($arr_dis as $key => $value){

              echo "<h2>District #".$key.": ".$value."</h2>";



              $res = get_list_of_schools();

              while($row = $res->fetch_assoc()){

                if($key == $row["districtID"]){

                  echo '<a href="school_details.php?id=' . $row["schoolID"] . '">'.$row["name"].'</a>';
                  //echo $row["name"];
                  echo "<br>";

                  $schoolInfo[] = $row;
                }

            }
          }

      }else{

          $username = trim($_SESSION['username']);

          $sql = "SELECT city
              FROM profile
              WHERE username = ?";

        $stmt = $db->prepare($sql);
        $stmt->bind_param('s',$username);
        $stmt->execute();
        //get the result from database
        $stmt->bind_result($city);

        $city_pref = '';

        while($stmt->fetch()){

        $city_pref = $city;
        }

        echo "<h2>".$city_pref." Schools</h2>";
        echo "<br>";

          $res = get_list_of_schools();

          while($row = $res->fetch_assoc()){

            if($row["city"] == $city_pref){

              echo '<a href="school_details.php?id=' . $row["schoolID"] . '">'.$row["name"].'</a>';
              echo "<br>";
            }
          }

          $stmt->free_result();


        }


          ?>



<script src="//code.jquery.com/jquery-3.1.0.min.js"></script>
<!-- <script src="js/filter_function.js"></script> -->
</body>
</html>
