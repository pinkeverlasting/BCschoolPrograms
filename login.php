
<?php
//If secure connection is not on
/*if($_SERVER["HTTPS"] != "on"){
//Turn on secure connection and direct to the url
  header("Location: https://".$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"]);

   exit(); }*/

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>BC School Programs</title>
  </head>
  <body>

      <?php
      //show header of the page

      require('header.php');

      db_connect();
      confirm_db_connect();


      ?>

    <form class="login" action="" method="post">

      Username: <input type="text" name="username" value=""> <br/>
      Password: <input type="password" name="password" value=""> <br/>
      <input type="submit" name="login" value="Log In"> <br/>
      <a href="register.php">Register here</a>

      <?php
      //If user submitted log in form
      if($_SERVER['REQUEST_METHOD'] == 'POST'){
        //Get user's email and password values
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';
        //If email is empty
        if($username == ''){
          //show error message
          echo "Username cannot be blank.";

        }
        //If password is empty
        if($password == ''){
          //show error message
          echo "Password cannot be blank.";
        }

        //If form is filled
        if(!$username == '' && !$password == ''){

        //Get user's information from database
        $query_str = "SELECT * FROM members ";
        $query_str.= "WHERE username='".$username."' ";
        $query_str.= "LIMIT 1";
        //prepare the database result
        $result = mysqli_query($db, $query_str);
        $user = mysqli_fetch_assoc($result);
        mysqli_free_result($result);

        //If result is true
        if($user){
          //If the password is same as the stored password
          if(password_verify($password, $user['hashed_password'])){
            //Log in user by setting user's email to session
              $_SESSION['username'] = $username;
              echo("log in successfully");
              header("Location: listofprograms.php");
              //If watch list session stored values
              //which users access to model's detail and add watchlist before
              //if(isset($_SESSION['id'])){
                //get product code and name
              //  $id = $_SESSION['id'];
            //    $name = $_SESSION['name'];
                //and direct to watchlist with selected product code and name
            //    header("Location: http://".$_SERVER['HTTP_HOST']."/lowail/A4/addtowatchlist.php?id=$id&name=$name");

            //  }else{
                //otherwise, direct to show models
            //    header("Location: http://".$_SERVER['HTTP_HOST']."/lowail/A4/showmodels.php");
            //  }

          } else {

            echo "Username and password do not match. Log In Failed.";
          }
        }


      } else {

        echo "Form can not be empty";
      }
    }


    $db->close();

       ?>

    </form>

  </body>
</html>
