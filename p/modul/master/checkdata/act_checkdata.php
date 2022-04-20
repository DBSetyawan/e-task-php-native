<?php
error_reporting(0);
session_start();
include('../../../../config/koneksi.php');

$p	=$_GET[p];  $act	=$_GET[act];

if ($p=='checkdata' AND $act=='inputhandling'){
	mysqli_query($conn, "INSERT INTO thandling VALUES(NULL,'$_POST[idprob]','$_POST[status_prob]','$_POST[handling]','$_POST[date_handling]',NULL)");
	$link = "<script>alert('Tambah handling Success.');
	window.location='../../../page.php?p=checkdata';</script>";
	echo $link;
}
if ($p=='checkdata' AND $act=='update_prob'){
	mysqli_query($conn, "UPDATE tproblems SET 
							status_problem 	= '$_POST[status_prob]'
						WHERE idprob  		= '$_POST[idprob]'");
	mysqli_query($conn, "INSERT INTO trevisistatuslog VALUES(NULL,'$_POST[idprob]','$_POST[alasan]','$_POST[status_prob_awal] ke $_POST[status_prob]','$_SESSION[username]',NOW())");
	$link = "<script>alert('Update Status Problem Success.');
	window.location='../../../page.php?p=checkdata';</script>";
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