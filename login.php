<?php
     session_start();
     if(isset($_SESSION["islog"]) && $_SESSION["islog"])
     {
      header("Location: main.php");
     }
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
     <style type="text/css">
     	.i-am-centered { margin: auto; max-width: 300px;}

     </style>
 
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css"/>
    <script type="text/javascript" src="js/jquery.js"></script>
    
  </head>
   
  <body>
  	   <?php include"menu.php"?>
 
 
 <div class="container" >
 	  <div class="i-am-centered" >
    <div class="row">
     
        <div class="col-lg-12" 
                style=" min-height:220px " id="Box">
      <div class="form-group ">     
      <label class="control-label " for="number">
       帳號:
      </label>
      <input class="form-control" id="username" name="username" type="text"/> 
      </div>
      
      <div class="form-group ">  
      <label class="control-label " for="number">
       密碼:
      </label>
      <input class="form-control" id="password" name="password" type="password"/>
      </div>
       
       <br>
       <button class="btn btn-primary  " id="btnlogin" name="btnlogin" type="submit" >
        登入
       </button>
      
        </div>
        </div>
      
  </div>
 </div>
  </body>
</html>

<script>
$(document).ready(function()
{
 $("#btnlogin").click(function()
 {
		if($("#username").val()!="" && $("#password").val()!="" )
		{
		 $.ajax
			({
					url:"verify.php",
					type:"POST",
					data:
				{
						username : $("#username").val(),
						password : $("#password").val(),
					},
					datatype:"json"
				})
				.done(function(data)
				{
					console.log(data);
					
					if(data == "ok")
					{
					   window.location.href ="main.php";
					}
					else
					{
         alert("您輸入的帳號密碼有誤");       
					}
					
				})
				.fail(function(jqXHR, textStatus, errorThrown) 
				{
			   console.log(jqXHR.responseText);
			 });
		}
		else
		{
		 alert("您有欄位沒輸入");
		}
		})
});
</script>