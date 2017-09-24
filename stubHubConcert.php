<?php

date_default_timezone_set("UTC");

require_once("vendor/autoload.php");

$client = new GuzzleHttp\Client();

$res = $client->request('GET', 'https://www.stubhub.com/shape/recommendations/core/v2/eventgroupings?handleName=unified_homepage&minAvailableTickets=1&maxEventsPerPerformer=3&limit=12&shstore=1&visitorId=7a419560bdd9411dba17e1b4edb7a364&categoryId=1&point=34.73037%2C-86.5861');

// $xml_string = file_get_contents("https://www.stubhub.com/shape/recommendations/core/v2/eventgroupings?handleName=unified_homepage&minAvailableTickets=1&maxEventsPerPerformer=3&limit=12&shstore=1&visitorId=7a419560bdd9411dba17e1b4edb7a364&categoryId=1&point=34.73037%2C-86.5861");

$xml = simplexml_load_string($res->getBody());

$events = [];

foreach ($xml->groups->group as $group) {
    foreach ($group->events->event as $event) {
        $title = trim($event->name);
        $url = trim($event->webURI);
        $img = trim($event->imageUrl);
        $location = trim($event->venueName);
        $date = trim($event->dateLocal);

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
}

echo "<pre>";
var_dump($events);
echo "</pre>";