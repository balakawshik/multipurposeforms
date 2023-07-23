<?php
include("connection.php");
session_start();
if(isset($_SESSION['id']) && isset($_GET['frm'])){
	$frm="forms/".$_GET['frm'].".csv";
	$name=$_GET['frm'];
	$id=$_SESSION['id'];
	//check  form's owner ship
	$is_mine_query="select * from form where user_id=".$id." and name='".$name."'";
	$is_mine_result=MYSQLi_qUERY($con,$is_mine_query);
	$num_rows=mysqli_num_rows($is_mine_result);
	//downloads file
	if($num_rows>0){
		header('Content-Type: application/download');
		header('Content-Disposition: attachment; filename="'.$frm.'"');
		header('Content-Length: '.filesize($frm));
		$fp=fopen($frm,'r');
		fpassthru($fp);
		fclose($fp);
	}
}
?>