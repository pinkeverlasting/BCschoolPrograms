
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

    <img src="images/schoolbanner.png" id="header-img" alt="school"/>
<h2> School List </h2>




     <h3 id="filter">Filter</h3>

     <div id="filter-section">
     <?php
     $arr_dis = array();
     echo "<span id=\"filter-title\">District:</span>";
     echo "<select id=\"drop-list\" name=\"order\">";
     echo "<option value=\"\">- Select District -</option>";
     while($num = $dis->fetch_assoc()){

       $arr_dis[$num["districtID"]] = $num["name"];

       echo "<option value=\"".$num['districtID']."\">".$num['name']."</option>";

     }

     echo "</select>";
     //while the fetching the result
      ?>

      <span id="filter-title">Type of School:</span>
      <select id="school">
          <option value="">- Select Type of School -</option>
          <option value="Elementary">Elementary School</option>
          <option value="Secondary">Secondary School</option>
      </select>


      <?php
                echo "<br>";
                echo "<span id=\"filter-title\">Programs Included:</span>";
                echo "<br>";
                echo "<div id=\"checkbox-area\">";
                while($gram = $pro->fetch_assoc()){

                  echo "<input type=\"checkbox\" id=\"checkbox\" value=\"".$gram["program_type"]."\"><span id=\"check-text\">".$gram["program_type"]."</span>";


                }
                echo "<br>";
                echo "<span id=\"filter-title\">Program Year:</span>";
                echo "<br>";
                echo "<input type=\"checkbox\" id=\"year\" value=\"2012/2013\"><span id=\"check-text\">2012/2013</span>";
                echo "<input type=\"checkbox\" id=\"year\" value=\"2013/2014\"><span id=\"check-text\">2013/2014</span>";
                echo"</div>";

                ?>

                <input type="button" id="button" value="filter" />

                <div id="show">
                  <?php

                  
                    while($num = $dis->fetch_assoc()){

                      $arr_dis[$num["districtID"]] = $num["name"];
                    }

                    $district = [];
                    $schoolInfo = [];
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

                        echo $row["name"];
                        echo "<br>";
                      }

                    }
                    $stmt->free_result();
                  }



                  db_disconnect($db);
                  ?>
                </div>



      <script src="//code.jquery.com/jquery-3.1.0.min.js"></script>
      <script src="js/filter_function.js"></script>



<!-- <script src="js/filter_function.js"></script> -->
  <?php
    require('footer.php');
  ?>
</body>
</html>
