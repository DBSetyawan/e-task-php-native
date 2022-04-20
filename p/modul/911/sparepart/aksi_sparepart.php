<?php
/* error_reporting(1); */
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
include('../../../../config/koneksi.php');
$m = date('m');$d = date('d');$y = date('Y');
$p	=$_GET['p'];  $act	=$_GET['act'];

if($p=='sparepart' AND $act=='permintaan'){
$jumlah = count($_POST['idReq']);
$kode = count($_POST['idProb']);

	//Pengecekan apakah semua sudah diberikan sparepartnya
	

	for($i=0; $i<$jumlah; $i++)  
	{
		$req = $_POST['idReq'][$i];
		$kode_sp = $_POST['kode_sparepart'][$i];
		$nama_sp = $_POST['nama_sparepart'][$i];
		$nama_pel = $_POST['nama_pelapor'][$i];
		$qty_ya = $_POST['qty_ya'][$i];
		$satuan_ya = $_POST['satuan_ya'][$i];
		$pemilik = $_POST['pemilik'][$i];
		
		$quer=mysqli_query($conn,"INSERT INTO tsparepart_action 
					                VALUES(NULL,
										   '$req',
										   '$kode_sp',
										   '$nama_sp',
										   '$qty_ya',
										   '$satuan_ya',
										   '$nama_pel',
										   '$_SESSION[username]',
										    NOW(),
											'$pemilik'
										   );");
		if(!$quer)
		{
			echo 'gagal';
		}
	}
	for($j=0; $j<$kode; $j++){
	
	$idprob = $_POST[idProb][$j];
	
	$st = mysqli_num_rows(mysqli_query($conn, "select * from thandling where idprob = '$idprob' AND statusProblem='STARTED'"));
	$max = mysqli_fetch_array(mysqli_query($conn, "select max(no)as no_max from thandling where idprob = '$idprob'"));
	if($st > 0){
		$status = "IN PROGRESS";
		$no = ($max[no_max]);
	}else{
		$status = "STARTED";
		$no = 1;
	}
	
		//mysqli_query($conn,"UPDATE tproblems SET status_problem='IN PROGRESS' WHERE idprob = '$idprob'");
		
		mysqli_query($conn,"INSERT INTO thandling VALUES(
										   NULL,
										   '$idprob',
										   '$status',
										   '$_SESSION[username]',
										   NOW(),
										   '$no'
										   )");
	
	$cek = mysqli_fetch_array(mysqli_query($conn, "SELECT c.PIC_HANDLING FROM `tproblems` a
															join tassign c on a.idprob=c.no_pelaporan
															where a.idprob = '$idprob'
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
		//mysqli_query($conn,"UPDATE tpenjadwalan SET status_tugas='ASSIGN' WHERE kode_tugas = '$idprob'");
		// mysqli_query($conn,"INSERT INTO thandling VALUES(
		// 								   NULL,
		// 								   '$idprob',
		// 								   'PAUSED',
		// 								   '$_SESSION[username]',
		// 								   NOW(),
		// 								   '".($no+1)."'
		// 								   )");
	 }else{
		 mysqli_query($conn,"UPDATE tproblems SET status_problem='IN PROGRESS' WHERE idprob = '$idprob'");
		 mysqli_query($conn,"UPDATE tpenjadwalan SET status_tugas='IN PROGRESS' WHERE kode_tugas = '$idprob' AND status_tugas not in ('PLAN')");
	 }
	}
	$link = "<script>alert('Save Success.');
	window.location='../../../page.php?p=sparepart';</script>";
	echo $link;
}
if($p=='sparepart' AND $act=='batal'){
	mysqli_query($conn,"DELETE FROM tsparepart_action WHERE idReq = '$_GET[idreq]'");
	mysqli_query($conn,"DELETE FROM tsparepart WHERE idReq = '$_GET[idreq]'");
	
	$link = "<script>window.location='../../../page.php?p=sparepart';</script>";
	echo $link;
}
mysqli_close($conn);
?>