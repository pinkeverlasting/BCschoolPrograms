<?php

//add_comment.php
require('Background/initialize.php');
//$connect = new PDO('mysql:host=localhost;dbname=testing', 'root', '');

$error = '';
$comment_name = '';
$comment_content = '';

if(empty($_POST["comment_name"]))
{
 $error .= '<p class="text-danger">Name is required</p>';
}
else
{
 $comment_name = $_POST["comment_name"];
}

if(empty($_POST["comment_content"]))
{
 $error .= '<p class="text-danger">Comment is required</p>';
}
else
{
 $comment_content = $_POST["comment_content"];
}

if(empty($error))
{	
 $query = "INSERT INTO tbl_comment (comment_id, comment, comment_sender_name) VALUES ";
 $query .= " ('". db_escape($db, $_POST["comment_id"]) . "', ";
    $sql .= "'". db_escape($db, $comment_content) .  "', ";
    $sql .= "'". db_escape($db, $comment_name)  .  "')";
    $result = mysqli_query($db, $sql) or die('SQL Error: ' . mysqli_error($db));
 
 /*(:parent_comment_id, :comment, :comment_sender_name)';*/
 /*$statement = $db->prepare($query);
 $statement->execute(
  array(
   ':parent_comment_id' => $_POST["comment_id"],
   ':comment'    => $comment_content,
   ':comment_sender_name' => $comment_name
  )
 );*/

 //for insert, result returns true if sucesssful
    if ($result) {
      //return true; //insert works
    	$new_id = mysqli_insert_id($db);
    } else {
      //return false; //failed
      db_disconnect($db);
        exit;
    }


 $error = '<label class="text-success">Comment Added</label>';
} 

$data = array(
 'error'  => $error
);

echo json_encode($data);

?>
