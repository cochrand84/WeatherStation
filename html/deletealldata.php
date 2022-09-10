<?php

$generated_password = "Shotput322397";
if(isset($_POST['submit'])){

$password = $_POST['password'];

if($password == $generated_password){

include 'dbconfig.php';

$con = mysqli_connect($host,$user,$password,$database);

$sql_delete_1="DELETE from outside_temp_data";
$sql_delete_2="DELETE from inside_temp_data";
$sql_delete_3="DELETE from rain_data";

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}


if (mysqli_query($con, $sql_delete_1)) {
    echo "<p><center>Outside data records deleted successfully</center></p>";
} else {
    echo "<p><center>Error deleting record: </center></p>" . mysqli_error($con);
}

if (mysqli_query($con, $sql_delete_2)) {
    echo "<p><center>Inside data records deleted successfully</center></p>";
} else {
    echo "<p><center>Error deleting record: </center></p>" . mysqli_error($con);
}

if (mysqli_query($con, $sql_delete_3)) {
    echo "<p><center>Rain data records deleted successfully</center></p>";
} else {
    echo "<p><center>Error deleting record: </center></p>" . mysqli_error($con);
}
mysqli_close($con);

}

else{
$error_message = "Sorry try again";
}

}

?>


<html>
<body>

<center><p></p>Please Enter Your Password</center>
<form style="color:red " align="center" method="post" action="deletealldata.php">
<input type="text" name="password" />
<input type="submit" name="submit" />
<?php if($error_message){ echo $error_message; } ?> 
</form></center>
</body>