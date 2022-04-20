<?php
error_reporting(0);
session_start();
include('../../../../config/koneksi.php');


$p	=$_GET[p];  $act	=$_GET[act];

if ($p=='machinesunit' AND $act=='input'){
	mysqli_query($conn, "INSERT INTO tmesinunit VALUES(NULL,'$_POST[mesin]','$_POST[unit_mesin]','$_SESSION[username]',NOW(),'$_SESSION[username]',NOW())");
	$link = "<script>alert('Save Success.');
	window.location='../../../page.php?p=machinesunit';</script>";
	echo $link;
}
if ($p=='machinesunit' AND $act=='update'){
	mysqli_query($conn, "UPDATE tmesinunit SET idMesin = '$_POST[mesin]', namaUnit = ' $_POST[unit_mesin]', changedBy = '$_SESSION[username]', changedDate = NOW()
				WHERE idUnit  = '$_POST[id]'");
	$link = "<script>alert('Update Success.');
	window.location='../../../page.php?p=machinesunit';</script>";
	echo $link;
}
if ($p=='machinesunit' AND $act=='delete'){
	mysqli_query($conn, "DELETE FROM tmesinunit WHERE idUnit = '$_GET[id]'");
	$link = "<script>alert('Delete Success.');
	window.location='../../../page.php?p=machinesunit';</script>";
	echo $link;
}
mysqli_close($conn);
?>