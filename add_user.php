<?php
  // require_once("db.php");
  require_once ("function.php");

  $checkregister = add_user($_POST["username"],$_POST["password"],$_POST["nickname"]);
   
  if($checkregister)
  {
      echo "ok";
  }
  else
  {
      echo "no";
  }
?>