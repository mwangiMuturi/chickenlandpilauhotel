<?php 

require_once('../connection.php');

 
$statement=$pdo->prepare('SELECT * FROM menu ORDER BY serial DESC');
 
$statement->execute();
$products=$statement->fetchAll(PDO::FETCH_ASSOC); 
//var_dump($products);
?>




<!DOCTYPE html>
<html lang="en">
<?php require_once '../partials/header.php' ?>
<body>
    <h1>Update Product</h1>
    <!----UPDATE PRODUCT BUTTON--->

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
<P>
      <a href="create_menu.php" class="btn btn-success">Create Product</a>
      <a href="create_order.php" class="btn btn-success">Create Order</a>

    </P>
    <!------->
</body>
</html>