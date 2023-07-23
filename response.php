<!DOCTYPE html>
<html lang="en">
<head>
	<title></title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link href="https://fonts.googleapis.com/css2?family=Comfortaa&display=swap" rel="stylesheet">
	<!-- purposively loaded script at begining-->
	<script src="js/jquery.min.js"></script>
	<script src="js/popper.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<style>
	.jumbotron{
		background-image:linear-gradient(#203030dd,#902030ff);
		color:white;
	}
	body{
		font-size: 16px;
		line-height: 24px;
		font-weight: 400;
		color: #212112;
		background-image: url("images/bg.svg");
		background-size: 7%;
		background-color: #fff;
		
	}
	.form-group{
		width:100%;
		padding:10px;
		background-image:linear-gradient(#203030dd,#902030ff);
		color:white;
		margin:1em 0 1em 0;
		border-radius:7px;
	}
	.form-control{
		border:none;
		border-bottom:2px solid #aaa;
		margin-top:4px;
	}
	.form-control:focus{
		border:none;
		box-shadow:none;
		border-bottom:2px solid #223;
	}
	.fa{
		color:var(--success);
	}
	.success{
		color:var(--success);
	}	
	</style>
</head>
<body>
<?php
	include("connection.php");
	if(isset($_GET['frm'])){
		$frm=$_GET['frm'];
		
		//check form expiry
				$expiration_query="select expiry,CURRENT_TIMESTAMP as now from form where name='".$frm."'";
				$expiry_result=MYSQLi_qUERY( $con,$expiration_query);
				$num_row=mysqli_num_rows($expiry_result);
				if($num_row){
					//checking form expiration
					$expiry=mysqli_fetch_array($expiry_result);
					if($expiry['expiry']>$expiry['now']){
						//if not expired	load JSON.js
						$security_check_query="select * from form where name='".$frm."'";
						$security_check_result=mysqli_query($con, $security_check_query);
						echo"<script src='JSON.js'></script>";
						//if the form is secured t will ask Auth credentials
						if($security=mysqli_fetch_array( $security_check_result)){
							echo"<input id='form_name' value='".$frm."' type='hidden'></input>";
							if($security['secured']){
								echo "<div class='container mt-5'><div class='row'><div class='col-md-4 col-xl-4 col-lg-4'></div>";
								echo"<div class='col-12 col-sm-12 col-md-4  col-xl-4  col-lg-4 '>";
								echo"<div align='center'>";
								echo"	<div class='h2'><i class='fa fa-lock'></i></div><span class='h6 success'>Secured Form</small>";
								echo"</div>";
								echo"<form method='POST' action='submit.php' class='form_lock'>";
								
								echo"<div class='form-group'>";
								echo"	<label>Mail ID</label>";
								echo"	<input class='form-control' id='unlock_mail' type='mail'></input>";
								echo"</div>";
								echo"<div class='form-group'>";
								echo"	<label>OTP</label>";
								echo"<input class='form-control' id='unlock_password' type='password'></input>";
								echo"<div class='float-right'>";
								echo"<input id='unlock' class='btn btn-primary mt-3' type='button' value='Unlock'></input>";
								echo"</div>";
								echo"</form></div><div class='col-md-3 col-xl-3 col-lg-3'></div></div>";
							}
							//if not secured display the form directly with the help of JSON.js
							else if($security['secured']==0){
								echo "<div class='container mt-5'><div class='row'><div class='col-md-3 col-xl-3 col-lg-3'></div>";
								echo"<div class='col-12 col-sm-12 col-md-6  col-xl-6  col-lg-6 '>";
								echo"<form method='POST' action='submit.php' class='form_lock'>";
								echo"</form></div><div class='col-md-3 col-xl-3 col-lg-3'></div></div>";
								echo"<script>";
								echo'container=$(".form_lock"); ';
								echo"json=JSON.parse('".file_get_contents("forms/".$frm.".json")."'); ";
								echo"console.log(json);";
								echo"create_and_append(json,container);";
								echo"</script>";
								
							}
						}
					}
					//displayed if the form is expired
					else{
						echo"<div class='container mt-5'>";
						echo"	<div class='row'>";
						echo"		<div class='col-md-4 offset-md-4 col-lg-4 offset-lg-4 col-xl-4 offset-lg-4'>";
						echo"			<div class='jumbotron'>";
						echo"				<h3 align='center'> Form expired</h3>";
						echo"				<div align='center'>";
						echo"					@";
						echo"					<p>".$expiry['expiry']."</p>";
						echo"			</div>";
						echo"		</div>";
						echo"	</div>";
						echo"</div>";
					}
				}
				//dislpayed if the form not found
				else{
					echo"<div class='container mt-5'>";
					echo"	<div class='row'>";
					echo"		<div class='col-md-4 offset-md-4 col-lg-4 offset-lg-4 col-xl-4 offset-lg-4'>";
					echo"			<div class='jumbotron'>";
					echo"				<h3 align='center'> No Form Found</h3>";
					echo"				<div align='center'>";
					
					echo"					<p>Kindly Check the URL</p>";
					echo"			</div>";
					echo"		</div>";
					echo"	</div>";
					echo"</div>";
				}
				
	}
	
?>
	
	<script>
	lat="";
	lon="";
	citi="";
	
	//validaate auth credentials and unlock form
		$(document).on("click","#unlock",function(){
			var mail=$("#unlock_mail").val();
			var password=$("#unlock_password").val();
			var form_name=$("#form_name").val();
			if(mail!="" && password!="" && form_name!=""){
				$.ajax({
					url:"secured_forms.php",
					data:"mail="+mail+"&password="+password+"&frm="+form_name,
					type:"post",
					success:function(data){
						
						json=JSON.parse(data);
						container=$(".form_lock");
						create_and_append(json,container);
						var form_name=$("#form_name").val();
						$(".form_lock").append("<input type='hidden' id='frm' name='frm' value="+form_name+"></input>");
					}
				});
			}
			else if(mail==""){
				$("#unlock_mail").addClass("border-danger");
			
			}
			
		});
	var form_name=$("#form_name").val();
	$(".form_lock").append("<input type='hidden' id='frm' name='frm' value="+form_name+"></input>");
	</script>
	<?session_start();?>
</body>
