<!DOCTYPE html>
<html>
<?php
require_once "../partials/header.php";
require_once "../connection.php";
$errors=[];


$email='';
$content='';
$success=['review created successfully'];
$whoopty=$_SERVER;
///get date and time EAT
$d = new DateTime('now');
$d->setTimezone(new DateTimeZone('EAT'));
$date= $d->format('Y-m-d H:i:s');



if ($_POST){
    //------------------------------------
$email=$_POST['email'];
$content=$_POST['review'];
var_dump($content);

if (!$email){
    $errors[]='Please enter a valid email address';
}
if (!$content){
    $errors[]='Please enter the review';
}
if (empty($errors)){
$statement=$pdo->prepare("INSERT INTO reviews (idreviews,email,create_date,review_content) VALUES (null,:email,:date_,:review_content)");
$statement->bindValue(':email',$email);
 $statement->bindValue(':date_',$date);
 $statement->bindValue(':review_content',$content);

$statement->execute();

header('location:review.php');
} }




?>
<body>

    <div class="container my-4">
        <h4>Contact Us</h4>
 <hr>
 
<?php if (!empty($errors) ) : ?>   
<div class="alert alert-danger">
<?php foreach ($errors as $error) : ?>
  <div><?php echo $error ?></div>
  <?php endforeach ?>
</div>
<?php endif ?>

<form action="" method="POST">
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label"> Your Email address</label>
    <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="<?php if ($_POST){echo $_POST['email'];} ?> ">
    <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
  </div>
  <div class="mb-3">
    <label for="review" class="form-label">Review</label>
<textarea name="review" id="" class="form-control"><?php  if ($_POST){echo $_POST['review'];}?></textarea>
</div>
 
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
</div>



</body>
</html>
