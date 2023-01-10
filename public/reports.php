<?php  
ob_start();

//require_once "view_orders.php";
//$newproduct=$products;
      // How to Generate CSV File from Array in PHP Script
      function generate($results){      
       
      $filename = 'userData.csv';       
    header("Content-type: text/csv");       
     header("Content-Disposition: attachment; filename=$filename");       
      $output = fopen("repoti", "w");       
      $header = array_keys($results[0]);       
      fputcsv($output, $header);       
      foreach($results as $row)       
      {  
           fputcsv($output, $row);  
      }       
      fclose($output);       
      
    }
ob_end_flush(); 