<?php 

require_once('../connection.php');

 $statement=$pdo->prepare('SELECT * FROM menu ORDER BY serial DESC');
 $statement->execute();
$products=$statement->fetchAll(PDO::FETCH_ASSOC); 
//var_dump($products);
?>


<!DOCTYPE html>
<html lang="en">
  <style>
    .side{
     width: 200px;
    }
  </style>
<?php require_once '../partials/header.php' ?>
<body class="con">
  <?php require_once '../partials/navbar.php' ?>
   <!-- <h3>Update Menu</h3>
    <!----UPDATE PRODUCT BUTTON--->
<div class="d-flex container">

<div class="card side" >
      <a href="create_menu.php" class="btn btn-success m-2">Add Menu Item</a>
     

   </div>
<div class="">
<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Image</th>
      <th scope="col">Title</th>
      <th scope="col">Price</th>
      <th scope="col">Description</th>
      <th scope="col">Action</th>


    </tr>
  </thead>
  <tbody>
   <?php
   foreach ($products as $i=> $product) : ?>
 <tr>
      <th scope="row"><?php echo $i+1?></th>
      <td>
        <img style="width: 50px;" src="<?php echo $product['image']?>" alt="" >
      </td>
      <td><?php echo $product['dish_title']?></td>
      <td><?php echo $product['price']?></td>
      <td><?php echo $product['description']?></td>
     <td>
       <a href="update_menu.php?serial=<?php echo $product['serial'];?>" class="btn btn-sm btn-outline-primary" >Edit</a>

       <form method="post" action="delete.php" style="display:inline-block;" >
       
       <input type="hidden" name='serial' value="<?php echo $product['serial']?>">

       <button   type="submit" class="btn btn-sm btn-outline-danger">Delete</button>

       </form>
      
     </td>
      
  </tr>
   <?php endforeach ?>
    
  </tbody>
</table>
</div>

</div>

    <!------->
</body>
</html>