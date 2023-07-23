<!DOCTYPE html>
<html>
<head>
<title>Bala FORMS</title>
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
//submitting form

if(isset($_POST['frm'])&& isset($_POST['submit'])){
	$num_fields=count($_POST)-6;
	$i=0;
	
	$frm=$_POST['frm'];
	//get user responses
	$response_array=array();
	while($i<=$num_fields){
		if(isset($_POST[$i])){
			array_push($response_array,$_POST[$i]);

		}
		$i=$i+1;
	}
	//get location, time, authentication mail
	array_push($response_array,date("F d, Y h:i:s A ",time()));
	session_start();
	
	
	if(isset($_SESSION['auth_mail']) && $_SESSION['auth_mail']!=''){
		array_push($response_array,$_SESSION['auth_mail']);
		include("connection.php");
		$update_auth_table_status="update auth_table set status=1 where form='".$frm."' and mail='".$_SESSION['auth_mail']."'";
		$res=mysqli_query($con,$update_auth_table_status);
	}
	else{
		array_push($response_array,"");
	}
	array_push($response_array,$_POST['lat']);
	array_push($response_array,$_POST['lon']);
	array_push($response_array,$_POST['citi']);
	array_push($response_array,$_POST['switched_tab']);
	$fp=fopen("forms/".$frm.".csv",'a');
	fputcsv($fp,$response_array);
	fclose($fp);
	session_destroy();
	echo"<script>alert('form submitted')</script>";
	echo "<div class='container mt-5'>
			<div class='row'>
				<div class='col-md-4 col-xl-4 col-lg-4'></div>";
	echo"			<div class='col-12 col-sm-12 col-md-4  col-xl-4  col-lg-4 '>";
	echo"				<div align='center'>";
	echo"					<div class='h2'><i class='fa fa-wpforms'></i></div><span class='h2 success'>Form Submitted</small>";
	echo"				</div>";
	echo"			</div>";
	echo"		</div>";
	echo"	</div>";
	echo"</div>";
	
	
	$_POST=array();
}

?>

<script>
if(window.history.replaceState){
	window.history.replaceState(null,null,window.location.href);
}
</script>
</body>
</html>