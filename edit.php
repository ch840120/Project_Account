<?php
      header("content-type:text/html; charset=utf-8");
      
      //require_once("db2.php");
      require_once("function.php");
      $link = link_account();
    //   mysqli_query($link,"set names utf8");
      $input = filter_input_array(INPUT_POST);
      //從外部獲取大量輸出
      $item = mysqli_real_escape_string($link,$input["item"]);
      //濾除特殊字符
      
      if($input["action"] ==='edit')
      {
       $query="update items set item='$item',price='".$input["price"]."'where id='".$input['id']."'";
       
       if($input["price"]>=0)
       {
         mysqli_query($link,$query);
       }
       
      }
      
      if($input["action"] === 'delete')
      {
        $result="delete from items where id ='".$input['id']."'";
                     
        $result2="alter table items drop column id;";               
                     
        $result3="alter table items  add id int(11) not null primary key auto_increment first";
            
        mysqli_query($link,$result);
        mysqli_query($link,$result2);
        mysqli_query($link,$result3);
      }
      
      echo json_encode($input);
?>