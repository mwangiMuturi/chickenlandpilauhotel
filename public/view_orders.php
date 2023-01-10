<?php
require_once "reports.php";


require_once '../connection.php';
$d = new DateTime('now');
$d->setTimezone(new DateTimeZone('EAT'));

$date= $d->format('Y-m-d 00:00:00');
$today= $d->format('Y-m-d 00:00:00');


//$statement=$pdo->prepare('SELECT * FROM `order`');
// $statement->execute();
//$products=$statement->fetchAll(PDO::FETCH_ASSOC);

//GET TOTAL VALUE-------------------------------------------------------------------------------------------------------
 
$statement=$pdo->prepare("
SELECT `order_status`,`create_date`,`server_id`,`phone_number`,`order_id`, sum(`units`*`price`) as 'total',`cust_name`
FROM `order_items` oi
INNER JOIN `order` o ON oi.`order_id fk`=o.`order_id` JOIN `menu` m ON m.`serial`=oi.`serial fk`
 WHERE o.`create_date`>'".$date."'  group by o.`order_id` order by `create_date` DESC; ");
 $statement->execute();


if($_POST){
  
$orgDate = $_POST['start'];  
    $newDate = date("Y/m/d", strtotime($orgDate));  
   
  
  
$orgiDate = $_POST['end'];  
$endDate = date("Y/m/d 23:59:59", strtotime($orgiDate));  
  
  
  if($_POST['status']=='All'){
    $statement=$pdo->prepare("
    SELECT `order_status`,o.`create_date`,`phone_number`,`server_id`,`order_id`, sum(`units`*`price`) as 'total',`cust_name`
    FROM `order_items` oi
    INNER JOIN `order` o ON oi.`order_id fk`=o.`order_id` JOIN `menu` m ON m.`serial`=oi.`serial fk` 
    WHERE o.`create_date` >='".$newDate."' AND o.`create_date` <='".$endDate."' group by o.`order_id` order by `create_date` DESC; ");
     $statement->execute();
   
  }else{
    $statement=$pdo->prepare("
    SELECT `order_status`,o.`create_date`,`phone_number`,`server_id`,`order_id`, sum(`units`*`price`) as 'total',`cust_name`
    FROM `order_items` oi
    INNER JOIN `order` o ON oi.`order_id fk`=o.`order_id` JOIN `menu` m ON m.`serial`=oi.`serial fk` 
    WHERE o.`create_date` >='".$newDate."' and o.`create_date` <='".$endDate."' and o.`order_status`='".$_POST['status']."' group by o.`order_id`; ");
     $statement->execute();
    
  }

 
 
 
}
$products=$statement->fetchAll(PDO::FETCH_ASSOC);

    //daily income
    $statement_income=$pdo->prepare("SELECT `order_status`,`create_date`,`order_id`, sum(`units`*`price`) as 'total'
    FROM `order_items` oi
    INNER JOIN `order` o ON oi.`order_id fk`=o.`order_id` JOIN `menu` m ON m.`serial`=oi.`serial fk` 
    WHERE `create_date`>'".$today."' AND `order_status`='Completed' and `mode`='M-PESA';"); 
    $statement_income->execute();
    $daily_income_mpesa=$statement_income->fetchAll(PDO::FETCH_ASSOC);

     //daily income
     $statement_income=$pdo->prepare("SELECT `order_status`,`create_date`,`order_id`, sum(`units`*`price`) as 'total'
     FROM `order_items` oi
     INNER JOIN `order` o ON oi.`order_id fk`=o.`order_id` JOIN `menu` m ON m.`serial`=oi.`serial fk` 
     WHERE `create_date`>'".$today."' AND `order_status`='Completed' and `mode`='CASH';"); 
     $statement_income->execute();
     $daily_income_cash=$statement_income->fetchAll(PDO::FETCH_ASSOC);
//generate($products);




//echo '<pre>';
//var_dump($products);
//echo '</pre>';

//------------------------------------------------------------
?>

<!DOCTYPE html>

<html lang="en">
    <link rel="stylesheet" href="bootstrap.min.css">
    <link rel="stylesheet" href="index.css">
<?php require '../partials/header.php' ?>
<style>
    .side{
    width: 200px;
    }
    
  </style>
<body >
  <?php require "../partials/navbar.php"?>
    <!----UPDATE PRODUCT BUTTON--->

   

<div class=" d-flex containe  mx-3 ">
<div class="card side">
     
      <a href="create_order.php" class="btn btn-success m-2">Create Order</a>
       </div>
<div class="container ">

 <div style="width:80%;">
  <form action="" method="POST" class="d-flex align-items-end">
    <div>
      <label for="">Created From</label>

    <input type="date" placeholder="dd-mm-yyyy"  min="2022-04-01" max="<?php echo date("Y-m-d");?>"
     value="<?php  if (isset($_POST['start'])){echo  $_POST['start'];}else{echo date("Y-m-d");} ?>" 
     name="start" id="date-start" class="form-control">

    </div>
    
    <div>
    <label for=""> Created To</label>
    <input type="date"   min="2022-04-01" max="<?php echo date("Y-m-d");?>"
     value="<?php  if (isset($_POST['end'])){echo  $_POST['end'];}else{echo date("Y-m-d");} ?>"
       name="end" id="date-stop" class="form-control">
    </div>

    
    <div>
    <select name="status" id="status" class="form-control ">
      <option value="All" >All</option>
      <option value="Pending" active>Pending</option>
      <option value="Cancelled">Cancelled</option>
      <option value="Completed">Completed</option>
 </select>
    </div>
   <?php 
   if(isset($_POST['status'])) : ?>

     <?php if($_POST['status']=='All') : ?>
    <script>
    document.getElementById("status").selectedIndex = 0;
  </script>
    <?php endif ?>

<?php if($_POST['status']=='Pending') : ?>
    <script>
    document.getElementById("status").selectedIndex = 1;
  </script>
    <?php endif ?>

    <?php if($_POST['status']=='Cancelled') : ?>
    <script>
    document.getElementById("status").selectedIndex = 2;
  </script>
    <?php endif ?>

    <?php if($_POST['status']=='Completed') : ?>
    <script>
    document.getElementById("status").selectedIndex = 3;
  </script>
    <?php endif ?>

  <?php endif ?>
   <!-- <input type="text" name="search" id="" placeholder="search" class="form-control">-->
    <button class="btn btn-secondary" onclick="searchDate()">Go</button>
    <div class="d-flex justify-content-between ">
    <span class="fs-4 tex-secondary"> Mpesa Ksh<?php echo $daily_income_mpesa[0]['total'] ?></span>
    <span class="fs-4 text-primary"> Cash Ksh<?php echo $daily_income_cash[0]['total'] ?></span>
    </div>
    </form>
    
   

  </div>
   <table class="table " id="mytable">
  <thead>
    <tr>
     
      <th scope="col">Order No.</th>
      <th scope="col">Date</th>
      <th scope="col">Value</th>
      <th scope="col">Customer</th>
      <th scope="col">Contact</th>
      <th scope="col">Status</th>
      <th scope="col">View</th>



    </tr>
  </thead>
  <tbody >
   <?php
   foreach ($products as $i=> $product) : ?>
 <tr  onclick="change()" class="t-row">
  <?php //getting maker name from DB to display on page
  if ($products[$i]['server_id']){
    
$statement_get_maker=$pdo->prepare("SELECT `name`,`type` FROM `chickenland_pilau`.`users` WHERE `user_id`='".$products[$i]['server_id']."' ");
$statement_get_maker->execute();
$maker_details=$statement_get_maker->fetchAll(PDO::FETCH_ASSOC);
  }
    
    ?>
      
      <th>
      <?php echo $products[$i]['order_id']?>
      </th>
      <td ><?php echo $product['create_date']?></td>
      <td><?php echo $products[$i]['total']?></td>
      <td><?php 
                      echo $products[$i]['cust_name'] ?></td>
        <td><?php 
         echo $products[$i]['phone_number'] ?></td>

      <td><?php echo $product['order_status']?></td>
     <td>
        
      <!-----<button class="btn btn-secondary " onclick="alerti()">View</button>  -->
       
       

       <form method="post" action="serve.php" style="display:flex;" >
       <input type="hidden" name='serial' value="<?php echo $product['order_id']?>">
       <button   type="submit" class="btn btn-sm btn-outline-secondary">Serve</button>
       </form>

       
     </td>
      
  </tr>
   <?php endforeach ?>
    
  </tbody>
</table>
  </div>
  </div>
<script>
  function change(event){
    let row=document.getElementsByClassName('t-row')
    //console.log(event.target)
   // e.target.style.backgroundColor='red'
  }
</script>

</body>

