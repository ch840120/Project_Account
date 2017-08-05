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
 <!---->
 
 <div class="container">
 	  <div class="i-am-centered">
    <div class="row">
        <div class="col-lg-12" 
                style=" min-height: 360px " id="Box">
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
       
      <div class="form-group ">    
      <label class="control-label " for="number">
       確認密碼:
      </label>
      <input class="form-control" id="doublecheck" name="doublecheck" type="password"/>
      </div>
      
      <div class="form-group ">  
      <label class="control-label " for="number">
       暱稱:
      </label>
      <input class="form-control" id="nickname" name="nickname" type="text"/>
      </div>
       <br>
       <button class="btn btn-primary  " id="register" name="register" type="submit" >
        註冊
       </button>
      
        </div>
        </div>
  </div>
 </div>
  </body>
</html>

<script>
// 檢查帳號	
	$(document).ready(function(){
		
		$("#username").on("keyup",function(){
			
			 if($(this).val()!='')
			 {
			 	$.ajax
				({
					url:"check_name.php",
					type:"POST",
					data:
					{
						'usn' : $(this).val()
					},
					datatype:"json"
				}).done(function(data)
				{
					console.log(data);
					if(data == "ok")
					{
					    $("#username").parent().removeClass("has-success").addClass("has-error");
						alert("帳號已使用");
						$("#register").attr("disabled",true);
					}
					else
					{
					    $("#username").parent().removeClass("has-error").addClass("has-success");
					    $("#register").attr("disabled",false);  
					}
					
				}).fail(function(jqXHR, textStatus, errorThrown) {
			      
			        console.log(jqXHR.responseText);
			   });
				
			 }
			 else
			 {
			     $("#username").parent().removeClass("has-success").removeClass("has-error");
			     $("#register").attr("disabled",false);  
			 }
			
		});	
		
//---------------------------------------		
		$("#register").click(function(){
		    
		   if($("#password").val() != $("#doublecheck").val())
		   {
		       $("#password").parent().addClass("has-error");
		       $("#doublecheck").parent().addClass("has-error");
		       alert("密碼不相同");
		   }
		   else
		   {
		   	if($("#username").val()!="" && $("#password").val()!="" && $("#nickname").val()!="")
		   	{
		       $.ajax
				({
					url:"add_user.php",
					type:"POST",
					data:
					{
						username : $("#username").val(),
						password : $("#password").val(),
						nickname : $("#nickname").val()
					},
					datatype:"json"
				}).done(function(data)
				{
					console.log(data);
					
					if(data == "ok")
					{
					  alert("新增成功"+"\n"+"請按確認跳轉到登入");
					  window.location.href ="login.php";
					}
					else
					{
                      alert("新增失敗");
					}
					
				}).fail(function(jqXHR, textStatus, errorThrown) {
			      
			        console.log(jqXHR.responseText);
			   });
			   
		   	}
		   	else
		   	{
		   		alert("您有欄位沒輸入");
		   	}
		   }
		})
		
	});


	
</script>
			

			
			
		