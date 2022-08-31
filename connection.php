<?php
//$connection = new mysqli("localhost","root","","chickenland_pilau");
$pdo =new PDO("mysql:host=localhost;port=3306;dbname=chickenland_pilau",'root','');  

 $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
// Check connect
