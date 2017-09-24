<?php

$json = file_get_contents("events.json");

$events = json_decode($json, true);

$todays_events = array_filter($events, function($event) {
    return (string)$event["day"] === "24";
});


// print_r($todays_events);
?>
<table border=1>
    <tbody>
<?php
foreach ($todays_events as $event) {
?>
        <tr>
            <td><img style="max-width: 200px;" src="<?php echo $event["img"]; ?>"></td>
            <td><?php echo $event["source"]; ?></td>
            <td><?php echo $event["title"]; ?></td>
            <td><?php echo $event["location"]; ?></td>
            <td><?php echo $event["timeStart"]; ?></td>
            <td><?php echo $event["timeEnd"]; ?></td>
        </tr>
<?php
}
?>
    </tbody>
</table>