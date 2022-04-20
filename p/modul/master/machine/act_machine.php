<?php
error_reporting(0);
include('../../../../config/koneksi.php');

$p	=$_GET[p];  $act	=$_GET[act];

if ($p=='machines' AND $act=='input'){
	mysqli_query($conn, "INSERT INTO tmesin VALUE(NULL,'$_POST[mesin_nm]','$_POST[mesin_cat]')");
	$link = "<script>alert('Save Success.');
	window.location='../../../page.php?p=machines';</script>";
	echo $link;
}
if ($p=='machines' AND $act=='update'){
	mysqli_query($conn, "UPDATE tmesin SET namaMesin = '$_POST[mesin_nm]', kategori = '$_POST[mesin_cat]'
				WHERE idMesin  = '$_POST[id]'");
	$link = "<script>alert('Update Success.');
	window.location='../../../page.php?p=machines';</script>";
	echo $link;
}
if ($p=='machines' AND $act=='delete'){
	mysqli_query($conn, "DELETE FROM tmesin WHERE idMesin = '$_GET[id]'");
	$link = "<script>alert('Delete Success.');
	window.location='../../../page.php?p=machines';</script>";
	echo $link;
}
mysqli_close($conn);
?>
