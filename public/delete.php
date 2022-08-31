<?php

require_once '../connection.php';
var_dump($_POST);

$id=$_POST['serial']??null;
if(!$id){
   header('Location:create_menu.php');
  
}
echo 'damah';
$statement=$pdo->prepare('DELETE FROM menu WHERE serial=:id');
$statement->bindValue(':id', $id);
$statement->execute();

header('Location:index.php');