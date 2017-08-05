<?php
// require_once("db2.php");
session_start();
require_once("function.php");

echo count_line($_POST["sm"],$_POST["em"]);

//  echo $_POST['sm'];
//  echo $_POST['em'];

?>