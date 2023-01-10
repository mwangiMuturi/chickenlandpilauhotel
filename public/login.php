<?php
require_once '../connection.php';
 $errors=[];
 
 if ($_SERVER['REQUEST_METHOD']=='POST'){
    $username=$_POST['username'];
    $password=$_POST['password'];
 


    session_start();
    $_SESSION['username']=$username;


    $statement=$pdo->prepare("SELECT * FROM chickenland_pilau.users where `username`=? and `password`=? ");
     $statement->execute(array($username,$password));
     $users=$statement->fetch(PDO::FETCH_ASSOC);
     if (isset($users['user_id'])){
    $_SESSION['user_id']=$users['user_id'];
     }
//var_dump($users);

     $checkuser=$statement->rowCount();
     if($checkuser==0){
       
       $errors= "Invalid Username or Password";
         }

     if($checkuser>0 && $users['type']==0){
       
    header("location: dashboard.php");
     }
     elseif($checkuser>0 && $users['type']==1){
        header("location: view_orders.php");
    }
    elseif($checkuser>0 && $users['type']==2){
        header("location: menu.php");
    }
}

?>

</php>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Ms+Madi&display=swap" rel="stylesheet">
    <?php require_once "../partials/header.php" ?>
    <title>Login</title>
</head>
<style>
    .branding{
      font-family: 'Ms Madi', cursive;
      color: #283618;
      font-weight: bold;
    }
</style>
<body class="container">
<h1 class="branding">ChickenLand Pilau</h1>
<form action="" method="post" class="containe mx-auto " style="width: 400px;" id="form">
    <div class="d-flex row" > 
    <label for="name">Username</label>
    <input name="username" type="text" class="form-control m-2 "  id="username">
    <label for="password">Password</label>
        <input name="password" type="password" autocomplete="on" class="form-control m-2" id="password">
        </div>
        <button type="submit" class="btn btn-primary">Login</button>
     <!--   <label for="">Don't have an account?</label> 
       
       <a href="registration.php"  class="btn btn-secondary">Register</a>-->


   
       <div class="text-danger"><?php if ($errors){echo $errors;} ?></div>

    </form>
</body>

<script>
//serious business
const form = document.getElementById('form')

const username = document.getElementById('username')
const password = document.getElementById('password')


  
form.addEventListener('submit', (e) => {
  let messages = []
  
  if (username.value.length>20) {
    messages.push('Max char is 20')
  }

  if (password.value.length==0) {
    messages.push('Max char is 20')
  }
  
  if (password.value.length>30) {
    messages.push('Max char is 20')
  }
  if (messages.length > 0) {
    e.preventDefault()
    //errorElement.innerText = messages.join(', ')
  }
})
</script>
</html>