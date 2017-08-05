<?php
     require_once("function.php");
     $link = link_account();
    //  mysqli_query($link,"set names utf8");
     $sql_3  = "select *from currency";
     $query3 = mysqli_query($link,$sql_3);
     
    while($row3 = mysqli_fetch_array($query3))
    {
        echo'
            <tr>
                <td>'.$row3["dollar"].'</td>
                <td>'.$row3["cbuy"].'</td>
                <td>'.$row3["csold"].'</td>
                <td>'.$row3["sbuy"].'</td>
                <td>'.$row3["ssold"].'</td>
            </tr>';
    }   
    
?>