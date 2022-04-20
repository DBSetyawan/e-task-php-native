<?php
$servername = "192.168.88.4:3306";
$username = "root";
$password = "19K23O15P";
$db = "db_emtc";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $db);


/* $con = mysqli_init();

if(!$con){
die("mysqli_init filed");}

mysqli_options($con, MYSQLI_OPT_CONNECT_TIMEOUT,30);

$conn= mysqli_real_connect($con, $servername, $username, $password, $db); */


// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
echo "Connected successfully";
//mysqli_close($conn);
?>
