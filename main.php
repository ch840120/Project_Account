<?php
     session_start();
     
     if(!isset($_SESSION["islog"]) or !$_SESSION["islog"])
     {
         header("Location: login.php");
     }
?>

<!DOCTYPE html>
<html>
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"> 
    
   

  <script type="text/javascript" src="js/jquery.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>

    
    
   <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"/>
    <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/jquery.tabledit.min.js"></script>
    <script type="text/javascript" src="js/jquery.tabledit.js"></script>
  
    </head>
   
   <body>
    <?php require_once("main_menu.php")?> 


<!---->

<div class="container">
    <div class="row">
        
        <div class="col-lg-6" 
                style="min-height: 300px">
         <h3 align="center">台銀外幣匯率</h3><br/>
                 <table class="table table-bordered">
                    <thead>
                     <th>幣別</th>
                     <th>現金匯率買入</th>
                     <th>現金匯率賣出</th>
                     <th>即期匯率買入</th>
                     <th>即期匯率賣出</th>
                    </thead>
                    
                    <tbody id="currency" name="currency" onclick="update_currency()">
                    <?php require_once("update_currency_table.php"); ?>
                    </tbody>
                  </table>
        </div>
<!---->
<div class="col-lg-6" 
                style=" min-height: 400px">
    
         <h3 align="center">記一筆</h3><br/>
         <label class="control-label" for="date"><strong>點擊選取日期:</strong></label>
        <input class="form-control" id="date" name="date" placeholder="YYYY/MM/DD" type="text"/>
      
    </label>

<!---->
      <label class="control-label " for="select">
       種類:
      </label>
      <select class="select form-control" id="type" name="type" onchange="">
       <option value=" 0">
        請選擇:
       </option>
       <option value="1">
        食品飲品
       </option>
       <option value="2">
        醫療保健
       </option>
       <option value="3">
        金融保險
       </option>
       <option value="4">
        休閒娛樂
       </option>
       <option value="5">
        行車交通
       </option>
       <option value="6">
        其他
       </option>
      </select>
<!---->
      <label class="control-label " for="select">
       項目:
      </label>
      <select class="select form-control" id="item" name="item"></select>
<!---->
      <label class="control-label " for="number">
       價格:
      </label>
      <input class="form-control" id="price" name="price" type="text"/>
<!---->
       <br>
       <button class="btn btn-primary " id="add" name="add" type="submit" onclick="">
        新增一筆
       </button>
<!---->
        <br><br>
      
         <label class="control-label" for="month">
         <strong>點擊選取月份:</strong>
         </label>
        <input class="form-control" id="month" name="month" placeholder="YYYY/MM" type="text"/>
        
        <label class="control-label " for="number">
           收入:
      </label>
      
      <input class="form-control" id="income" name="income" type="text" />
      
       <br>
       <button class="btn btn-primary " id="add" name="add" type="submit" onclick="addincome()">
        新增當月份收入
       </button>
      </div>
     </div>
    </div>
   </div>
  </div>
 </div>
</div>
<!---->
        <div class="container">
        <div class="table-responsive">
            <h3 align="center">項目清單</h3><br/>
            <table id="editable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Date</th>
                        <th>Type</th>
                        <th>Item</th>
                        <th>Price</th>
                    </tr>
                </thead>
                
                <tbody id="editbody">
                <?php require_once("update_editable.php");?>
                </tbody>
              </table>
        </div>
       </div> 
    </body>
</html>

<script type="text/javascript" >
var JQ=$.noConflict(); 
JQ(document).ready(function(){
var date_input=$('input[name="date"]'); //our date input has the name "date"
var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
var options=
{
  format: 'yyyy-mm-dd',
  container: container,
  todayHighlight: true,
  autoclose: true,
};
date_input.datepicker(options);
      
var date_input=$('input[name="month"]'); //our date input has the name "date"
var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
var options=
{
 format: 'yyyy-mm',
 container: container,
 todayHighlight: true,
 autoclose: true,
 viewMode: "months", 
 minViewMode: "months"
};
date_input.datepicker(options);
});
// --------------------------------------------
JQ(document).ready(function()
{
JQ('#editable').Tabledit
({
   hideIdentifier: true,
   url: 'edit.php',
   columns: {
   identifier: [0, 'id'],
   editable: [[3, 'item'], [4, 'price']]
},
   restoreButton:false,
   //Activate restore button to undo delete action
   onSuccess:function(data, textStatus,jqXHR)
   // textStatus - 請求狀態 (success, error)
   // jqXHR - XMLHttpRequest Object
{
if(data.action == "delete")
{
 JQ('#'+data.id).remove();
}
}
});
});
// -------------------------------

$("#type").change(function(){
switch (parseInt($(this).val()))
{
 //以type各個Option的Value作為判斷條件
 case 0: 
 $("#item option").remove();
 break;
      
 case 1: 
 $("#item option").remove();
 var array = [ "請選擇","早餐", "午餐", "晚餐", "水果零食", "菸酒茶飲料" ];
 //利用each遍歷array中的值並將每個值新增到Select中
 $.each(array, function(i, val) 
 {
  $("#item").append($("<option value='" + array[i] + "'>" + array[i] + "</option>"));
 });      
  break;
      
 case 2: 
 $("#item option").remove();
 var array = [ "請選擇","生病醫療", "勞健保",  "健康食品", "美容" ];
 //利用each遍歷array中的值並將每個值新增到Select中
 $.each(array, function(i, val)
 {
  $("#item").append($("<option value='" + array[i] + "'>" + array[i] + "</option>"));
 });      
 break;
 
 case 3: 
 $("#item option").remove();
 var array = [ "請選擇","投資理財", "分期付款", "保險", "貸款", "稅捐支出","賠償罰款" ];
 //利用each遍歷array中的值並將每個值新增到Select中
 $.each(array, function(i, val) 
 {
 $("#item").append($("<option value='" + array[i] + "'>" + array[i] + "</option>"));
 });      
 break;
 
 case 4: 
 $("#item option").remove();
 var array = [ "請選擇","運動健身", "休閒玩樂", "朋友聚餐", "旅遊度假" ];
 //利用each遍歷array中的值並將每個值新增到Select中
 $.each(array, function(i, val)
 {
 $("#item").append($("<option value='" + array[i] + "'>" + array[i] + "</option>"));
 });      
 break;
      
 case 5: 
 $("#item option").remove();
 var array = [ "請選擇","汽機車加油", "火車高鐵", "飛機", "計程車", "公共交通","罰單" ];
 //利用each遍歷array中的值並將每個值新增到Select中
 $.each(array, function(i, val) 
 {
  $("#item").append($("<option value='" + array[i] + "'>" + array[i] + "</option>"));
 });      
 break;
      
 case 6: 
 $("#item option").remove();
 var array = [ "請選擇","其他支出", "遺失捨取",  "帳務出錯" ];
 //利用each遍歷array中的值並將每個值新增到Select中
 $.each(array, function(i, val) 
 {
  $("#item").append($("<option value='" + array[i] + "'>" + array[i] + "</option>"));
 });      
      break;
}
});
//------------------------------------------------ 
$(document).ready(function() 
{
$("#add").click(function()
{
if ($("#price").val()>=0
    && $("#price").val()!=""
    && $("#date").val()!=""
    && $("#type").val()!= 0
    && $("#item").val()!= "請選擇"
   )
{
$.ajax
({
  url: "add.php",
  data: 
{
 'date' : $("#date").val(),
 'price': $("#price").val(),
 'type' : $("#type").val(),
 'item' : $("#item").val()
},
  type     :"POST",
  dataType :'json',
})
.done(function(data)
{
 console.log(data);
 alert("新增成功");
 location.reload();
})
.fail(function(jqXHR, textStatus, errorThrown) 
{
  console.log(jqXHR.responseText);
});
} 
})
});
//------------------------------------------------------ 
var addincome=function()
{
 if ($("#month").val()!=""
    && $("#income").val()!="")
 {
   $.ajax
   ({
     url: "add_income.php",
     data: {
            'month' : $("#month").val(),
            'income': $("#income").val()
           },
    type:"POST",
    dataType:'json',
    success: function(data)
    {
      console.log(data);
      alert("新增成功");
    },
    error:function(jqXHR, textStatus, errorThrown)
    { 
     alert(xhr.status); 
     alert(thrownError); 
    }
    });
  } 
}
// ----------------------------------------------
$(document).ready(function()
{
 var myVar = setInterval(function(){update_currency()}, 10000);
 function update_currency()
 {
   $.ajax
   ({
     url:"curl_update.php",
     type:"GET"
   })
   .done(function(data)
   {
    console.log(data);
   })
   .fail(function(jqXHR, textStatus, errorThrown)
   {
		  console.log(jqXHR.responseText);
   }); 
    
   $.ajax
   ({
     url: "update_currency_table.php",
     type:"GET",
   })
   .done(function(data)
   {
    $("#currency").html(data);
      // console.log(data);
   })
   .fail(function(jqXHR, textStatus, errorThrown)
   {
		  console.log(jqXHR.responseText);
   }); 
 }
});
 
</script>