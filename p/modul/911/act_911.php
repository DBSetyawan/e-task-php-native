<?php
error_reporting(0);
session_start();
include('../../../config/koneksi.php');
$m = date(m);$d = date(d);$y = date(Y);
mysql_connect($server,$username,$password) or die("Koneksi gagal ". mysql_error());
mysql_select_db($database) or die("Database tidak bisa dibuka ". mysql_error());
$p	=$_GET[p];  $act	=$_GET[act];

if($p=='new-post' AND $act=='doc'){
	header('location:../../page.php?p=new-post&act=doc&j='.$_POST[j]);
}
if($p=='new-post' AND $act=='up-doc'){
	header("location:../../page.php?p=new-post&act=edit-problem&id=$_POST[id]&j=$_POST[j]");
}
if($p=='assign' AND $act=='assign'){
	date_default_timezone_set('Asia/Jakarta');
	$dateawal = date('Y-m-d H:i:s');
	$days=+$_POST[est_day];
	$hour=+$_POST[est_hour];
	$minute=+$_POST[est_minute];
	$unik=uniqid();
	$value = filter_input(INPUT_POST,'problem_group');
	$exploded_value=explode('|',$value);
	$value=$exploded_value[0];
	$dateakhir = date('Y-m-d H:i:s',strtotime("$days days  $hour hour $minute minutes",strtotime($dateawal)));
	mysql_query("INSERT INTO tassign(no_assign, no_pelaporan, pic_handling, est_handling, created_by, created_date, EST_DAY, EST_HOUR, EST_MIN) 
					                VALUES('$unik',
										   '$_POST[idprob]',
										   '$_POST[assign_group]',
										   '$dateakhir',
										   '$_SESSION[username]',
										   '$dateawal',
										   '$_POST[est_day]',
										   '$_POST[est_hour]',
										   '$_POST[est_minute]'
										   )");
	mysql_query("UPDATE tlaporan SET JENIS_PROBLEM = '$value',STATUS='A' WHERE NO_PELAPORAN = '$_POST[idprob]'");
	
	$link = "<script>alert('Save Success.');
	window.location='../../page.php?p=assign';</script>";
	echo $link;
}
if($p=='assign' AND $act=='reassign'){
	date_default_timezone_set('Asia/Jakarta');
	$dateawal = date('Y-m-d H:i:s');
	$days=+$_POST[est_day];
	$hour=+$_POST[est_hour];
	$minute=+$_POST[est_minute];
	$dateakhir = date('Y-m-d H:i:s',strtotime("$days days  $hour hour $minute minutes",strtotime($dateawal)));
	
	mysql_query("UPDATE tassign SET PIC_HANDLING='$_POST[assign_group]', EST_HANDLING='$dateakhir' WHERE NO_PELAPORAN = '$_POST[idprob]'");
	
	$link = "<script>alert('Re-Assign Success.');
	window.location='../../page.php?p=assign';</script>";
	echo $link;
}
if($p=='todolist' AND $act=='update'){
	mysql_query("UPDATE tlaporan SET STATUS='IN' WHERE NO_PELAPORAN = '$_GET[id]'");
	
	$link = "<script>window.location='../../page.php?p=todolist';</script>";
	echo $link;
}
if($p=='todolist' AND $act=='finished'){
	mysql_query("UPDATE tlaporan SET STATUS='F',REAL_HANDLING=NOW(),ACTION='$_POST[action]' WHERE NO_PELAPORAN = '$_POST[idprob]'");
	
	$link = "<script>alert('Finished Success.');
	window.location='../../page.php?p=todolist';</script>";
	echo $link;
}

if($p=='new-post' AND $act=='update'){
	$dated = date('Y-m-d');
	$t = mysql_fetch_array(mysql_query("select max(idprob) as no , dateprob from tproblems where dateprob='$dated' "));
		$noUrut = (int) substr($t[no], 13, 3);
		$noUrut++;
		$char = "$y$m$d";
		$newID = $char . sprintf("%03s", $noUrut) . "_";
		$count = 0;
	mysql_query("UPDATE tproblems SET idcat = '$_POST[idcat]', judulprob = '$_POST[judul]', deskripsi = '$_POST[des]', updated_by = '$_POST[u_by]'
				WHERE idprob  = '$_GET[id]'");
	$j=$_GET['j']; 
	$v = mysql_query("select *from tdoc where idprob = '$_GET[id]' ");
	$a = mysql_num_rows($v);
	for($i=$a+1;$i<=$a+$j;$i++){
		$nodoc=$_POST['nodoc'][$i];
		if($nodoc == ''){}
		else{
		mysql_query("INSERT INTO tdoc (idprob, nodoc) VALUES ('$_GET[id]','$nodoc')");
		}
	}
	
	foreach ($_FILES['fupload']['name'] as $f => $fileName) {
	if($fileName==''){
		
	}else{
	$file = $newID.$fileName;	
	mysql_query("INSERT INTO tlampiran (idprob, lampiran) VALUES ('$_GET[id]', '$file')");
	
	move_uploaded_file($_FILES['fupload']['tmp_name'][$f], "attachment/".$newID.$_FILES['fupload']['name'][$f]);
	 $count++;
	}
	}
	
	$link = "<script>alert('Update Success.');
	window.location='../../page.php?p=new-post&act=problem-detail&id=$_GET[id]';</script>";
	echo $link;
}
if($p=='new-post' AND $act=='delete-problem'){
	mysql_query("DELETE FROM tproblems WHERE idprob = '$_GET[id]'");
	unlink("attachment/".$_GET['nm']);
	$link = "<script>window.location='../../page.php?p=new-post&act=problem-list';</script>";
	echo $link;
}
if($p=='new-post' AND $act=='delete'){
	mysql_query("UPDATE tproblems SET status_del = '$_GET[st]'
				WHERE idprob  = '$_GET[id]'");
	$link = "<script>window.location='../../page.php?p=new-post&act=problem-detail&id=$_GET[id]';</script>";
	echo $link;
}
if($p=='new-post' AND $act=='problem-note'){
	mysql_query("INSERT INTO tproblemnote( idprob, note, datenote, timenote, created_by ) 
					                VALUES('$_GET[id]',
										   '$_POST[note]',
										   '$_POST[dt_note]',
										   '$_POST[tm_note]',
										   '$_POST[c_by]'
										   )");
	$link = "<script>alert('Save Success.');
	window.location='../../page.php?p=new-post&act=problem-detail&id=$_GET[id]';</script>";
	echo $link;
}
if($p=='new-post' AND $act=='deldoc'){
	mysql_query("DELETE FROM tdoc WHERE iddoc = '$_GET[iddoc]'");
	$link = "<script>window.location='../../page.php?p=new-post&act=edit-problem&id=$_GET[id]';</script>";
	echo $link;
}
if($p=='new-post' AND $act=='dellampiran'){
	mysql_query("DELETE FROM tlampiran WHERE id_lampiran = '$_GET[id_lampiran]'");
	unlink("attachment/".$_GET['nm']);
	
	$link = "<script>window.location='../../page.php?p=new-post&act=edit-problem&id=$_GET[id]';</script>";
	echo $link;
}
if($p=='new-post' AND $act=='dellampiran'){
	mysql_query("DELETE FROM tlampiran WHERE id_lampiran = '$_GET[id_lampiran]'");
	unlink("attachment/".$_GET['nm']);
	
	$link = "<script>window.location='../../page.php?p=new-post&act=edit-problem&id=$_GET[id]';</script>";
	echo $link;
}
if($p=='new-post' AND $act=='delete-note'){
	mysql_query("DELETE FROM tproblemnote WHERE idnote = '$_GET[idnote]'");
	
	$link = "<script>window.location='../../page.php?p=new-post&act=problem-detail&id=$_GET[id]';</script>";
	echo $link;
}
if($p=='new-post' AND $act=='problem-note-edit'){
	
	mysql_query("UPDATE tproblemnote SET note = '$_POST[note]', datenote = '$_POST[dt_note]', timenote = '$_POST[tm_note]', created_by = '$_POST[c_by]', edited='edited'
				WHERE idnote  = '$_POST[idnote]'");
	
	$link = "<script>alert('Update Success.');
	window.location='../../page.php?p=new-post&act=problem-detail&id=$_POST[idprob]';</script>";
	echo $link;
}
if($p=='new-post' AND $act=='911'){
	$s=mysql_fetch_array(mysql_query("SELECT deskripsi from tproblems where idprob='$_GET[id]'"));
	mysql_query("INSERT INTO tlaporan( no_pelaporan, nama_pelapor, divisi_pelapor, tanggal_pelaporan,detail_problem, status ) 
					                VALUES('$_GET[id]',
										   '$_SESSION[username]',
										   '$_SESSION[divisi]',
										   NOW(),
										   '$s[deskripsi]',
										   'O')");
	$link = "<script>alert('Sent To 911 Success.');
	window.location='../../page.php?p=new-post&act=problem-detail&id=$_GET[id]';</script>";
	echo $link;
}
mysqli_close($conn);