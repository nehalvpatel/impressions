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
    $filtered = array_filter($events, function($event) {
        global $date;
        if ($event["source"] === "UAHEvents") {
            return false;
        }
        if (empty($event["timeStart"])) {
            return false;
        }
        return DateTime::createFromFormat("j", $event["day"])->format("j") === $date->format("j");
        // return $event["source"] === "UAHEvents";
        // return true;
    });

    usort($filtered, function($a, $b) {
        $ad = DateTime::createFromFormat("M j h:i A", $a["month"] . " " . $a["day"] . " " . $a["timeStart"]);
        $bd = DateTime::createFromFormat("M j h:i A", $b["month"] . " " . $b["day"] . " " . $b["timeStart"]);
      
        if ($ad == $bd) {
          return 0;
        }
      
        return $ad < $bd ? -1 : 1;
      });

      $format = [
        "date" => $date,
        "events" => $filtered,
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
                background: rgba(0, 0, 0, 0.6);
            }

            h2 {
                font-family: 'Futura';
                color: #fff;
                text-shadow: 0 0 5px #fff, 0 0 10px #fff, 0 0 20px #ff0080, 0 0 30px #ff0080, 0 0 40px #ff0080, 0 0 55px #ff0080, 0 0 75px #ff0080;
                text-align: center;
            }
        </style>
    </head>
<body>
	<div class="container">
        <h2 class="mt-4">Rocket City, Alabama</h2>
<?php
foreach ($days as $day) {
?>
<div class="date">
<br>
<h3 style="text-shadow: 3px 2px blue;"><?php echo $day["date"]->format("l, F j"); ?></h3>
<br>
</div>
    <div class="card-columns">
<?php
foreach ($day["events"] as $event) {
?>
    <!-- <div class="col-sm-3"> -->
	  <div class="card">
<?php
if (!empty($event["img"])) {
?>
        <img class="card-img-top" src="<?php echo $event["img"]; ?>" alt="<?php echo $event["title"]; ?>">
<?php
}
?>
		<div class="card-body">
          <h4 class="card-title"><?php echo $event["title"]; ?></h4>
          <span class="badge badge-light"><?php echo $event["location"]; ?></span>
<?php
if (!empty($event["timeStart"]) && !empty($event["timeEnd"])) {
?>
          <span class="badge badge-info"><?php echo $event["timeStart"] . " - " . $event["timeEnd"]; ?></span>
<?php
} else if (!empty($event["timeStart"])) {
?>
          <span class="badge badge-info"><?php echo $event["timeStart"]; ?></span>
<?php
}

$class = "";
if (!empty($event["description"]) || !empty($event["url"])) {
    $class = "mt-3";
}
?>
<div class="<?php echo $class; ?>">
<?php
if (!empty($event["description"])) {
?>
          <p class="card-text"><?php echo $event["description"]; ?></p>
<?php
}
if (!empty($event["url"])) {
?>
          <a href="<?php echo $event["url"]; ?>" class="btn btn-info">Visit Website</a>
<?php
}
?>
</div>
    <!-- </div> -->
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
