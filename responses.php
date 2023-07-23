<?php
//download responses and World map showing responded people location
include("connection.php");
session_start();
if(isset($_GET['frm']) && !empty($_GET['frm'])){
	$my_form_check_query=" select * from form where user_id=".$_SESSION['id']." and name='".$_GET['frm']."'";
	$my_form_check_result=MYSQLi_qUERY($con,$my_form_check_query);
	$is_mine=mysqli_num_rows($my_form_check_result);
	if($is_mine){
		//if the form is mine the it will load responses
		if(file_exists("forms/".$_GET['frm'].".csv")){
			$form=fopen("forms/".$_GET['frm'].".csv",'r');
			$head=fgetcsv($form);
			$json=array();
			while($data=fgetcsv($form)){
				$json[]=array_combine($head,$data);
				
			}
				
			echo"<script>json='".json_encode($json)."'</script>";
			fclose($form);
		}
		else{
			echo"<script>alert('OOPS.... No responses');</script>";
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
	.navbar{
		font-family: 'Comfortaa', cursive;
		box-shadow:0 0 15px 0 rgba(200,200,200,0.5),
					0 0 15px 0 rgba(200,200,200,0.3),
					0 0 15px 0 rgba(200,200,200,0.1);
	}
	.bg-light,navbar-light{
		background-color:#fff !important;
		
	}
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
							
							//profile picture
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

<a href="download.php?frm=<?php
			if(isset($_GET['frm']) && !empty($_GET['frm'])){
				echo $_GET['frm'];
			}
			?>" ><button class="btn btn-info">DownLoad Responses</button></a>
</nav>
<!--loading scripts-->
<!--JQUERY scripts-->
<script src="js/jquery.min.js"></script>
<!--POPPER scripts-->
<script src="js/popper.min.js"></script>
<!--BOOTSTRAP scripts-->
<script src="js/bootstrap.min.js"></script>
<!--scrpt for statistics-->
<script src="https://cdn.amcharts.com/lib/4/core.js"></script>
<script src="https://cdn.amcharts.com/lib/4/maps.js"></script>
<script src="https://cdn.amcharts.com/lib/4/geodata/worldLow.js"></script>
<script src="https://cdn.amcharts.com/lib/4/themes/animated.js"></script>
<script src="https://cdn.amcharts.com/lib/4/core.js"></script>
<script src="https://cdn.amcharts.com/lib/4/maps.js"></script>
<script src="https://cdn.amcharts.com/lib/4/geodata/worldLow.js"></script>
<script src="https://cdn.amcharts.com/lib/4/themes/animated.js"></script>
<div id="chartdiv"></div>
<script type="text/javascript">
/**
 * ---------------------------------------
 * This demo was created using amCharts 4.
 * 
 * For more information visit:
 * https://www.amcharts.com/
 * 
 * Documentation is available at:
 * https://www.amcharts.com/docs/v4/
 * ---------------------------------------
 */

// Themes begin
am4core.useTheme(am4themes_animated);
// Themes end

// Create map instance
var chart = am4core.create("chartdiv", am4maps.MapChart);

// Set map definition
chart.geodata = am4geodata_worldLow;

// Set projection
chart.projection = new am4maps.projections.Miller();

// Create map polygon series
var polygonSeries = chart.series.push(new am4maps.MapPolygonSeries());

// Exclude Antartica
polygonSeries.exclude = ["AQ"];

// Make map load polygon (like country names) data from GeoJSON
polygonSeries.useGeodata = true;

// Configure series
var polygonTemplate = polygonSeries.mapPolygons.template;
polygonTemplate.tooltipText = "{name}";
polygonTemplate.polygon.fillOpacity = 0.6;


// Create hover state and set alternative fill color
var hs = polygonTemplate.states.create("hover");
hs.properties.fill = chart.colors.getIndex(0);

// Add image series
var imageSeries = chart.series.push(new am4maps.MapImageSeries());
imageSeries.mapImages.template.propertyFields.longitude = "longitude";
imageSeries.mapImages.template.propertyFields.latitude = "latitude";
imageSeries.mapImages.template.tooltipText = "{title}";
imageSeries.mapImages.template.propertyFields.url = "url";


var colorSet = new am4core.ColorSet();
imageSeries.data= [];



var circle = imageSeries.mapImages.template.createChild(am4core.Circle);
circle.radius = 3;
circle.propertyFields.fill = "color";

var circle2 = imageSeries.mapImages.template.createChild(am4core.Circle);
circle2.radius = 3;
circle2.propertyFields.fill = "color";


circle2.events.on("inited", function(event){
  animateBullet(event.target);
})


function animateBullet(circle) {
    var animation = circle.animate([{ property: "scale", from: 1, to: 5 }, { property: "opacity", from: 1, to: 0 }], 1000, am4core.ease.circleOut);
    animation.events.on("animationended", function(event){
      animateBullet(event.target.object);
    })
}

imageSeries.data= [ ];
json=JSON.parse(json);
$.each(json,function(i,item){
item={
  "title": item.City,
  "latitude": parseFloat(item.Latitude),
  "longitude": parseFloat(item.Longitude),
  "color":colorSet.next()
} ;

imageSeries.data.push(item);
});

</script>
<script type="text/javascript">

</script>
</body>
</html>
