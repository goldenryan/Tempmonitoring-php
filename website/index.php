<?php
$pagetitle="COSI Temperature Monitoring";
$links = "<span style='font-size:20px'>Past: ";
$links .= "<a href='/?start=-1 hour&end=now'>Hour</a> ";
$links .= "<a href='/?start=-1 day&end=now'>Day</a> ";
$links .= "<a href='/?start=-1 week&end=now'>Week</a> ";
$links .= "<a href='/?start=-1 month&end=now'>Month</a> ";
$links .= "<a href='/?start=-1 year&end=now'>Year</a> ";
$links .= "</span>";
include "header.php";


if(!isset($_GET["start"]))
	$start = "-1 day";
else
	$start = $_GET["start"];
if(!isset($_GET["end"]))
	$end = "today";
else
	$end   = $_GET["end"];

$start_date = new DateTime();
$end_date = new DateTime();

$start_date->setTimestamp(strtotime($start));
$end_date->setTimestamp(strtotime($end));

$date_string = sprintf("(%s, %s)", $start_date->format('Y-m-d H:i:s'), $end_date->format('Y-m-d H:i:s'));

$diff = $end_date->diff($start_date);

$next_start = clone $start_date;
$next_end   = clone $end_date;

$prev_start = clone $start_date;
$prev_end   = clone $end_date;

$next_start->sub($diff);
$next_end->sub($diff);

$prev_start->add($diff);
$prev_end->add($diff);

$next_start = $next_start->format('Y-m-d H:i:s');
$next_end   = $next_end->format('Y-m-d H:i:s');

$prev_start = $prev_start->format('Y-m-d H:i:s');
$prev_end   = $prev_end->format('Y-m-d H:i:s');



$args = sprintf("&start=%s&end=%s", $start, $end);
$prev_args = sprintf("?start=%s&end=%s", $prev_start, $prev_end);
$next_args = sprintf("?start=%s&end=%s", $next_start, $next_end);

?>

<script type="text/javascript" src="/data.php?sensor=1<?php echo $args ?>"></script>
<script type="text/javascript" src="/data.php?sensor=2<?php echo $args ?>"></script>
<script type="text/javascript" src="/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="/highcharts.js"></script>
<script src="http://code.highcharts.com/highcharts-more.js"></script>
<script src="http://code.highcharts.com/modules/exporting.js"></script>

<script type="text/javascript">

function GraphSensors( data_ ) {
	$("#graph").highcharts({
		legend: {
			enabled: true
		},
		xAxis: {
			title: { text: 'Date' },
			type: 'datetime'
		},
		series: data_,
		chart: {
			type: 'area'
		},
		title: {
			text: 'Temperature Data <br> <?php echo $date_string; ?>',
			margin: 40
		},
		yAxis: {
			title: {
				text: 'Temperature (c)'
			},
		},
		tooltip: {
			crosshairs: true,
			shared: true,
			valueSuffix: 'C',
		},
		plotOptions: {
			area: {
				fillOpacity: 0.3
			}
		},
	});
}


$(function () {
	GraphSensors( [
			{ data: sensor_data1, name: "Sensor 1" }, 
			{ data: sensor_data2, name: "Sensor 2" }
	]);
});


</script>

<div style='text-align: right; font-size:16px; margin: 10px'>
<a href="<?php echo $prev_args; ?>">&larr; Previous</a>
<a href="<?php echo $next_args; ?>">Next &rarr;</a>
</div>

<div id="graph"> </div>


<?php
include "footer.php";
?>
