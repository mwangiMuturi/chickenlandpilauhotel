<?php
require_once '../connection.php';
$errors=[];
 

$title='';
$price='';
$description='';
 if ($_SERVER['REQUEST_METHOD']==='POST'){
    //var_dump($_POST);
   // echo 'yoh';

 $title=$_POST['dish_title'];
 $description=$_POST['description'];
 $price=$_POST['price'];
//var_dump($title);
if(!$title){
$errors[]='Product title required';

}
if (!$price)
{
  $errors[]='Product price is required';
}

if(!is_dir('images')){
  mkdir('images');
}
 
if (empty($errors)){
$image=$_FILES['image']??null;
$imagePath='';
if($image&&$image['tmp_name']){
  $imagePath='images/'.randomString(8).'/'.$image['name'];
 mkdir(dirname($imagePath));
 // exit;
  move_uploaded_file($image['tmp_name'],$imagePath);
}//exit;
 
 $statement=$pdo->prepare("INSERT INTO menu (dish_title, price, description,image) VALUES (:title,:price,:description,:image)");

 $statement->bindValue(':title',$title);
 $statement->bindValue(':image',$imagePath);
 $statement->bindValue(':price',$price);
 $statement->bindValue(':description',$description);
$statement->execute();
echo "<script>alert('successful')</script>";
echo 'done';
header('Location:create_menu.php');
 
}
 }

 function randomString($n){
   $characters='0123456789asdfghjklpoiuytrewqzxcvbnmQWERTYUIOPLKJHGFDSAZXCVBNM';
   $str='';
   for($i=0;$i<$n;$i++){
     $index=rand(0,strlen($characters)-1);
     $str.=$characters[$index];   }
     return $str;
 }
?>
<!DOCTYPE html>
<html lang="en">
<a href="index.php" class="btn-primary btn btn-lg" style="width: 6em;">Dashboard</a>

<?php require_once '../partials/header.php' ?>
<h3>Create Menu Item</h3>
<body class="container d-flex flex-column justify-content-around">
    
   
<!-------ERRORS DIV---->
    <?php if (!empty($errors) ) : ?>   

<div class="alert alert-danger">
<?php foreach ($errors as $error) : ?>
  <div><?php echo $error ?></div>
  <?php endforeach ?>
</div>

<?php endif ?>
<!-------------->


    <form action="" method="POST" autocomplete="off" enctype="multipart/form-data" >
<!--ids are title, price, desc, img, availability -->
        <label for="dish_title" class="btn fs-5">Dish Name</label>
<input name="dish_title" type="text" placeholder="enter dish name" id="title"  class="form-control"> 

<label for="price" class="btn fs-5">Price</label> 
<input type="text" placeholder="enter price" class="form-control"  name="price" id="price" >

<label for="availability"  class="btn fs-5">Availability</label> 
<input type="text" placeholder="availability" name="availability" id="availability"  class="form-control">

<label for="description"  class="btn fs-5">Description</label>
<textarea name="description" id="desc"  cols="30" rows="2"  class="form-control"></textarea>

<label for="dish image"   class="btn fs-5">  Image</label>
 <input type="file" name="image" id="img" accept=".png,.jpg,.jpeg"  class="form-control">

 <button type="submit" id="button" class="btn-success btn fs-5 my-3">Submit</button>
    </form> 
    

</body>
<script src="scriptjs"></script>
</html>