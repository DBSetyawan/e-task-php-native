<?php
$servername_sim = "192.168.88.88";
$username_sim = "root";
$password_sim = "19K23O15P";
$db_sim = "sim_krisanthium";

// Create connection
$conn_sim = mysqli_connect($servername_sim, $username_sim, $password_sim, $db_sim);


/* $con = mysqli_init();

if(!$con){
die("mysqli_init filed");}

mysqli_options($con, MYSQLI_OPT_CONNECT_TIMEOUT,30);

$conn= mysqli_real_connect($con, $servername, $username, $password, $db); */


// Check connection
if (!$conn_sim) {
    die("Connection failed: " . mysqli_connect_error());
}
//echo "Connected successfully";
//mysqli_close($conn);

?>
