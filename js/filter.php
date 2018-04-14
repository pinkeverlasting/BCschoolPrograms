<?php

require('../Background/initialize.php');
session_start();
header("Content-type: application/json");




$empty = '';
$arr = array();

if(isset($_GET['district'])) { $district = $_GET['district']; }else{$district = '';}
if(isset($_GET['year'])) { $year = $_GET['year']; }else{$year = '';}
if(isset($_GET['type'])) { $type = $_GET['type']; }else{$type = '';}
if(isset($_GET['programType'])){


foreach($_GET['programType'] as $pt){
$res = get_programs_by_school($pt,$district,$year,$type);


while($row = $res->fetch_assoc()){

  {
   $arr[] = array(
     'name' => $row['name'],
     'code' => $row['schoolID'],
     'year' => $row['year'],
     'type' => $row['program_type']);

 }

 }
}
}else{

  $res = get_programs_by_school($empty,$district,$year,$type);

  while($row = $res->fetch_assoc()){

    {
     $arr[] = array(
       'name' => $row['name'],
       'code' => $row['schoolID'],
       'year' => '',
       'type' => '');

   }

   }
 }






       print json_encode($arr);








db_disconnect($db);


?>
