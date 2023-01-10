<!DOCTYPE html>
<html>

<?php

$previous = "javascript:history.go(-1)";
if(isset($_SERVER['HTTP_REFERER'])) {
    $previous = $_SERVER['HTTP_REFERER'];
}
session_start();

//var_dump($_SESSION);

require_once "../partials/header.php";
require_once "../connection.php";
$errors=[];



$whoopty=$_SERVER;
///get date and time EAT
$d = new DateTime('now');
$d->setTimezone(new DateTimeZone('EAT'));
$date= $d->format('Y-m-d H:i:s');



if ($_POST){
    //------------------------------------
$content=$_POST['review'];
$telephone=$_POST['telephone'];
$name=$_POST['name'];

//var_dump($content);

if ($_POST['telephone']==""){
    $errors[]='Please enter a valid mobile number';
    
}
if (!$content){
    $errors[]='Please enter the review';
}
if ($_POST['name']==""){
  $errors[]='Please enter your name';
}

if (empty($errors)){
$statement=$pdo->prepare("INSERT INTO reviews (idreviews,create_date,review_content,cust_name,phone_number) VALUES (null,:date_,:review_content,:cust_name,:phone_number)");
$statement->bindValue(':phone_number',$telephone);
$statement->bindValue(':cust_name',$name);
 $statement->bindValue(':date_',$date);
 $statement->bindValue(':review_content',$content);

$statement->execute();
$_SESSION['success']='Review created successfully';
header( "refresh:2;url=review.php" );
} }
?>




<body>
  

    <div class="container my-4">
<a href="menu.php" class="btn btn-success">Home</a> 

        <h4>Contact Us</h4>
<div id="errors" class="alert-danger"></div>

 <hr>
 
<?php if (!empty($errors) ) : ?>   
<div class="alert alert-danger" id="error">
<?php foreach ($errors as $error) : ?>
  <div><?php echo $error ?></div>
  <?php endforeach ?>
</div>
<?php endif ?>

<?php if(isset($_SESSION['success'])) :?>
<div class="alert alert-success">
  <div><?php echo $_SESSION[ 'success'] ;  unset($_SESSION['success']);
  
  ?> </div>
</div>

<?php endif ?>

<span class="alert alert-dange"></span>
<form action="" method="POST" id="form">
<div class="mb-3">
    <label for="exampleInputEmai" class="form-label">Name</label>
    <input type="text" name="name"  class="form-control" id="name" requid value="<?php if ($_POST){echo $_POST['name'];} ?> ">
  
  </div>


  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label"> Your Mobile Number</label>
   <div class="d-flex input-group"><span class="input-group-text">254</span> <input type="tel" name="telephone" id="telephone" class="form-control"  aria-describedby="emailHelp" requir id="e"
    value="<?php if ($_POST){echo $_POST['telephone'];} ?> "> </div>
    <div id="emailHelp" class="form-text">We'll never share your mobile number with anyone else.</div>
  </div>


  <div class="mb-3">
    <label for="review" class="form-label">Review</label>
<textarea name="review" requird id="reviews" class="form-control"><?php  if ($_POST){echo $_POST['review'];}?></textarea>
</div>
 
  <button type="submit" id="sbmit"  class="btn btn-primary" >Submit</button>
</form>
</div>



</body>
<script>
  const names = document.getElementById('name')
const telephone = document.getElementById('telephone')
const form = document.getElementById('form')
const reviews = document.getElementById('reviews')
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

  if (!(/^[a-zA-Z]/.test(reviews.value.trim()))) {
    messages.push('Review must contain alphabetical characters only')
  }

  if (telephone.value.trim().length < 9) {
    
    messages.push('telephone must be at least 9 characters')
    
  }

  if (telephone.value.trim().length > 10) {
    messages.push('telephone is a maximum of 10 characters')
  }

  if (!(/^[0-9]+$/.test(telephone.value.trim()))) {
    messages.push('Mobile number must be digits')
  }
  
  if (messages.length > 0) {
    e.preventDefault()
    errorElement.innerText = messages.join(', ')
  }
})


function arrToUl(arr) {
  var ul = document.createElement('ul'), li;
  for (var i = 0; i < arr.length; i++) {
    if (Array.isArray(arr[i])) {
      li.appendChild(arrToUl(arr[i]));
    } else {
      li = document.createElement('li');
      li.appendChild(document.createTextNode(arr[i]));
      ul.appendChild(li);
    }
  }
  return ul;
}

</script>
</html>

