<html>
   <link rel="stylesheet" href="index.css"> 
   <body class="container">
   

<?php
require_once "../connection.php";
require_once "../partials/header.php";?>
<span class="d-fl">
<a href="index.php" class="btn btn-success">Home</a> 
<h1>Create Order</h1>
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
$date = date('Y/m/d', time());
$status='pending';


if ($_POST){
 //   echo $date;
  
$statement=$pdo->prepare(" INSERT INTO `order` ( `order_id`,`create_date`, `order_status`) VALUES ( :highest,:dates, :statuss)");  
$statement->bindValue(':highest',$highest_order_id+1);
$statement->bindValue(':dates',$date);
$statement->bindValue(':statuss',$status); 
$statement->execute();

for ($i=count($_POST['units'])-1;$i>=0;$i--){
//echo '<h1>baba</h1>';


$statement_order_items=$pdo->prepare("INSERT INTO order_items (`units`, `order_id fk`, `serial fk`)   VALUES(:units,:highest,:seriall) ");
$statement_order_items->bindValue(':units', $_POST['units'][$i]);
$statement_order_items->bindValue(':highest',$highest_order_id+1);
$statement_order_items->bindValue(':seriall', $_POST['serial'][$i]);
$statement_order_items->execute();
}
echo '<pre>';
  // var_dump($_POST['units'][0]);
   echo '</pre>';

}
 
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

<form action="" method="post" class="card text-center" style="width: 20rem;" id="order_form">
  <div class="text-center pt-3"><h4>Order Items</h4></div> 
 
   <hr>
<button type="submit" class="btn btn-lg btn-success" style="position:absolute ; bottom:0;">Make Order</button>

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


function choose_item(event){
let h=event.target.value

//----------------------------------------------------
let formdiv = document.createElement("div");
formdiv.classList.add('d-flex', 'items')
//const units=document.getElementById('select_unit')
//units.addEventListener("change", price_calculator);

var formspan = document.createElement("span");

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
        console.log(child.siblings)

    }

</script>

</html>



