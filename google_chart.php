<?php session_start(); 
     if(!isset($_SESSION["islog"]) or !$_SESSION["islog"])
     {
         header("Location: login.php");
     }
?>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"> 
     
     
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css"/>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript" src="js/jquery.js"></script>

  <script type="text/javascript" src="js/jquery.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>
  </head>
  <body>
      
   <ul class="nav nav-pills">
   <li role="presentation"><a href="main.php">返回主頁</a></li>
   <li role="presentation"><a href="logout.php">登出</a></li>
   </ul>
      
    <h3 align="center">花費比例</h3><br/>
    <div class="col-lg-6" style=" min-height: 400px " >
    
    <div id="piechart_3d" style="width:650px; height: 400px; ">
    </div>
    </div>
       
    <div class="col-lg-4"  style=" min-height: 400px" >
    <br><br><br>    
    <label class="control-label" for="date"><strong>點擊選取開始日期:</strong></label>
    <input class="form-control" id="sdate" name="sdate" placeholder="YYYY/MM/DD" type="text"/>
    <br><br>
    <label class="control-label" for="date"><strong>點擊選取結束日期:</strong></label>
    <input class="form-control" id="ldate" name="ldate" placeholder="YYYY/MM/DD" type="text"/>
    <br><br>
    <button class="btn btn-primary  " id="btnOK" name="btnOK" type="submit" >
    確認
    </button>
   </div>
   
   <div class="col-lg-2"  style=" min-height: 400px" >
   </div>
    
   <h3 align="center">收支表</h3><br/>
   <div class="col-lg-6" style="min-height: 400px " >
   <div id="linechart_material" style="width: 650px; height:400px"></div>
   </div>
    
    <div class="col-lg-4" style=" min-height: 400px " >
    <br><br><br>       
    <label class="control-label" for="date"><strong>點擊選取起始月份:</strong></label>
    <input class="form-control" id="smonth" name="smonth" placeholder="YYYY/MM" type="text"/>
    <br><br>
    <label class="control-label" for="date"><strong>點擊選取結束月份:</strong></label>
    <input class="form-control" id="emonth" name="emonth" placeholder="YYYY/MM" type="text"/>
    <br>
    
    <button class="btn btn-primary  " id="btnMonOK" name="btnMonOK" type="submit" >
    確認
    </button>
   </div>
   
      <div class="col-lg-4" style=" min-height: 400px " >
   
   </div>
   
  </body>
</html>

<script type="text/javascript">
$(document).ready(function(){
  var date_input=$('input[name="sdate"]'); //our date input has the name "date"
  var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
  var options=
  {
    format: 'yyyy-mm-dd',
    container: container,
    todayHighlight: true,
    autoclose: true,
   };
   date_input.datepicker(options);
      
  var date_input=$('input[name="ldate"]'); //our date input has the name "date"
  var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
  var options=
  {
    format: 'yyyy-mm-dd',
    container: container,
    todayHighlight: true,
    autoclose: true,
   };
   date_input.datepicker(options);
      
  var date_input=$('input[name="smonth"]'); //our date input has the name "date"
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
      
   var date_input=$('input[name="emonth"]'); //our date input has the name "date"
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
//---------------------------------------------------------------------------------- 
$(document).ready(function()
{
  $("#btnOK").click(function()
  {
   if($("#sdate").val()!="" && $("#ldate").val()!="")
   {
     google.charts.load("current", {packages:["corechart"]});
     google.charts.setOnLoadCallback(drawChart);
             
    function drawChart() 
    {
     var jsondata = $.ajax
     ({
        url:"count_pie.php",
        type:"POST",
        data:
        {
         'sd' : $("#sdate").val(),
         'ld' : $("#ldate").val()
        },
        async: false,
        datatype:"json"
        }).responseText;
               
        json=JSON.parse(jsondata);
        console.log(json);
        var data = new google.visualization.DataTable();
        data.addColumn('string','items');
        data.addColumn('number','percent');
        data.addRows(json);
            
        var options = 
        {
         is3D: true,
         chartArea:{left:80,top:20,width:'100%',height:'100%'}
        };
        var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
        chart.draw(data,options);  
    }
   }
  })
});
//--------------------------------------------------------------------
$(document).ready(function()
{
 $("#btnMonOK").click(function()
 {
  if($("#smonth").val()!="" && $("#emonth").val()!="")
  {
    google.charts.load('current', {'packages':['line']});
    google.charts.setOnLoadCallback(drawChart);
              
    function drawChart()
    {
     var jsondata = $.ajax
     ({
         url:"count_line.php",
         type:"POST",
         data:
         {
          'sm' : $("#smonth").val(),
          'em' : $("#emonth").val()
         },
         async: false,
         datatype:"json"
      }).responseText;
               
      json=JSON.parse(jsondata);
      console.log(json);
              
      var data = new google.visualization.DataTable();
      data.addColumn('string', 'months');
      data.addColumn('number', '收入');
      data.addColumn('number', '支出');
      data.addRows(json);

      var options = 
      {};
      var chart = new google.charts.Line(document.getElementById('linechart_material'));
       chart.draw(data, google.charts.Line.convertOptions(options));
     }
   }
  })
});
</script>