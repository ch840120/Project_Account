<?php
   // require_once("db2.php");
   session_start();
 
   require_once("function.php");
   $link = link_account();
   $input=filter_input_array(INPUT_POST);
   
   switch($input["type"])
   {
       case 1:
           $input["type"]="食品飲品";
           break;
       case 2:
           $input["type"]="醫療保健";
           break;
       case 3:
           $input["type"]="金融保險";
           break;
       case 4:
           $input["type"]="休閒娛樂";
           break;
       case 5:
          $input["type"]="行車交通";
           break;
       case 6:
           $input["type"]="其他";
           break;
   }

    $sql="insert into items(date,type,item,price,userId)
          values(    '".$input["date"]."',
                     '".$input["type"]."',
                     '".$input["item"]."',
                     '".$input["price"]."'
                     ,'".$_SESSION['userId']."')";
                     
    mysqli_query($link,$sql);

    echo json_encode($input);
?>