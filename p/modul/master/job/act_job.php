<?php
error_reporting(0);
include('../../../../config/koneksi.php');

$p	=$_GET[p];  $act	=$_GET[act];

if ($p=='job' AND $act=='input'){
	mysqli_query($conn, "INSERT INTO tprepress VALUE('$_POST[idPrepress]','$_POST[pre_nm]')");
	$link = "<script>alert('Save Success.');
	window.location='../../../page.php?p=job';</script>";
	echo $link;
}
if ($p=='job' AND $act=='update'){
	mysqli_query($conn, "UPDATE tprepress SET namaPrepress = '$_POST[pre_nm]'
				WHERE idPrepress  = '$_POST[id]'");
	$link = "<script>alert('Update Success.');
	window.location='../../../page.php?p=job';</script>";
	echo $link;
}
if ($p=='job' AND $act=='delete'){
	mysqli_query($conn, "DELETE FROM tprepress WHERE idPrepress = '$_GET[id]'");
	$link = "<script>alert('Delete Success.');
	window.location='../../../page.php?p=job';</script>";
	echo $link;
}
mysqli_close($conn);
?>
