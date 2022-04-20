<?php
error_reporting(0);
header("Content-Type:application/json");
$servername = "192.168.88.4";
$username = "root";
$password = "19K23O15P";
$db = "db_emtc_tes";
//include('../../../config/koneksi.php');

$conn = mysqli_connect($servername, $username, $password,$db);
// Check connection
if (!$conn) {
�die("Connection failed: " . mysqli_connect_error());
}

$search = $_GET['kode'];
$unit 				= mysqli_query($conn, "SELECT * FROM tmesinunit WHERE idMesin='$search'");



$result = array();
$i=0;
while ($data = mysqli_fetch_assoc($unit)) {
	// var_dump($data);die;
	$result[$i] = json_decode(json_encode($data));
	// array_push($result, (object) $data);
	$i++;
}



$json = json_encode($result);
// var_dump($result);
// var_dump($json);die;
echo $json;

mysqli_close($conn);												