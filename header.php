
<!-- Set Page Title if not already set -->
<?php
  if(!isset($page_title)) { $page_title = 'Main'; 
}

?>

<!-- Start HTML -->
<!doctype html>

<html lang="en">
  <head>
    <!-- Change Page Name depending what page -->
    <title>Assignment 4: Christy Chan - <?php echo $page_title; ?></title> 
    <meta charset="utf-8">
    <link rel="stylesheet" media="all" href="main.css"> 

  </head>

  <body>
    <header>
      <h1>BC Youth Programs Directory</h1>

      <!-- Navagation Area -->
      <navigation>

      <!-- Load currect user if session exists -->
          User: <?php echo $_SESSION['email'] ?? ''; ?>
           ||
          <a href="showmodels.php">Home</a>   
          ||
           <a href="addtowatchlist.php">List of Programs</a>
            ||


          <?php
            //If these sessions exist then it means user is logged in so show log out
            if (!empty($_SESSION['logged_in']) && !empty($_SESSION['email']))
            {
               echo "<a href='logout.php'>Log Out</a>";

            } else {
              //not logged in
            echo "<a href='login.php'>Login</a>";
          }

          ?>   
           
      </navigation>
      
    </header>


