<?php
session_start();
require_once('bdd.php');
//echo $_POST['title'];
if (isset($_POST['title']) && isset($_POST['start']) && isset($_POST['end']) && isset($_POST['color'])){
	//$m = date(m);$d = date(d);$y = date(Y);
	$dated = $_POST['start'];
	
	$y = substr($dated, 0, 4);
	$m = substr($dated, 5, 2);
	$d = substr($dated, 8, 2);
	
	$dep	 = $bdd->query("select * from user where username='$_SESSION[username]' ");
	$dp		 = $dep->fetch();
	
	$ds		 = $bdd->query("select * from mdocumentseries where divisi='$dp[divisi]' and dokumen like 'MTC%'");
	$series	 = $ds->fetch();
	
	$result	 = $bdd->query("select max(kode_tugas) as no , datetgs from tpenjadwalan where datetgs='$dated' ");
	$row	 = $result->fetch();
	
		$noUrut = (int) substr($row[0], 13, 3);
		$noUrut++;
		$char = "$series[series]-$y$m$d-";
		$newID = $char . sprintf("%03s", $noUrut);
	echo "<h2>$row[0]</h2>";
	
	//$title 		= $_POST['title']." - ".$_POST['mesin'];
	$title		= $newID;
	$title_only = $_POST['title'];
	$start 		= $_POST['start'];
	$end 		= $_POST['start'];
	$color 		= $_POST['color'];
	$mesin 		= $_POST['mesin'];
	$teknisi 	= $_POST['teknisi'];
	$isi_tugas 	= $_POST['isi_tgs'];
	if($_POST['est_day']==NULL){$est_day 	= 0;}else{$est_day 	= $_POST['est_day'];}
	if($_POST['est_hour']==NULL){$est_hour 	= 0;}else{$est_hour 	= $_POST['est_hour'];}
	if($_POST['est_minute']==NULL){$est_min = 0;}else{$est_min 	= $_POST['est_minute'];}
	

	$sql = "INSERT INTO tpenjadwalan(title, start, end, color, mesin, teknisi, isi_tugas, datetgs, title_only, kode_tugas, status_tugas, est_day, est_hour, est_min, created_by, created_date, changed_by, changed_date, series) values 		
				('$title', '$start', '$end', '$color', '$mesin', '$teknisi', '$isi_tugas', '$start', '$title_only', '$newID', 'PLAN', '$est_day', '$est_hour', '$est_min', '$_SESSION[username]', NOW(), '$_SESSION[username]', NOW(),'$series[series]')";
	
	
	$sqq = "INSERT INTO tpenjadwalantemp(kode_tugas, teknisi, assign_date, EST_DAY, EST_HOUR, EST_MIN) values 		
				('$newID', '$teknisi', '$start', '$est_day', '$est_hour', '$est_min')";

	//SIMPAN DI TABEL PROBLEM

	//$user = mysqli_fetch_array(mysqli_query($conn, "select *from user u where username = '$_SESSION[username]'"));
	$mes	 = $bdd->query("select *from tmesin m where namaMesin = '$mesin' ");
	$ms		 = $mes->fetch();

	$sql_prob = "INSERT INTO tproblems (idprob, idcat, namapelapor, dateprob, timeprob, deskripsi, created_by, divisi_problem, created_at, updated_at, updated_by, status_problem, id_mesin, id_unit_mesin, category)
					                VALUES('$newID',
										   '3',
										   '$dp[fullname]',
										   '2021-06-25',
										   '00:00:00',
										   '$isi_tugas',
										   '$_SESSION[username]',
										   '$dp[divisi]',
										    NOW(),
											NOW(),
											'$_SESSION[username]',
											'PLAN',
											'$ms[idMesin]',
											0,
											'Mechanical'
										   )";
	
	echo $sql;
	echo $sqq;
	
	$query = $bdd->prepare( $sql );
	if ($query == false) {
	 print_r($bdd->errorInfo());
	 die ('Error prepare');
	}
	$query_prob = $bdd->prepare( $sql_prob );
	if ($query_prob == false) {
	 print_r($bdd->errorInfo());
	 die ('Error prepare jadwal');
	}

	$sth = $query->execute();
	if ($sth == false) {
	 print_r($query->errorInfo());
	 die ('Error execute');
	}
	$sth_prob = $query_prob->execute();
	if ($sth_prob == false) {
	 print_r($query_prob->errorInfo());
	 die ('Error execute');
	}
	
	$quer = $bdd->prepare( $sqq );
	if ($quer == false) {
	 print_r($bdd->errorInfo());
	 die ('Error prepare');
	}
	$st = $quer->execute();
	if ($st == false) {
	 print_r($quer->errorInfo());
	 die ('Error execute');
	}

}
header('Location: '.$_SERVER['HTTP_REFERER']);

	
?>
