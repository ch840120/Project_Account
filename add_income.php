<?php
    // require_once("db2.php");
    session_start();
    require_once("function.php");
    $link = link_account();
   
    $input = filter_input_array(INPUT_POST); 
    
    $month = $input["month"]."-01";
    
    $sql="insert into income(month,money,userId)values('".$month."','".$input["income"]."','".$_SESSION['userId']."')";
                     
    mysqli_query($link,$sql);

    echo json_encode($input);
?>