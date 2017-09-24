<?php

use Goutte\Client;

$uahEvents = [];

function addEvent($node, $month, $day) {
    global $uahEvents;

    $title = trim($node->filter(".jevents-title")->extract("_text")[0]);
    $location = trim($node->filter(".jevents-event-venue")->extract("_text")[0]);
    
    $url = "http://www.uah.edu" . trim($node->filter("a")->extract("href")[0]);
    $timeStart = trim($node->filter(".jevents-eventlist-starttime")->extract("_text")[0]);
    $images = $node->filter(".bkgimage")->extract("style")[0];

    $re = '/url\(([^)]*)\)/';
    preg_match_all($re, $images, $matches, PREG_SET_ORDER, 0);

    $img = $matches[0][1];
    if ($img === "") {
        $img = $matches[1][1];
    }
    if ($img === "") {
        $img = $matches[2][1];
    } else {
        if (strpos($img, "uah.edu") === false) {
            $img = "http://www.uah.edu" . $img;
        }
    }

    $event = [
        "source" => "UAHEvents",
        "title" => $title,
        "description" => $description,
        "location" => $location,
        "img" => $img,
        "url" => $url,
        "month" => $month,
        "day" => $day,
        "weekday" => $weekday,
        "timeStart" => $timeStart,
        "timeEnd" => $timeEnd,
    ];

    $uahEvents[] = $event;
}

function gatherUAHEvents() {

    global $uahEvents;
$client = new Client();

$crawler = $client->request('GET', 'http://www.uah.edu/events');

// $uahEvents = [];

$crawler->filter(".ev_td_li")->each(function ($node) {
    global $uahEvents;
    $monthasdf = trim($node->filter(".jevents-event-date")->extract("_text")[0]);

    if (strpos($monthasdf, "-") !== false) {
        $DATESPLIT = explode("-", $monthasdf);
        $endDateSplit = explode(" ", trim($DATESPLIT[1]));

        $startDate = DateTime::createFromFormat("M d", trim($DATESPLIT[0]));
        $endDate = DateTime::createFromFormat("M d", $endDateSplit[0] . " " . $endDateSplit[1]);
        $endDate->modify('+1 day'); 

        $interval = DateInterval::createFromDateString('1 day');
        $period = new DatePeriod($startDate, $interval, $endDate);
        
        foreach ( $period as $dt ) {
            addEvent($node, $dt->format("M"), $dt->format("d"));
        }        
    } else {
        $date2 = explode(" ", trim($monthasdf));
        addEvent($node, $date2[0], $date2[1]);
    }
});
    return $uahEvents;
}