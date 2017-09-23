<?php

date_default_timezone_set("UTC");

require_once("vendor/autoload.php");

$xml_string = file_get_contents("http://hsvbg.org/?plugin=all-in-one-event-calendar&controller=ai1ec_exporter_controller&action=export_events&xml=true");

$xml = simplexml_load_string($xml_string);

$events = [];

function objectifyDate($dateString) {
    $dateSplit = explode("T", $dateString);
    $hasTime = false;
    if (isset($dateSplit[1])) {
        $date = DateTime::createFromFormat("Ymd\THis", $dateString);
        $hasTime = true;
    } else {
        $date = DateTime::createFromFormat("Ymd", $dateString);
    }

    return [
        "date" => $date,
        "hasTime" => $hasTime
    ];
}

function addEvent($event, $date) {
    global $events;

    $title = trim($event->summary);
    $description = trim($event->description);
    $month = $date["date"]->format("M");
    $day = $date["date"]->format("j");
    $weekday = $date["date"]->format("D");

    if ($date["hasTime"] === true) {
        $timeStart = $date["date"]->format("g:i A");
    }

    $event = [
        "title" => $title,
        "description" => $description,
        "location" => "",
        "img" => "",
        "url" => (string)$event->url->attributes()->uri[0],
        "month" => $month,
        "day" => $day,
        "weekday" => $weekday,
        "timeStart" => $timeStart,
        "timeEnd" => $timeEnd,
    ];

    $events[] = $event;
}

foreach ($xml->vevent as $event) {
    if (!empty($event->rdate)) {
        foreach ($event->rdate as $rdate) {
            $date = objectifyDate($rdate);
            addEvent($event, $date);
        }
    } else {
        $dateStart = trim($event->dtstart);
        $date = objectifyDate($dateStart);
        addEvent($event, $date);
    }
}

echo "<pre>";
var_dump($events);
echo "</pre>";