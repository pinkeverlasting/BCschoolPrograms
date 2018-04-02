  <?php

   //Validation functions 

  function is_blank($value) {
    //trim white spaces 
    //use === to prevent false positive 
    return !isset($value) || trim($value) === '';
  }

  //check if email is in correct format
  function valid_email_format($value) {
    $email_regex = '/\A[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,}\Z/i';
    return preg_match($email_regex, $value) === 1;
  }

  // has_length('abcd', ['min' => 3, 'max' => 5])
  // * validate string length
  // * combines functions_greater_than, _less_than, _exactly
  // * spaces count towards length
  // * use trim() if spaces should not count
  function has_length($value, $options) {
    if(isset($options['min']) && !has_length_greater_than($value, $options['min'] - 1)) {
      return false;
    } elseif(isset($options['max']) && !has_length_less_than($value, $options['max'] + 1)) {
      return false;
    } elseif(isset($options['exact']) && !has_length_exactly($value, $options['exact'])) {
      return false;
    } else {
      return true;
    }
  }

     function validate_registration($user) {

    $errors = [];  //create var just in case

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





  ?>