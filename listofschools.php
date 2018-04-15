
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


    ?>

    <img src="images/schoolbanner.png" id="header-img" alt="school"/>
<h2> School List </h2>




     <h3 id="filter">Filter</h3>

     <div id="filter-section">
     <?php
     //filter section
     //define an array for district
     $arr_dis = array();
     echo "<span id=\"filter-title\">District:</span>";
     echo "<select id=\"drop-list\" name=\"order\">";
     echo "<option value=\"\">- Select District -</option>";
     //show all the district in droplist
     while($num = $dis->fetch_assoc()){

       $arr_dis[$num["districtID"]] = $num["name"];

       echo "<option value=\"".$num['districtID']."\">".$num['name']."</option>";

     }

     echo "</select>";
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
                  //show all the programs in checkbox
                  echo "<input type=\"checkbox\" id=\"checkbox\" value=\"".$gram["program_type"]."\"><span id=\"check-text\">".$gram["program_type"]."</span>";


                }
                echo "<br>";
                echo "<span id=\"filter-title\">Program Year:</span>";
                echo "<br>";
                echo "<input type=\"checkbox\" id=\"year\" value=\"2012/2013\"><span id=\"check-text\">2012/2013</span>";
                echo "<input type=\"checkbox\" id=\"year\" value=\"2013/2014\"><span id=\"check-text\">2013/2014</span>";
                echo "<input type=\"button\" id=\"button\" value=\"filter\" />";
                echo"</div>";

                ?>



                <div id="show">
                  <?php

                  //show all the schools


                    $district = [];
                    $schoolInfo = [];
                    //if user is not logged in
                    if(!isset($_SESSION['username'])){
                        //and didn't set their city preference
                        if(!isset($_SESSION['city'])){
                          //show each district number
                      foreach($arr_dis as $key => $value){

                        echo "<h2>District #".$key.": ".$value."</h2>";


                        //get the list of school in each district
                        $res = get_list_of_schools();

                        while($row = $res->fetch_assoc()){

                          if($key == $row["districtID"]){
                            //show school result
                            echo '<a href="school_details.php?id=' . $row["schoolID"] . '">'.$row["name"].'</a>';
                            //echo $row["name"];

                            echo "<br>";

                  $schoolInfo[] = $row;
                  }

                  }
                  }
                }else{
                  //if city is set
                    $city_session = $_SESSION['city'];
                  echo "<h2>".$city_session." Schools</h2>";
                  echo "<br>";

                    $res = get_list_of_schools();
                    //get list of school with in the city
                    while($row = $res->fetch_assoc()){

                      if($row["city"] == $city_session){

                      echo '<a href="school_details.php?id=' . $row["schoolID"] . '">'.$row["name"].'</a>';
                        echo "<br>";
                      }

                    }


                }
                  }else{
                    //get user's city
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
                  //show school in user's city
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
