<?php
//save form 
include("connection.php");
session_start();
if(isset($_SESSION['id']) && isset($_POST['frm'])){
	$id=$_SESSION['id'];
		
	if(isset($_POST['jsonObj'])){
		//extracting question sfrom json
		$json_data=$_POST['jsonObj'];
		
		$json=json_decode($json_data,true);
		
		$i=0;
		
		$frm=$_POST['frm'];
		$secured=$_POST['secured'];
		$header_count=count($json);
		$a=array();
		while($i<$header_count){
				if($json[$i]["type"]!="head" && $json[$i]["type"]!="paragraph"){
					array_push($a,$json[$i]["question"]);
					
				}
				$i=$i+1;
		}
		//add extra features
		array_push($a,"TIME_STAMP");
		array_push($a,"Submitted By");
		array_push($a,"Latitude");
		array_push($a,"Longitude");
		array_push($a,"City");
		array_push($a,"Switched Tab ( Times )");
		// save questions as csv
		$fp=fopen("forms/".$frm.'.csv','w');
		fputcsv($fp,$a);
		fclose($fp);
		//save form in json format
		$fp=fopen("forms/".$frm.'.json','w');
		fwrite($fp,$json_data);
		fclose($fp); 
		//update basic details of form
		$update="update form set secured=".$secured.", last_edited=CURRENT_TIMESTAMP where user_id=".$id." and name='".$frm."'";
		$result=MYSQLi_qUERY($con,$update);
		if($result){
			echo"success";
		}
		else{
			echo"Failure";
		}
		


	}
	//provide authencation credential for accessing  form
	if(isset($_POST['mail']) && isset($_POST['pass']) && isset($_POST['frm']) ){
		$date="9999-12-31 ";
		$time="23:59:59";
		$frm=$_POST['frm'];
		$mail=$_POST['mail'];
		$pass=$_POST['pass'];
		if(isset($_POST['date']) && !empty($_POST['date'])){
			$date=$_POST['date']." ";
			
		}
		if(isset($_POST['time']) && !$_POST['time']=="" ){
			$time=$_POST['time'];
			
		}
		$dt=$date.$time;
		echo $dt;
		$auth_table_insert="insert into auth_table(form,mail,otp,expiry)values('".$frm."','".$mail."','".$pass."','".$dt."')";
		$auth_table_result=mysqli_query($con,$auth_table_insert);
		if($auth_table_result){
			echo"success";
		}
		else{
				echo mysqli_error($con);
		}
		
	}

}
?>