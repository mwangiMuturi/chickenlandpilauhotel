<?php
require_once '../connection.php';
$statement= $pdo->prepare("SELECT price,dish_title FROM menu where serial='".$_REQUEST['h']."'");
$statement->execute();
$items= $statement->fetch(PDO::FETCH_ASSOC);
//---------------------------------------------
?>
<select name='units[]' id='select_units' class='btn btn-sm 
style='border-radius: 2rem; padding:1px; onchange="price_calculator()">

<option value="1" selected>1</option>
<option value="2">2</option>
<option value="3">3</option>
<option value="4">4</option>
<option value="5">5</option>
<option value="6">6</option>
<option value="7">7</option>
<option value="8">8</option>
<option value="9">9</option>
<option value="10">10</option>
<option value="11">11</option>
<option value="12">12</option>
<option value="13">13</option>
<option value="14">14</option>
<option value="15">15</option>
<option value="16">16</option>
<option value="17">17</option>
</select> 
<p class="btn " id="title"><?php echo $items['dish_title']; ?></p>
<label for="p">Ksh</label>
<span id='showp' value=<?php echo $items['price']?> >  <?php echo $items['price']?>   
</span>
<input type="number" hidden  name="price" id="<?php echo $_REQUEST['h'];?>" value=<?php echo $items['price']?>> 
<input type="text" hidden name="serial[]" value="<?php echo $_REQUEST['h'];?>">

<div class="mx-3" onclick="remov()" id="child"><img src="delete.jpeg" alt="" style="height: 1em;" ></div>
