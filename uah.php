<?php

date_default_timezone_set("UTC");

require_once("vendor/autoload.php");

use Goutte\Client;

$client = new Client();

$crawler = $client->request('GET', 'http://www.uah.edu/events');

$events = [];

$crawler->filter(".jev_listrow")->each(function ($node) {
    global $events;

    $title = trim($node->filter(".jevents-title")->extract("_text")[0]);
    $location = trim($node->filter(".jevents-event-venue")->extract("_text")[0]);
    $month = trim($node->filter(".jevents-event-date")->extract("_text")[0]);
    //$day = trim($node->filter(".dateInfo")->extract("title")[0]);
    //$weekday = trim($node->filter(".jevents-event-date")->extract("_text")[0]);
    //$time = trim($node->filter(".jevents-eventlist-starttime")->extract("_text")[0]);
    $description = trim($node->filter(".descriptionInfo")->extract("_text")[0]);
    $img = trim($node->filter(".ai1ec-content_img img")->extract("src")[0]);
    $url = trim($node->filter(".ai1ec-load-event")->extract("href")[0]);

    $dateSplit = explode(" ", $month);
    $startDate = trim($dateSplit[0]);
    $day = trim($dateSplit[1]);
    $endDate = trim($dateSplit[2]);
    $time = trim($dateSplit[4]) . trim($dateSplit[5]);

    $event = [
        "title" => $title,
        "description" => $description,
        "location" => $location,
        "img" => $img,
        "url" => $url,
        "startdate" => $day,
        "enddate" => $endDate,
        "weekday" => $weekday,
        "timeStart" => $time,
        "timeEnd" => $timeEnd,
    ];

    $events[] = $event;
});

echo "<pre>";
var_dump($events);
echo "</pre>";

