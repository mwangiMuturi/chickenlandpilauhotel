<?php
require_once ("../vendor/autoload.php");
require_once "../vendor/davmixcool/php-sentiment-analyzer/src/analyzer.php";
require_once('../connection.php');
 require '../partials/header.php' ;

require_once ("../partials/navbar.php");
//time*********************************
$d = new DateTime('now');
$d->setTimezone(new DateTimeZone('EAT'));

$date= $d->format('Y-m-d 00:00:00');
$today= $d->format('Y-m-d 00:00:00');

//the statements ************************************
$statement= $pdo->prepare("SELECT * FROM reviews where `create_date`>'".$today."'  ORDER BY `create_date` DESC");
$statement->execute();

if ($_POST){ 
$orgiDate = $_POST['end'];  
$endDate = date("Y/m/d 23:59:59", strtotime($orgiDate));

  $statement= $pdo->prepare("SELECT * FROM reviews where `create_date`>='".$_POST['start']."' 
  AND `create_date` <= '".$endDate."' ORDER BY `create_date` DESC ");
$statement->execute();
}
$result= $statement->fetchAll(PDO::FETCH_ASSOC);

Use Sentiment\Analyzer;
$analyzer = new Analyzer(); 

?>

<form action="" method="POST" class="d-flex align-items-end container">
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

    <button class="btn btn-secondary" onclick="searchDate()">Go</button>

</form>

<div class="container">
<table class="table" id="mytable">
  <thead>
    <tr>
     
      <th scope="col">#</th>
      <th scope="col">Date</th>
      <th scope="col">Review</th>
      <th scope="col">Customer Name</th>
      <th scope="col">Contact</th>

     
    </tr>
  </thead>
  <tbody >
   <?php
   foreach ($result as $i=> $product) : ?>
 <tr>
  <?php //getting maker name from DB to display on page
  if ($result[$i]['cust_name']){
    
//$statement_get_maker=$pdo->prepare("SELECT `name`,`type` FROM `chickenland_pilau`.`users` WHERE `user_id`='".$result[$i]['maker_id']."' ");
//$statement_get_maker->execute();
//$maker_details=$statement_get_maker->fetchAll(PDO::FETCH_ASSOC);
  }
    
    ?>
      
      <th>
      <?php echo $i+1;?>
      </th>
      <td ><?php echo $product['create_date']?></td>
      <td><?php echo $result[$i]['review_content']?></td>
      <td><?php echo $result[$i]['cust_name']?></td>
      <td><?php echo $result[$i]['phone_number']?></td>
      <?php 
       
$output_text = $analyzer->getSentiment($result[$i]['review_content']);?>
<?php if($output_text['compound']>= 0.05): ?>
<td class="text-succe"><?php echo "Positive"?></td>
<?php endif ?>

<?php if($output_text['compound']<= -0.05): ?>
<td class="text-warning"><?php echo "Negative"?></td>
<?php endif ?>


<?php if($output_text['compound']> -0.05&&$output_text['compound']< 0.05): ?>
<td class="text-primary"><?php echo "Neutral"?></td>
<?php endif ?>


      
     <!-- <td><?php //if($maker_details[0]['name']) {echo $maker_details[0]['name'];} ?></td>-->

     <td>
        
      <!-----<button class="btn btn-secondary " onclick="alerti()">View</button>  
       
       

       <form method="post" action="serve.php" style="display:flex;" >
       <input type="hidden" name='serial' value="<?php // echo $product['order_id']?>">
     <button   type="submit" class="btn btn-sm btn-outline-secondary">Serve</button>
       </form>-->

       
     </td>
      
  </tr>
   <?php endforeach ?>
    
  </tbody>
</table>
</div>
