<?php
// settings
// host, user and password settings
include 'dbconfig.php';



// make connection to database
$con = mysql_connect($host,$user,$password);
// select db
mysql_select_db($database,$con);

// sql command that selects all entires from current time and X hours backwards
$sql="SELECT * FROM outside_temp_data ORDER BY outside_dateandtime ASC";

//NOTE: If you want to show all entries from current date in web page uncomment line below by removing //
//$sql="select * from outside_temp_data where date(outside_dateandtime) = curdate();";

// set query to variable
$temperatures = mysql_query($sql);

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
  echo '  "outside_dateandtime": "' . $row['outside_dateandtime'] . '",' . "\n";
  echo '  "outside_temp": ' . $row['outside_temp'] . ',' . "\n";
  echo '  "outside_humidity": ' . $row['outside_humidity'] . ',' . "\n";
 # echo '  "lineColor": ' . $row['outside_line_color'] . ',' . "\n";
  echo '  "outside_dewpoint": ' . $row['outside_dewpoint'] . '' . "\n";
  echo " }";
  $prefix = ",\n";
}
echo "\n]";
?>

