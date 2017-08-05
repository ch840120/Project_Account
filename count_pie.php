<?php
// require_once("db2.php");
session_start();
require_once("function.php");

echo count_pie($_POST["sd"],$_POST["ld"]);

// echo $_POST['sd'];
// echo $_POST['ld'];

?>