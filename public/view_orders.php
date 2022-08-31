<?php
require_once '../connection.php';

$statement=$pdo->prepare('SELECT * FROM `order`');
 $statement->execute();
$products=$statement->fetchAll(PDO::FETCH_ASSOC);
//GET TOTAL VALUE-------------------------------------------------------------------------------------------------------
 $statement=$pdo->prepare("
SELECT `order_id`, sum(`units`*`price`) as 'total'
FROM `order_items` oi
INNER JOIN `order` o ON oi.`order_id fk`=o.`order_id` JOIN `menu` m ON m.`serial`=oi.`serial fk` group by o.`order_id`; ");
 $statement->execute();
$order_iid=$statement->fetchAll(PDO::FETCH_ASSOC);

echo '<pre>';
//var_dump($products);
echo '</pre>';
//-----------------------------------------------------------------------------------------------------------------------
?>

<!DOCTYPE html>

<html lang="en">
    <link rel="stylesheet" href="bootstrap.min.css">
    <link rel="stylesheet" href="index.css">
<?php require '../partials/header.php' ?>
<body class="container">
  
    <!----UPDATE PRODUCT BUTTON--->



<table class="table">
  <thead>
    <tr>
     
      <th scope="col">Order No</th>
      <th scope="col">Date</th>
      <th scope="col">Value</th>
      <th scope="col">Status</th>
      <th scope="col">View</th>


    </tr>
  </thead>
  <tbody>
   <?php
   foreach ($products as $i=> $product) : ?>
 <tr>
      
      <th>
      <?php echo $order_iid[$i]['order_id']?>
      </th>
      <td><?php echo $product['create_date']?></td>
      <td><?php echo $order_iid[$i]['total']?></td>
      <td><?php echo $product['order_status']?></td>
     <td>
        
      <!-----<button class="btn btn-secondary " onclick="alerti()">View</button>  -->
       
       <form method="post" action="complete_order.php" style="display:inline-block;" >
       <input type="hidden" name='serialll' value="<?php echo $product['order_id']?>">
       <button   type="submit" class="btn btn-sm btn-outline-primary">Complete</button>
       </form>
       <form method="post" action="cancel_order.php" style="display:inline-block;" >
       <input type="hidden" name='serial' value="<?php echo $product['order_id']?>">
       <button   type="submit" class="btn btn-sm btn-outline-danger">Cancel</button>
       </form>
       
     </td>
      
  </tr>
   <?php endforeach ?>
    
  </tbody>
</table>
</body>
