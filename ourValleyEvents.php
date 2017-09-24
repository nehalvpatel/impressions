<?php

require_once("vendor/autoload.php");

$test = file_get_contents("http://www.trumba.com/s.aspx?calendar=ourvalleyevents&widget=main&srpc.cbid=trumba.spud.4&srpc.get=true");

$asdf = explode('body : "', $test);
// echo stripslashes($asdf[1]);
// die();
// var_dump(stripslashes($asdf[1]));

$crawler = new Symfony\Component\DomCrawler\Crawler(stripslashes($asdf[1]));

$events = [];

$crawler->filter(".twEventDetails")->each(function ($node) {
    global $events;

    $img = trim($node->filter(".twFeaturedImage")->extract("src")[0]);
    $title = trim($node->filteR(".twDescription")->extract("_text")[0]);
    $time = trim($node->filter(".twDetailTime")->extract("_text")[0]);

    $tables = $node->filter(".twRyoEventCellRight table");
    $location = trim($tables->first()->extract("_text")[0]);
    $description = trim($tables->last()->extract("_text")[0]);

    $timeSplit = explode(",", $time);
    $weekday = $timeSplit[0];
    $date = $timeSplit[1];
    $dateSplit = explode(" ", $date);
    $month = $dateSplit[1];
    $day = $dateSplit[2];

    if (isset($timeSplit[2])) {
        $asdfSplit = explode("–", $timeSplit[2]);
        $timeStart = trim($asdfSplit[0]);
        $timeEnd = trim($asdfSplit[1]);
    }

    $event = [
        "title" => $title,
        "description" => $description,
        "location" => $location,
        "img" => $img,
        "url" => "",
        "month" => $month,
        "day" => $day,
        "weekday" => $weekday,
        "timeStart" => $timeStart,
        "timeEnd" => $timeEnd,
    ];

    $events[] = $event;
});

$bruh = [];

$crawler->filter(".twSimpleTableTable tr")->each(function ($node) {
    global $bruh;
    global $events;
    if ($node->children()->first()->attr("class") === "twSimpleTableFirstCell") {
        $node->children()->reduce(function ($asdf, $i) {
            return ($i === 2);
        })->each(function ($asdf) {
            global $bruh;
            $date = explode(" ", $asdf->text());
            $bruh["month"] = $date[0];
            $bruh["day"] = $date[1];
        });

        $node->children()->reduce(function ($asdf, $i) {
            return ($i === 3);
        })->each(function ($asdf) {
            global $bruh;
            $bruh["timeStart"] = $asdf->text();
        });

        $node->children()->reduce(function ($asdf, $i) {
            return ($i === 4);
        })->each(function ($asdf) {
            global $bruh;
            $bruh["title"] = $asdf->text();
        });

        $node->children()->reduce(function ($asdf, $i) {
            return ($i === 5);
        })->each(function ($asdf) {
            global $bruh;
            $bruh["location"] = $asdf->text();
        });

        $events[] = $bruh;
    }
});

echo "<pre>";
var_dump($events);
echo "</pre>";