<?php
require_once '../connection.php';
$statement=$pdo->prepare("
SELECT order_id,price,units,dish_title
FROM `order` o join `order_items` oi on o.`order_id`=oi.`order_id fk` 
JOIN `menu` m on oi.`serial fk`=m.`serial`  where `order_id`='". $_POST['serial']."'; ");
 $statement->execute();
$order_details=$statement->fetchAll(PDO::FETCH_ASSOC);  

require_once "../partials/header.php";
$order_value=0;

?>
<style>
    body{
       
    }
</style>

<body>
    <div class="containe d-flex justify-content-around text-centre m-4 ">
        <div class="card p-3 text-center">
            <h1>Order No. <?php echo $order_details[0]['order_id']?></h1>
            <hr>
            <?php for ($i=count($order_details)-1;$i>=0;$i--): ?>

      <div class="d-flex justify-content-around fs-4 " style="width: 480;">
            <span><?php echo $order_details[$i]['units']?></span>
            <span class="mr-4 fw-bold"><?php echo ucfirst( $order_details[$i]['dish_title'])?></span> 
            <span  class="d-flex">
                <p class="">Ksh&nbsp; </p><?php echo $order_details[$i]['price']* $order_details[$i]['units']?>
            </span> 
            <?php 
            $order_value=$order_value+($order_details[$i]['price']* $order_details[$i]['units']);
            ?>
     </div>
     <hr>
            <?php endfor?>

<div class="d-flex justify-content-around fs-4 ml-4"  ><p class="fw-bold">Total</p> <p>  Ksh&nbsp;
    <?php echo $order_value?>
</p> </div>


<div class="d-flex justify-content-around">
       <form method="post" action="cancel_order.php" style="display:inline-block;" >
       <input type="hidden" name='serial' value="<?php echo $order_details[0]['order_id']?>">
       <button   type="submit" class="btn  btn-outline-danger">Cancel order</button>
       </form>

       <form method="post" action="complete_order.php" style="display:inline-block;" >
       <input type="hidden" name='serialll' value="<?php echo $order_details[0]['order_id']?>">
       <button   type="submit" class="btn btn-outline-primary">Complete order</button>
       </form>
</div>
           
        </div>
    </div>
</body>