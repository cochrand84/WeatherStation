<?php
include 'dbconfig.php';
$hours = 24;
$conn = new mysqli($host,$user,$password,$database);
$sql="SELECT * FROM temp1_data WHERE temp1_dateandtime >= (NOW() - INTERVAL $hours HOUR) ORDER BY temp1_dateandtime ASC";
$result = $conn->query($sql);

?>
<?php 

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

if ($result->num_rows > 0) {
$prefix = '';
echo "[\n";
while($row = $result->fetch_assoc()) {
  echo $prefix . " {\n";
  echo '  "temp1_dateandtime": "' . $row['temp1_dateandtime'] . '",' . "\n";
  echo '  "temp1_temp": ' . $row['temp1_temp'] . ',' . "\n";
  echo '  "temp1_humidity": ' . $row['temp1_humidity'] . ',' . "\n";
  echo '  "temp1_dewpoint": ' . $row['temp1_dewpoint'] . '' . "\n";
  echo " }";
  $prefix = ",\n";
}
echo "\n]";
}
?>