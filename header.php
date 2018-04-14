
<!-- Set Page Title if not already set -->
<?php
//start session for cookies and etc
 session_start();
?>

<!-- Start HTML -->
<!doctype html>

<html lang="en">
  <head>
    <!-- Change Page Name depending what page -->
    <title>BC School Programs</title>
    <meta charset="utf-8">
    <link rel="stylesheet" media="all" href="style.css">
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
      <script src="//code.jquery.com/jquery-3.1.0.min.js"></script>
  </head>

  <body>
  <div class="header-flex">
    <header>
      <a href="index.php"><h1>BC Youth Programs Directory</h1></a>

    </header>
      <!-- Navagation Area -->
      <navigation>

      <!-- Load currect user if session exists -->



          <?php
          require('Background/initialize.php');

          db_connect();

          if (isset($_SESSION['username']))
            {
              echo "<span id=\"nav\">User: </span>";
              echo "<a href='profile.php' id=\"nav\">" .$_SESSION['username']. "</a>";
              echo "|";
            }else{
              echo "<span id=\"nav\">City: </span>";
              echo "<select id=\"city-pref\">";
              if(isset($_SESSION['city'])){
                echo "<option value=\"".$_SESSION['city']."\">".$_SESSION['city']."</option>";
              }else{
                echo "<option value=\"\"></option>";
              }
              $resultCity = get_cities();
              while($row = $resultCity -> fetch_assoc()){
                //output data from each row


                  echo '<option value="'.$row['city'].'">' . $row["city"] . '</option>';
                }
              }
              echo "</select>";
              echo "|";

            ?>


           <a href="listofprograms.php" id="nav">List of Programs</a>
            |
            <a href="listofschools.php" id="nav">List of Schools</a>



          <?php
            //If these sessions exist then it means user is logged in so show log out
            if (isset($_SESSION['username']))
            {
              echo "|";

              echo "<a href=\"addtowatchlist.php\" id=\"nav\">Favorite List</a>";
              echo "|";
               echo "<a href='logout.php' id=\"nav\">Log Out</a>";

            } else {
              //not logged in
            echo "|";
            echo "<a href='login.php' id=\"nav\">Login</a>";
          }

          ?>


      </navigation>

    </div>

    <script>

    $("#city-pref").change(function(){

        console.log("yo");
        var city_val = this.value;

        $.ajax({
           type: 'GET',
           url: 'session.php', // change url as your
           data: { city : city_val },
           success: function (data) {
             console.log("city preferece changed");
           }
       });

    });

    </script>
