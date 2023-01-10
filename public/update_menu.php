<?php
require_once '../connection.php';

$id=$_GET['serial']??null;
 
if(!$id){
    header('Location:index.php');
   exit;
}


 

 $statement=$pdo->prepare('SELECT * FROM menu WHERE serial=:id');
 $statement->bindValue(':id',$id);
 $statement->execute();
 $product= $statement->fetch(PDO::FETCH_ASSOC);


 $errors=[];
 

$title=$product['dish_title'];
$price=$product['price'];
$description=$product['description'];
//echo $description;exit;

 if ($_SERVER['REQUEST_METHOD']==='POST'){
    // var_dump($_POST);exit;
 $title=$_POST['title'];
 $description=$_POST['description'];
 $price=$_POST['price'];
 //$id=$_POST['id'];
//$date =date('Y-m-d H:i:s');
var_dump($_POST);
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


$imagePath=$product['image'];

if($image&&$image['tmp_name']){
    if($product['image']){
        unlink($product['image']);
    }
  $imagePath='images/'.randomString(8).'/'.$image['name'];
 mkdir(dirname($imagePath));
 // exit;
  move_uploaded_file($image['tmp_name'],$imagePath);
}//exit;

$statement = $pdo->prepare("UPDATE menu SET dish_title = :dish_title, 
image = :image, 
description = :description, 
price = :price WHERE serial = :id");

 $statement->bindValue(':dish_title',$title);
 $statement->bindValue(':image',$imagePath);
 $statement->bindValue(':description',$description);
 $statement->bindValue(':price',$price);
 $statement->bindValue(':id',$id);
 
$statement->execute();
header('Location:index.php');
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
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/x-icon" href="https://media.istockphoto.com/vectors/flat-icon-check-vector-id496603666?k=20&m=496603666&s=170667a&w=0&h=QOfI-aqzv1dEamb2evpWUvKkukJwtH4YRF_Ugwksk6Y=">

    <!-- Bootstrap CSS -->
    <link href="bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="app.css">
    <title>Create new product</title>
  </head>
  <body class="container mt-2">
      <a href="index.php" class="btn btn-secondary">Go back to previous page</a>
    <h1>Update product <b><?php echo $product['dish_title']?></b></h1>

    <?php if (!empty($errors) ) : ?>   

<div class="alert alert-danger">
<?php foreach ($errors as $error) : ?>
  <div><?php echo $error ?></div>
  <?php endforeach ?>
</div>

<?php endif ?>


    <form action="" method="post" enctype="multipart/form-data">
<?php if($product['image']) :?>
    <img style="width: 100px;" src="<?php echo $product['image']?>" alt="" srcset="">
    <?php endif;?>
    <div class="mb-3 form-group">
    <label  class="form-label">Product Image</label>
    <input type="file" class="form-control"  name="image">
    <div  class="form-text"></div>
  </div>

  <div class="mb-3 form-group">
    <label  class="form-label">Product Title</label>
    <input type="text"class="form-control" name="title" value="<?php echo $title ?>" >
    <div  class="form-text"></div>
  </div>

  <div class="mb-3 form-group">
    <label  class="form-label">Product Description</label>
    <input type="text" class="form-control" name="description" value="<?php echo $description?>"></input>
    <div  class="form-text"></div>
  </div>

  <div class="mb-3 form-group">
    <label  class="form-label">Product Price</label>
    <input type="number" step="1" min=1 class="form-control" name="price" value="<?php echo $price ?>">
    <div  class="form-text"></div>
  </div>  


  <button type="submit" class="btn btn-primary">Submit</button>
</form>
     
  </body> 
</html> 