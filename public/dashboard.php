<?php 
require_once '../connection.php';
require_once '../partials/header.php';
require_once ("../vendor/autoload.php");
require_once "../vendor/davmixcool/php-sentiment-analyzer/src/analyzer.php";

Use Sentiment\Analyzer;
$analyzer = new Analyzer(); 
session_start();
if (isset( $_SESSION['username'])){
    //echo 'Hello'.'<h3>'. $_SESSION['username'].'</h3>';
}
else {
   
echo "You're not signed in";
header("location: login.php");
}

// killing sessions *murder*💖
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 0)) {
    // last request was more than 30 minutes ago
    //session_unset();     // unset $_SESSION variable for the run-time 
    //session_destroy();   // destroy session data in storage
    }
    $_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp

    $d = new DateTime('now');
    $d->setTimezone(new DateTimeZone('EAT'));
    
    $date= $d->format('Y-m-00 00:00:00');
    $today= $d->format('Y-m-d 00:00:00');

    //the followng is to establish variables for dashboard
     //all orders this month
$statement=$pdo->prepare("SELECT COUNT(`order_id`) as n FROM `order` WHERE `create_date`>'".$date."'"); 
$statement->execute();
$monthly_orders=$statement->fetchAll(PDO::FETCH_ASSOC);
    //all orders
$statement=$pdo->prepare("SELECT COUNT(`order_id`) as n FROM `order`"); 
$statement->execute();
$orders=$statement->fetchAll(PDO::FETCH_ASSOC);
 //completed orders
$statement1=$pdo->prepare("SELECT COUNT(`order_id`) as n FROM `order` WHERE `order_status`='completed'"); 
$statement1->execute();
$completed_orders=$statement1->fetchAll(PDO::FETCH_ASSOC);
//pending orders
$statement2=$pdo->prepare("SELECT COUNT(`order_id`) as n FROM `order` WHERE `order_status`='pending' "); 
$statement2->execute();
$pending_orders=$statement2->fetchAll(PDO::FETCH_ASSOC);
//cancelled orders
$statement3=$pdo->prepare("SELECT COUNT(`order_id`) as n FROM `order` WHERE `order_status`='cancelled'"); 
$statement3->execute();
$cancelled_orders=$statement3->fetchAll(PDO::FETCH_ASSOC);
//all users
$statement_users=$pdo->prepare("SELECT COUNT(`user_id`) as n FROM `users`"); 
$statement_users->execute();
$users=$statement_users->fetchAll(PDO::FETCH_ASSOC);
//admins
$statement_users0=$pdo->prepare("SELECT COUNT(`user_id`) as n FROM `users` where `type`=0"); 
$statement_users0->execute();
$admins=$statement_users0->fetchAll(PDO::FETCH_ASSOC);
//waiters /workers
$statement_users1=$pdo->prepare("SELECT COUNT(`user_id`) as n FROM `users` where `type`=1"); 
$statement_users1->execute();
$waiters=$statement_users1->fetchAll(PDO::FETCH_ASSOC);
// users ---customers
$statement_users2=$pdo->prepare("SELECT COUNT(`user_id`) as n FROM `users` where `type`=2"); 
$statement_users2->execute();
$customers=$statement_users2->fetchAll(PDO::FETCH_ASSOC);
//menu items
$statement_menu=$pdo->prepare("SELECT COUNT(`serial`) as n FROM `menu`"); 
$statement_menu->execute();
$menu=$statement_menu->fetchAll(PDO::FETCH_ASSOC);

//total income
$statement_income=$pdo->prepare("SELECT `order_status`,`create_date`,`order_id`, sum(`units`*`price`) as 'total'
FROM `order_items` oi
INNER JOIN `order` o ON oi.`order_id fk`=o.`order_id` JOIN `menu` m ON m.`serial`=oi.`serial fk` 
WHERE `create_date`>'".$date."' and `order_status`='Completed';"); 
$statement_income->execute();
$income=$statement_income->fetchAll(PDO::FETCH_ASSOC);

     //daily income
$statement_income=$pdo->prepare("SELECT `order_status`,`create_date`,`order_id`, sum(`units`*`price`) as 'total'
FROM `order_items` oi
INNER JOIN `order` o ON oi.`order_id fk`=o.`order_id` JOIN `menu` m ON m.`serial`=oi.`serial fk` 
WHERE `create_date`>'".$today."' AND `order_status`='Completed';"); 
$statement_income->execute();
$daily_income=$statement_income->fetchAll(PDO::FETCH_ASSOC);

//reviews
$statement_review=$pdo->prepare("SELECT COUNT(`idreviews`) as n, `review_content` FROM `reviews` WHERE `create_date`>'".$date."' "); 
$statement_review->execute();
$reviews=$statement_review->fetchAll(PDO::FETCH_ASSOC);
//var_dump($reviews);
 foreach($reviews as $l){
//$output_text =array_push($output_text,$analyzer->getSentiment($reviews[$l]['review_content']));
//echo $output_text ['compound']; 
//echo 'review'; 
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<style>
    .side{
        width: 200px;
    }
    .title{
color: #fcbf49;
    }
    .fs{
        font-weight: bold;
    }
    .user{
        
        border-left:solid 1em #fcbf49 ;
      
    }
</style>
<body>
<?php require "../partials/navbar.php"?>
<div class="d-flex container">
<div class="card side " >
    
      <a href="create_menu.php" class="btn btn-success m-2">Add Menu Item</a>
      <a href="create_order.php" class="btn btn-success m-2">Create Order</a>
      <a href="menu.php" class="btn btn-success m-2">Customer Menu</a>
      <a href="review.php" class="btn btn-success m-2">Review Creating</a>
      
   </div>

   <div class="container">
    <div class="d-flex row">
    <div class="card p-2 m-1 user col  col-md-3">  <p class="title fs-5">System Admins</p>   <p class="fs"><?php echo $admins[0]['n'] ?></</p> </div>
    <div class="card p-2 m-1 user col  col-md-3">  <p class="title fs-5"> Hotel Waiters </p>   <p class="fs"><?php echo $waiters[0]['n'] ?></</p> </div>
    </div>

    <div class="containr">
    <div class="d-flex row">
    <div class="card p-2 m-1 user col col-md-3"> <p class="title fs-5">Menu Items</p>   <p class="fs"><?php echo $menu[0]['n']; ?></</p></div>
    <div class="card p-2 m-1 user col col-md-2.5">  <p class="title fs-5"> Reviews(This Month)</p>   <p class="fs"><?php echo $reviews[0]['n'] ?></</p> </div>
    <div class="card p-2 m-1 user col col-md-2.5">  <p class="title fs-5"> Orders(This Month) </p>   <p class="fs"><?php echo $monthly_orders[0]['n'] ?></</p> </div>
    <div class="card p-2 m-1 user col col-md-3">  <p class="title fs-5"> Income(Monthly) </p>   <p class="fs">Ksh<?php echo ' '.$income[0]['total'] ?></</p> </div>

    <canvas id="myChart" style="max-width:400px" class="col col-md-8"></canvas>


    
</div>
     


<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>



<script>
var xValues = ["pending", "completed", "cancelled",];

var yValues = [ <?php echo $pending_orders[0]['n'] ?>,<?php echo $completed_orders[0]['n'] ?>,<?php echo $cancelled_orders[0]['n'] ?>,];
var barColors = [
  "#b91d47",
  "#00aba9",
  "#2b5797",
];

new Chart("myChart", {
  type: "doughnut",
  data: {
    labels: xValues,
    datasets: [{
      backgroundColor: barColors,
      data: yValues
    }]
  },
  options: {
    title: {
      display: true,
      text: "Total Orders"
    }
  }
});
</script>
   </div>
</div>    

</body>
</html>

   