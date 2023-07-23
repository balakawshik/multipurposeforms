<?php
	
	include("connection.php");
	if(isset($_POST['frm']) && isset($_POST['mail']) && isset($_POST['password'])){
		//responder details and form details
		$frm=$_POST['frm'];
		$mail=$_POST['mail'];
		$password=$_POST['password'];
		//fetching user info from authenticaton table of database
		$auth_query="select CURRENT_TIMESTAMP as `now`,expiry,status,otp from auth_table where mail='".$mail."' and form='".$frm."' order by id desc  limit 1";
		
		$auth_result=MYSQLi_qUERY($con,$auth_query);
		$num_rows=mysqli_num_rows($auth_result);
		//if user mail exist and password matches for particular form
		if($num_rows>0){
		
			while($auth_row=mysqli_fetch_array($auth_result)){
				$now=$auth_row['now'];
				$expiry=$auth_row['expiry'];
				$status=$auth_row['status'];
				//checking whether already responded or not
				if($status==1){
					echo file_get_contents("forms/already_submitted.json");
				}
				//checking whether the otp for particular  has expired
				else 
				{	//if not expired collect and send form 
					if($now<$expiry){
						if($auth_row['otp']!=$password){
							echo file_get_contents("forms/invalid.json");
							
						}
						else{
							echo file_get_contents("forms/".$frm.".json",true);
							session_start();
							$_SESSION['auth_mail']=$mail;		
						}
					}
					//if expired send form expired message
					else if($now>$expiry){
						echo file_get_contents("forms/expired_mail.json");
					}
					//if password doesn't match - display error message
				}
			}
		}
		else{
			echo file_get_contents("forms/invalid.json");
		}
		
		
	}
?>