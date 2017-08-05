<?php
  // require_once("db.php");
  require_once("function.php");

  $check = check_hasname($_POST['usn']);
  
  if($check)
  {
    echo "ok";
  }
  else
  {
    echo "no";
  }
?>