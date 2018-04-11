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
        if($result) {
          $new_id = mysqli_insert_id($db); //insert it into the db

          //create sessions
          $_SESSION['username'] = $user['username'];

          //redirect user
          header('Location: index.php');

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
    <h3>hasdfasdfafasdfsad</h3>

      <!-- name text field -->
        <h3>Username:</h3>
        <input type="text" name="username" value="<?php echo htmlspecial($user['username']); ?>" /><br />
        <h3>First Name:</h3>
        <input type="text" name="first_name" value="<?php echo htmlspecial($user['first_name']); ?>" /><br />
        <h3>Last Name:</h3>
        <input type="text" name="last_name" value="<?php echo htmlspecial($user['last_name']); ?>" /><br />

      <!-- Email text field -->
        <h3>Email:</h3>
        <input type="text" name="email" value="<?php echo htmlspecial($user['email']); ?>" /><br />

        <!-- City text field -->
        <h3>City:</h3>
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
          <br/><br/>

      <!-- warning for password message-->
         <p>
        Passwords should be at least 5 characters and include at least one uppercase letter, lowercase letter, number, and symbol.
        </p><br/>

      <!-- password text field -->
        <h3>Password:</h3>
        <input type="password" name="password" value="" /><br />
        <h3>Confrim Password:</h3>
        <input type="password" name="confirm_password" value="" /><br />

      <br />

    <!-- Submit Button -->
        <input class="button" type="submit" value="Create user" />

    </form>


</body>
</html>
