<?php
error_reporting(0);
session_start();
include('../../../config/koneksi.php');
$m = date(m);$d = date(d);$y = date(Y);
$p	=$_GET[p];  $act	=$_GET[act];

if($p=='todolist' AND $act=='pengerjaan'){
	//$title 		= $_POST['title']." - ".$_POST['mesin'];
	$title		= $_GET[id];
	$title_only = $_POST['title'];
	$start 		= $_POST['start'];
	$end 		= $_POST['start'];
	$color 		= "#0071c5";
	$mesin 		= $_POST['mesin'];
	$teknisi 	= $_POST['teknisi'];
	
	
	$dtnote = $_POST[dt_note];
	$tmnote = $_POST[tm_note];
	$cby = $_POST[c_by];
	$desk 	= $_POST['isi_tugas'];
	
	/* mysqli_query($conn, "INSERT INTO tpenjadwalan(title, color,  mesin, teknisi, isi_tugas, datetgs, title_only, kode_tugas, status_tugas, est_day, est_hour, est_min) values 		
				('$title', '$mesin', '$teknisi', '$isi_tugas', NOW(), '$title_only', '$_GET[id]', 'DIKERJAKAN', 0, 0, 0)"); */
	
	mysqli_query($conn,"UPDATE tpenjadwalan SET 
					title = '$title',
					color='#ec0101', 
					start = '$start', 
					end = '$start',
					mesin = '$mesin',
					teknisi = '$teknisi',
					isi_tugas = '$desk',
					datetgs = NOW(),
					title_only = '$title_only',
					status_tugas = 'FINISH'
				WHERE kode_tugas = '$_GET[id]' and status_tugas='IN PROGRESS'");
	mysqli_query($conn,"UPDATE tproblems SET 
					status_problem = 'IN PROGRESS'
				WHERE idprob = '$_GET[id]'");
				
	$number = count($_POST['note']);
	for($i=0; $i<$number; $i++)  
		{
			
			$isi_tugas 	= $_POST['note'][$i];
					mysqli_query($conn, "INSERT INTO tpenjadwalancatatan(kode_tugas, note, datenote, timenote, created_by, created_att) values 		
								('$_GET[id]', '$isi_tugas', '$dtnote', '$tmnote', '$cby', NOW())");
			mysqli_query($conn,"INSERT INTO tproblemnote( idprob, note, datenote, timenote, created_by, idMesin, idUnit, category1, category2, category3 ) 
													VALUES('$_GET[id]',
														   '$isi_tugas',
														   '$dtnote',
														   '$tmnote',
														   '$cby',
														   NULL,
														   NULL,
														   'Maintenace',
														   'Jadwal',
														   'Rutin'
														   )");
		}
	$link = "<script>alert('Berhasil Input Catatan Tugas');window.location='../../page.php?p=todolist&act=tugas_detail&id=$_GET[id]&tek=$_GET[tek]&i=as';</script>";
	echo $link;
}
if($p=='todolist' AND $act=='kerjakantugas'){
	//mysqli_query($conn,"UPDATE tpenjadwalan SET color='#81b214', status_tugas='IN PROGRESS' WHERE kode_tugas = '$_GET[id]'");
	
	$dep	 = mysqli_query($conn, "select * from user where username='$_SESSION[username]' ");
	$dp		 = mysqli_fetch_array($dep);
	$ds		 = mysqli_query($conn,"select * from mdocumentseries where divisi='$dp[divisi]' and dokumen like 'MTC%'");
	$series	 = mysqli_fetch_array($ds);
	
	$qq = mysqli_fetch_array(mysqli_query($conn, "select *from tpenjadwalan where kode_tugas='$_GET[id]'"));
	$title		= $_GET[id];
	$title_only = "$qq[title_only]";
	$start 		= date('Y-m-d')." 00:00:00";
	$end 		= date('Y-m-d')." 00:00:00";
	$color 		= "#81b214";
	$mesin 		= "$qq[mesin]";
	$teknisi 	= "$qq[teknisi]";
	$isi_tugas 	= "$qq[isi_tugas]";
	mysqli_query($conn, "INSERT INTO tpenjadwalan(title, color, start, end,  mesin, teknisi, isi_tugas, datetgs, title_only, kode_tugas, status_tugas, est_day, est_hour, est_min, created_by, created_date, changed_by, changed_date, series) values 
				('$title', '$color', '$start', '$end', '$mesin', '$teknisi', '$isi_tugas', NOW(), '$title_only', '$_GET[id]', 'IN PROGRESS', 0, 0, 0, '$_SESSION[username]', NOW(), '$_SESSION[username]', NOW(), '$series[series]')");
	mysqli_query($conn,"INSERT INTO thandling VALUES(
										   NULL,
										   '$_GET[id]',
										   'IN PROGRESS',
										   '$_SESSION[username]',
										   NOW(),
										   null
										   )");
	mysqli_query($conn,"INSERT INTO thandling VALUES(
										   NULL,
										   '$_GET[id]',
										   'STARTED',
										   '$_SESSION[username]',
										   NOW(),
										   1
										   )");
	mysqli_query($conn,"UPDATE tproblems SET 
					status_problem = 'IN PROGRESS'
				WHERE idprob = '$_GET[id]'");
	$link = "<script>window.location='../../page.php?p=todolist&act=tugas_detail&id=$_GET[id]&tek=$_GET[tek]&i=as';</script>";
	echo $link;
}
if($p=='todolist' AND $act=='finishtugas'){
	$pf = mysqli_fetch_array(mysqli_query($conn, "SELECT *FROM tproblems where idprob = '$_GET[id]'"));
		if($pf[status_problem]=='CLOSED'){}
		else{
	mysqli_query($conn,"INSERT INTO thandling VALUES(
										   NULL,
										   '$_GET[id]',
										   'DIKERJAKAN',
										   '$_SESSION[username]',
										   NOW(),
										   NULL
										   )");
	mysqli_query($conn,"INSERT INTO thandling VALUES(
										   NULL,
										   '$_GET[id]',
										   'FINISH',
										   '$_SESSION[username]',
										   NOW(),
										   1
										   )");
	
			mysqli_query($conn,"UPDATE tproblems SET 
					status_problem = 'FINISH'
				WHERE idprob = '$_GET[id]'");
		}
	
	
								$time_inpro = mysqli_fetch_array(mysqli_query($conn, "select idProb, statusProblem, dateAction, handling from thandling where statusProblem = 'IN PROGRESS' AND idProb = '$_GET[id]' ORDER BY dateAction asc LIMIT 1"));
								$time_fin = mysqli_fetch_array(mysqli_query($conn, "select idProb, statusProblem, dateAction, handling from thandling where statusProblem = 'FINISH' AND idProb = '$_GET[id]' "));
								$time_app = mysqli_fetch_array(mysqli_query($conn, "select idProb, statusProblem, dateAction, handling from thandling where statusProblem = 'APPROVED' AND idProb = '$_GET[id]' "));
								$time_menunggusp = mysqli_fetch_array(mysqli_query($conn, "select idProb, statusProblem, dateAction, handling from thandling where statusProblem = 'MENUNGGU SPAREPART' AND idProb = '$_GET[id]' "));
								$time_inpro2 = mysqli_fetch_array(mysqli_query($conn, "select idProb, statusProblem, dateAction, handling from thandling where statusProblem = 'IN PROGRESS' AND idProb = '$_GET[id]' ORDER BY dateAction desc LIMIT 1"));
								
								$time_pending = mysqli_fetch_array(mysqli_query($conn, "select idProb, statusProblem, dateAction, handling from thandling where statusProblem = 'PENDING' AND idProb = '$_GET[id]'"));
								$time_dispending = mysqli_fetch_array(mysqli_query($conn, "select idProb, statusProblem, dateAction, handling from thandling where statusProblem = 'DISPENDING' AND idProb = '$_GET[id]' ORDER BY dateAction desc LIMIT 1"));
								
								$awal  = strtotime($time_inpro[dateAction]); //waktu awal
								$akhir = strtotime($time_fin[dateAction]); //waktu akhir
								
								$tunggu_in = strtotime($time_inpro2[dateAction]); //waktu menunggu sparepart
								$tunggu_sp = strtotime($time_menunggusp[dateAction]); //waktu menunggu sparepart
								
								$tunggu_dispen = strtotime($time_dispending[dateAction]); //waktu dispending
								$tunggu_pen = strtotime($time_pending[dateAction]); //waktu pending
								
								if($time_menunggusp[idProb]==NULL){
										$diff  = ($akhir - $awal);
										$all = $diff;
								}else{
										$differ  = ($akhir - $awal);
										$differe  = ($tunggu_in - $tunggu_sp);
										$diff = $differ - $differe;
										$all = $diff;
									}
								
								// Untuk menghitung jumlah dalam satuan hari:
								$hari = floor($all/86400);

								// Untuk menghitung jumlah dalam satuan jam:
								$sisa = $all % 86400;
								$jam = floor($sisa/3600);

								// Untuk menghitung jumlah dalam satuan menit:
								$sisa = $sisa % 3600;
								$menit = floor($sisa/60);
								
								//MENUNGGU Sparepart-----------------------------------
								// Untuk menghitung jumlah dalam satuan hari:
								$hari_SP = floor($differe/86400);

								// Untuk menghitung jumlah dalam satuan jam:
								$sisa_SP = $differe % 86400;
								$jam_SP = floor($sisa_SP/3600);

								// Untuk menghitung jumlah dalam satuan menit:
								$sisa_SP = $sisa_SP % 3600;
								$menit_SP = floor($sisa_SP/60);
	
	$start 		= date('Y-m-d')." 00:00:00";
	mysqli_query($conn,"UPDATE tpenjadwalan SET color='#0071c5', status_tugas='DIKERJAKAN', est_day = '$hari', est_hour = '$jam', est_min = '$menit' where kode_tugas='$_GET[id]' AND status_tugas='FINISH'");
	mysqli_query($conn,"UPDATE tpenjadwalan SET color='#0071c5', status_tugas='DIKERJAKAN', est_day = '$hari', est_hour = '$jam', est_min = '$menit' where kode_tugas='$_GET[id]' AND status_tugas='IN PROGRESS'");
	
	$link = "<script>alert('Berhasil Dikerjakan');window.location='../../page.php?p=todolist';</script>";
	echo $link;
}

mysqli_close($conn);