<!--displaying all forms of particular user-->
<?php
//login check
session_start();
include("connection.php");
if(!isset($_SESSION['id'])){
	echo"<script>alert('Login Please....!');
	window.location.href='index.php';
	</script>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>	
	<title>Dashboard</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link href="https://fonts.googleapis.com/css2?family=Comfortaa&display=swap" rel="stylesheet">
	
<style>
	*{
		
	}
	body{
		
		font-size: 16px;
		line-height: 24px;
		font-weight: 400;
		color: #212112;
		background-image: url("images/bg.svg");
		background-size: 7%;
		background-color: #fff;
		transition: all 200ms linear;
	}
	/*navigation bar styling*/
	.navbar{
		font-family: 'Comfortaa', cursive;
		box-shadow:0 0 15px 0 rgba(200,200,200,0.5),
					0 0 15px 0 rgba(200,200,200,0.3),
					0 0 15px 0 rgba(200,200,200,0.1);
	}
	.bg-light,navbar-light{
		background-color:#fff !important;
		
	}
	/*scrooll bar coloring*/
	.grad{
		background:linear-gradient(#233,#923);
		-webkit-background-clip:text;
		-webkit-text-fill-color:transparent;
	}
	a:hover{
		text-decoration:none;
	}
	#myforms{
		padding:2em 0 0 0.5em;
		
	}
	#forms{
		margin: 1em 0 0 0;
		border:2px solid #223;
		border-radius:5px;
		width:100%;
		font-size:12px;
		font-style:"normal";
	}
</style>
</head>
<body>
<nav class="navbar navbar-expand bg-light navbar-light">
		<a class="navbar-brand" href="#"><strong class="grad"><i class="fa fa-wpforms"></i>&nbsp;Bala Forms</strong>
		</a>
		<ul class="navbar-nav navbar-brand ml-auto my-auto">
				
				
				<li class="nav-item" >
				
					<span class="nav-link"><img class="rounded-circle" 
					src=<?php
							//load profile pictuure
							
							if(isset($_SESSION['id'])){
								$id=$_SESSION['id'];
								$sel="select * from users where id=".$id;
								$res=MYSQLi_qUERY($con,$sel);
								$result=mysqli_fetch_array($res);
								if($res){
									$img=$result['image'];
									echo "'".$img."'";
									
								}
							}
							else{
								echo "'images/factory.jpeg'";
								echo mysqli_error($con);
							}
						
						?>
									style="width:35px; height:35px;"/></span>
				</li>
				<li class="nav-item" >
					<a href="logout.php" ><span class="nav-link">Logout</span></a>
				</li>
				
		</ul>
</nav>
<div id="myforms" class="container">
	My Forms <button id="new" class="btn btn-secondary">New&nbsp;<i class="fa fa-plus"></i></button>
	<div id="forms" class="container" >
	</div>
</div>

<!--loading scripts-->
<!--JQUERY scripts-->
<script src="js/jquery.min.js"></script>
<!--POPPER scripts-->
<script src="js/popper.min.js"></script>
<!--BOOTSTRAP scripts-->
<script src="js/bootstrap.min.js"></script>

<script>
//new form creation
$(document).on("click","#new",function(){
	title=prompt("Enter Form Title");
	if(title!=""){
		
		$.ajax({
			url:"new.php",
			type:"post",
			data:"new=1"+"&title="+title,
			success:function(data){
				
				if(data=="success"){
					myforms();
				}
			}
		});
	}
	else{
		alert("Empty Form Title")
	}
});
//load my forms
function myforms(){
	
	$.ajax({
		url:"myforms.php",
		success:function(data){
			
			$("#forms").html(data);
		}
	});
}
myforms();
//changing expiry of form
$(document).on("change",".custom-control-input",function(){
	expiry=$(this).is(":checked");
	id=$(this).attr("id")
	$.ajax({
		url:"alter_form.php",
		data:"frm="+id+"&expiry="+expiry,
		type:"post",
		success:function(data){
			
		}
	})
});
//delete form
$(document).on("click",".delete",function(){
	id=$(this).attr("fake_id");
	
	$.ajax({
		url:"alter_form.php",
		data:"frm="+id+"&delete=1",
		type:"post",
		success:function(data){
			
			myforms();
		}
	})
});

</script>
</body>
</html>