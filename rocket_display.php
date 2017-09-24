<?php

$json = file_get_contents("events.json");

$events = json_decode($json, true);

$todays_events = array_filter($events, function($event) {
    return (string)$event["day"] === "25";
    // return $event["source"] === "UAHEvents";
    // return true;
});


// print_r($todays_events);
?>



<!DOCTYPE html>

<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	
<title> Website </title>
<link href="https://fonts.googleapis.com/css?family=Rubik" rel="stylesheet">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
<style>


body{
	background: url("https://res.cloudinary.com/simpleview/image/upload/c_fill,f_auto,h_752,q_65,w_1110/v1/clients/huntsville/slide1_846c31c3-af0e-4f3a-bff4-6228e3cf1170.jpg") no-repeat center center fixed; 
	-webkit-background-size: cover;
    -moz-background-size: cover;
    -o-background-size: cover;
    background-size: cover;
    font-family: 'Rubik', sans-serif;
	color: white;
}

section, .card {
	background: rgba(0, 0, 0, 0.7);
}
</style>
</head>

<body>
	<div class="container">


<section>
<p> <center> <b> Rocket City, Alabama </b> </center><br><br><br><br><br></p>

</section>

<div class="row">
<?php
foreach ($todays_events as $event) {
?>
    <div class="col-sm-3">
	  <div class="card">
		<img class="card-img-top" src="<?php echo $event["img"]; ?>" alt="Card image cap">
		<div class="card-body">
		  <h4 class="card-title"><?php echo $event["title"]; ?></h4>
          <p class="card-text"><?php echo $event["description"];?></p>
<?php
if ($event["url"] !== "") {
?>
          <a href="<?php echo $event["url"];?>" class="btn btn-primary">Visit Website</a>
<?php
}
?>
		</div>
	  </div>
	</div>
<?php
}
?>
  </div>


<section> 
<p>   <h2><u> Monday, September 26 </h2></u>
<img src= "https://media.giphy.com/media/aCKMaeduKfFXG/giphy.gif" alt= "image not available" style="width:304px;height:228px;"/>

&emsp; Swing Dancing 
&emsp; &emsp; Lowe Mill 
&emsp; &emsp; 7:00 p.m. 
&emsp; &emsp; $7.00 
<br><br><br><br><br></p>
</section>


<section> 
<p>   &emsp; &emsp; &emsp;<u> Tuesday</u> <br/>
&emsp; &emsp; &emsp; Scavenger Hunt
&emsp; &emsp; UAH BCM Building 
&emsp; &emsp; 6:30 p.m.
&emsp; &emsp; $0.00
&emsp; &emsp; <br><br><br><br><br></p>
</section>



<section> 
<p>   
&emsp; &emsp; &emsp; <u>Wednesday </u>
&emsp; &emsp; Fun event
&emsp; &emsp; UAH
&emsp; &emsp; 8:00 p.m.
&emsp; &emsp; $0.00
<br><br><br><br><br></p>
</section>


<section> 
<p>  
&emsp; &emsp; &emsp;<u>Thursday</u>
&emsp; &emsp; Cookie and Canvas
&emsp; &emsp; CU theater
&emsp; &emsp; 6:00 p.m.
&emsp; &emsp; $1.00
<br><br><br><br><br></p>
</section>


<section> 
<p>   
&emsp; &emsp; &emsp;<u> Friday </u>
&emsp; &emsp; High Five Friday
&emsp; &emsp; 9:00 p.m.
&emsp; &emsp; $3.00
<br>
&emsp; &emsp; Concerts on the docks
&emsp; &emsp; 7:00 p.m.
&emsp; &emsp; $0.00

<br><br><br><br><br></p>
</section>


<section> 
<p>   
&emsp; &emsp; &emsp;<u> Saturday </u>
&emsp; &emsp; Fun event
&emsp; &emsp; Space and Rocket Center
&emsp; &emsp; 8:00 p.m.
&emsp; &emsp; $2:00
<br>
<br><br><br><br><br></p>
</section>


<section> 
<p>   
&emsp; &emsp; &emsp;<u> Sunday </u>
&emsp; &emsp; The Well Church
&emsp; &emsp; UAH BAB
&emsp; &emsp; 9:00 a.m.
&emsp; &emsp; $0.00
<br><br><br><br><br></p>
</section>
</div>

</body>


</html>