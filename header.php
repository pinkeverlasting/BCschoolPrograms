
<!-- Set Page Title if not already set -->
<?php
 session_start();
  if(!isset($page_title)) { $page_title = 'Main';
}


?>

<!-- Start HTML -->
<!doctype html>

<html lang="en">
  <head>
    <!-- Change Page Name depending what page -->
    <title>BC School Programs - <?php echo $page_title; ?></title>
    <meta charset="utf-8">
    <link rel="stylesheet" media="all" href="style.css">
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">

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

          if (isset($_SESSION['username']))
            {
              echo "<span id=\"nav\">User: </span>";
              echo "<a href='profile.php' id=\"nav\">" .$_SESSION['username']. "</a>";
              echo "|";
            }else{
              echo "";
            } ?>


           <a href="listofprograms.php" id="nav">List of Programs</a>
            |
            <a href="listofschools.php" id="nav">List of Schools</a>
            |


          <?php
            //If these sessions exist then it means user is logged in so show log out
            if (isset($_SESSION['username']))
            {
               echo "<a href='logout.php' id=\"nav\">Log Out</a>";

            } else {
              //not logged in
            echo "<a href='login.php' id=\"nav\">Login</a>";
          }

          ?>


      </navigation>

    </div>
