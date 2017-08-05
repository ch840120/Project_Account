<?php
  function link_memeber()
  {
      $link = @mysqli_connect("localhost","root","","member") or die(mysqli_connect_error());
      mysqli_query($link,"set names utf8");
      return $link;
  }
  
  function link_account()
  {
      $link = @mysqli_connect("localhost","root","","account") or die(mysqli_connect_error());
      mysqli_query($link,"set names utf8");
      return $link;
  }

  function check_hasname($username)
  {
      $link = link_memeber();
      $result = false;
      $sql = $link->prepare("select *from member where username = ?");
      $sql->bind_param('s', $username);
      $sql->execute();
      $end = $sql->fetch();
      
      if($end>=1)
      {
        $result = true;
      }
      return $result;
  }
  
  function add_user($username,$password,$nickname)
  {
      $link = link_memeber();
      $result   = false;
      $password = md5($password);
      $sql = "insert into member (username,password,nickname) values('$username','$password','$nickname')";
      $query = mysqli_query($link,$sql);
       
      if($query)
      {
         if(mysqli_affected_rows($link) > 0 )
       {
        //mysqli_affected_rows()確認資料庫有無新增   
          $result = true;
       }
       
      }
      return $result;
  }
  
  function verify_user($username,$password)
  {
    $link = link_memeber();
    $result = false;
    $password = md5($password);
    $sql = $link->prepare("select *from member where username = ? and password = ?");
    $sql->bind_param('ss', $username,$password);
    $sql->execute();
    $end = $sql->fetch();
    
    if($end>=1)
    {
     $_SESSION['islog'] = true;
     $_SESSION['userId'] = $username;
     $result = true;
    }
    return $result;
  }

  function count_pie($sday,$lday)
  {
     $link = link_account();
     mysqli_query($link,"set names utf8");
     $sql_sum ="select sum(price) from items
                where userId = '".$_SESSION['userId']."'and 
                date between '".$sday."'
                and '".$lday."' 
                " ;
               
     $sql_medical_sum ="select sum(price) from items
                        where type = '醫療保健' and 
                        userId = '".$_SESSION['userId']."'and 
                        date between '".$sday."'
                        and '".$lday."'
                        " ;
    
     $sql_food_sum   = "select sum(price) from items
                        where type = '食品飲品' and
                        userId = '".$_SESSION['userId']."'and 
                        date between '".$sday."'
                        and '".$lday."' 
                        " ;
                      
                      
     $sql_traffic_sum = "select sum(price) from items
                         where type = '行車交通' and
                         userId = '".$_SESSION['userId']."'and 
                         date between '".$sday."'
                         and '".$lday."' 
                         " ;
                      
     $sql_else_sum = "select sum(price) from items
                        where type = '其他' and
                        userId ='".$_SESSION['userId']."'and 
                        date between '".$sday."'
                        and '".$lday."' 
                        " ;
    
    $sql_play_sum   = "select sum(price) from items
                        where type = '休閒娛樂' and
                        userId = '".$_SESSION['userId']."'and 
                        date between '".$sday."'
                        and '".$lday."' 
                        " ;
                     
    $sql_financial_sum = "select sum(price) from items
                          where type = '金融保險' and
                          userId = '".$_SESSION['userId']."'and 
                          date between '".$sday."'
                          and '".$lday."' 
                          " ;
//----------------------------------------------------------------------- - 
     $query_sum = mysqli_query($link,$sql_sum);
     
     $query_medical_sum = mysqli_query($link,$sql_medical_sum);
     
     $query_food_sum = mysqli_query($link,$sql_food_sum);
     
     $query_traffic_sum = mysqli_query($link,$sql_traffic_sum);
     
     $query_else_sum = mysqli_query($link,$sql_else_sum);
     
     $query_play_sum = mysqli_query($link,$sql_play_sum);
     
     $query_financial_sum = mysqli_query($link,$sql_financial_sum);
//--------------------------------------------------------------------------  
     $row_sum = mysqli_fetch_assoc($query_sum);
     
     $row_medical_sum = mysqli_fetch_assoc($query_medical_sum);
     
     $row_food_sum = mysqli_fetch_assoc($query_food_sum);
     
     $row_traffic_sum = mysqli_fetch_assoc($query_traffic_sum);
     
     $row_else_sum = mysqli_fetch_assoc($query_else_sum);
     
     $row_play_sum = mysqli_fetch_assoc($query_play_sum);
     
     $row_financial_sum = mysqli_fetch_assoc($query_financial_sum);
//--------------------------------------------------------------------------  
     $medical_percent = $row_medical_sum["sum(price)"]/$row_sum["sum(price)"];
     
     $food_percent = $row_food_sum["sum(price)"]/$row_sum["sum(price)"];
     
     $traffic_percent = $row_traffic_sum["sum(price)"]/$row_sum["sum(price)"];
     
     $else_percent = $row_else_sum["sum(price)"]/$row_sum["sum(price)"];
     
     $play_percent = $row_play_sum["sum(price)"]/$row_sum["sum(price)"];
     
     $financial_percent = $row_financial_sum["sum(price)"]/$row_sum["sum(price)"];
     
     $pie_array = array
                ( 
                  array('醫療保健',(double)$medical_percent),
                  array('食品飲品'   ,(double)$food_percent),
                  array('行車交通',(double)$traffic_percent),
                  array('其他'   ,(double)$else_percent),
                  array('休閒娛樂'   ,(double)$play_percent),
                  array('金融保險',(double)$financial_percent),
                );
                
    $jsonpie = json_encode($pie_array);
    
    return $jsonpie;
  }

  function count_line($smonth,$emonth)
  {
     $link = link_account();
     mysqli_query($link,"set names utf8");
     $smonth = $smonth."-01";
     $emonth = $emonth."-31";    
//------------------------------------------------------------------------------------------------ 
     $sql_spend  = "select sum(price) from items where userId = '".$_SESSION['userId']."'and date between '".$smonth."' and '".$emonth."' group by month(date)";
     //當月支出
     $sql_income = "select money  from income where userId = '".$_SESSION['userId']."'and month  between '".$smonth."' and '".$emonth."'";
     //當月收入
     $sql_month  = "select month  from income where  userId = '".$_SESSION['userId']."'and month  between '".$smonth."' and '".$emonth."'";
//---------------------------------------------------------------------------------
     $query_spend  = mysqli_query($link,$sql_spend);

     $query_income = mysqli_query($link,$sql_income);

     $query_month  = mysqli_query($link,$sql_month);
// --------------------------------------------------------------------------------
     $spend = "";
     $count = 0 ;
     while($row_spend = mysqli_fetch_assoc($query_spend))
     {
      $spend.=$row_spend['sum(price)'].',';
      $count++;
     }
     $spend = explode(',',$spend);

     $income = "";
     while($row_income = mysqli_fetch_assoc($query_income))
     {
      $income.=$row_income['money'].",";
     }
     $income = explode(',',$income);

     $month = "";
     while($row_month = mysqli_fetch_assoc($query_month))
     {
      $month.=$row_month['month'].",";
     }
     $month = explode(',',$month);

     $line_array=array();

     for($i=0;$i<$count;$i++)
     {
      array_push($line_array, array((string)$month[$i],(int)$income[$i],(int)$spend[$i])); 
     }
     $jsonline = json_encode($line_array); 
     return $jsonline;
  }

  function curl_currency()
  {
   header("content-type: text/html; charset=utf-8");
      
   $ch = curl_init();
      
   curl_setopt($ch, CURLOPT_URL, "http://rate.bot.com.tw/xrt?Lang=zh-TW");
   curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
   //CURLOPT_RETURNTRANSFER是要把輸出的內容放到buffer中,可以被echo或者賦予某變量
   curl_setopt($ch, CURLOPT_HEADER, 0);
   //CURLOPT_HEADER是要得到的頭
      
   $pageContent = curl_exec($ch);
   //將curl_exec()獲取的訊息以文件流的形式返回，而不是直接輸出。
   curl_close($ch);
      
   $doc = new DOMDocument();
   libxml_use_internal_errors(true);
   $doc->loadHTML($pageContent);

   $xpath = new DOMXPath($doc);
     
   $currency = array();
       
   for($i=1;$i<20;$i++)
   {
    for($j=1;$j<6;$j++)
    {
      $table = $xpath->query("/html/body/div[1]/main/div[4]/table/tbody/tr[$i]/td[$j]");
      array_push($currency,$table->item(0)->nodeValue);
    }
       
   }
    $number = 0;
    for($i=0;$i<19;$i++)
    {
     $currency[$number] = str_replace(" ","",$currency[$number]);
     $currency[$number] = trim($currency[$number]);
     $currency[$number] = substr($currency[$number],0,17);
    
     $number+=5;
    }
  return $currency;
}
?>
