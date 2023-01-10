<?php
require_once "../connection.php";


if ($_POST){
   // sleep(3);
   if(!$_POST['name']||!$_POST['email']){
  //  echo "<div id='".$fsearch->name."'><div class='header'>".htmlspecialchars($title)."</div>";
$stile="class='alert alert-danger -2'";
    echo "<h6"." ";
    echo "class='alert alert-danger'";
    echo ">";
    echo " Enter a valid Name and Email";
    echo  "</h6>" ;
   } else{
$name=$_POST['name'];
$email=$_POST['email'];
$username=$_POST['username'];
$password=$_POST['password'];


    $statement=$pdo->prepare("INSERT INTO `chickenland_pilau`.`users` (`email`,`name`,`username`,`password`,`type`)
        VALUES(:email,:names,:username, :passwords ,2)");

$statement->bindValue(':names', $name);
$statement->bindValue(':email', $email);
$statement->bindValue(':username', $username);
$statement->bindValue(':passwords', $password);


    $statement->execute();
  sleep(2);
  header('Location: login.php');


   }
}
 ?>
 <!DOCTYPE html>
 <html lang="en">
 <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require_once "../partials/header.php"?>
    <title>Register</title>
 </head>
 
 <body>
    <form action="" method="post">
    <label for="">Name</label>
    <input type="text " name="name">

    <label for="">Email</label>
    <input type="email" name="email">

    <label for="username">Username</label>
    <input type="text" name="username">

    <label for="password"></label>
    <input type="password" name="password">

<button type="submit" class="btn btn-primary">Create</button>
    </form>
    <label for="">Already have an Account?</label> <a href="login.php" class="btn btn-secondary">Login</a>
 </body>
 </html>