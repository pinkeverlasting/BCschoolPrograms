<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>

    <?php
    require('Background/initialize.php');
    require('header.php');
    db_connect();

    // there can be multiple errors so errors is an array
    $errors = [];

    //preload queries 

     $res = get_list_of_cities();

    //error
    if (!$res) {
      die ('SQL Error: ' . mysqli_error($connection));
    }

    //form vaildations

    if(is_post()) {

        //recieve the user inputs
        $user['username'] = $_POST['username'] ?? '';
        $user['first_name'] = $_POST['first_name'] ?? '';
        $user['last_name'] = $_POST['last_name'] ?? '';
        $user['email'] = $_POST['email'] ?? '';
        $user['city'] = trim($_POST['city']) ?? '';
        $user['password'] = $_POST['password'] ?? '';
        $user['confirm_password'] = $_POST['confirm_password'] ?? '';

        //run user validations and make the query 
        $result = add_user($user);  

          
        //if result is true which means validated, then insert it 
        if($result === true) {
          $new_id = mysqli_insert_id($db); //insert it into the db

          //create sessions
          $_SESSION['username'] = $user['username']; 
          $_SESSION['logged_in'] = true;

          //redirect user
          header('Location: addtowatchlist.php');

        } else {
          //show the sql error
          $errors = $result;
        }

      } else {
        // display the blank form
        $user = [];
        $user["username"] = '';
        $user["first_name"] = '';
        $user["last_name"] = '';
        $user["email"] = '';
        $user["city"] = '';
        $user['password'] = '';
        $user['confirm_password'] = '';
      }

   
    ?>

    <h1>Create user</h1>

     <!-- display any errors -->
   <?php echo display_errors($errors); ?> 

    <form action="register.php" method="post">
      
      <!-- name text field -->
        Username:
        <input type="text" name="username" value="<?php echo htmlspecial($user['username']); ?>" /><br />
        First Name:
        <input type="text" name="first_name" value="<?php echo htmlspecial($user['first_name']); ?>" /><br />
        Last Name:
        <input type="text" name="last_name" value="<?php echo htmlspecial($user['last_name']); ?>" /><br />
       
      <!-- Email text field --> 
        Email:
        <input type="text" name="email" value="<?php echo htmlspecial($user['email']); ?>" /><br />

        <!-- City text field --> 
        City:
        <select name="city">
        <option value=""> -- select city -- </option>
        <?php 

        //populating the dropbox with city names
            while($row = $res -> fetch_assoc()){
              //output data from each row
              $id = $row['city'];
              echo '<option value="'.$id.'">' . $row["city"] . '</option>';
            }
          ?> 

          </select>
      
      <!-- warning for password message-->
         <p>
        Passwords should be at least 5 characters and include at least one uppercase letter, lowercase letter, number, and symbol.
        </p><br />
        
      <!-- password text field -->
        Password:
        <input type="password" name="password" value="" /><br />
        Confrim Password:
        <input type="password" name="confirm_password" value="" /><br />
    
      <br />

    <!-- Submit Button -->
        <input type="submit" value="Create user" />

    </form>


</body>
</html>