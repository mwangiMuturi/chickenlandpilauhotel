<?php
require_once "../connection.php";
require_once "../partials/header.php";

echo "<h2>Menu</h2>";

$statement= $pdo->prepare("SELECT * FROM menu ORDER BY serial DESC");
$statement->execute();
$result= $statement->fetchAll(PDO::FETCH_ASSOC);
?>
<body class="container">
   <div class="container d-flex justify-content-between row">
   <?php
 for ($i=count($result)-1;$i>=0;$i--){
    $img =$result[$i]['image'];
    $title=$result[$i]['dish_title'];
    $desc=$result[$i]['description'];
    $price=$result[$i]['price'];
  echo '<div class="col my-3">';
   echo "<h4>$title</h4>";
   require "../partials/card.php";
   echo '</div>';
}
?> 
   </div>

<a href="review.php" class="btn btn-lg btn-outline-secondary text-info my-2">Make a review</a>


<div style="height: 200;" class="bg-dark"></div>

<a class="btn btn-success" href="sentiment.php">Too long</a>
</body>


<script>
  let card=document.getElementsByClassName('kadi');
  console.log(card)
  for (let i = 0; i < card.length; i++) {   
   card[i].style.display='none'
} 
</script>
