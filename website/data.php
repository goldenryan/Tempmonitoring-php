<?php


include_once "db.php";

$start = $_GET["start"];
$end   = $_GET["end"];

$sensor = intval($_GET["sensor"]);

if(!isset($_GET["start"]))
	$start = "-1 day";
if(!isset($_GET["end"]))
	$end = "today";

$start_date = new DateTime();
$end_date = new DateTime();


$start_date->setTimestamp(strtotime($start));
$end_date->setTimestamp(strtotime($end));

$interval = 1;
$diff = $end_date->diff($start_date);
if ( $diff->y != 0 )
	$interval = $diff->y * 1000;
elseif ( $diff->m != 0 )
	$interval = $diff->m * 600;
elseif ( $diff->d != 0 )
	$interval = $diff->d * 10;
elseif ( $diff->h != 0 )
	$interval = $diff->h ;

$query = sprintf("SELECT UNIX_TIMESTAMP(time) as time, temp FROM data WHERE sensor_id=%d AND time>='%s' AND time<='%s'", $sensor, $start_date->format('Y-m-d H:i:s'), $end_date->format('Y-m-d H:i:s')); 

db::connect();

$res = db::query($query);

$data = array();

$count = 0;
for($event = $res->fetch_assoc(); $event != NULL; $event = $res->fetch_assoc()) {
	if($count % $interval == 0) {
		$data[] = array(intval($event["time"]), intval($event["temp"]));
	}
	$count++;
}

echo sprintf("var sensor_data%d = %s;", $sensor, json_encode($data));
?>
