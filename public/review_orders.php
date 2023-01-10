<?php 
require_once "../connection.php";

session_start();
var_dump($_SESSION);
$statement=$pdo->prepare("SELECT `order_status`,`create_date`,`maker_id`,`order_id`, sum(`units`*`price`) as 'total'
FROM `order_items` oi
INNER JOIN `order` o ON oi.`order_id fk`=o.`order_id` 
JOIN `menu` m ON m.`serial`=oi.`serial fk` WHERE o.`maker_id`='".$_SESSION['user_id']."'
group by o.`order_id` order by `create_date` DESC; ");
$statement->execute();
$products=$statement->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require_once "../partials/header.php" ?>
    <title></title>
</head>
<body>
    <div class="d-flex align-items-end">
    <h3 class="fs-4">Hello</h3>
    <h3>
    <?php echo '!'.' '. $_SESSION['username'];?>
</h3>
    </div>
   

    <table class="table " id="mytable">
  <thead>
    <tr>   
      <th scope="col">Order No</th>
      <th scope="col">Date</th>
      <th scope="col">Value</th>
      <th scope="col">Status</th>
    </tr>
  </thead>
  <tbody >
   <?php
   foreach ($products as $i=> $product) : ?>
 <tr>
  <?php //getting maker name from DB to display on page
  if ($products[$i]['maker_id']){
    
$statement_get_maker=$pdo->prepare("SELECT `name`,`type` FROM `chickenland_pilau`.`users` WHERE `user_id`='".$products[$i]['maker_id']."' ");
$statement_get_maker->execute();
$maker_details=$statement_get_maker->fetchAll(PDO::FETCH_ASSOC);
  }
    
    ?>
      
      <th>
      <?php echo $products[$i]['order_id']?>
      </th>
      <td ><?php echo $product['create_date']?></td>
      <td><?php echo $products[$i]['total']?></td>
      <td><?php //if($maker_details[0]['name']) {echo $maker_details[0]['name'];} ?></td>
      <td><?php echo $product['order_status']?></td>
     <td>
        
      <!-----<button class="btn btn-secondary " onclick="alerti()">View</button>  -->
       
       
<div class="d-flex" style="width:200px;"> 
<form method="post" action="serve.php" style="display:flex;" class="mx-2">
       <input type="hidden" name='serial' value="<?php echo $product['order_id']?>">
       <button   type="submit" class="btn btn-sm btn-outline-secondary">View</button>
       </form>

       
       <form method="get" action="review.php" style="display:flex;" class="ml-2" >
       <input type="hidden" name='order' value="<?php echo $product['order_id']?>">
       <button   type="submit" class="btn btn-sm btn-outline-primary">Review</button>
       </form>
</div>
      

       
     </td>
      
  </tr>
   <?php endforeach ?>
    
  </tbody>
</table>
</body>
</html>