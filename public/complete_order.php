<?php
require_once '../partials/header.php';


require_once '../connection.php';
var_dump($_POST);

$id=$_POST['serialll']??null;
if(!$id){
    //header('Location:create_menu.php');
   echo 'no id';
}
echo 'damah';
$statement=$pdo->prepare('UPDATE `order` SET `order_status`= "Completed" WHERE `order_id`=:id');
$statement->bindValue(':id', $id);
$statement->execute();

header('Location:view_orders.php');
?>
?>
<h1>
    What Up Biatch?
</h1>