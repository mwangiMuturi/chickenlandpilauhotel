<?php
require_once '../partials/header.php';
require_once '../connection.php';
var_dump($_POST);

$id=$_POST['serial']??null;
if(!$id){
    //header('Location:create_menu.php');
   echo 'no id';
}
echo 'damah';
$statement=$pdo->prepare('UPDATE `order` SET `order_status`= "Cancelled" WHERE `order_id`=:id AND `order_status`="pending"');
$statement->bindValue(':id', $id);
$statement->execute();

header('Location:view_orders.php');
?>
<h1>Congo Brazaville</h1>