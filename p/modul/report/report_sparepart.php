 <?php
 error_reporting(0);
session_start(); 
$m = date(m);$d = date(d);$y = date(Y);
$aksi="modul/911/aksi_911.php";
$y = date('Y');
$m = date('m');
$d = date('d');
 ?>
  <link rel="stylesheet" href="">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/css/select2.min.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js"></script>
			<?php
switch($_GET[act]){
default:
			echo"
			<div class='block-header'>
                <div class='row'>
                    <div class='col-lg-5 col-md-8 col-sm-12'>                        
                        <h2><a href='javascript:void(0);' class='btn btn-xs btn-link btn-toggle-fullwidth'><i class='fa fa-arrow-left'></i></a> Report Request Sparepart</h2>
                        <ul class='breadcrumb'>
                            <li class='breadcrumb-item'><a href='?p=dashboard'><i class='icon-home'></i></a></li>                            
                            <li class='breadcrumb-item active'>Report</li>
                        </ul>
                    </div>         
                </div>
            </div>
				<div class='col-lg-12 col-md-12'>
                    <div class='card'>
                        <div class='body'>
                           <div class='row'>
						    <div class='col-lg-12 col-md-12'>
							<u><h6>Report Permintaan Sparepart</h6></u><br />
							<form method='post' action='?p=report-reqsparepart&act=list'>
								<table border='0' width='100%'>
								<tr><td width='15%'>Kode Masalah</td><td>";?>
									<select id="idprob" name="idprob[]" class="theSelect_idprob form-control" multiple="multiple">
				                        <option value=""></option>
				                           <?php
					                        // ambil data dari database
					                        $query2 = "SELECT idProb from tproblems order by idProb ASC;";
					                        $hasil2 = mysqli_query($conn, $query2);
					                        while ($row2 = mysqli_fetch_array($hasil2)) {
					                            ?>
					                            <option value="<?php echo $row2['idProb']; ?>">
					                            	<?php echo $row2['idProb']; ?></option>
					                            <?php
					                        }
					                        ?>
				                    </select>
									<?php
									echo"
									</td><td>&nbsp;</td><td width='15%'>&nbsp;</td><td>&nbsp;</td></tr>
									<tr><td width='15%'>Teknisi </td><td>
										<select class='default-select2 form-control' name='nm_teknisi'>
											<option value=''>---Select Teknisi---</option>";
											$q = mysqli_query($conn, "select FULLNAME,USERNAME from user where divisi='MAINTENANCE' and (active=1 or active=2) order by fullname asc");
											while($p = mysqli_fetch_array($q)){
													echo "<option value='$p[USERNAME]'>$p[FULLNAME]</option>";
											}
											echo "
										</select>
									</td><td>&nbsp;</td>
									<td width='15%'>&nbsp;</td><td>&nbsp;</td></tr>
									<tr><td width='20%'>Tanggal Problem Mulai</td><td><input type='date' name='begda_tsk' class='form-control'></td><td>&nbsp;</td>
									<td width='10%' align='center'>Sampai </td><td width='33%'><input type='date' name='endda_tsk' class='form-control' ></td></tr>
									<tr><td width='20%'>Tanggal Req. Sparepart</td><td><input type='date' name='begda' class='form-control' ></td><td>&nbsp;</td>
									<td width='10%' align='center'>Sampai </td><td width='33%'><input type='date' name='endda' class='form-control'  ></td></tr>
										<tr><td width='15%'>Mesin </td><td>
											<select class='form-control show-tick' name='idmesin' id='idmesin'>
												<option selected disabled>---Select Mesin---</option>";
												$r = mysqli_query($conn, "select *from tmesin order by namaMesin ASC");
												while($c = mysqli_fetch_array($r)){
														echo "<option value='$c[idMesin]'>$c[namaMesin]</option>";
													}
												echo "
											</select>
											</td><td>&nbsp;</td><td width='15%'>&nbsp;</td><td>&nbsp;</td></tr>
											<tr><td width='15%'>Unit Mesin </td><td>
											<select class='form-control show-tick'  name='idunit' id='unit'>
												<option selected disabled>---Select Unit---</option>
												</select>
											</td><td>&nbsp;</td><td width='15%'>&nbsp;</td><td>&nbsp;</td></tr>
									<tr><td width='15%'>Kode / Nama Sparepart</td><td>";?>
									<select id="kota2" name="kode_sp[]" class="theSelect form-control" multiple="multiple">
				                        <option value=""></option>
				                           <?php
					                        // ambil data dari database
					                        $query2 = "SELECT t.idReq,  ta.nama_sparepart, ta.kode_sparepart FROM tsparepart t join tsparepart_action ta ON t.idReq=ta.idReq
												where ta.nama_sparepart IS NOT NULL AND ta.nama_sparepart !='' 
												group by ta.nama_sparepart 
												order by ta.nama_sparepart asc;";
					                        $hasil2 = mysqli_query($conn, $query2);
					                        while ($row2 = mysqli_fetch_array($hasil2)) {
					                            ?>
					                            <option value="<?php echo $row2['nama_sparepart']; ?>">
					                            	<?php echo $row2['nama_sparepart'] ."- [".$row2['kode_sparepart']."]"; ?></option>
					                            <?php
					                        }
					                        ?>
				                    </select>
									<?php
									echo"
									</td><td>&nbsp;</td><td width='15%'>&nbsp;</td><td>&nbsp;</td></tr>
								</table><br /><br />
								<p align='right'>";
								?>
								<button class="btn btn-danger" type="submit"><b><i class='fa fa-print'></i>&nbsp; &nbsp; TAMPILKAN</button>
								<?php
								echo"
							</form>
							
                        </div>
                    </div></div>
							";
	break;
	case "list":
	echo"
			<div class='block-header'>
                <div class='row'>
                    <div class='col-lg-5 col-md-8 col-sm-12'>                        
                        <h2><a href='javascript:void(0);' class='btn btn-xs btn-link btn-toggle-fullwidth'><i class='fa fa-arrow-left'></i></a> Problem Report</h2>
                        <ul class='breadcrumb'>
                            <li class='breadcrumb-item'><a href='?p=dashboard'><i class='icon-home'></i></a></li>                            
                            <li class='breadcrumb-item active'>Report</li>
                        </ul>
                    </div>         
                </div>
            </div>
				<div class='col-lg-12 col-md-12'>
                    <div class='card'>
                        <div class='body'>
                           <div class='row'>
						    <div class='col-lg-12 col-md-12'>
							<div class='table-responsive'>
                                <table class='table table-striped table-hover dataTable js-exportable'>
                                    <thead>
                                        <tr>
											<th align='center' width='10%' style='display:none'>No.</th>
											<th align='center' width='10%'>KODE</th>
											<th align='center' width='10%'>TANGGAL PROB.</th>
											<th align='left' width='15%'>TANGGAL REQ.</th>
											<th align='left' width='15%'>TEKNISI</th>
											<th align='left' width='15%'>NAMA SP</th>
											<th width='10%'>KODE SP</th>
                                            <th align='center'>JUMLAH</th>
											<th align='center'>SATUAN</th>
											<th align='center'>MESIN</th>
                                            <th >UNIT MESIN</th>
                                            <th width='10%'>LOKASI</th>
											<th >APPROVED OLEH</th>
											<th >TANGGAL APPROVED</th>
                                        </tr>
                                    </thead>
                                    <tbody>";

                                    	$idproblem = array();
										foreach ($_POST['idprob'] as $idprob) {
										    array_push($idproblem, $idprob);
										}
										$idprob = "'".implode("','",$idproblem)."'";

										$kota_favorit = array();
										foreach ($_POST['kode_sp'] as $kota2) {
										    array_push($kota_favorit, $kota2);
										}
										$kota2 = "'".implode("','",$kota_favorit)."'";
									//echo "KOTA = $idprob";
									echo "<br />";
									//echo "Hasil = $kota2";
									$cari = "SELECT p.dateprob, s.username, m.idMesin, u.idUnit, t.idReq, t.idProb, t.nama_teknisi, t.kode_sparepart, t.mesin, t.unit,ta.nama_sparepart, t.qty, t.satuan, t.createdDate, ta.info, ta.createdBy as appBy, ta.createdDate as appDate, t.lokasi as lokasi
											 FROM tsparepart t left join tsparepart_action ta ON t.idReq=ta.idReq
											 left join tmesin m on t.mesin=m.namaMesin
						                       LEFT JOIN tmesinunit u on t.unit=u.namaUnit
						                       left join `user` s on s.fullname=t.nama_teknisi
						                       left join tproblems p on t.idProb=p.idProb
											 where ta.createdBy IS NOT NULL AND ta.createdDate IS NOT NULL" ;
									if($_SESSION[divisi]==MAINTENANCE){
										$cari .= "  AND t.lokasi = 'G19SP' ";
									}if($_SESSION[divisi]==GA){
										$cari .= "  AND t.lokasi = 'GGA' ";
									}if($_POST[begda_tsk]!=NULL AND $_POST[endda_tsk]!=NULL){
										$cari .= "  AND p.dateprob BETWEEN '$_POST[begda_tsk]' AND '$_POST[endda_tsk]' ";
									}if($_POST[begda]!=NULL AND $_POST[endda]!=NULL){
										$cari .= "  AND date(t.createdDate) BETWEEN '$_POST[begda]' AND '$_POST[endda]' ";
									}if($_POST[idprob]!=NULL){
										$cari .= " AND t.idProb IN ($idprob) ";
									}if($_POST[nm_teknisi]!=NULL){
										// ada tanggal yg lain tidak												
										$cari .= " AND s.username = '$_POST[nm_teknisi]' ";
									}if($_POST[idmesin]!=NULL){
										//Ad teknisi yg lain tidak
										$cari .= " AND m.idMesin='$_POST[idmesin]' ";
									}if($_POST[idunit]!=NULL){
										//Ad status yg lain tidak
										$cari .= " AND u.idUnit ='$_POST[idunit]' ";
									}if($_POST[kode_sp]!=NULL){
										//Ad status yg lain tidak
										$cari .= " AND ta.nama_sparepart IN ($kota2) ";
									}
									$cari .= " order by ta.nama_sparepart ASC";
									$hasil  = mysqli_query($conn,$cari);
									
									$no=1;
									
									while($r = mysqli_fetch_array($hasil)){
									
									$usernya = mysqli_fetch_array(mysqli_query($conn, "select *from user where username='$r[handling]'"));
									
									
									echo "
                                        <tr>
											<td style='display:none' align='center'>$no</td>
											<td><h6><b>$r[idProb]</b></h6></td>
											<td>$r[dateprob]</td>
											<td>$r[createdDate]</td>
											<td>$r[nama_teknisi]</td>
											<td>$r[kode_sparepart]</td>
											<td>$r[nama_sparepart]</td>
                                            <td align='center'>$r[qty]</td>
											<td align='center'>".strtoupper($r[satuan])."</td>
                                            <td>$r[mesin]</td>
											<td>$r[unit]</td>
											<td>$r[lokasi]</td>
											<td>$r[appBy]</td>
											<td>$r[appDate]</td>
                                        </tr>";
										$no++;
									}
										
                              echo"      </tbody>
                                </table>
                            </div>
							
                        </div>
                    </div></div>
							";
	break;
}
mysqli_close($conn);
?>
<script>
	$(".theSelect").select2();
	$(".theSelect_idprob").select2();
</script>
<script language='javascript'>
$(document).ready(function() {
    $('#example').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5'
        ]
    } );
} );
</script>