<?php
  session_start();
  require_once("function.php");
 
  $check = verify_user($_POST['username'],$_POST['password']);
   
   if($check)
   {
       echo "ok";
   }
   else
   {
       echo "no";
   }
?>