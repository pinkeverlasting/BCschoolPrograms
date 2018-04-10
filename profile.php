<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script type="text/javascript">

    $(document).ready(function(){

      $("#edit").click(function(){
          $("#first_name").prop('disabled', false);
          $("#last_name").prop('disabled', false);
          $("#email").prop('disabled', false);
          $("select[name='city']").prop('disabled', false);
          $("input[id='edit']").hide();
          //$("input[id='edit']").prop("value", "Submit");
          //$("input[id='edit']").prop("id", "submit");

          $("#Create").toggle();
      });


    });
    </script>
  </head>
  <body>

    <?php

    require('header.php');
    db_connect();
    $errors = [];

    if (isset($_SESSION['username'])) {

        $resultProfile = get_profile($_SESSION['username']);
        $resultCity = get_cities();

         while($row = mysqli_fetch_array($resultProfile)) {
            $fname = $row['first_name'];
            $lname = $row['last_name'];
            $email = $row['email'];
            $city = $row['city'];
         }
    }

    //preload queries

    if(is_post()) {

        //recieve the user inputs
        $user['first_name'] = $_POST['first_name'] ?? '';
        $user['last_name'] = $_POST['last_name'] ?? '';
        $user['email'] = $_POST['email'] ?? '';
        $user['city'] = $_POST['city'] ?? '';
        $user['username'] = $_SESSION['username'];

        //run user validations and make the query
      
        //validate the form first
        $result = validate_profile($user);
        
        if (empty($result)) {
          $result = update_user($user);
          $fname = $user['first_name'];
          $lname = $user['last_name'];
          $email = $user['email'];
          $city= $user['city'];

        } else {
          $errors = $result;
        }

      } else {
        // display the blank form
        $user = [];
        $user["first_name"] = '';
        $user["last_name"] = '';
        $user["email"] = '';
        $user["city"] = '';

      }
  

    ?>

    <h1>My Profile</h1>
    <?php echo display_errors($errors); 
    if (isset($_SESSION['username'])) {?>

    <form action="profile.php" method="post">

    First Name:
    <input id="first_name" name="first_name" type="text" value="<?php echo $fname?>" disabled></br>
    Last Name:
    <input id="last_name" name="last_name" type="text" value="<?php echo $lname?>" disabled></br>
    Email:
    <input id="email" name="email" type="text" value="<?php echo $email?>" disabled></br>
  

        <!-- City text field -->
        City: 
        <select name="city" id="city" disabled>
        <option value=""> -- select city -- </option>
        <?php

        //populating the dropbox with city names
            while($row = $resultCity -> fetch_assoc()){
              //output data from each row
              
              if ($city == $row['city']) {
                 echo '<option value="'.$row['city'].'"selected>' . $row["city"] . '</option>';
              } else if ($row['city'] != ""){
                echo '<option value="'.$row['city'].'">' . $row["city"] . '</option>';
              }
            }
          ?>

          </select>
      <br />

    <!-- Submit Button -->
        <input type="button" id='edit' value="Edit">
        
        <div id="Create" style="display:none">
          <input type="submit" id='submit' value="Submit">
        </div>


    </form>

    <?php
  } else {
      echo '<h2> No Profile </h2>';
  }
   ?>
    


</body>
</html>
