<html>
   <link rel="stylesheet" href="index.css"> 
   <body class="container">
   

<?php
$previous = "javascript:history.go(-1)";
if(isset($_SERVER['HTTP_REFERER'])) {
    $previous = $_SERVER['HTTP_REFERER'];
}

session_start();
//var_dump($_SESSION);
require_once "../connection.php";
require_once "../partials/header.php";?>
<span class="d-fl">
<a href="view_orders.php" class="btn btn-success">Home</a> 


<h3>Make Order</h3>
</span>

<?php
$statement= $pdo->prepare("SELECT * FROM menu ORDER BY serial DESC");
$statement->execute();
$result= $statement->fetchAll(PDO::FETCH_ASSOC);
//get the highest order number currently

$statement_num= $pdo->prepare("SELECT max(`order_id`) FROM `order`");
$statement_num->execute();
$result_num= $statement_num->fetch(PDO::FETCH_ASSOC);
//var_dump($result_num);
//echo ($result_num ["max(`order_id`)"]);
$highest_order_id= ($result_num ["max(`order_id`)"]) ? $result_num ["max(`order_id`)"] :0;



// Setting  timezone!
date_default_timezone_set('Africa/Nairobi');
$date = date('Y/m/d H:i:s', time());
$status='pending';

//var_dump($_POST);
if ($_POST){
 //   echo $date;
$payment=$_POST['payment'];
echo $payment;
$statement=$pdo->prepare(" INSERT INTO `order` ( `order_id`,`create_date`, `order_status`,`mode` )
                           VALUES ( :highest,:dates, :statuss,:mode)");  
$statement->bindValue(':highest',$highest_order_id+1);
$statement->bindValue(':dates',$date);
$statement->bindValue(':statuss',$status); 
$statement->bindValue(':mode',$payment); 

$statement->execute();
/*
$statement_customer_orders=$pdo->prepare(" INSERT INTO `chickenland_pilau`.`customer_orders` ( `cust_id`,`order_id`)
                                            VALUES (:makersid,:orderid)");
$statement_customer_orders->bindValue(':makersid',$_SESSION['user_id']);
$statement_customer_orders->bindValue(':orderid',$highest_order_id+1);
$statement_customer_orders->execute();
*/
for ($i=count($_POST['units'])-1;$i>=0;$i--){
//echo '<h1>baba</h1>';
$statement_order_items=$pdo->prepare("INSERT INTO order_items (`units`, `order_id fk`, `serial fk`) 
                                      VALUES(:units,:highest,:seriall) ");
$statement_order_items->bindValue(':units', $_POST['units'][$i]);
$statement_order_items->bindValue(':highest',$highest_order_id+1);
$statement_order_items->bindValue(':seriall', $_POST['serial'][$i]);
$statement_order_items->execute();
header('location:create.php');

}}
 
//------------GETTING PRICE AND DISH_TITLE TO BE USED IN CREATING ITEM
/*
$items=[];
if (  $_GET){
 $statement= $pdo->prepare("SELECT price,dish_title FROM menu where serial='".$_GET['id']."'");
$statement->execute();
$items= $statement->fetch(PDO::FETCH_ASSOC);
if (isset($items['dish_title'])){
echo '<pre>';
var_dump($items);
echo '</pre>';
echo $items["dish_title"];
}
}else{
   echo 'ngai';
}
*/
//End of php ---------------------------------------------------------------------------------------------------------

?>
<?php if(isset($_SESSION['success'])) : ?>
<div class="alert alert-success"><?php echo $_SESSION['success'];unset($_SESSION['success']); ?></div> <?php endif ?>
<div class="content">
<table class="table ms-3" style="width: 50%;">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Image</th>
      <th scope="col">Title</th>
      <th scope="col">Price</th>
      <th scope="col">Description</th>
    </tr>
  </thead>
  <tbody>
   <?php
   foreach ($result as $i=> $product) : ?>
 <tr>
      <th scope="row"><?php echo $i+1?></th>
      <td>
        <img style="width: 50px;" src="<?php echo $product['image']?>" alt="" >
      </td>
      <td class="d_title"><?php echo $product['dish_title']?></td>
      <td class="price"><?php echo $product['price']?></td>
      <td><?php echo $product['description']?></td>
     <td>

       <div style="display:inline-block;" >
       <input type="hidden" name='id' value="<?php echo $product['serial']?>">
       <button  value="<?php echo $product['serial']?>"  type="submit" class="btn btn-sm btn-outline-primary choose"
       onclick="this.disabled=true;">Choose Item</button>
         
   </div>
      
     </td>
      
  </tr>
   <?php endforeach ?>
  
   
  </tbody>
</table>

<form action="" method="post" class="card text-center" style="width: 20rem; " id="order_form" >

  <div class="text-center pt-3"><h4>Order Items</h4></div> 
 
   <hr>
   <div class="d-flex fs-6 justify-content-around">
 <div> <input type="radio" name="payment" id="m-pesa" value="M-PESA" onclick=enable()> <Label for="m-pesa" class="m-1"> M-PESA</Label> </div>
<div>  <input type="radio" name="payment" id="cash" value="CASH" onclick=enable()> <Label for="cash" class="m-1">CASH</Label>  </div>
 </div>
<button type="submit" id="continue" class="btn  btn-success form-control" style="position:absolute ; bottom:0;">CONTINUE</button>

      </form>
</div>

<span id="spani"></span>


</body>


<script>

  //SCRIPT FOR CREATE_ORDER.PHP==============================================================================================
 
//const units=document.getElementById('select_units')
//units.addEventListener("change", price_calculator);
//=--------------------------var price=document.getElementById('unit_price').value
//let show_price=document.getElementById('show_price')
//let dish_title=document.getElementsByClassName('d_title')
let choose=document.getElementsByClassName('choose')
for (i=choose.length-1;i>=0;i--){
choose[i].addEventListener('click',choose_item)
   
}
let order_form=document.getElementById('order_form')

//let price=90


/*
function  price_calculator(){
   price=<?php //echo  (int)$result[2]['price'];?>;
  let _price=price*units.value
   console.log(_price)
   show_price.innerHTML=_price
console.log('davie')
}
*/
let formspan

function choose_item(event){
let h=event.target.value

//----------------------------------------------------
let formdiv = document.createElement("div");
formdiv.classList.add('d-flex', 'items')
//const units=document.getElementById('select_unit')
//units.addEventListener("change", price_calculator);

 formspan = document.createElement("span");

formspan.classList.add('btn','order' , 'm-2', 'd-flex' ,'align-items-baseline', 'align-content-center')
formdiv.appendChild(formspan)

order_form.appendChild(formdiv)

//=-------AJAX------------------------------------
var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
                     formspan.innerHTML=xmlhttp.responseText
 }
    };
    xmlhttp.open("POST", "dummy.php?h="+h, true);//value of element
    xmlhttp.send();  
//=--------------------------------------


}


function  price_calculator(){
  let price= getPrice(event)[3].value
  let showp=document.getElementById('showp')
   
  let spani=document.getElementById('spani')
   let units=parseInt (event.target.value)
  
let _price=price*units

   getPrice(event)[2].innerHTML=_price

 

}




let getPrice = function (event) {
 // for collecting siblings
 let siblings = []; 
    // if no parent, return no sibling
    if(!event.target.parentNode) {
        return siblings;
    }
    // first child of the parent node
    let sibling  = event.target.parentNode.firstChild;
    
    // collecting siblings
    while (sibling) {
        if (sibling.nodeType === 1 && sibling !== event.target) {
            siblings.push(sibling);
        }
        sibling = sibling.nextSibling;
    }

    return (siblings);
};
/*
let deleter=document.getElementsByClassName('delete')
for (let i=0; i<=deleter.length; i++) {
  //the rest of the code
  console.log ('delete')
}
*/



function remov(ind){
        //let h=event.target.value
       let choosebtn=document.getElementsByClassName('choose');
       choosebtn[0].disabled=false
        let child=document.getElementById('child')
        child.parentElement.parentElement.remove();
        if (!child.siblings){
        document.getElementById("continue").disabled=true

        }
        console.log(child.siblings)

    }

    let payment=document.getElementsByName("payment");
 if (!(payment[0].checked || payment[1].checked)) {
        document.getElementById("continue").disabled=true
    }
    function enable(){
      if (formspan){
      console.log(formspan);
      document.getElementById("continue").disabled=false

      }
    }
</script>

</html>



