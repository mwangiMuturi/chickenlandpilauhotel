<?php
require_once ("../vendor/autoload.php");
require_once "../vendor/davmixcool/php-sentiment-analyzer/src/analyzer.php";
require_once('../connection.php');


$statement= $pdo->prepare("SELECT review_content FROM reviews");
$statement->execute();
$result= $statement->fetchAll(PDO::FETCH_ASSOC);
var_dump($result);

echo '<h1>run</h1>';
echo 'man of culture';

/*require_once "vadersentiment.php";

$textToTest = "VADER is smart, handsome, and funny.";

$sentimenter =new SentimentIntensityAnalyzer();
$result = $sentimenter->getSentiment($textToTest);

var_dump($result);
*/

Use Sentiment\Analyzer;
$analyzer = new Analyzer(); 
echo $result[1]['review_content'];

for ($i=count($result)-1;$i>=0;$i--){
    echo 'jayz';
$output_text = $analyzer->getSentiment($result[$i]['review_content']);
echo '<pre>';
print_r($output_text ['compound']);
echo '</pre>';
}

//$output_text = $analyzer->getSentiment($result[1]['review_content']);

$output_emoji = $analyzer->getSentiment("😁");

$output_text_with_emoji = $analyzer->getSentiment("Aproko doctor made me funny.");

//print_r($output_text ['compound']);
print_r($output_emoji);
print_r($output_text_with_emoji);

/*
$to = "jamesmuturimwangi7@gmail.com";
$subject = "Review For ChickenLand Pilau";
$txt = "Hello world!";
$headers = "From: jamesmuturimwangi7@gmail.com" . "\r\n";

mail($to,$subject,$txt,$headers);
*/