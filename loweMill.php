<?php

date_default_timezone_set("UTC");

require_once("vendor/autoload.php");

use Goutte\Client;

$client = new Client();

$crawler = $client->request('GET', 'http://www.lowemill.net/calendar/');

$events = [];

$crawler->filter(".ai1ec-event-wrap")->each(function ($node) {
    global $events;

    $title = trim($node->filter(".ai1ec-event-title")->extract("title")[0]);
    $location = trim($node->filter(".ai1ec-event-location")->extract("_text")[0]);
    $month = trim($node->filter(".ai1ec-month")->extract("_text")[0]);
    $day = trim($node->filter(".ai1ec-day")->extract("_text")[0]);
    $weekday = trim($node->filter(".ai1ec-weekday")->extract("_text")[0]);
    $time = trim($node->filter(".ai1ec-event-time")->extract("_text")[0]);
    $description = trim($node->filter(".ai1ec-event-description")->extract("_text")[0]);
    $img = trim($node->filter(".ai1ec-content_img img")->extract("src")[0]);
    $url = trim($node->filter(".ai1ec-load-event")->extract("href")[0]);

    $titleSplit = explode("@", $title);
    $actualTitle = trim($titleSplit[0]);

    $timeRange = explode("@", $time);
    $times = explode("–", $timeRange[1]);
    $timeStart = trim($times[0]);
    $timeEnd = trim($times[1]);

    $event = [
        "title" => $actualTitle,
        "description" => $description,
        "location" => substr($location, 2),
        "img" => $img,
        "url" => $url,
        "month" => $month,
        "day" => $day,
        "weekday" => $weekday,
        "timeStart" => $timeStart,
        "timeEnd" => $timeEnd,
    ];

    $events[] = $event;
});

echo "<pre>";
var_dump($events);
echo "</pre>";