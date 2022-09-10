<?php
// settings
// host, user and password settings
include 'dbconfig.php';

//how many hours backwards do you want results to be shown in web page.
$hours = 24;

// make connection to database
$con = mysql_connect($host,$user,$password);
// select db
mysql_select_db($database,$con);

// sql command that selects all entires from current time and X hours backwards
$sql="SELECT * FROM rain_data WHERE rain_dateandtime >= (NOW() - INTERVAL $hours HOUR) ORDER BY rain_dateandtime ASC";

//NOTE: If you want to show all entries from current date in web page uncomment line below by removing //
//$sql="select * from inside_temp_data where date(inside_dateandtime) = curdate();";

// set query to variable
$rain = mysql_query($sql);

// create content to web-pagge
?>
<?php 
// Fetch the data
$query = $sql;
$result = mysql_query( $query );

// All good?
if ( !$result ) {
  // Nope
  $message  = 'Invalid query: ' . mysql_error() . "\n";
  $message .= 'Whole query: ' . $query;
  die( $message );
}
// Print out rows
$prefix = '';
echo "[\n";
while ( $row = mysql_fetch_assoc( $result ) ) {
  echo $prefix . " {\n";
  echo '  "rain_dateandtime": "' . $row['rain_dateandtime'] . '",' . "\n";
  echo '  "rain_metered": ' . $row['rain_metered'] . '' . "\n";
  echo " }";
  $prefix = ",\n";
}
echo "\n]";
?>

