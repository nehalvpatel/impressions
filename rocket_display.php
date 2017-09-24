<?php

$proper_sources = [
    "loweMill" => "Lowe Mill Events",
    "UAHEvents" => "UAH Events",
    "ourValleyEvents" => "Our Valley Events",
    "downtownHuntsville" => "Downtown Huntsville Events"
];

date_default_timezone_set("America/Chicago");

$json = file_get_contents("events.json");

$events = json_decode($json, true);

$todays_date = new DateTime();

$dates = [];
$dates[] = $todays_date;

$days = [];

for ($i = 0; $i < 6; $i++) {
    $next_date = clone $dates[$i];
    $next_date->modify("+1 days");
    $dates[] = $next_date;
}

foreach ($dates as $date) {
    $format = [
        "date" => $date,
        "events" => array_filter($events, function($event) {
            global $date;
            if ($event["source"] === "UAHEvent") {
                return false;
            }
            return DateTime::createFromFormat("j", $event["day"])->format("j") === $date->format("j");
            // return $event["source"] === "UAHEvents";
            // return true;
        })
    ];

    $days[] = $format;
}

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
            body {
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
        <p> <center> <b> Rocket City, Alabama </b> </center></p>
        </section>
<?php
foreach ($days as $day) {
?>
<h3><?php echo $day["date"]->format("l, F j"); ?></h3>
    <div class="row">
<?php
foreach ($day["events"] as $event) {
?>
    <div class="col-sm-3">
	  <div class="card">
		<img class="card-img-top" src="<?php echo $event["img"]; ?>" alt="Card image cap">
		<div class="card-body">
          <h4 class="card-title"><?php echo $event["title"]; ?></h4>
          <span class="badge badge-light"><?php echo $proper_sources[$event["source"]]; ?></span>
          <p class="card-text">
              <?php echo $event["description"];?></p>
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
<?php
}
?>
        </div>
    </body>
</html>