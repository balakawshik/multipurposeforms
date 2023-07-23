<?php
include("connection.php");
session_start();
if(isset($_SESSION['id']) && isset($_POST['frm'])){
	$id=$_SESSION['id'];
	//delete form and related files
	if(isset($_POST['delete'])){
		$delete_form="delete from form where name='".$_POST['frm']."' and user_id=".$id;
		$result=mysqli_query($con,$delete_form);
		if($result){
			 unlink("forms/".$_POST['frm'].".json");
		}
		echo mysqli_error($con);
	}
	//expire form
	if(isset($_POST['expiry']) && $_POST['expiry']=="true"){
		$delete_form="update form set expiry=CURRENT_TIMESTAMP where name='".$_POST['frm']."' and user_id=".$id;
		$result=mysqli_query($con,$delete_form);
		if($result){
			echo"success";
		}
		
	}
	//activate form
	else if(isset($_POST['expiry']) && $_POST['expiry']=="false"){
		$delete_form="update form set expiry='9990-12-31 23:59:00' where name='".$_POST['frm']."' and user_id=".$id;
		$result=mysqli_query($con,$delete_form);
		if($result){
			
		}
		
	}
}
?>