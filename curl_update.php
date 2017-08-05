<?php
    // require_once("db2.php");
    require_once("function.php");
   
    $result = curl_currency();
    $link = link_account();
    // mysqli_query($link,"set names utf8");
    var_dump($result);
    
       $dollar = 0;
       $cbuy   = 1;
       $csold  = 2;
       $sbuy   = 3;
       $ssold  = 4;  
       
       $sql1 = "truncate table currency";  
       $query = mysqli_query($link,$sql1); 
        
    for($i=0;$i<19;$i++)
    {
         $sql2 = "insert into currency (dollar,cbuy,csold,sbuy,ssold)
                  values(' ".$result[$dollar]."','".$result[$cbuy]."',
                  '".$result[$csold]."','".$result[$sbuy]."',
                  '".$result[$ssold]."')";
//-------------------------------------------------------------------------------- 
                 $query2 = mysqli_query($link,$sql2);       
     
                 $dollar += 5;
                 $cbuy   += 5;
                 $csold  += 5;
                 $sbuy   += 5;
                 $ssold  += 5;
    }
    
//  ".$result[$dollar]."
?>