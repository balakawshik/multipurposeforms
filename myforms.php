<?php
//asssociated with dashboard
include("connection.php");
session_start();

if(isset($_SESSION['id'])){
	$id=$_SESSION['id'];
	//get details of user forms
	$select_user_forms='select title,name,user_id,expiry,secured,created_date,last_edited  ,current_timestamp as now from form where user_id='.$id;
	$result_user_forms=MYSQLi_qUERY($con,$select_user_forms);

	if( $result_user_forms ){
		// display and provide options for accessing forms
		echo"<table class='table table-hover'>";
		echo"	<tr><th>S.No.</th><th>Form Title</th><th>code</th><th>Created</th><th>Updated</th><th>Expire</th></tr>";
		$i=1;
		while($result=mysqli_fetch_array($result_user_forms)){
				$available="checked";
				if($result['expiry']>$result['now']){
					$available="";
				}
				
				echo"<tr>";
				echo"	<th>".$i."</th>";
				echo"	<th>".$result['title']."</th>";
				echo"	<th>".$result['name']."</th>";
				echo"	<th>".$result['created_date']."</th>";
				echo"	<th>".$result['last_edited']."</th>";
				echo"	<th><div class='custom-control custom-switch'>";
				echo"			<input type='checkbox' class='custom-control-input' id='".$result['name']."' ".$available." ><label class='custom-control-label' for='".$result['name']."' ></label>	</div></th>";
				echo"	<th><div class='btn-group'>";
				echo"		<button type='button' id='".$result['name']."' class='dropdown-toggle btn btn-secondary' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>options</button>";
				echo"		<div class='dropdown-menu dropdown-menu-right'>";
				echo"			<a href='edit.php?frm=".$result['name']."'><button class='dropdown-item' type='button'>Edit</button></a>";
				echo"			<a href='responses.php?frm=".$result['name']."'><button class='dropdown-item' type='button'>Responses</button></a>";
				echo"			<button class='dropdown-item delete' fake_id='".$result['name']."' type='button'>Delete</button>";
				echo"		</div>";
				echo"		</div>";
				echo"	</th>";
				
				echo"</tr>";
				$i=$i+1;
		}
		echo"</table>";
	}
	echo mysqli_error($con);
}
?>