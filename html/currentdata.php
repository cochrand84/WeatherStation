<html>
<head>
<link rel="stylesheet" type="text/css" href="styles.css" />
</head>
<?php
$url1=$_SERVER['REQUEST_URI'];
header("Refresh: 5; URL=$url1");

include 'dbconfig.php';
$hours = 24;
$conn = new mysqli($host,$user,$password,$database);
$sql="SELECT * FROM temp1_data WHERE temp1_dateandtime >= (NOW() - INTERVAL $hours HOUR) ORDER BY temp1_dateandtime ASC";
$result = $conn->query($sql);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $temp1_dateandtime = $row['temp1_dateandtime'];
        $temp1_temp = $row['temp1_temp'];
        $temp1_humidity = $row['temp1_humidity'];
        $temp1_dewpoint = $row['temp1_dewpoint'];
    }
}
if ($temp1_temp < 150) {
 $temp1_temp_color = '#cc3300';
}
if ($temp1_temp < 100) {
 $temp1_temp_color = '#ff9933';
}
if ($temp1_temp < 80) {
 $temp1_temp_color = '#009900';
}
if ($temp1_temp < 60) {
 $temp1_temp_color = '#3366ff';
}
if ($temp1_temp < 40) {
 $temp1_temp_color = '#6600ff';
}
if ($temp1_temp < 20) {
 $temp1_temp_color = '#ff00ff';
}

if ($temp1_humidity < 95) {
 $temp1_humidity_color = '#cc3300';
}
if ($temp1_humidity < 90) {
 $temp1_humidity_color = '#ff9933';
}
if ($temp1_humidity < 80) {
 $temp1_humidity_color = '#009900';
}
if ($temp1_humidity < 70) {
 $temp1_humidity_color = '#3366ff';
}
if ($temp1_humidity < 60) {
 $temp1_humidity_color = '#6600ff';
}
if ($temp1_humidity < 50) {
 $temp1_humidity_color = '#ff00ff';
}

?>
<center>
<div id="currentconditions" style="width:100%">
Current Conditions
<p></p>

temp1: 
<div style="color:<?php echo $temp1_temp_color; ?>;">
Temp: <?php echo $temp1_temp ?> &deg;F</div>

<div style="color:<?php echo $temp1_humidity_color; ?>;">
Humidity: <?php echo $temp1_humidity ?> &#37;</div>

</div>
</center>
</html>