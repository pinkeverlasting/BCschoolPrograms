
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

    $res = get_list_of_schools();

    //error
    if (!$res) {
      die ('SQL Error: ' . mysqli_error($connection));
    }
   
    ?>
<h2> School List </h2>

    <table class="list">
      <tr>
        <th>School Name</th>
        <th>&nbsp;</th>
      </tr>
    <?php
    //query string to get product's name and code
    //$query_str = "SELECT schoolID, name FROM schools ORDER BY districtID";
    //send query to database and get the result
    //$res = $db->query($query_str);

    //while the fetching the result
    while ($row = $res->fetch_assoc()){ ?>
       <tr>
         <!-- show product name  -->
         <td><?php echo $row["name"]; ?></td>
         <!-- put product code into url and in order to help get the specified product information in other page -->
         <td><a href="schoolsdetail.php?id=<?php echo $row["schoolID"]; ?>">View</a></td>
       </tr>

   <?php };
   db_disconnect($db);
     ?>
  </table>

</body>
</html>
