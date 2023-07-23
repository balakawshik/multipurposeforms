<?php
include('connection.php');

//posting signup details

if(isset($_POST['signup']))
{
$name=$_POST['name'];
$number=$_POST['number'];
$mail=$_POST['mail'];
$dob=$_POST['dob'];
$password=$_POST['password'];
$cpassword=$_POST['cpassword'];

$filename=$_FILES['profile']['name'];
$tempname=$_FILES['profile']['tmp_name'];
$folder="profile/".$filename;
move_uploaded_file($tempname,$folder);

if($password==$cpassword)
{
$sql="insert into users ( name,number,mail,dob,password,image)values('".$name."',".$number.",'".$mail."','".$dob."','".$password."','".$folder."')";
$res=mysqli_query($con,$sql);
if($res)
{
	echo"<script>alert('Register Successfully....!');
	window.location.href='index.php';
	</script>";
	
}
else
{
	echo"<script>alert('Register Failed...!');
	</script>";
}
}
else
{
	echo"<script>alert('Password Not Match...!');
	</script>";
}
}
//Login
if(isset($_POST['login']))
{
	$mail=$_POST['mail'];
	$password=$_POST['password'];
	
	$sql="select * from users where mail='".$mail."' and password='".$password."'";
	$res=MYSQLi_qUERY($con,$sql);
	$result=mysqli_fetch_array($res);
	$rt=mysqli_num_rows($res);
	if($rt)
	{
		session_start();
		$_SESSION['id']=$result['id'];
		$img=$result['image'];
									
		echo"<script>alert('Login Success');
		window.location.href='index.php';
		</script>";
	}
	else
	{
		echo"<script>alert('Invalid Username/passowrd');</script>";
	}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Bala Forms</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link href="https://fonts.googleapis.com/css2?family=Comfortaa&display=swap" rel="stylesheet">
	
<style>
	*{
		font-family: 'Comfortaa', cursive;
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
	.navbar{
		
		box-shadow:0 0 15px 0 rgba(200,200,200,0.5),
					0 0 15px 0 rgba(200,200,200,0.3),
					0 0 15px 0 rgba(200,200,200,0.1);
	}
	.bg-light,navbar-light{
		background-color:#fff !important;
		
	}
	.dropdown-toggle:after{
		display: none;
	}
	.dropdown-menu{
		
		width:20em;
		height:20em;
		margin-left:-15em;
		transform:translate3d(0,10px,0);
		position:relative;
		
	}
	.grad{
		background:linear-gradient(#233,#923);
		-webkit-background-clip:text;
		-webkit-text-fill-color:transparent;
	}
	.dropdown-item{
		position:relative;
	}
	::-webkit-scrollbar{
		width:7px;
	}
	::-webkit-scrollbar-track{
		background:#fff;		
	}
	::-webkit-scrollbar-thumb{
		background:linear-gradient(#230,#923);
		border-radius:3px;
	}
	.container{
		width:100%;
		height:100%;
	}
	.row{
		width:100%;
		height:33%;
	}
	.split{
		text-align:center;
		width:33%;
		height:33%;
	}
	.service_name{
		font-size:13px;
	}
	
	.new_launch {
		margin-top:10vh;
		width:100%;
		text-align:center;
		
	}
	
	.new_icon{
		font-size:72px;
		margin: 0 0 0.3em 0;
		
		
	}
	.new_launch div {
		font-weight:400;
		font-size:25px;
		padding:0 0 1em 0;	
			
	}
	.new_launch {
		font-weight:400;
		font-size:20px;
		padding:1em 0 1em 0;	
		
	}
	
	.btn-grad{
		color:white !important;
		background-image:linear-gradient(#233,#923) !important;
		box-shadow:0 0 15px 0 rgba(200,200,200,0.6),
					0 0 15px 0 rgba(200,200,200,0.5),
					0 0 15px 0 rgba(200,200,200,0.3) !important;
	
	}
	.input-group-text,.form-control{
		border: 1px solid;
		border:linear-gradient(#233,#923) !important;
		background-color:#fff;
		
	
	}/* The message box is shown when the user clicks on the password field */
#message {
  display:none;
  background: #fff;
  color: #000;
  border:1px solid #223;
  margin-top: 10px;
  width:80%;
  padding:1em; 
  margin-left:10%;
  margin-bottom:1em;
  border-radius:5px;
  font-size:15px;
}

/* Add a green text color and a checkmark when the requirements are right */
.valid {
  color: green;
}

.valid:before {
  margin-right:0.5em;
  content: "✔";
}

/* Add a red text color and an "x" when the requirements are wrong */
.invalid {
  color: red;
}

.invalid:before {
  margin-right:0.5em;
  content: "✖";
}

</style>
</head>
<body>
	<nav class="navbar navbar-expand bg-light navbar-light">
		<a class="navbar-brand" href="#"><strong class="grad">Bala Forms</strong>
		</a>
		<ul class="navbar-nav navbar-brand ml-auto my-auto">
				<li class="nav-item" ></li>
				<li class="nav-item my-auto pl-4 pl-md-0 ml-0 ml-md-4">
					<span class=" nav-link h3 dropdown">
						<i class="fa fa-th web dropdown-toggle  " role="button" data-toggle="dropdown" ></i></div>
					
					<!--products-->
					<div class="dropdown-menu pre-scrollable ">
						<div class="container">
							<div class="row grad mx-auto my-auto">
								<div class="split">
								<span><a class="h1" href="#"><i class="fa grad fa-wpforms"></i></a></span>
								<div class="service_name">Bala Forms</div>
								</div>
								<div class="split">
								<a class="h1" href="#"><i class="fa grad fa-cogs"></i></a>
								<div class="service_name">Service</div>
								</div>
								<div class="split">
								<a class="h1" href="#"><i class="fa grad fa-forumbee"></i></a>
								<div class="service_name">Bala Com</div>
								</div>
							</div>
							<div class="row mx-auto grad my-auto">
								
								<div class="split">
								<a class="h1" href="#"><i class="fa grad fa-cloud"></i></a>
								<div class="service_name">Bala Cloud</div>
								</div>
								<div class="split">
								<a class="h1" href="#"><i class="fa grad fa-sun-o"></i></a>
								<div class="service_name">Weather</div>
								</div>
								<div class="split">
								<a class="h1" href="#"><i class="fa grad fa-bolt"></i></a>
								<div class="service_name">Intellisense</div>
								</div>
								
							</div>
							<div class="row mx-auto grad my-auto">
								
								<div class="split">
									<span><a class="h1" href="#"><i class="fa grad fa-superpowers"></i></a></span>
									<div class="service_name">Loop</div>
								</div>
								<div class="split">
								<a class="h1" href="#"><i class="fa grad fa-cart-plus"></i></a>
								<div class="service_name">Billing</div>
								</div>
								<div class="split">
								<a class="h1" href="#"><i class="fa grad fa-braille"></i></a>
								<div class="service_name">Braille</div>
								</div>
								
							</div>
							<div class="row mx-auto grad my-auto">
								
								<div class="split">
									<span><a class="h1" href="#"><i class="fa grad fa-youtube"></i></a></span>
									<div class="service_name">Tutorials</div>
								</div>
								<div class="split">
								<a class="h1" href="#"><i class="fa grad fa-facebook"></i></a>
								<div class="service_name">Support</div>
								</div>
								<div class="split">
								<a class="h1" href="#"><i class="fa grad fa-info"></i></a>
								<div class="service_name">About</div>
								</div>
								
							</div>

						</div>
					</div>
					</span>
				</li>
				<!--profile picture-->
				<li class="nav-item" >
					<span class="nav-link"><img class="rounded-circle" data-toggle="modal" data-target="#myModal" 
					src=<?php
							session_start();
							
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
					<!-- The Modal -->
					<div class="modal" id="myModal">
						<div class="modal-dialog">
							<div class="modal-content">
				   
								
				   
								<!-- Modal body -->
								<div class="modal-body">
									<div class="nav nav-tabs" id="credentialTab" role="tablist">
										<a class="nav-item nav-link active" id="logintab" data-toggle="tab" href="#login" role="tab" aria-controls="#login" aria-selected="true">Login</a>
										<a class="nav-item nav-link " id="registertab" data-toggle="tab" href="#register" role="tab" aria-controls="#register" aria-selected="true">Register</a>
									</div>
									<br/>
									<div id="credentialTabContent" class="tab-content">
										<div class="tab-pane fade show active " id="login" role="tabpanel" aria-labelledby="login-tab">
											<form id="login" method="post">
												<div class="input-group mb-3">
													<div class="input-group-prepend">
														<span class="input-group-text">Mail</span>
													</div>
													<input id="mail" type="mail" name="mail" class="form-control" placeholder="Username">
												</div>
												<div class="input-group mb-3">
													<div class="input-group-prepend">
														<span class="input-group-text">🔐</span>
													</div>
													<input id="Login_password" type="password" class="form-control" name="password" placeholder="Password">
													<div class="input-group-append">
											   
														<button type="button" id="eye" class="btn btn-grad" onclick="visibility()">👁</button>

													</div>
												</div>
												<div class="form-group">
													<button id="login" name="login" value="login" class=" btn btn-grad float-right" >Login</button>
												</div>
											   
											</form>
										</div>
										<div class="tab-pane fade  " id="register" role="tabpanel" aria-labelledby="register-tab">
											
											<form id="signup_from" method="post" enctype="multipart/form-data">
												<div class="form-group">
												<div class="input-group mb-3">
													<div class="input-group-prepend">
														<span class="input-group-text">@</span>
													</div>
													<input type="text" name="name" class="form-control" placeholder="Username" required>
												</div>
												
												<div class="input-group mb-3">
													<div class="input-group-prepend">
														<span class="input-group-text">🔐</span>
													</div>
													<input id="password" type="password" class="form-control" name="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" placeholder="Password" required>
												
													<div class="input-group-append">
														<button type="button" id="eye" class="btn btn-grad" onclick="visibility()">👁</button>
													</div>
												</div>
													<div id="message" >
													  <p>Password must contain the following:</p>
													  <p id="letter" class="invalid">A <b>lowercase</b> letter</p>
													  <p id="capital" class="invalid">A <b>capital (uppercase)</b> letter</p>
													  <p id="number" class="invalid">A <b>number</b></p>
													  <p id="length" class="invalid">Minimum <b>8 characters</b></p>
													</div>

												
												<div class="input-group mb-3">
													<div class="input-group-prepend">
														<span class="input-group-text">🔐</span>
													</div>
													<input id="cpassword" type="password" class="form-control" name="cpassword" placeholder="Confirm Password" required>
												</div>
												<div class="input-group mb-3">
													<div class="input-group-prepend">
														<span class="input-group-text">Phone</span>
													</div>
													<input type="text" name="number" class="form-control" placeholder="999-999-9999" required>
												</div>
												
												<div class="input-group mb-3">
													<div class="input-group-prepend">
														<span class="input-group-text">D.O.B</span>
													</div>
													<input type="date" name="dob" class="form-control" required>
												</div>
												<div class="input-group mb-3">
													
														<div class="input-group-prepend">
															<span class="input-group-text">Mail</span>
														</div>
														<input type="email" name="mail" class="form-control" placeholder="xyz@abc.com" required>
													
												</div>
												<div class="custom-file">
													<input type="file" class="custom-file-input" name="profile" id="profile"accept=".png, .jpg, .jpeg" required>
													<label class="custom-file-label" for="profile">Choose Profile</label>
												</div>
												
												<br>
												<br>
												<div class="form-group">
												<div class="float-right">		
													<input id="signing" type="submit" name="signup" value="Submit" class=" btn btn-primary float-right" >
												</div>
												</div>
												
											</form>					
										</div>
									</div>
								</div>
							   
							</div>
							   
						</div>
			   
					</div>
		
		</ul>
		
	</nav>		
	<div class="container ">
		<div class="row ">
			<div class="new_launch mx-auto">
				<i class="fa new_icon grad fa-wpforms"></i>
				<div >
					Bala FORMS
				</div>
				
				<p>One stop Business Solutions</p>
				<a class="btn  btn-grad" href="dashboard.php">Create Free One</a>	
			</div>
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
//change visibility for password
	function visibility (){

		passwordInput=document.getElementById("password");
		if (passwordInput.type == 'password')
		{
			passwordInput.type='text';
			document.getElementById("eye").ClassName ="btn btn-warning";
		}
		else
		{
			passwordInput.type='password';
		
			document.getElementById("eye").ClassName ="btn btn-light";
		}
		passwordInput=document.getElementById("Login_password");
		if (passwordInput.type == 'password')
		{
			passwordInput.type='text';
			
		}
		else
		{
			passwordInput.type='password';
		
			
		}
	 }
	$(document).on("click","#submit",function(event){
		event.preventDefault();
		if($("#mail").val()!="" && $("#password").val()!=""){
		var serial=$("#login").serialize();
		alert(serial);
		}
	});
	var signup=document.getElementById('signup');
	

var myInput = document.getElementById("password");

var letter = document.getElementById("letter");
var capital = document.getElementById("capital");
var number = document.getElementById("number");
var length = document.getElementById("length");

// When the user clicks on the password field, show the message box
myInput.onfocus = function() {

  document.getElementById("message").style.display = "block";
}

// When the user clicks outside of the password field, hide the message box
myInput.onblur = function() {
  document.getElementById("message").style.display = "none";
}

// When the user starts to type something inside the password field
myInput.onkeyup = function() {
  // Validate lowercase letters
  var lowerCaseLetters = /[a-z]/g;
  if(myInput.value.match(lowerCaseLetters)) {
    letter.classList.remove("invalid");
    letter.classList.add("valid");
  } else {
    letter.classList.remove("valid");
    letter.classList.add("invalid");
  }

  // Validate capital letters
  var upperCaseLetters = /[A-Z]/g;
  if(myInput.value.match(upperCaseLetters)) {
    capital.classList.remove("invalid");
    capital.classList.add("valid");
  } else {
    capital.classList.remove("valid");
    capital.classList.add("invalid");
  }

  // Validate numbers
  var numbers = /[0-9]/g;
  if(myInput.value.match(numbers)) {
    number.classList.remove("invalid");
    number.classList.add("valid");
  } else {
    number.classList.remove("valid");
    number.classList.add("invalid");
  }

  // Validate length
  if(myInput.value.length >= 8) {
    length.classList.remove("invalid");
    length.classList.add("valid");
  } else {
    length.classList.remove("valid");
    length.classList.add("invalid");
  }
}
$(document).on("change",".custom-file-input",function(){
	var filename=$(this).val().split("\\").pop();
	$(this).siblings(".custom-file-label").addClass("selected").html(filename);
	});
</script>

</body>	
</html>	