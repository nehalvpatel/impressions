<?php

date_default_timezone_set("UTC");

require_once("vendor/autoload.php");

use Goutte\Client;

$client = new Client();

$crawler = $client->request('GET', 'http://www.huntsville.org/events');

$events = [];

$crawler->filter(".info-list")->each(function ($node) {
    global $events;

    $title = trim($node->filter(".eventItem item row")->extract("data-seo-title")[0]);
    $location = trim($node->filter(".addressInfo")->extract("_text")[0]);
    $month = trim($node->filter(".dateInfo")->extract("title")[0]);
    $day = trim($node->filter(".dateInfo")->extract("title")[0]);
    $weekday = trim($node->filter(".ai1ec-weekday")->extract("_text")[0]);
    $time = trim($node->filter(".timeInfo")->extract("_text")[0]);
    $description = trim($node->filter(".descriptionInfo")->extract("_text")[0]);
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

