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
  unset($_SESSION['type']);

  //Connect to database
  db_connect();

  //Get the product code and product name stored in the url
    if(isset($_GET['id'])) { $code = $_GET['id']; }else{ $code = '';}
    if(isset($_GET['type'])) {$type = $_GET['type'];}else{$type = '';}
  //if user is logged in, get user's email
    if(isset($_SESSION['username'])) $username = $_SESSION['username'];
      //if email session is set
      if(isset($_SESSION['username'])){
        //select user's watchlist information through email
        $sql = "SELECT *
                FROM bookmark_list
                WHERE username = ?";

        $stmt = $db->prepare($sql);
        $stmt->bind_param('s',$username);
        $stmt->execute();
        //get the result from database
        $stmt->bind_result($id,$name,$programtype,$auto);
        //create an array to check if there is any duplicate product code
        $school_arr = array();
        $programs_arr = array();

        while($stmt->fetch()){
          //put all user's school to an arry
          if(!empty($id)){
          array_push($school_arr,$id);
        }
        if(!empty($programtype)){
          //put all user's program to an array
          array_push($programs_arr,$programtype);
        }

        }
        //if users access watch list through models detail
        if($code !== '' || $type !== ''){
        //if the products is not in watch list
        if(!in_array($code,$school_arr) && !in_array($type,$programs_arr)){
        //SQL query insert program or school into wish list table
        $query_str = "INSERT INTO bookmark_list ";
        $query_str.= "(schoolID,username,program_type) ";
        $query_str.= "VALUES (";
        $query_str.= "'".$code."',";
        $query_str.= "'".$username."',";
        $query_str.= "'".$type."'";
        $query_str.= ")";
        //get the result
        $result = mysqli_query($db,$query_str);
        //if result is true
        if($result) {
          echo "add product to bookmark successfully";


        } else {
          // INSERT failed
          echo mysqli_error($db);
          db_disconnect($db);
          echo "add product to bookmark failed";
          exit;

        }}else{
          //show error message if user put duplicate products in watch list
        echo "Duplicate schools / programs in wishlist";
      }

        }
          //create table to show user's favorite list information
          echo "<table>";
          echo "<tr><th>Your Favorite Schools / Programs</th><th>&nbsp;</th></tr>";
          //get username and send query to database
          $res = $db->prepare($sql);
          $res->bind_param('s',$username);
          $res->execute();
          $res->bind_result($schoolID,$name,$program_type,$increment);
    //get product information and show the result

    $school = array();
    $program = array();
    while($res->fetch()){

     //if there is school saved in favorite list
      if(!empty($schoolID)){
        //push in to an school array
        array_push($school,$schoolID);

      }

      if(!empty($program_type)){

        array_push($program,$program_type);
      }


    }

    //print_r($school);
    //print_r($program);

    // for each school store in school array
    foreach($school as $value){
      //get school information
    $sch = get_school_names($value);

    while($num = $sch->fetch_assoc()){
      //display the link of the school
      echo "<tr>";
      echo "<td>".$num["name"]."</td>";
      echo "<td><a href=\"school_details.php?id=".$value."\">View</a></td>";
      echo "</tr>";

    }
  }

  foreach($program as $value){
  $pro = get_names_of_programs($value);

  while($gram = $pro->fetch_assoc()){

    echo "<tr>";
    echo "<td>".$gram["program_type"]."</td>";
    echo "<td><a href=\"program_details.php?id=".$gram["program_type"]."\">View</a></td>";
    echo "</tr>";

  }
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
      $_SESSION['type'] = $type;
      header("Location: login.php");
      exit;
    }

    ?>

  </body>
</html>
