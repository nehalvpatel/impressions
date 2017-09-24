<?php

date_default_timezone_set("UTC");

require_once("vendor/autoload.php");

require_once("downtownHuntsville.php");
require_once("loweMill.php");
require_once("ourValleyEvents.php");
require_once("hsvbg.php");
require_once("uah.php");

$events = array_merge(
    gatherDowntownHuntsvilleEvents(),
    gatherLoweMillEvents(),
    gatherOurValleyEvents(),
    gatherUAHEvents()
    // gatherBotanicalGardenEvents()
);

file_put_contents("events.json", json_encode($events));