<?php
session_start();
if(isset($_SESSION['id'])){
	include("connection.php");
	function getFormName($n){
		//generate random name for form
		$characters="0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
		$randomString='';
		$index=0;
		for($i=0;$i<$n;$i=$i+1){
			$index=rand(0,strlen($characters)-1);
			$randomString.=$characters[$index];
		}
		return $randomString;
	}
	
	// create new form
	if(isset($_POST['new']) && isset($_POST['title']))
	{	//login check for user
		$id=$_SESSION['id'];
		$folder= getFormName(15);
		
		

		$create_form="insert into form (name,user_id,title)values('".$folder."',".$id.",'".$_POST['title']."')";
		$res=mysqli_query($con,$create_form);
		
		if($res)
		{
			echo"success";
		}
		else
		{
			echo"<script>alert('Invalid User name');</script>";
		}
	}
}
?>
