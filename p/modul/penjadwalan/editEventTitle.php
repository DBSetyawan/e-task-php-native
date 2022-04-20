<?php
session_start();
require_once('bdd.php');
if (isset($_POST['delete']) && isset($_POST['id'])){
	
	
	$id = $_POST['id'];
	
	$sql = "DELETE FROM tpenjadwalan WHERE id = $id";
	$query = $bdd->prepare( $sql );
	
	
	$pj	 	= $bdd->query("select * from tpenjadwalan where id = $id ");
	$jd		= $pj->fetch();
	
	$sql_temp = "DELETE FROM tpenjadwalantemp WHERE kode_tugas = '$jd[kode_tugas]'";
	$query_temp = $bdd->prepare( $sql_temp );
	
	if ($query == false) {
	 print_r($bdd->errorInfo());
	 die ('Error prepare');
	}
	$res = $query->execute();
	if ($res == false) {
	 print_r($query->errorInfo());
	 die ('Error execute');
	}
	
	if ($query_temp == false) {
	 print_r($bdd->errorInfo());
	 die ('Error prepare');
	}
	$res_temp = $query_temp->execute();
	if ($res_temp == false) {
	 print_r($query_temp->errorInfo());
	 die ('Error execute');
	}
	
}elseif (isset($_POST['title']) && isset($_POST['color']) && isset($_POST['mesin']) && isset($_POST['teknisi']) && isset($_POST['isi_tgs']) && isset($_POST['id'])){
	
	$id = $_POST['id'];
	$kode = $_POST['kode_tugas'];
	$title_mesin = $_POST['title']." - ".$_POST['mesin'];
	$title = $_POST['title'];
	$color = $_POST['color'];
	$mesin = $_POST['mesin'];
	$teknisi = $_POST['teknisi'];
	$isi_tugas = $_POST['isi_tgs'];
	$est_day = $_POST['est_day'];
	$est_hour = $_POST['est_hour'];
	$est_min = $_POST['est_minute'];
	
	$sql = "UPDATE tpenjadwalan SET  title = '$kode', color = '$color', mesin = '$mesin', teknisi = '$teknisi', isi_tugas = '$isi_tugas', title_only = '$title', changed_by = '$_SESSION[username]', changed_date = NOW(),
			est_day = '$est_day', est_hour = '$est_hour', est_min = '$est_min'
			WHERE id = $id ";

	
	$query = $bdd->prepare( $sql );
	if ($query == false) {
	 print_r($bdd->errorInfo());
	 die ('Error prepare');
	}
	$sth = $query->execute();
	if ($sth == false) {
	 print_r($query->errorInfo());
	 die ('Error execute');
	}

}
header('Location: index.php');

	
?>
