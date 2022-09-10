<html>
<head>
<link rel="stylesheet" type="text/css" href="styles.css" />
</head>
<?php
/**
* Comments 
*
* PHP version 5 
*
* @category Testing
* @package  None_Yet
* @author   David Cochran <david@davidcochran.us>
* @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
* @link     http://code.davidcochran.us
*/
// lets refresh the page every 5 minutes, so you can see the new data
$url1=$_SERVER['REQUEST_URI'];
header("Refresh: 5; URL=$url1");
?>

<?php
// settings
// host, user and password settings
include 'dbconfig.php';

// make connection to database
$link = mysql_connect($host, $user, $password);

// select db
mysql_select_db($database, $link);

// sql command that selects the last row of data from each table 
// and sets them in their own variable
$query="
SELECT * 
FROM outside_temp_data 
WHERE outside_dateandtime=(SELECT MAX(outside_dateandtime) 
FROM `outside_temp_data`)";
$query2="
SELECT * 
FROM inside_temp_data 
WHERE inside_dateandtime=(SELECT MAX(inside_dateandtime) 
FROM `inside_temp_data`)";
$query3="
SELECT * 
FROM rain_data 
WHERE rain_dateandtime=(SELECT MAX(rain_dateandtime) 
FROM `rain_data`)";
$query4="
SELECT sum(rain_metered) AS rain_sum 
FROM (SELECT rain_metered FROM `rain_data` ORDER BY rain_dateandtime DESC LIMIT 10) t1";
$query5="
SELECT MAX(wind_speed) AS wind_gust 
FROM (SELECT * FROM `wind_speed_data` 
    ORDER BY `wind_speed_dateandtime` 
    DESC LIMIT 20) t1";
$query6="
SELECT AVG(wind_speed) AS wind_average
FROM (SELECT * FROM `wind_speed_data` 
    ORDER BY `wind_speed_dateandtime` 
    DESC LIMIT 20) t2";

// query the above sql commands and set them to a variable
$result= mysql_query($query) or die(mysql_error());
$result2= mysql_query($query2) or die(mysql_error());
$result3= mysql_query($query3) or die(mysql_error());
$result4= mysql_query($query4) or die(mysql_error());
$result5= mysql_query($query5) or die(mysql_error());
$result6= mysql_query($query6) or die(mysql_error());

// pull out the outside data from the query and set it to a variable
while ($row = mysql_fetch_assoc($result)) {
    $outside_dateandtime = $row['outside_dateandtime'];
    $outside_temp = $row['outside_temp'];
    $outside_humidity = $row['outside_humidity'];
    $outside_dewpoint = $row['outside_dewpoint'];
}
//pull out the inside data from the query and set it to a variable
while ($row = mysql_fetch_assoc($result2)) {
    $inside_dateandtime = $row['inside_dateandtime'];
    $inside_temp = $row['inside_temp'];
    $inside_pressure = $row['inside_pressure'];
}
//pull out the rain data from the query and set it to a variable
while ($row = mysql_fetch_assoc($result3)) {
    $rain_dateandtime = $row['rain_dateandtime'];
}
while ($row = mysql_fetch_assoc($result4)) {
    $rain_sum = $row['rain_sum'];
}
while ($row = mysql_fetch_assoc($result5)) {
    $wind_gust = $row['wind_gust'];
}
while ($row = mysql_fetch_assoc($result6)) {
    $wind_average = $row['wind_average'];
}
?>

<?php
// change the color of the font based on the temperatures from outside, 
// and set it to a variable
if ($outside_temp < 150) {
    $outside_color = '#cc3300';
}
if ($outside_temp < 100) {
    $outside_color = '#ff9933';
}
if ($outside_temp < 80) {
    $outside_color = '#009900';
}
if ($outside_temp < 60) {
    $outside_color = '#3366ff';
}
if ($outside_temp < 40) {
    $outside_color = '#6600ff';
}
if ($outside_temp < 20) {
    $outside_color = '#ff00ff';
}
// change the color of the font based on the temperatures from inside, 
// and set it to a variable
if ($inside_temp < 150) {
    $inside_color = '#cc3300';
}
if ($inside_temp < 100) {
    $inside_color = '#ff9933';
}
if ($inside_temp < 80) {
    $inside_color = '#009900';
}
if ($inside_temp < 60) {
    $inside_color = '#3366ff';
}
if ($inside_temp < 40) {
    $inside_color = '#6600ff';
}
if ($inside_temp < 20) {
    $inside_color = '#ff00ff';
}
// take the current date and subtract 10 minutes
$date = date("Y-m-d H:i:s", strtotime("-10 minutes"));
$outside_dateandtime_color = '000000';
$inside_dateandtime_color = '000000';
$rain_dateandtime_color = '000000';
// determine if the current date (minus 10 minutes) is greater than the last 
// date we got from outside, if it is set the variable 
// for outside date and time color to red
if ($outside_dateandtime < $date) {
    $outside_dateandtime_color = 'ff0000';
}
// determine if the current date (minus 10 minutes) is greater 
// than the last date we got from inside, if it is set the variable 
// for inside date and time color to red
if ($inside_dateandtime < $date) {
    $inside_dateandtime_color = 'ff0000';
}
if ($rain_dateandtime < $date) {
    $rain_dateandtime_color = 'ff0000';
}
// round wind speed
$wind_gust_rounded = round($wind_gust, 3);
$wind_average_rounded = round($wind_average, 3);
// calculate wind chill

$wind_chill = 35.74 + (0.6215 * $outside_temp) - (35.75 * ($wind_average_rounded ** 0.16)) + (0.4275 * $outside_temp * ($wind_average_rounded ** 0.16));
$wind_chill2 = $outside_temp - 1.5 * $wind_average_rounded
?>
<!-- now we are going to start writing the page in html, using php when needed -->
<center>
<div id="currentconditions" style="width:100%">
Current Conditions
<p></p>
<!-- listing the outside and inside temps, the php 
here just echo's the variable for the color set above -->
Outside Tempurature: <div style="color:<?php echo $outside_color; ?>;">
<?php echo $outside_temp ?> &deg;F</div>
Current Rain(last 5 Mins): <div>
<?php echo $rain_sum ?>
 inches</div>
Inside Tempurature: 
<div style="color:<?php echo $inside_color; ?>;">
<?php echo $inside_temp ?> &deg;F</div>
<!-- echo out the rest of the readings -->
Barometer: <div><?php echo $inside_pressure ?> inHg</div>
Outside Humidity: <div><?php echo $outside_humidity ?> &#37;</div>
Outside Dewpoint: <div><?php echo $outside_dewpoint ?> &deg;F</div>
Wind Gust: <div><?php echo $wind_gust_rounded ?> mPh</div>
Wind Average: <div><?php echo $wind_average_rounded ?> mPh</div>
Wind Chill: <div><?php echo $wind_chill ?> &deg;F</div>
Wind Chill2: <div><?php echo $wind_chill2 ?> &deg;F</div>
<p></p>
<!-- this list the last recorded data and time for the outside and inside readings,
 if over 10 has past, the date and time will be in red. -->
Last record date for inside is 
<div style="color:<?php echo $inside_dateandtime_color; ?>;">
<?php echo $inside_dateandtime ?></div> and outside is 
<div style="color:<?php echo $outside_dateandtime_color; ?>;">
<?php echo $outside_dateandtime ?></div>
<p></p>
Last record for rain is 
<div style="color:<?php echo $inside_dateandtime_color; ?>;">
<?php echo $rain_dateandtime; ?></div>
<p></p>
Current time is <?php echo date('Y-m-d H:i:s'); ?>
<p></p>
Graphs below show last 24 hours
</div>
</center>
</html>