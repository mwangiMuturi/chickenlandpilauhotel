<?php
require_once '../connection.php';
session_start();

$statement0=$pdo->prepare("SELECT max(`order_id`) as 'serial' from  `order`;");
$statement0->execute();
$order_no=$statement0->fetchAll(PDO::FETCH_ASSOC); 





$statement=$pdo->prepare("
SELECT order_id,price,units,dish_title
FROM `order` o join `order_items` oi on o.`order_id`=oi.`order_id fk` 
JOIN `menu` m on oi.`serial fk`=m.`serial`  where `order_id`='". $order_no[0]['serial']."'; ");
 $statement->execute();
$order_details=$statement->fetchAll(PDO::FETCH_ASSOC);  

require_once "../partials/header.php";
$order_value=0;
if($_POST){
  $statement1=$pdo->prepare("UPDATE chickenland_pilau.`order` SET `cust_name`='".$_POST['name']."' ,
  `phone_number`= '".$_POST['telephone']."'WHERE 	`order_id`='". $order_no[0]['serial']."';");
$statement1->execute();

$_SESSION['success']='Order created successfully';
header('location:create_order.php');
}


?>
<style>
    body{
       
    }
</style>

<body>
 
  <div> <div class="text-centre container d-flex justify-content-between"><p class="fs-4">Pay Via Lipa na M-Pesa Business No. 
    247247 Account Number 0724047444</p></div>
    <div id="errors" class="alert-danger"></div>
    <div class="containe d-flex justify-content-around text-cente m-4 ">
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

<form method="post" action="" id="form" style="display:inline-block;" >
 
 <div class="mb-3">
    <label for="exampleInputEmai" class="form-label"> Name</label>
    <input type="text" name="name" class="form-control" id="name" required value="<?php if ($_POST){echo $_POST['name'];} ?> ">
  
  </div>


  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label"> Mobile Number</label>
   <div class="d-flex input-group"> <span class="input-group-text">254</span> <input type="tel" name="telephone" class="form-control"  
   aria-describedby="emailHelp" required id="telephone"
    value="<?php if ($_POST){echo $_POST['telephone'];} ?> "> </div>
    <div id="emailHelp" class="form-text">We'll never share your mobile number with anyone else.</div>
  </div>


<div class="d-flex justify-content-around">
       <input type="hidden" name='serialll' id="name" value="<?php echo $order_details[0]['order_id']?>">
       <button   type="submit" class="btn btn-outline-primary">Confirm</button>
       </form>
</div>
           
        </div>
    </div>
  </div>
<script> 
const names = document.getElementById('name')
const telephone = document.getElementById('telephone')
const form = document.getElementById('form')

const errorElement = document.getElementById('errors')



form.addEventListener('submit', (e) => {
  let messages = []
  
let myArray=messages

  if (names.value === ' ' || names.value == null) {
    messages.push('Name is required')
  }

  if (!(/^[a-zA-Z]/.test(names.value.trim()))) {
    messages.push('Name must contain alphabetical characters only')
  }


  if (telephone.value.trim().length < 9) {
    console.log(telephone)
    messages.push('telephone must be at least 9 characters')
    
  }

  if (telephone.value.trim().length > 10) {
    messages.push('telephone is a maximum of 10 characters')
    console.log(telephone.value.trim().length)
  }

  if (!(/^[0-9]+$/.test(telephone.value.trim()))) {
    messages.push('Mobile number must be digits')
  }
  
  if (messages.length > 0) {
    e.preventDefault()
    errorElement.innerText = messages.join(', ')
  }
})

</script>
</body>