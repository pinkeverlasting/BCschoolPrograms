  <?php

  function get_list_of_schools() {
    global $db;

    //select name and code from the table
    $sql = "SELECT schoolID, name FROM schools ORDER BY districtID";
    //echo $sql;
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
  }

  ?>