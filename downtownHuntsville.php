<?php

$downtownEvents = [];

function gatherDowntownHuntsvilleEvents() {
$test = file_get_contents("http://www.trumba.com/s.aspx?calendar=our-valley-events-downtown-huntsville&widget=main&srpc.cbid=trumba.spud.0&srpc.get=true");

$asdf = explode('body : "', $test);
// echo stripslashes($asdf[1]);
// die();
// var_dump(stripslashes($asdf[1]));

global $downtownEvents;

$crawler = new Symfony\Component\DomCrawler\Crawler(stripslashes($asdf[1]));

$crawler->filter(".twEventDetails")->each(function ($node) {
    global $downtownEvents;

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
        "source" => "downtownHuntsville",
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

    $downtownEvents[] = $event;
});

return $downtownEvents;

}