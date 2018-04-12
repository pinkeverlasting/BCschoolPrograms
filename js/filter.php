<?php

require('../Background/initialize.php');
session_start();
header("Content-type: application/json");



$dis = get_list_of_districts();
$pro = get_list_of_programs();
$action = 'filter';


switch($action) {

  case 'default':

  $arr_dis = array();
  while($num = $dis->fetch_assoc()){

    $arr_dis[$num["districtID"]] = $num["name"];
  }

  $district = [];
  $schoolInfo = [];
  if(!isset($_SESSION['username'])){

    foreach($arr_dis as $key => $value){

      echo "<h2>District #".$key.": ".$value."</h2>";



      $res = get_list_of_schools();

      while($row = $res->fetch_assoc()){

        if($key == $row["districtID"]){

          echo '<a href="school_details.php?id=' . $row["schoolID"] . '">'.$row["name"].'</a>';
          //echo $row["name"];

          echo "<br>";

$schoolInfo[] = $row;
}

}
}

// print json_encode([
//   'success' => true,
//   'district' => $district,
//   'school' => $schoolInfo
// ]);

}else{

$username = trim($_SESSION['username']);

$sql = "SELECT city
FROM profile
WHERE username = ?";

$stmt = $db->prepare($sql);
$stmt->bind_param('s',$username);
$stmt->execute();
//get the result from database
$stmt->bind_result($city);

$city_pref = '';

while($stmt->fetch()){

$city_pref = $city;
}

echo "<h2>".$city_pref." Schools</h2>";
echo "<br>";

  $res = get_list_of_schools();

  while($row = $res->fetch_assoc()){

    if($row["city"] == $city_pref){

      echo $row["name"];
      echo "<br>";
    }

  }

$stmt->free_result();


}


case 'filter':


if(isset($_GET['programType'])){

$arr = array();
foreach($_GET['programType'] as $pt){
$res = get_programs_by_school($pt);


while($row = $res->fetch_assoc()){

  {
   $arr[] = array(
     'name' => $row['name'],
     'code' => $row['schoolID'],
     'year' => $row['year']);

 }

 }
}


       print json_encode($arr);


}else{
 echo "no program type";
}



}

db_disconnect($db);


?>
