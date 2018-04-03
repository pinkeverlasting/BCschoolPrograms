<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
<?php
  //show header of the page
  require('header.php');
  //unset saved watchlist values
  unset($_SESSION['id']);
  unset($_SESSION['name']);

  //Connect to database
  $dbhost = "localhost";
  $dbuser = "root";
  $dbpass = "";
  $dbname = "classicmodels";
  @$db = new mysqli($dbhost,$dbuser,$dbpass,$dbname);

  //If there is any error in database
  if (mysqli_connect_errno()) {
    echo "Database connection error: ". mysqli_connect_errno();
  exit();
}
  //Get the product code and product name stored in the url
    $code = $_GET['id'] ?? '1';
    $name = $_GET['name'] ?? '';
  //if user is logged in, get user's email
    if(isset($_SESSION['email'])) $email = $_SESSION['email'];
      //if email session is set
      if(isset($_SESSION['email'])){
        //select user's watchlist information through email
        $sql = "SELECT *
                FROM wishlist
                WHERE email = ?";

        $stmt = $db->prepare($sql);
        $stmt->bind_param('s',$email);
        $stmt->execute();
        //get the result from database
        $stmt->bind_result($id,$useremail,$productcode,$productname);
        //create an array to check if there is any duplicate product code
        $arr = array();

        while($stmt->fetch()){
          //put all user's exist product code in an array
          array_push($arr,$productcode);


        }
        //if users access watch list through models detail
        if($code !== '1' && $name !== ''){
        //if the products is not in watch list
        if(!in_array($code,$arr)){
        //SQL query insert product code and name into wish list table
        $query_str = "INSERT INTO wishlist ";
        $query_str.= "(email,productCode,productName) ";
        $query_str.= "VALUES (";
        $query_str.= "'".$email."',";
        $query_str.= "'".$code."',";
        $query_str.= "'".$name."'";
        $query_str.= ")";
        //get the result
        $result = mysqli_query($db,$query_str);
        //if result is true
        if($result) {
          echo "add product to wishlist successfully";


        } else {
          // INSERT failed
          echo mysqli_error($db);
          db_disconnect($db);
          echo "add product to wishlist failed";
          exit;

        }}else{
          //show error message if user put duplicate products in watch list
        echo "Duplicate product in wishlist";
      }

        }
          //create table to show user's watch list information
          echo "<table>";
          echo "<tr><th>Product Name</th><th>&nbsp;</th></tr>";
          //get user's email and send query to database
          $res = $db->prepare($sql);
          $res->bind_param('s',$email);
          $res->execute();
          $res->bind_result($id,$email,$productcode,$productname);
    //get product information and show the result
    while($res->fetch()){

      echo "<tr>";
      echo "<td>".$productname."</td>";
      echo "<td><a href=\"modelsdetail.php?id=".$productcode."\">View</a></td>";
      echo "</tr>";

    }
    echo "</table>";


    //relese the result for both request
    $stmt->free_result();
    $res->free_result();
    //close database
     $db->close();


    }else{
      //if user didn't log in/register yet, store product code and name into session
      $_SESSION['id'] = $code;
      $_SESSION['name'] = $name;
      header("Location: login.php");
      exit;
    }

    ?>

  </body>
</html>
