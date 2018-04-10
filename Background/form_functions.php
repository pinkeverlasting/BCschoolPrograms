  <?php

   //Validation functions 

  //check if email is in correct format
  function valid_email_format($value) {
    $email_regex = '/\A[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,}\Z/i';
    return preg_match($email_regex, $value) === 1;
  }

  function validate_profile($user) {

    $errors = [];  //create var just in case


    if(is_blank($user['first_name'])) {
      $errors[] = "First Name cannot be blank.";
    } 

    //make sure not blank
    if(is_blank($user['last_name'])) {
      $errors[] = "Last Name cannot be blank.";
    }

    //make sure not blank
    if(is_blank($user['email'])) {
      $errors[] = "Email cannot be blank.";
    } elseif (!has_length($user['email'], array('max' => 255))) {
      //has to be below 255 characters long
      $errors[] = "Last name must be less than 255 characters.";
    } else if (!valid_email_format($user['email'])) {
      $errors[] = "Email must be a valid format.";
    }

    return $errors;
  }

  function validate_registration($user) {

    $errors = [];  //create var just in case


    if(is_blank($user['username'])) {
      $errors[] = "Username cannot be blank.";
    } elseif (!has_length($user['username'], array('min' => 6, 'max' => 255))) {
    //between 2 and 255 characters long
      $errors[] = "Username must be between 6 characters or more.";
    } elseif (username_exists($user['username'])) {
    //between 2 and 255 characters long
      $errors[] = "Username Exists";
    }

    //make sure not blank
    if(is_blank($user['first_name'])) {
      $errors[] = "First name cannot be blank.";

    } elseif (!has_length($user['first_name'], array('min' => 2, 'max' => 255))) {
    //between 2 and 255 characters long
      $errors[] = "First name must be between 2 and 255 characters.";
    }

  //make sure not blank
    if(is_blank($user['last_name'])) {
      $errors[] = "Last name cannot be blank."; //can't be blank

    } elseif (!has_length($user['last_name'], array('min' => 2, 'max' => 255))) {
      //between 2 and 255 characters long
      $errors[] = "Last name must be between 2 and 255 characters.";
    }

  //make sure not blank
    if(is_blank($user['email'])) {
      $errors[] = "Email cannot be blank.";
    } elseif (!has_length($user['email'], array('max' => 255))) {
      //has to be below 255 characters long
      $errors[] = "Last name must be less than 255 characters.";
    } elseif (!valid_email_format($user['email'])) {
      $errors[] = "Email must be a valid format.";
    }

    //make sure not blank
    if(is_blank($user['city'])) {
      $errors[] = "City cannot be blank.";
    }

  
  //make sure not blank
    if(is_blank($user['password'])) {
      $errors[] = "Password cannot be blank.";
    } elseif (!has_length($user['password'], array('min' => 5))) {
      $errors[] = "Password must contain 5 or more characters";
    }
  
  //make sure not blank
    if(is_blank($user['confirm_password'])) {
      $errors[] = "Confirm password cannot be blank.";
    } elseif ($user['password'] !== $user['confirm_password']) {
      $errors[] = "Password and confirm password must match.";
    }

    return $errors;
  }


  //add new user to table
  function add_user($user) {
    global $db;

    //validate the form first
    $errors = validate_registration($user);
    if (!empty($errors)) {
      //echo "validate error";
      return $errors;
    }

    //get district id
    $schoolid = get_district_id($user['city']);

  //create new user/member into the database  

  //for password encreption purposes
  $hashed_password = password_hash($user['password'], PASSWORD_BCRYPT);

  //query for insert new user in table
    $sql = "INSERT INTO profile ";
    $sql .= "(username, first_name, last_name, email, districtID, city) ";
    $sql .= "VALUES ";
    $sql .= " ('". db_escape($db, $user['username']) . "', ";
    $sql .= "'". db_escape($db, $user['first_name']) .  "', ";
    $sql .= "'". db_escape($db, $user['last_name']) .  "', ";
    $sql .= "'". db_escape($db, $user['email']) .  "', ";
    $sql .= "'". db_escape($db, $schoolid) .  "', ";
    $sql .= "'". db_escape($db, $user['city']) .  "')";
    $result = mysqli_query($db, $sql);

$randomid = (rand(10000,20000));

    $sql2 = "INSERT INTO members ";
    $sql2 .= "(memberID, username, hashed_password) ";
    $sql2 .= "VALUES ";
    $sql2 .= " ('". db_escape($db, $randomid) . "', ";
    $sql2 .= "'". db_escape($db, $user['username']) .  "', ";
    $sql2 .= "'". db_escape($db,$hashed_password) .  "')";
    $result2 = mysqli_query($db, $sql2);

    //echo "query insert created";

    //for insert, result returns true if sucesssful
    if ($result && $result2) {
      return true; //insert works
    } else {
      return false; //failed
      db_disconnect($db);
        exit;
    }

  }


  //add new user to table
  function update_user($user) {
    global $db;

    $username = trim($user['username']);
    $fname = trim($user['first_name']);
    $lname = trim($user['last_name']);
    $email = trim($user['email']);
    $city = trim($user['city']);
    $schoolid = get_district_id($user['city']);

    // Attempt update query execution
    $sql = "UPDATE profile SET first_name = '$fname', last_name = '$lname', email = '$email', districtID = '$schoolid', city = '$city' WHERE username = '$username'";
    $result = mysqli_query($db, $sql) or die('SQL Error: ' . mysqli_error($db));
    if(mysqli_query($db, $sql)) {
        echo "<h3><form> Records were updated successfully. </form></h3>";
    } else {
        echo "ERROR: Could not able to execute $sql. " . mysqli_error($db);
    }
    // Close connection
    mysqli_close($db);
    //return true;

  }






  ?>