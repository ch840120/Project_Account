<?php
    //  require_once("db2.php");
     require_once("function.php");
     $link = link_account();
    //  mysqli_query($link,"set names utf8");
     $sql_2  = "select * from items where userId = '".$_SESSION['userId']."' order by id desc";
     $query2 = mysqli_query($link,$sql_2);
     
       
       while($row2 = mysqli_fetch_array($query2))
       {
        echo'
            <tr>
                <td>'.$row2["id"].'</td>
                <td>'.$row2["date"].'</td>
                <td>'.$row2["type"].'</td>
                <td>'.$row2["item"].'</td>
                <td>'.$row2["price"].'</td>
                </tr>';
               
      }     
      
//   <td>'.$row2["id"].'</td>
     
?>