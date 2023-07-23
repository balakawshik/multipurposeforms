<?php
//to edit the form
include("connection.php");
session_start();
if(isset($_GET['frm']) && !empty($_GET['frm'])){
	$my_form_check_query=" select * from form where user_id=".$_SESSION['id']." and name='".$_GET['frm']."'";
	$my_form_check_result=MYSQLi_qUERY($con,$my_form_check_query);
	$is_mine=mysqli_num_rows($my_form_check_result);
	//check form's ownership
	if($is_mine){
		//if form already exist load previous data
		$result=mysqli_fetch_array($my_form_check_result);
		if(file_exists("forms/".$_GET['frm'].".json")){
			echo "<script> pre_json=JSON.parse('".file_get_contents("forms/".$_GET['frm'].".json")."'); form='".$_GET['frm']."'; secured=".$result['secured'].";</script>";
		}
		//otherwise load normal mode that is empty form
		else{
			echo "<script> pre_json=''; form='".$_GET['frm']."';  secured=".$result['secured']."</script>";
		}
	}
	else{
		header("location:index.php");
	}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>	
	<title>Edit</title>
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
	.navbar{
		
		font-family: 'Comfortaa', cursive;
		box-shadow:0 0 15px 0 rgba(200,200,200,0.5),
					0 0 15px 0 rgba(200,200,200,0.3),
					0 0 15px 0 rgba(200,200,200,0.1);
	}
	.nav-item{
		font-size:15px;
	}
	.bg-light,navbar-light{
		background-color:#fff !important;
		width:100%;
	}
	
	.grad{
		background:linear-gradient(#233,#923);
		-webkit-background-clip:text;
		-webkit-text-fill-color:transparent;
	}
	a:hover{
		text-decoration:none;
	}
	div.tools{
		position:fixed;
		right:0;
		top:35vh;
		height:35vh;
		width:5%;
		min-width:2.5em;
		background:linear-gradient(#233,#923);
		border-radius:7px;
		text-align:center;
		z-index:9;
	}
	.tools li{
		list-style:none;
		color:white;
		padding-top:1em;
		height:25%;
		
	}
	#form{
		background-image:linear-gradient(#203030dd,#902030ff);
		border-radius:7px;
	}
	.block:hover{
		
		background-image:linear-gradient(#20303088,#90203088);
	}
	.block{
		width:100%;
		padding:10px;
		background-color:#fff;
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
	.answer{
		width:100%;
		padding:0;
	}
	
	
</style>
</head>
<body>
<nav class="navbar navbar-expand-sm bg-light navbar-light">
		<a class="navbar-brand" href="#"><strong class="grad"><i class="fa fa-wpforms"></i>&nbsp;Bala Forms</strong>
		</a>
		<ul class="navbar-nav navbar-brand ml-auto my-auto">
				
				
				<li class="nav-item" >
					<span class="nav-link"><img class="rounded-circle"
					src=<?php
							//load profile picture
							
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

<!--Tools-->
<div class="tools">
<!--Add new question-->
<li><i id="new" class="fa fa-plus"></i></li>
<!--send forms-->
<li id="save_and_send" data-toggle="modal" data-target="#myModal"><i class="fa fa-paper-plane"></i></li>
<!--secure forms-->
<li><i id="security" class="fa fa-lock"></i></li>
<!--save -form-->
<li><i id="check" class="fa fa-save"></i></li>
</div>
<div class="container">
	<div class="row">
		<div id="form" class="col-12 col-sm-12 col-md-8 offset-md-2 col-lg-8 offset-lg-2 col-xl-8 offset-xl-2">	
		</div>
	</div>
</div>
<!-- The Modal -->
<div class="modal" id="myModal">
	<div class="modal-dialog">
		<div class="modal-content">
			<!-- Modal body -->
			<div class="modal-body">
			<!--shareable form-->
			<div class="nav nav-tabs" id="shareTab" role="tablist">
				<a class="nav-item nav-link" id="linktab" data-toggle="tab" href="#link" role="tab" aria-controls="#link" aria-selected="true"><i class="fa fa-link"></i></a>
				<a class="nav-item nav-link  active" id="mailtab" data-toggle="tab" href="#mail" role="tab" aria-controls="#mail" aria-selected="true"><i class="fa fa-envelope"></i></a>
			</div>
			<div id="shareTabContent" class="tab-content">
				<!--Link of form to share-->
				<div class="tab-pane fade  " id="link" role="tabpanel" aria-labelledby="link-tab">
					<div class="input-group mt-3">
						<input id="copyable_text" type="text" class="form-control" value="http://localhost/Bala%20Forms/response.php?frm=<?php echo $_GET['frm'];?>" disabled>
						<div class="input-group-append">
							<i id="copy_form_link" class="fa form-control input-group-text fa-copy"></i>
						</div>
					</div>
				</div>
				<!--Send mail to share form-->
				<div class="tab-pane fade show active" id="mail" role="tabpanel" aria-labelledby="mail-tab">
					<div class="form-group">
						<label >Expiry</label>
						<div class="form-inline">
							<input id="expiry_date" type="date" class="col form-control">&nbsp;
							<input id="expiry_time" type="time" class="col form-control">
						</div>
					</div>
					<div class="input-group mt-3">
						<input id="mail_ids" type="text" class="form-control" placeholder="abc@gmail.com, xyz@yahoo.com" required> &nbsp;
						<button id="mail_send" class="btn btn-success" >Send</button>
					</div>
					<div id="confirmation_container">
						<div class="form-group">
						<label >Sent</label>
							<div id="confirmation_container_sent"></div>
						</label>
						<div class="form-group">
						<label >Not Sent</label>
							<div id="confirmation_container_not_send"></div>
						</div>
					</div>
					
				</div>
			</div>
		</div>
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
<!--SMTP MAIL scripts-->
<script src="https://smtpjs.com/v3/smtp.js"></script>

<script>
//convert create dform to JSON format
var jsonObj=[];
index=0;
$(document).on("click","#check",function(){
	jsonObj=[];
	$(".block").each(function(){
		QID=$(this).attr("fake_id");
		item={};
		type=$(this).children(".type").val();
		question=$("#question_"+QID).val();
		
		required=false;
		required=$("#required_"+QID).is(":checked");
		
		
		if(type=="number"){
		
			min=$("#min_"+QID).val();
			max=$("#max_"+QID).val();
			hint=$("#hint_"+QID).val();
			required=$("#required_"+QID).val();
			item={"type":type, "min":min,"max":max,"hint":hint,"question":question,"required":required};
			jsonObj.push(item);
			
		}
		
		else if(type=="text"){
			max_length=$("#max_length_"+QID).val();
			hint=$("#hint_"+QID).val();
			item={"type":type, "max_length":max_length,"hint":hint,"question":question,"required":required};
			jsonObj.push(item);
			
		}
		
		else if(type=="head"){
			
			description=$("#description_"+QID).val();
			
			item={"type":type, "question":question,"description":description};
			jsonObj.push(item);
			
		}
		
		else if(type=="paragraph"){
			
			
			description=$("#description_"+QID).val();
			item={"type":type, "question":question,"description":description};
			jsonObj.push(item);
			
		}
		
		else if(type=="textarea"){
			num_rows=$("#num_rows_"+QID).val();
			hint=$("#hint_"+QID).val();
			item={"type":type,"num_rows":num_rows,"hint":hint,"question":question,"required":required};
			jsonObj.push(item);
			
		}
		
		else if(type=="date"){
			min=$("#min_"+QID).val();
			max=$("#max_"+QID).val();
			item={"type":type, "min":min,"max":max,"question":question,"required":required};
			jsonObj.push(item);
			
		}
		
		else if(type=="time"){
			min=$("#min_"+QID).val();
			max=$("#max_"+QID).val();
			item={"type":type, "min":min,"max":max,"question":question,"required":required};
			jsonObj.push(item);
			
		}
		
		else if(type=="color"){
			item={"type":type,"question":question,"required":required};
			jsonObj.push(item);
			
		}	
		
		else if(type=="file"){
			item={"type":type,"question":question,"required":required};
			jsonObj.push(item);
			
			
		}
		
		else if(type=="range"){
			min=$("#min_"+QID).val();
			max=$("#max_"+QID).val();
			step=$("#step_"+QID).val();
			item={"type":type, "min":min,"max":max,"step":step,"question":question,"required":required}
			jsonObj.push(item);
			
			
		}
		else if(type=="radio"){
			item["type"]=type;
			item["options"]={};
			item["required"]=required;
			item['question']=question;
			i=0;
			$("#radio_select_"+QID).children().each(function(){
				
				item.options[i]=$(this).val();
				i=i+1;
			})
			jsonObj.push(item);
		}
		else if(type=="checkbox"){
			item["type"]=type;
			item["options"]={};
			item["required"]=required;
			item['question']=question;
			i=0;
			$("#check_select_"+QID).children().each(function(){
				
				item.options[i]=$(this).val();
				i=i+1;
			})
			jsonObj.push(item);
			
		}
		else if(type=="timer"){
			max=$("#max_"+QID).val();
			item={"type":type,"max":max,"required":required};
			jsonObj.push(item);
			
		}	
		
	
	});
	
	
	$.ajax({
	url:"forms.php",
	type:"post",
	
	data:"jsonObj="+JSON.stringify(jsonObj)+"&frm="+form+"&secured="+secured,
	success:function(data){
			if(data=="success"){
				alert("Form Saved");
			}
			else{
				alert(data);
			}
		}
	});

});
question_id=0;
//handling input types
function element_creation(type_element){
	//get input type
	type=type_element.val();
	QID=type_element.attr("fake_id");
	
	//switching between types
	if(type=="number"){
		//if number add min ,max , hint 
		$(type_element).parent().children("div.answer").html("<div class='form-inline'><input id='min_"+QID+"'  class='form-control'type='number' placeholder='Minimum'>&nbsp;<input id='max_"+QID+"'  class='form-control'type='number' placeholder='Maximum'>&nbsp;<input id='hint_"+QID+"' class='form-control ' placeholder='Hint Text' type='text'></div>");
	}
	else if(type=="head"){
		$(type_element).parent().children("div.answer").html("<div class='form-inline'><input id='description_"+QID+"' class='form-control ' placeholder='Description' type='text'></div>");
	}
	else if(type=="paragraph"){
		$(type_element).parent().children("div.answer").html("<div class='form-inline'><input id='description_"+QID+"' class='form-control ' placeholder='Description' type='text'></div>");
		
	}
	// if text add max length, hint
	else if(type=="text"){
		$(type_element).parent().children("div.answer").html("<div class='form-inline'><input id='max_length_"+QID+"' class='form-control' placeholder='Max length' type='number'>&nbsp;<input id='hint_"+QID+"' class='form-control ' placeholder='Hint Text' type='text'></div>");
	}
	//if paragraph add number of rows, hint
	else if(type=="textarea"){
		$(type_element).parent().children("div.answer").html("<input id='num_rows_"+QID+"' placeholder='Number of Rows' class='form-control' type='text'>&nbsp;<input class='form-control ' id='hint_"+QID+"' placeholder='Hint Text' type='text'>");
	}
	// if date add min and max date
	else if(type=="date"){
		$(type_element).parent().children("div.answer").html("<div class='form-group'><label>Min : &nbsp;</label><input class='form-control' id='min_"+QID+"' type='date'>&nbsp;<label>Max : &nbsp;</label><input id='max_"+QID+"' class='form-control' type='date'></div>");
	}
	//if time add min,max to time
	else if(type=="time"){
		$(type_element).parent().children("div.answer").html("<div class='form-group'><label>Min : &nbsp;</label><input id='min_"+QID+"' class='form-control' type='time'>&nbsp;<label>Max : &nbsp;</label><input id='max_"+QID+"' class='form-control' type='time'></div>");
	}
	//if color color box preview will be added
	else if(type=="color"){
		$(type_element).parent().children("div.answer").html("<input class='mt-2' type='color'>");
		
	}
	//add mix max and step to range
	else if(type=="range"){
		$(type_element).parent().children("div.answer").html("<div class='form-inline'><input class='form-control'type='number' id='min_"+QID+"' placeholder='Minimum'>&nbsp;<input class='form-control'type='number' id='max_"+QID+"' placeholder='Maximum'>&nbsp;<input class='form-control'type='number' id='step_"+QID+"' placeholder='Step'>&nbsp;</div>");
		
	}
	else if(type=="radio"){
		$(type_element).parent().children("div.answer").html("<div class='form-group'><select  id='radio_select_"+QID+"' class='form-control'><option class='deletable_option' disabled>Choose an option</option></select> &nbsp;<br class='d-md'><button fake_id="+QID+"  class='btn btn-success add_radio_option'>Add</button>&nbsp;<button fake_id="+QID+" class='btn btn-danger remove_radio_option'>Remove</button></div>");
		
	}
	else if(type=="checkbox"){
		$(type_element).parent().children("div.answer").html("<div class='form-group'><select multiple id='check_select_"+QID+"' class='form-control'><option class='deletable_option' disabled>Choose an option</option></select> &nbsp;<br class='d-md'><button fake_id="+QID+" class='btn btn-success add_check_option'>Add</button>&nbsp;<button fake_id="+QID+" class='btn btn-danger remove_check_option'>Remove</button></div>");
		
	}
	else if(type=="timer"){
		$(type_element).parent().children("div.answer").html("<div class='form-inline'><input class='form-control'type='number' id='max_"+QID+"'  placeholder='Time In Seconds'></div>");
		
	}
	
	
	
}
//while changing type
$(document).on("change",".type",function(){
	element_creation($(this));
});
// delete a question
$(document).on("click",".fa-trash",function(){
	$(this).parents(".block").remove();
});

//new question creation function
function new_question(){
	$("#form").append(`<div class="block form-inline" fake_id=`+question_id+`>
				
				<input id="question_`+question_id+`" class="form-control col-12 col-sm-6 col-col-md-6 col-lg-6 col-xl-6" type="text" placeholder="Question / Title">
				
				<div class="col-md-1 col-lg-1 col-xl-1"></div>
				
				<select id=type_`+question_id+` value="Type" fake_id=`+question_id+` class="type  form-control col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2" >
					<option value="" readonly>Type</option>
					<option value="head">Title</option>
					<option value="paragraph">Paragraph</option>
					<option value="number">Number</option>
					<option value="text">Single Line Text</option>
					<option value="textarea">Multi Line Text</option>
					<option value="date">Date</option>
					<option value="time">Time</option>
					<option value="color">Color</option>
					<option value="range">Range</option>
					<option value="radio">Radio</option>
					<option value="checkbox">Check Box</option>
					<option value="timer">Timer</option>
					
				</select>
				
				<div class="form-inline col-sm-6 col-md-2 col-lg-2 col-xl-2">
					<input value=1 type="checkbox" fake_id=`+question_id+ ` id="required_`+question_id+`">
					
					&nbsp;
					<label  for="required">Required</label>
				</div>
				<i class="fa fa-trash" fake_id=`+question_id+`></i>
				<div class="answer" id=`+question_id+` ></div>
			</div>
			`);
			question_id=question_id+1;
}
</script>
<script>
// on click new ->new question will be created using function called new_question
$(document).on("click","#new",function(){
	new_question();
});
// add option to radio list
$(document).on("click",".add_radio_option",function(){
	var option=prompt("Enter Option");
	var QID=$(this).attr("fake_id");
	if(option!=""	){
		$("#radio_select_"+QID).append("<option class='deletable_option'>"+option+"</option>");
	}
});
// add option check list
$(document).on("click",".add_check_option",function(){
	var option=prompt("Enter Option");
	var QID=$(this).attr("fake_id");
	if(option!=""	){
		$("#check_select_"+QID).append("<option class='deletable_option'>"+option+"</option>");
	}
});
//remove option form radio list
$(document).on("click",".remove_radio_option",function(){
	var QID=$(this).attr("fake_id");
	$("#radio_select_"+QID+" option:selected").remove();
});
// remove option from check list
$(document).on("click",".remove_check_option",function(){
	var QID=$(this).attr("fake_id");
	$("#check_select_"+QID+" option:selected").remove();
});
$(document).on("focusout",$(".answer").children(),function(){
	console.log("working");
});
function pre_create_element(json,form){
	$.each(json,function(i,item){
		new_question();
		$("#type_"+i).val(item.type);
		$("#question_"+i).val(item.question);
		
		
		type_element=$("#type_"+i)
		type=type_element.val();
		QID=type_element.attr("fake_id");
		if(item.required==true){
			$("#required_"+QID).prop("checked",true);
		}
		
		//switching between types
		if(type=="number"){
			//if number add min ,max , hint 
			$(type_element).parent().children("div.answer").html("<div class='form-inline'><input id='min_"+QID+"'  class='form-control'type='number' value="+item.min+" placeholder='Minimum'>&nbsp;<input id='max_"+QID+"'  class='form-control'type='number' value="+item.max+" placeholder='Maximum'>&nbsp;<input id='hint_"+QID+"' class='form-control ' value='"+item.hint+"' placeholder='Hint Text' type='text'></div>");
		}
		else if(type=="head"){
			$(type_element).parent().children("div.answer").html("<div class='form-inline'><input id='description_"+QID+"' class='form-control ' value='"+item.description+"' placeholder='Description' type='text'></div>");
		}
		else if(type=="paragraph"){
			$(type_element).parent().children("div.answer").html("<div class='form-inline'><input id='description_"+QID+"' class='form-control ' value='"+item.description+"' placeholder='Description' type='text'></div>");
			
		}
		// if text add max length, hint
		else if(type=="text"){
			$(type_element).parent().children("div.answer").html("<div class='form-inline'><input id='max_length_"+QID+"' class='form-control' placeholder='Max length' value="+item.max_length+" type='number'>&nbsp;<input id='hint_"+QID+"' class='form-control ' value='"+item.hint+"' placeholder='Hint Text' type='text'></div>");
		}
		//if paragraph add number of rows, hint
		else if(type=="textarea"){
			$(type_element).parent().children("div.answer").html("<input id='num_rows_"+QID+"' placeholder='Number of Rows' value="+item.num_rows+" class='form-control' type='text'>&nbsp;<input class='form-control ' id='hint_"+QID+"'  value='"+item.hint+"' placeholder='Hint Text' type='text'>");
		}
		// if date add min and max date
		else if(type=="date"){
			$(type_element).parent().children("div.answer").html("<div class='form-group'><label>Min : &nbsp;</label><input class='form-control' id='min_"+QID+"' value="+item.min+" type='date'>&nbsp;<label>Max : &nbsp;</label><input id='max_"+QID+"' value="+item.max+" class='form-control' type='date'></div>");
		}
		//if time add min,max to time
		else if(type=="time"){
			$(type_element).parent().children("div.answer").html("<div class='form-group'><label>Min : &nbsp;</label><input id='min_"+QID+"' value="+item.min+" class='form-control' type='time'>&nbsp;<label>Max : &nbsp;</label><input id='max_"+QID+"' value="+item.max+" class='form-control' type='time'></div>");
		}
		//if color color box preview will be added
		else if(type=="color"){
			$(type_element).parent().children("div.answer").html("<input class='mt-2' type='color'>");
			
		}
		//add mix max and step to range
		else if(type=="range"){
			$(type_element).parent().children("div.answer").html("<div class='form-inline'><input class='form-control'type='number' id='min_"+QID+"'  value="+item.min+" placeholder='Minimum'>&nbsp;<input class='form-control'type='number' id='max_"+QID+"'  value="+item.max+" placeholder='Maximum'>&nbsp;<input class='form-control'type='number' id='step_"+QID+"' value="+item.step+" placeholder='Step'>&nbsp;</div>");
			
		}
		else if(type=="radio"){
			html="<div class='form-group'><select  id='radio_select_"+QID+"' class='form-control'>";
			option_html="";
			$.each(item.options,function(index,option_item){
				if(index==0){
					option_html+="<option class='deletable_option' disabled>Choose an option</option>";
				}
				else{
					option_html+="<option class='deletable_option' >"+item.options[index]+"</option>";
				}
			});
			html+=option_html
			html+="</select> &nbsp;<br class='d-md'><button fake_id="+QID+"  class='btn btn-success add_radio_option'>Add</button>&nbsp;<button fake_id="+QID+" class='btn btn-danger remove_radio_option'>Remove</button></div>"
			$(type_element).parent().children("div.answer").html(html);
			
		}
		else if(type=="checkbox"){
			html="<div class='form-group'><select multiple id='radio_select_"+QID+"' class='form-control'>";
			option_html="";
			$.each(item.options,function(index,option_item){
				if(index=0){
					option_html+="<option class='deletable_option' disabled>Choose an option</option>";
				}
				else{
					option_html+="<option class='deletable_option' >"+item.options[index]+"</option>";
				}
			});
			html+=option_html
			html+="</select> &nbsp;<br class='d-md'><button fake_id="+QID+"  class='btn btn-success add_radio_option'>Add</button>&nbsp;<button fake_id="+QID+" class='btn btn-danger remove_radio_option'>Remove</button></div>"
			$(type_element).parent().children("div.answer").html(html);
		}
		//add mix max and step to timer
		else if(type=="timer"){
			$(type_element).parent().children("div.answer").html("<div class='form-inline'><input class='form-control'type='number' id='max_"+QID+"'  value="+item.max+" placeholder='Maximum'></div>");
			
		}
		
		
		
	});
}

if(pre_json==""){
	new_question();
}
//if form alrady exist load old content
else{
	pre_create_element(pre_json,$("#form"));
	
}
//copy link
$(document).on("click","#copy_form_link",function(){
	var copy=document.getElementById("copyable_text");
	copy.select();
	
	document.execCommand("copy");
	alert("URL Copied: "+copy.value);
});
//OTP Generation
function OTP(n){
	
		characters="0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
		randomString='';
		index=0;
		for(i=0;i<n;i++){
			index=Math.floor(Math.random()*characters.length-1);
			randomString+=characters[index];
		}
		return randomString;
}

//mail sending code
function mail_to_id(mail,content){
	content+="\n"
	if(secured==1){
		pass=OTP(15);
		password="Your password/OTP :  "+pass;
		content+=password;
		date="";
		time="";
		if($("#expiry_date").val()!=""){
			date=$("#expiry_date").val();
			
		}
		if($("#expiry_time").val()){
			time=$("#expiry_time").val();
		}
		$.ajax({
			url:"forms.php",
			data:"frm="+form+"&mail="+mail+"&pass="+pass+"&date="+date+"&time="+time,
			type:"post",
			success:function(data){
				console.log(data)
			}
			
		})
	}
	alert(content);
	msg="";
Email.send({
    SecureToken : "aa745652-0538-43ee-a9c3-545a2b2b9583",
	From : "balakawshik2000@gmail.com",
    //password - 45460B15AC56D70AD0A24DEB2F0E14519052
	//app-password - mhxwsucexwwaxatc
    To : mail,
    Subject : "Fill Up the Form",
    Body : content
}).then(
  message => msg=message
);
	return msg;
	
}

//preprocessing mails
$(document).on("click","#mail_send",function(){
	if($("#mail_ids").val()==""){
		if(!$("#mail_ids").hasClass("is-invalid")){
			$("#mail_ids").addClass("is-invalid");
		}
	}
	else{
		form_link=$("#copyable_text").val();
		mails=$("#mail_ids").val();
		mail_array=mails.split(",");
		$("#confirmation_container_sent").html("");
		$("#confirmation_container_not_sent").html("");
		$.each(mail_array,function(i,item){
			if(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})*(\.\w{2,3})+$/.test(item)){
				mail_id=item.trim();
				success=mail_to_id(mail_id,"Form Link : "+form_link);
				if(success="OK"){
					$("#confirmation_container_sent").append('<div class="input-group mb-3"><input class="form-control is-valid" value="'+mail_id+'" ></div>');
				}
				else{
					$("#confirmation_container_sent").append('<div class="input-group mb-3"><input class="form-control is-invalid" value="'+item+'" ></div>');
				}
			}
			else{
				$("#confirmation_container_not_send").append('<div class="input-group mb-3"><input class="form-control is-invalid" value="'+item+'" ></div>');
			}
		});
	}
});
//checking whether form is secured
$(document).ready(function(){
	if(secured==1){
		$("#security").removeClass("fa-unlock");
		$("#security").addClass("fa-lock");
	}
	else{
		$("#security").removeClass("fa-lock");
		$("#security").addClass("fa-unlock");
	}
});

//toggle between unlock and lock
$(document).on("click","#security",function(){
	if($(this).hasClass("fa-lock")){
		$(this).removeClass("fa-lock");
		$(this).addClass("fa-unlock");
		secured=0;
		
	}
	else if($(this).hasClass("fa-unlock")){
		$(this).removeClass("fa-unlock");
		$(this).addClass("fa-lock");
		secured=1;
	}
});
</script>
</body>
</html>