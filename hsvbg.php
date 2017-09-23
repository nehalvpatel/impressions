<?php

date_default_timezone_set("UTC");

require_once("vendor/autoload.php");

use Goutte\Client;

$client = new Client();

$crawler = $client->request('GET', 'http://hsvbg.org/events');

$events = [];
$currentDay = "";

$crawler->filter(".ai1ec-day")->each(function ($day) {

$currentDay = $day->filter(".ai1ec-load-view")->extract("_text")[0];

$day->filter(".ai1ec-event-container")->each(function ($node) {
    global $events;

    $title = trim($node->filter(".ai1ec-event-title")->extract("_text")[0]);
    $location = trim($node->filter(".ai1ec-event-location")->extract("_text")[0]);
    $month = trim($node->filter(".ai1ec-month")->extract("_text")[0]);
    //$day = trim($node->filter(".ai1ec")->extract("_text")[0]);
    $weekday = trim($node->filter(".ai1ec-weekday")->extract("_text")[0]);
    $time = trim($node->filter(".ai1ec-event-time")->extract("_text")[0]);
    $description = trim($node->filter(".ai1ec-event-description")->extract("_text")[0]);
    $img = trim($node->filter(".ai1ec-content_img img")->extract("src")[0]);

    $timeRange = explode("@", $time);
    $times = explode("–", $timeRange[1]);
    $timeStart = trim($times[0]);
    $timeEnd = trim($times[1]);

    $event = [
        "title" => $title,
        "description" => $description,
        "location" => substr($location, 2),
        "img" => $img,
        "month" => $month,
        "day" => $currentDay,
        "weekday" => $weekday,
        "timeStart" => $time,
        "timeEnd" => $timeEnd,
    ];

    $events[] = $event;
});
});

echo "<pre>";
var_dump($events);
echo "</pre>";
