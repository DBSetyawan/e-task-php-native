<?php
/*ob_start ("ob_gzhandler");
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/
error_reporting(0);
session_start();
include('../../../config/koneksi.php');
$m = date(m);$d = date(d);$y = date(Y);
$p	=$_GET[p];  $act	=$_GET[act];


if($p=='input-problem' AND $act=='input'){
	$dated = date('Y-m-d');
	$t = mysqli_fetch_array(mysqli_query($conn,"select max(idprob) as no , dateprob from tproblems where dateprob='$dated' "));
		$noUrut = (int) substr($t[no], 13, 3);
		$noUrut++;
		$char = "$y$m$d";
		$newID = $char . sprintf("%03s", $noUrut) . "_";
		$count = 0;
		$deskripsi = nl2br($_POST['des']);
	mysqli_query($conn,"INSERT INTO tproblems 
					                VALUES('$_POST[kodeprob]',
										   '$_POST[idpriority]',
										   '$_POST[nama_pelapor]',
										   '$_POST[date]',
										   '$_POST[time]',
										   '$deskripsi',
										   '$_SESSION[username]',
										   '$_POST[divisi]',
										    NOW(),
											NOW(),
											'$_SESSION[username]',
											'OPEN',
											$_POST[idmesin],
											$_POST[idunit],
											'$_POST[category]'
										   )");
	foreach ($_FILES['fupload']['name'] as $f => $fileName) {
	if($fileName==''){
		
	}else{
	$file = $_POST[kodeprob]."_".$fileName;	
	mysqli_query($conn,"INSERT INTO tlampiran (idprob, lampiran) VALUES ('$_POST[kodeprob]', '$file')");
	
	move_uploaded_file($_FILES['fupload']['tmp_name'][$f], "attachment/".$_POST[kodeprob]."_".$_FILES['fupload']['name'][$f]);
	 $count++;
	}
}
	
	date_default_timezone_set('Asia/Jakarta');
	$time_now = date('H:i');
	
	//JIKA SHIFT 2
	$sh2 = mysqli_fetch_array(mysqli_query($conn, "select *from mshift m left join tusershift t on m.idShift = t.idShift 
												   left join user u on t.idUser=u.iduser where t.idShift = 1"));
	if($sh2[Status]=='Aktif'){
		if($time_now >= $sh2[jamMulaiShift] && $time_now <= $sh2[jamAkhirShift] && $_POST[idpriority] == '1' && $sh2[Status]=='Aktif'){
		
		date_default_timezone_set('Asia/Jakarta');
		$dateawal = date('Y-m-d H:i:s');
		$days=+$_POST[est_day];
		$hour=+$_POST[est_hour];
		$minute=+$_POST[est_minute];
		$unik=uniqid();
		$dateakhir = date('Y-m-d H:i:s',strtotime("$days days  $hour hour $minute minutes",strtotime($dateawal)));
		mysqli_query($conn,"INSERT INTO tassign(no_assign, no_pelaporan, pic_handling, est_handling, created_by, created_date) 
										VALUES('$unik',
											   '$_POST[kodeprob]',
											   '$sh2[username]',
											   '$dateakhir',
											   'automatic by system-shift2',
											   '$dateawal'
											   )");
		mysqli_query($conn,"UPDATE tproblems SET status_problem = 'ASSIGN' WHERE idprob = '$_POST[kodeprob]'");
		mysqli_query($conn,"INSERT INTO thandling VALUES(
											   NULL,
											   '$_POST[kodeprob]',
											   'ASSIGN TO',
											   'automatic by system-shift2',
											   NOW(),
											   NULL
											   )");
		
		}
	}else{}
	
	//JIKA SHIFT 3
	
	/*$sh3 = mysqli_fetch_array(mysqli_query($conn2, "select *from mshift m left join tusershift t on m.idShift = t.idShift 
												   left join user u on t.idUser=u.iduser where t.idShift = 2"));
	if($sh3[status]=='Aktif'){
		if($time_now >= $sh3[jamMulaiShift] && $time_now <= $sh2[jamAkhirShift] && $_POST[idpriority] == '1'  && $sh3[Status]=='Aktif'){
		
		date_default_timezone_set('Asia/Jakarta');
		$dateawal = date('Y-m-d H:i:s');
		$days=+$_POST[est_day];
		$hour=+$_POST[est_hour];
		$minute=+$_POST[est_minute];
		$unik=uniqid();
		$dateakhir = date('Y-m-d H:i:s',strtotime("$days days  $hour hour $minute minutes",strtotime($dateawal)));
		mysqli_query($conn2,"INSERT INTO tassign(no_assign, no_pelaporan, pic_handling, est_handling, created_by, created_date, EST_DAY, EST_HOUR, EST_MIN) 
										VALUES('$unik',
											   '$_POST[kodeprob]',
											   '$sh3[username]',
											   '$dateakhir',
											   'automatic by system-shift3',
											   '$dateawal',
											   '$_POST[est_day]',
											   '$_POST[est_hour]',
											   '$_POST[est_minute]'
											   )");
		mysqli_query($conn2,"UPDATE tproblems SET status_problem = 'ASSIGN' WHERE idprob = '$_POST[kodeprob]'");
		mysqli_query($conn2,"INSERT INTO thandling VALUES(
											   NULL,
											   '$_POST[kodeprob]',
											   'ASSIGN TO',
											   'automatic by system-shift3',
											   NOW()
											   )");
		}
	}	*/
	
	if($_POST[in_ke]=='internal'){
		$link = "<script>alert('Save Success.');
		window.location='../../page.php?p=dashboard-internal';</script>";
		echo $link;
	}else{
		$link = "<script>alert('Save Success.');
		window.location='../../page.php?p=dashboard';</script>";
		echo $link;
	}
}
if($p=='edit-problem' AND $act=='edit'){
	mysqli_query($conn,"UPDATE tproblems SET 
											idcat 			= '$_POST[idpriority]',
											deskripsi 		= '$_POST[des]',
											updated_at		= NOW(),
											updated_by		= '$_SESSION[username]',
											id_mesin		= '$_POST[idmesin]',
											id_unit_mesin 	= '$_POST[idunit]',
											category		= '$_POST[category]'
											WHERE idprob = '$_POST[kodeprob]'");
	if(substr($_POST['kodeprob'],0,3) == 'PGA'){
		$link = "<script>alert('Update Success.');
		window.location='../../page.php?p=dashboard-internal';</script>";
		echo $link;
	}else{
		$link = "<script>alert('Update Success.');
		window.location='../../page.php?p=dashboard';</script>";
		echo $link;
	}
}
if($p=='assign' AND $act=='assign'){
	date_default_timezone_set('Asia/Jakarta');
	$dateawal = date('Y-m-d H:i:s');
	$days=+$_POST[est_day];
	$hour=+$_POST[est_hour];
	$minute=+$_POST[est_minute];
	$unik=uniqid();
	$dateakhir = date('Y-m-d H:i:s',strtotime("$days days  $hour hour $minute minutes",strtotime($dateawal)));
	
	mysqli_query($conn,"UPDATE tproblems SET status_problem = 'ASSIGN' WHERE idprob = '$_POST[idprob]'");
	//JIKA PENJADWALAN
	if(substr($_POST[idprob],0,3) == 'MTC'){
		mysqli_query($conn,"UPDATE tpenjadwalan SET teknisi='$_POST[assign_group]', est_day='$_POST[est_day]', est_hour='$_POST[est_hour]', est_min='$_POST[est_minute]' WHERE kode_tugas = '$_POST[idprob]' AND status_tugas='PLAN'");

		mysqli_query($conn,"DELETE FROM tpenjadwalan WHERE kode_tugas = '$_POST[idprob]' AND status_tugas not in ('PLAN')");
		
		mysqli_query($conn,"INSERT INTO tpenjadwalantemp(kode_tugas, teknisi, assign_date, EST_DAY, EST_HOUR, EST_MIN) values
					('$_POST[idprob]', '$_POST[assign_group]', NOW(), '$_POST[est_day]', '$_POST[est_hour]', '$_POST[est_minute]')");
		mysqli_query($conn,"DELETE FROM tassign WHERE no_pelaporan = '$_POST[idprob]'");
		mysqli_query($conn,"INSERT INTO tassign(no_assign, no_pelaporan, pic_handling, est_handling, created_by, created_date, EST_DAY, EST_HOUR, EST_MIN) 
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
	}else{
		mysqli_query($conn,"INSERT INTO tassign(no_assign, no_pelaporan, pic_handling, est_handling, created_by, created_date, EST_DAY, EST_HOUR, EST_MIN) 
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
	}
	mysqli_query($conn,"INSERT INTO thandling VALUES(
										   NULL,
										   '$_POST[idprob]',
										   'ASSIGN TO',
										   '$_SESSION[username]',
										   NOW(),
										   0
										   )");
	//include('sendmail.php');
	if(substr($_POST['idprob'],0,3) == 'PGA'){
		$link = "<script>alert('Save Success.');
		window.location='../../page.php?p=dashboard-internal&act=open';</script>";
		echo $link;
	}else if($_GET[act]=='open'){
		$link = "<script>alert('Save Success.');
		window.location='../../page.php?p=dashboard&act=open';</script>";
		echo $link;
	}
	else if($_GET[act]=='assign'){
		if(substr($_POST['idprob'],0,3) == 'PGA'){
			if($_GET[ds]=='inprogress'){
				$link = "<script>alert('Save Success.');
						window.location='../../page.php?p=dashboard-internal&act=inprogress';</script>";
				echo $link;
			}else{
				$link = "<script>alert('Save Success.');
						window.location='../../page.php?p=dashboard-internal&act=assign';</script>";
				echo $link;
			}
		}
		else{
			if($_GET[ds]=='inprogress'){
				$link = "<script>alert('Save Success.');
						window.location='../../page.php?p=dashboard&act=inprogress';</script>";
				echo $link;
			}else{
				$link = "<script>alert('Save Success.');
						window.location='../../page.php?p=dashboard&act=assign';</script>";
				echo $link;
			}
		}
		
	}
	else{
		$link = "<script>alert('Save Success.');
		window.location='../../page.php?p=assign';</script>";
		echo $link;
	}
}
if($p=='assign' AND $act=='reassign'){
	date_default_timezone_set('Asia/Jakarta');
	$dateawal = date('Y-m-d H:i:s');
	$days=+$_POST[est_day];
	$hour=+$_POST[est_hour];
	$minute=+$_POST[est_minute];
	$dateakhir = date('Y-m-d H:i:s',strtotime("$days days  $hour hour $minute minutes",strtotime($dateawal)));
	
	mysqli_query($conn,"UPDATE tassign SET PIC_HANDLING='$_POST[assign_group]', EST_HANDLING='$dateakhir', EST_DAY='$_POST[est_day]', EST_HOUR='$_POST[est_hour]', EST_MIN='$_POST[est_minute]', PROBLEM_JOB='$_POST[jenis]'	WHERE NO_PELAPORAN = '$_POST[idprob]'");

	

	//JIKA PENJADWALAN
	if(substr($_POST[idprob],0,3) == 'MTC'){
		mysqli_query($conn,"UPDATE tpenjadwalan SET teknisi='$_POST[assign_group]', est_day='$_POST[est_day]', est_hour='$_POST[est_hour]', est_min='$_POST[est_minute]' WHERE kode_tugas = '$_POST[idprob]' AND status_tugas='PLAN'");

		mysqli_query($conn,"DELETE FROM tpenjadwalan WHERE kode_tugas = '$_POST[idprob]' AND status_tugas not in ('PLAN')");
		
		mysqli_query($conn,"INSERT INTO tpenjadwalantemp(kode_tugas, teknisi, assign_date, EST_DAY, EST_HOUR, EST_MIN) values
					('$_POST[idprob]', '$_POST[assign_group]', NOW(), '$_POST[est_day]', '$_POST[est_hour]', '$_POST[est_minute]')");
	}

	
	if($_GET[ds]=='assign'){
		$link = "<script>alert('Re-Assign Success.');
		window.location='../../page.php?p=dashboard&act=$_GET[ds]';</script>";
		echo $link;
	}else{
		$link = "<script>alert('Re-Assign Success.');
		window.location='../../page.php?p=assign';</script>";
		echo $link;
	}
}
if($p=='todolist' AND $act=='in-progress'){
	//$max = mysqli_fetch_array(mysqli_query($conn, "select (max(no)+1) as no_max from thandling where idprob = '$_GET[id]'"));
	mysqli_query($conn,"UPDATE tproblems SET status_problem='IN PROGRESS' WHERE idprob = '$_GET[id]'");
	$st = mysqli_num_rows(mysqli_query($conn, "select * from thandling where idprob = '$_GET[id]' AND statusProblem='STARTED'"));
	$max = mysqli_fetch_array(mysqli_query($conn, "select max(no)as no_max from thandling where idprob = '$_GET[id]'"));
	if($st > 0){
		$status = "IN PROGRESS";
		$no = ($max[no_max]);
	}else{
		$status = "STARTED";
		$no = 1;
	}
	mysqli_query($conn,"INSERT INTO thandling VALUES(
										   NULL,
										   '$_GET[id]',
										   '$status',
										   '$_SESSION[username]',
										   NOW(),
										   '$no'
										   )");
	$link = "<script>window.location='../../page.php?p=todolist&act=problem-detail&id=$_GET[id]&i=as';</script>";
	echo $link;
}
if($p=='todolist' AND $act=='in-progress-assign'){
	
	$max = mysqli_fetch_array(mysqli_query($conn, "select max(no)as no_max from thandling where idprob = '$_GET[id]'"));
	$max_in = mysqli_fetch_array(mysqli_query($conn, "select max(no) as no_max_in from thandling where idprob = '$_GET[id]' where status = 'PAUSED'"));
	
	$max_idass = mysqli_fetch_array(mysqli_query($conn, "select (max(no)) as no_max from thandling where idprob = '$_GET[idass]'"));
	
	$st = mysqli_num_rows(mysqli_query($conn, "select * from thandling where idprob = '$_GET[id]' AND statusProblem='STARTED'"));
	
	if($st > 0){
		$status = "IN PROGRESS";
		$no = ($max[no_max]);
	}else{
		$status = "STARTED";
		$no = 1;
	}
	
	mysqli_query($conn,"UPDATE tproblems SET status_problem='IN PROGRESS' WHERE idprob = '$_GET[id]'");
	mysqli_query($conn,"UPDATE tproblems SET status_problem='ASSIGN' WHERE idprob = '$_GET[idass]'");
	mysqli_query($conn,"INSERT INTO thandling VALUES(
										   NULL,
										   '$_GET[id]',
										   '$status',
										   '$_SESSION[username]',
										   NOW(),
										   ".$no."
										   )");
	 mysqli_query($conn,"INSERT INTO thandling VALUES(
										   NULL,
										   '$_GET[idass]',
										   'PAUSED',
										   '$_SESSION[username]',
										   NOW(),
										   ".($max_idass[no_max]+1)."
										   )");
	 mysqli_query($conn,"INSERT INTO tpending VALUES(
										   NULL,
										   '$_GET[idass]',
										   '$_POST[user]',
										   NOW(),
										   '$_POST[alasan]',
										   '$_SESSION[username]',
										   NOW()
										   )");
	$link = "<script>alert('$no Success. Thank You');window.location='../../page.php?p=todolist&act=problem-detail&id=$_GET[id]&i=as';</script>";
	echo $link;
}
if($p=='todolist' AND $act=='menunggusp'){
	$link = "<script>window.location='../../page.php?p=todolist&act=problem-detail&id=$_GET[id]&i=as';</script>";
	echo $link;
}

if($p=='todolist' AND $act=='finished'){
		
		$max = mysqli_fetch_array(mysqli_query($conn, "select max(no)as no_max from thandling where idprob = '$_GET[id]'"));
		$max_in = mysqli_fetch_array(mysqli_query($conn, "select max(no) as no_max_in from thandling where idprob = '$_GET[id]' where status = 'IN PROGRESS'"));
		
		$max_idass = mysqli_fetch_array(mysqli_query($conn, "select max(no)as no_max from thandling where idprob = '$_GET[idass]'"));
		
		if($max_in[no_max_in] = NULL || $max_in[no_max_in] = 0){
			$no = 2;
		}
		else{
			$no = $max[no_max]+1;
		}
		
		mysqli_query($conn,"UPDATE tproblems SET status_problem='FINISH' WHERE idprob = '$_GET[id]'");
		mysqli_query($conn,"INSERT INTO thandling VALUES(
														   NULL,
														   '$_GET[id]',
														   'FINISH',
														   '$_SESSION[username]',
														   NOW(),
														   1
														   )");
		//jika telah di approve sebelumnya
		$max_approve = mysqli_fetch_array(mysqli_query($conn, "select count(idHandling) as proved from thandling where idprob = '$_GET[id]' and statusProblem='APPROVED'"));
		if ($max_approve['proved'] > 0) {
			mysqli_query($conn,"UPDATE tproblems SET status_problem='APPROVED' WHERE idprob = '$_GET[id]'");
		}


		$link = "<script>alert('Finished Success. Thank You');
				window.location='../../page.php?p=todolist';</script>";
		echo $link;
	
}

if($p=='todolist' AND $act=='finished_dua'){
	
	function compress($source, $destination, $quality)
	{
     $info = getimagesize($source);
     if ($info['mime'] == 'image/jpeg') $image = imagecreatefromjpeg($source);
     elseif ($info['mime'] == 'image/gif') $image = imagecreatefromgif($source);
     elseif ($info['mime'] == 'image/png') $image = imagecreatefrompng($source);
     imagejpeg($image, $destination, $quality);
     return $destination;
	}
	
	$mesin = mysqli_query($conn, "select *from tmesin where namaMesin = '$_POST[job]'");
	$m = mysqli_fetch_array($mesin);
	
	foreach ($_FILES['ffinish']['name'] as $f => $fileName) {
	$ukuran	= $_FILES['ffinish']['size'][$f];
	
			if($fileName==''){
				$number = count($_POST['note']);
	
					$id = $_GET[id];
					$dtnote = $_POST[dt_note];
					$tmnote = $_POST[tm_note];
					$cby = $_POST[c_by];
					$mesin = $m[idMesin];
					$unit = $_POST[unit_mesin];
					$cat1 = $_POST[category1];
					$cat2 = $_POST[spek1];
					$cat3 = $_POST[spek2];
					
					for($i=0; $i<$number; $i++)  
					{
						
						 
						$note = $_POST[note][$i];
						mysqli_query($conn,"INSERT INTO tproblemnote( idprob, note, datenote, timenote, created_by, idMesin, idUnit, category1, category2, category3 ) 
													VALUES('$id',
														   '$note',
														   '$dtnote',
														   '$tmnote',
														   '$cby',
														   NULL,
														   NULL,
														   '$cat1',
														   '$cat2',
														   '$cat3'
														   )");
					}
					mysqli_query($conn,"INSERT INTO thandling VALUES(
														   NULL,
														   '$_GET[id]',
														   'CATATAN KERJA',
														   '$_SESSION[username]',
														   NOW(),
														   NULL
														   )");
					$link = "<script>alert('Note Success. Thank You');
					window.location='../../page.php?p=todolist&act=problem-detail&id=$_GET[id]&tek=$_GET[tek]&i=as';</script>";
					echo $link;
			}else{	
					$number = count($_POST['note']);
	
					$id = $_GET[id];
					$dtnote = $_POST[dt_note];
					$tmnote = $_POST[tm_note];
					$cby = $_POST[c_by];
					$mesin = $m[idMesin];
					$unit = $_POST[unit_mesin];
					$cat1 = $_POST[category1];
					$cat2 = $_POST[spek1];
					$cat3 = $_POST[spek2];
					$count = 0;
				
					for($i=0; $i<$number; $i++)  
					{
						$note = $_POST[note][$i];
						mysqli_query($conn,"INSERT INTO tproblemnote( idprob, note, datenote, timenote, created_by, idMesin, idUnit, category1, category2, category3 ) 
											VALUES('$id',
												   '$note',
												   '$dtnote',
												   '$tmnote',
												   '$cby',
												   NULL,
												   NULL,
												   '$cat1',
												   '$cat2',
												   '$cat3'
												   )");
					$link = "<script>alert('Finished Success. Thank You');
					window.location='../../page.php?p=todolist&act=problem-detail&id=$_GET[id]&tek=$_GET[tek]&i=as';</script>";
					echo $link;
					}
					
					$file = $id."_".$fileName;	
					//create folder upload
						 $tempdir = "attachment/note/";
						 if (!file_exists($tempdir)) mkdir($tempdir, 0755);

						 //target file
						 $target_path = $tempdir . basename($id."_".$_FILES['ffinish']['name'][$f]);

						 $source_img = $_FILES['ffinish']['tmp_name'][$f];

						 $destination_img = $target_path;

						 //panggil fungsi compress,
						 $r = compress($source_img, $destination_img, 65);
					
						
					mysqli_query($conn,"INSERT INTO tlampirannote (idprob, lampirannote, dtnote, tmnote) VALUES ('$id', '$file','$dtnote','$tmnote')");
					$count++;
					
					mysqli_query($conn,"UPDATE tproblems SET category ='$_POST[category1]', status_problem='FINISH' WHERE idprob = '$_GET[id]'");
					mysqli_query($conn,"INSERT INTO thandling VALUES(
												   NULL,
												   '$_GET[id]',
												   'CATATAN KERJA',
												   '$_SESSION[username]',
												   NOW(),
												   NULL
												   )"); 
					
				}
	}
	
}


if($p=='todolist' AND $act=='re-finished'){
	
	mysqli_query($conn,"UPDATE tproblems set status_problem='FINISH' WHERE idprob = '$_GET[id]'");
	mysqli_query($conn,"INSERT INTO thandling VALUES(
										   NULL,
										   '$_GET[id]',
										   'FINISH',
										   '$_SESSION[username]',
										   NOW(),
										   NULL
										   )");
	$link = "<script>alert('Re-Finished Success. Thank You');
	window.location='../../page.php?p=todolist';</script>";
	echo $link;
}

if($p=='approve' AND $act='approve'){
	//query untuk status x akan diarahkan ke approved 
	$query= mysqli_query($conn , "Select status_problem from tproblems where idprob='$_GET[id]'");
	
	$datastatus = mysqli_fetch_array($query);
	if ($datastatus['status_problem'] == 'X') {
		mysqli_query($conn,"UPDATE tproblems SET status_problem='CLOSED' WHERE idprob = '$_GET[id]'");	
	}
	//
	else
	{
		mysqli_query($conn,"UPDATE tproblems SET status_problem='APPROVED' WHERE idprob = '$_GET[id]'");
		mysqli_query($conn,"INSERT INTO thandling VALUES(
										   NULL,
										   '$_GET[id]',
										   'APPROVED',
										   '$_SESSION[username]',
										   NOW(),
										   NULL
										   )");
	}
	if(substr($_GET[id],0,3) == 'PGA'){
		$link = "<script>alert('Approved Success.');
		window.location='../../page.php?p=dashboard-internal';</script>";
		echo $link;
	}else{
		$link = "<script>alert('Approved Success.');
		window.location='../../page.php?p=dashboard';</script>";
		echo $link;
	}
	
}
if($p=='todolist' AND $act=='delete-problem'){
	mysqli_query($conn,"DELETE FROM tproblems WHERE idprob = '$_GET[id]'");
	unlink("attachment/".$_GET['nm']);
	if(substr($_GET['id'],0,3) == 'PGA'){
		$link = "<script>window.location='../../page.php?p=dashboard-internal';</script>";
		echo $link;
	}
	else if($_GET[dash]==1){
		$link = "<script>window.location='../../page.php?p=dashboard';</script>";
		echo $link;
	}else{
		$link = "<script>window.location='../../page.php?p=new-post&act=problem-list';</script>";
		echo $link;
	}
}
if($p=='todolist' AND $act=='problem-note'){
	mysqli_query($conn,"INSERT INTO tproblemnote( idprob, note, datenote, timenote, created_by ) 
					                VALUES('$_GET[id]',
										   '$_POST[note]',
										   '$_POST[dt_note]',
										   '$_POST[tm_note]',
										   '$_POST[c_by]'
										   )");
	$link = "<script>alert('Save Success.');
	window.location='../../page.php?p=todolist&act=problem-detail&id=$_GET[id]&i=$_GET[i]';</script>";
	echo $link;
}
if($p=='todolist' AND $act=='problem-action'){
	mysqli_query($conn,"INSERT INTO tproblemnote( idprob, note, datenote, timenote, created_by ) 
					                VALUES('$_GET[id]',
										   '$_POST[note]',
										   '$_POST[dt_note]',
										   '$_POST[tm_note]',
										   '$_POST[c_by]'
										   )");
	
	$link = "<script>alert('Save Success.');
	window.location='../../page.php?p=todolist&act=problem-detail&id=$_GET[id]';</script>";
	echo $link;
}
if($p=='todolist' AND $act=='delete-note'){
	mysqli_query($conn,"DELETE FROM tproblemnote WHERE idprob = '$_GET[id]' and created_by = '$_SESSION[username]' and datenote = '$_GET[d]' and timenote = '$_GET[t]'");
	
	$link = "<script>window.location='../../page.php?p=todolist&act=problem-detail&id=$_GET[id]&tek=$_GET[tek]&i=$_GET[i]';</script>";
	echo $link;
}

if($p=='todolist' AND $act=='sparepart'){
	$number = count($_POST["kode_sparepart"]);  
	mysqli_query($conn,"UPDATE tproblems SET status_problem='MENUNGGU SPAREPART' WHERE idprob = '$_POST[kode_problem]'");
	mysqli_query($conn,"UPDATE tpenjadwalan SET status_tugas='MENUNGGU SPAREPART' WHERE kode_tugas = '$_POST[kode_problem]' AND status_tugas not in ('PLAN')");
		if($number > 0)  
		{  
			 for($i=0; $i<$number; $i++)  
			  {  
					$no=$i+1;
						$sql = "INSERT INTO tsparepart (idProb, nama_teknisi, mesin, unit, kode_sparepart, qty, satuan, createdDate, lokasi)
								VALUES('".mysqli_real_escape_string($conn, $_POST["kode_problem"])."','".mysqli_real_escape_string($conn, $_POST["fullname"])."','".mysqli_real_escape_string($conn, $_POST["namaMesin"])."',
										'".mysqli_real_escape_string($conn, $_POST["namaUnit"])."','".mysqli_real_escape_string($conn, $_POST["kode_sparepart"][$i])."','".mysqli_real_escape_string($conn, $_POST["qty_sp"][$i])."',
										'".mysqli_real_escape_string($conn, $_POST["satuan_sp"][$i])."',NOW(),
										'".mysqli_real_escape_string($conn, $_POST["lokasi"][$i])."')"; 
						
						mysqli_query($conn, $sql);  
				 
			  }
		}
		
	//$max = mysqli_fetch_array(mysqli_query($conn, "select max(no)as no_max from thandling where idprob = '$_GET[id]'"));
	$max_in = mysqli_fetch_array(mysqli_query($conn, "select max(no) as no_max_in from thandling where idprob = '$_GET[id]' where status = 'IN PROGRESS'"));
	
	$max = mysqli_fetch_array(mysqli_query($conn, "select (max(no)) as no_max from thandling where idprob = '$_GET[id]'"));
	
	if($max_in[no_max_in] = NULL || $max_in[no_max_in] = 0){
		$no = 2;
	}
	else{
		$no = $max[no_max]+1;
	}		  
			  mysqli_query($conn,"INSERT INTO thandling VALUES(
										   NULL,
										   '$_GET[id]',
										   'MENUNGGU SPAREPART',
										   '$_SESSION[username]',
										   NOW(),
										   ".($max[no_max]+1)."
										   )");
	if($_GET[d]=='tugas_detail'){
		$link = "<script>alert('Permintaan Sparepart Berhasil ".$number."');
		window.location='../../page.php?p=todolist&act=tugas_detail&id=$_GET[id]&tek=$_GET[tek]&i=$_GET[i]';</script>";
		echo $link;
	}else{
		$link = "<script>alert('Permintaan Sparepart Berhasil ".$number."');
		window.location='../../page.php?p=todolist&act=problem-detail&id=$_GET[id]&i=$_GET[i]';</script>";
		echo $link;
	}
}
if($p=='todolist' AND $act=='delsp'){
	mysqli_query($conn,"DELETE FROM tsparepart WHERE idReq = '$_GET[idreq]'");
	$rr = mysqli_num_rows(mysqli_query($conn, "select *from tsparepart where idProb='$_GET[id]'"));
	$rt = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM tsparepart t left join tsparepart_action a on t.idReq=a.idReq
  			where t.idprob='$_GET[id]' AND a.idReq is null;"));
		if($rr <= 0 || $rt <=0)  
		{  
			$cek = mysqli_fetch_array(mysqli_query($conn, "SELECT c.PIC_HANDLING FROM `tproblems` a
															join tassign c on a.idprob=c.no_pelaporan
															where a.idprob = '$_GET[id]'
															group by a.idprob   ;"));
			$jum = mysqli_num_rows(mysqli_query($conn, "SELECT a.*,mc.category_name, c.PIC_HANDLING FROM `tproblems` a
															LEFT JOIN mcategories mc ON a.idcat=mc.idcat 
															join tassign c on a.idprob=c.no_pelaporan
															where a.status_problem IN ('IN PROGRESS')
															and c.PIC_HANDLING = '$cek[PIC_HANDLING]'
															group by a.idprob
															order by mc.idcat asc;"));
			if($jum > 0){
				mysqli_query($conn,"UPDATE tproblems SET status_problem='ASSIGN' WHERE idprob = '$idprob'");
				mysqli_query($conn,"INSERT INTO thandling VALUES(
												   NULL,
												   '$idprob',
												   'PAUSED',
												   '$_SESSION[username]',
												   NOW(),
												   '".($no+1)."'
												   )");
			 }else{
				 mysqli_query($conn,"UPDATE tproblems SET status_problem='IN PROGRESS' WHERE idprob = '$_GET[id]'");
				 mysqli_query($conn,"INSERT INTO thandling VALUES(
											   NULL,
											   '$_GET[id]',
											   'IN PROGRESS',
											   '$_SESSION[username]',
											   NOW(),
											   NULL
											   )");
			 }
			 
		}
	
	$link = "<script>alert('Berhasil hapus permintaan sparepart ".$rr."');
	window.location='../../page.php?p=todolist&act=problem-detail&id=$_GET[id]&i=$_GET[i]';</script>";
	echo $link;
}
if($p=='todolist' AND $act=='closed'){
	mysqli_query($conn,"UPDATE tproblems SET status_problem = 'CLOSED' WHERE idprob = '$_GET[id]'");
	mysqli_query($conn,"INSERT INTO thandling VALUES(
										   NULL,
										   '$_GET[id]',
										   'CLOSED',
										   '$_SESSION[username]',
										   NOW(),
										   NULL
										   )");
	if(substr($_GET[id],0,3) == 'PGA'){
		if($_GET[ds]=='approved'){
		$link = "<script>alert('Closed Success.');
		window.location='../../page.php?p=dashboard-internal&act=$_GET[ds]';</script>";
		echo $link;
		}else{
			$link = "<script>alert('Closed Success.');
			window.location='../../page.php?p=dashboard-internal';</script>";
			echo $link;
		}
	}else{
		if($_GET[ds]=='approved'){
		$link = "<script>alert('Closed Success.');
		window.location='../../page.php?p=dashboard&act=$_GET[ds]';</script>";
		echo $link;
		}else{
			$link = "<script>alert('Closed Success.');
			window.location='../../page.php?p=dashboard';</script>";
			echo $link;
		}
	}

	
	
}
if($p=='todolist' AND $act=='disapproved'){	
	mysqli_query($conn,"UPDATE tproblems SET status_problem = 'CLOSED' WHERE idprob = '$_GET[id]'");
	//mysqli_query($conn,"DELETE FROM thandling WHERE idProb = '$_GET[id]' AND statusProblem = 'APPROVED'");
	mysqli_query($conn,"DELETE FROM thandling WHERE idProb = '$_GET[id]' AND statusProblem = 'REJECTED'");					   
	
	if($_GET[ds]=='approved'){
		
	$link = "<script>alert('Disapproved Success.');
	window.location='../../page.php?p=dashboard&act=approved';</script>";
	echo $link;
	}else{
		
	$link = "<script>alert('Disapproved Success.');
	window.location='../../page.php?p=finished';</script>";
	echo $link;
	}
}

if($p=='todolist' AND $act=='rejected'){	
	//mysqli_query($conn,"UPDATE tproblems SET status_problem = 'IN PROGRESS' WHERE idprob = '$_GET[id]'");
	mysqli_query($conn,"UPDATE tproblems SET status_problem = 'REJECTED' WHERE idprob = '$_GET[id]'");
	//mysqli_query($conn,"DELETE FROM thandling WHERE idProb = '$_GET[id]' AND statusProblem = 'APPROVED'");
	mysqli_query($conn,"DELETE FROM thandling WHERE idProb = '$_GET[id]' AND statusProblem = 'REJECTED'");
	/* mysqli_query($conn,"INSERT INTO thandling VALUES(
										   NULL,
										   '$_GET[id]',
										   'REJECTED',
										   '$_SESSION[username]',
										   NOW(),
										   NULL
										   )"); */
					$id = $_GET[id];
					$dtnote = $_POST[dt_note];
					$tmnote = $_POST[tm_note];
					$cby = $_POST[c_by];
					$note = "REJECTED - ".$_POST[alasan_reject];
	mysqli_query($conn,"INSERT INTO tproblemnote( idprob, note, datenote, timenote, created_by, idMesin, idUnit, category1, category2, category3 ) 
													VALUES('$id',
														   '$note',
														   '$dtnote',
														   '$tmnote',
														   '$cby',
														   NULL,
														   NULL,
														   'REJECTED',
														   'REJECTED',
														   'REJECTED'
														   )");										   
	
	if(substr($id,0,3) == 'PGA'){
	if($_GET[s]=="dash"){
		if($_GET[ds]=="finish"){
			$link = "<script>alert('Rejected Success.');
			window.location='../../page.php?p=dashboard-internal&act=finish';</script>";
			echo $link;
		}else{
			$link = "<script>alert('Rejected Success.');
			window.location='../../page.php?p=dashboard-internal';</script>";
			echo $link;
		}
	}else{
		if($_GET[ds]=="finish"){
			$link = "<script>alert('Rejected Success.');
			window.location='../../page.php?p=dashboard&act=finish';</script>";
			echo $link;
		}else{
			$link = "<script>alert('Rejected Success.');
			window.location='../../page.php?p=dashboard';</script>";
			echo $link;
		}
	}
	} 
	
	else{
		$link = "<script>alert('Rejected Success.');
		window.location='../../page.php?p=finished';</script>";
		echo $link;
	}
}

if($p=='todolist' AND $act=='pending'){
	mysqli_query($conn,"UPDATE tproblems SET status_problem = 'PENDING' WHERE idprob = '$_GET[id]'");
	mysqli_query($conn,"UPDATE tpenjadwalan SET status_tugas = 'PENDING' WHERE kode_tugas = '$_GET[id]' AND status_tugas NOT IN ('PLAN','DIKERJAKAN','FINISH')");
	mysqli_query($conn,"INSERT INTO tpending VALUES(
										   NULL,
										   '$_GET[id]',
										   '$_POST[user]',
										   NOW(),
										   '$_POST[alasan]',
										   '$_SESSION[username]',
										   NOW()
										   )");
	mysqli_query($conn,"INSERT INTO thandling VALUES(
										   NULL,
										   '$_GET[id]',
										   'PENDING',
										   '$_SESSION[username]',
										   NOW(),
										   NULL
										   )");
	$link = "<script>alert('Pending Success.');
	window.location='../../page.php?p=pendingproblem';</script>";
	echo $link;
}
if($p=='todolist' AND $act=='dispending'){
	
	mysqli_query($conn,"UPDATE tproblems SET status_problem = 'IN PROGRESS' WHERE idprob = '$_GET[id]'");
	mysqli_query($conn,"UPDATE tpenjadwalan SET status_tugas = 'IN PROGRESS' WHERE kode_tugas = '$_GET[id]' AND status_tugas IN ('PENDING')");
	mysqli_query($conn,"INSERT INTO thandling VALUES(
										   NULL,
										   '$_GET[id]',
										   'DISPENDING',
										   '$_SESSION[username]',
										   NOW(),
										   NULL
										   )");									   
	
	$link = "<script>alert('Disapproved Success.');
	window.location='../../page.php?p=pendingproblem';</script>";
	echo $link;
}
if($p=='estimasi' AND $act=='input_estimasi'){
	$est_day	= $_POST[est_day];
	$est_hour 	= $_POST[est_hour];
	$est_min	= $_POST[est_minute];
	
	if($est_day == NULL){$est_day = 0;}
	if($est_hour == NULL){$est_hour = 0;}
	if($est_min == NULL){$est_min = 0;}
	
	mysqli_query($conn,"UPDATE tassign SET EST_DAY 	= $est_day,
										   EST_HOUR = $est_hour,
										   EST_MIN	= $est_min,
										   PIC_HANDLING = '$_POST[teknisi]'
										   WHERE NO_PELAPORAN = '$_POST[idprob]'");						   
	
	$link = "<script>alert('Input Estimasi Handling, Success. ');
	window.location='../../page.php?p=input-est-time';</script>";
	echo $link;
}
if($p=='todolist' AND $act=='tambah'){
	$est_day	= $_POST[est_day];
	$est_hour 	= $_POST[est_hour];
	$est_min	= $_POST[est_minute];
	
	if($est_day == NULL){$est_day = 0;}
	if($est_hour == NULL){$est_hour = 0;}
	if($est_min == NULL){$est_min = 0;}
	
	mysqli_query($conn,"UPDATE tassign SET EST_DAY 	= $est_day,
										   EST_HOUR = $est_hour,
										   EST_MIN	= $est_min,
										   PIC_HANDLING = '$_POST[teknisi]'
										   WHERE NO_PELAPORAN = '$_POST[idprob]'");						   
	
	if(substr($_POST[idprob],0,3) == 'MTC'){
		mysqli_query($conn,"UPDATE tpenjadwalan SET est_day 	= $est_day,
										   est_hour = $est_hour,
										   est_min	= $est_min,
										   teknisi = '$_POST[teknisi]'
										   WHERE kode_tugas = '$_POST[idprob]' AND status_tugas = 'PLAN'");
	}

	$link = "<script>alert('Ubah Estimasi Waktu pada Kasus ".$_POST[idprob].", Menjadi ".$est_day." Hari, ".$est_hour." Jam, ".$est_min." Menit , Success. ');
	window.location='../../page.php?p=dashboard&act=".$_GET[ds]."';</script>";
	echo $link;
}
mysqli_close($conn);