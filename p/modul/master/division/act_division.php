<?php
error_reporting(0);
include('../../../../config/koneksi.php');

$p	=$_GET[p];  $act	=$_GET[act];

if ($p=='division' AND $act=='input'){
	mysqli_query($conn, "INSERT INTO tdepartment VALUE(NULL,'$_POST[div_nm]','$_POST[info]')");
	$link = "<script>alert('Save Success.');
	window.location='../../../page.php?p=division';</script>";
	echo $link;
}
if ($p=='division' AND $act=='update'){
	mysqli_query($conn, "UPDATE tdepartment SET nama_dep = '$_POST[div_nm]', ket_dep = '$_POST[info]'
				WHERE id_dep  = '$_POST[id]'");
	$link = "<script>alert('Update Success.');
	window.location='../../../page.php?p=division';</script>";
	echo $link;
}
if ($p=='division' AND $act=='delete'){
	mysqli_query($conn, "DELETE FROM tdepartment WHERE id_dep = '$_GET[id]'");
	$link = "<script>alert('Delete Success.');
	window.location='../../../page.php?p=division';</script>";
	echo $link;
}
mysqli_close($conn);
?>