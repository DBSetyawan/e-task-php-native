<?php
error_reporting(0);
include('../../../../config/koneksi.php');
$path = $_SERVER['DOCUMENT_ROOT'];
$path .= "/e-logbook-server/sql/sql.php";
include_once($path);

$p	=$_GET[p];  $act	=$_GET[act];

if ($p=='categories' AND $act=='input'){
	inCat($_POST['cat_nm'], $_POST['info']);
}
if ($p=='categories' AND $act=='update'){
	upCat($_POST['cat_nm'], $_POST['info'], $_POST[id]);
}
if ($p=='categories' AND $act=='delete'){
	delCat($_GET['id']);
}
mysqli_close($conn);
?>