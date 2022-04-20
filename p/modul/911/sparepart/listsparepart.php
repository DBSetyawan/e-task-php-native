 <?php
error_reporting(0);
/* ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL); */
session_start(); 
$m = date(m);$d = date(d);$y = date(Y);
$aksi="modul/911/sparepart/aksi_sparepart.php";
$dated = date('Y-m-d');
 ?>
 <div class="container-fluid">
			<?php
switch($_GET[act]){
default:
			echo"
			<div class='block-header'>
                <div class='row'>
                    <div class='col-lg-5 col-md-8 col-sm-12'>                        
                        <h2><a href='javascript:void(0);' class='btn btn-xs btn-link btn-toggle-fullwidth'><i class='fa fa-arrow-left'></i></a> Daftar Permintaan Sparepart</h2>
                        <ul class='breadcrumb'>
                            <li class='breadcrumb-item'><a href='?p=dashboard'><i class='icon-home'></i></a></li>                            
                            <li class='breadcrumb-item active'>Sparepart</li>
                        </ul>
                    </div>         
                </div>
            </div>
			
				<div class='col-lg-12 col-md-12'>
                    <div class='card'>
                        <div class='body'>
							<form method='POST' action='?p=sparepart&act=permintaan'>
								<table border='0' width='100%'>
									<tr>
										<td><button type='submit' class='btn btn-block btn-success m-t-20'>Buat Permintaan</button></td>
										<td align='right' width='81%'><h4><font color='red'><u>Permintaan Sparepart</u></font></h4></td>
									</tr>
								</table><br />
                           <div class='row'>
						    <div class='col-lg-12 col-md-12'>
							<div class='table-responsive'>
                                <table class='table table-striped table-hover dataTable'>
                                    <thead>
                                        <tr>
											<th align='center' width='10%'>No.</th>
											<th align='center' width='10%'>KODE</th>
											<th align='left' width='15%'>TANGGAL REQ.</th>
											<th align='left' width='15%'>TEKNISI</th>
											<th align='left' width='15%'>NAMA SP</th>
											<th width='10%'>KODE SP</th>
                                            <th align='center'>JUMLAH</th>
											<th align='center'>SATUAN</th>
											<th align='center'>MESIN</th>
                                            <th >UNIT MESIN</th>
                                        </tr>
                                    </thead>
                                    <tbody>";
                                    if($_SESSION['divisi']=='GA'){
                                    	$cari = "SELECT t.idReq, t.idProb, t.nama_teknisi, t.mesin, t.unit, t.kode_sparepart, t.mesin, t.unit, t.lokasi,
											 ta.nama_sparepart, t.qty, t.satuan, t.createdDate, ta.info, ta.createdBy as appBy, ta.createdDate as appDate 
											 FROM tsparepart t left join tsparepart_action ta ON t.idReq=ta.idReq
											 where (t.idprob like 'PGA%' and lokasi in (SELECT lokasi FROM mdocumentseriesl m where series='PGA' and lokasi_dep=1)) and ta.createdBy IS NULL AND ta.createdDate IS NULL" ;
                                    }else{
                                    	$cari = "SELECT t.idReq, t.idProb, t.nama_teknisi, t.mesin, t.unit, t.kode_sparepart, t.mesin, t.unit, t.lokasi,
											 ta.nama_sparepart, t.qty, t.satuan, t.createdDate, ta.info, ta.createdBy as appBy, ta.createdDate as appDate 
											 FROM tsparepart t left join tsparepart_action ta ON t.idReq=ta.idReq
											 where t.lokasi = 'G19SP' AND ta.createdBy IS NULL AND ta.createdDate IS NULL" ;
                                    }
									
									
									$hasil  = mysqli_query($conn,$cari);
									
									$no=1;
									
									while($r = mysqli_fetch_array($hasil)){
									
									$usernya = mysqli_fetch_array(mysqli_query($conn, "select *from user where username='$r[handling]'"));
									
									
									echo "
                                        <tr>
											<td align='center'><input type='checkbox' name='req[]' value='$r[idReq]'></td>
											<td><h6><b>$r[idProb]</b></h6></td>
											<td>$r[createdDate]</td>
											<td>$r[nama_teknisi]</td>
											<td>$r[kode_sparepart]</td>
											<td>$r[nama_sparepart]</td>
                                            <td align='center'>$r[qty]</td>
											<td align='center'>".strtoupper($r['satuan'])."</td>
                                            <td>$r[mesin]</td>
											<td>$r[unit]</td>
											
                                        </tr>";
										$no++;
									}
										
                              echo"      </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
					</form>
					</div>
					 </div></div>
					<!--
					<div class='col-lg-12 col-md-12'>
                    <div class='card'>
                        <div class='body'>
						<font size='2' color='red'><b>*Jika ingin menarik report secara LENGKAP, dapat dilakukan di Menu Report Sparepart. Dihalaman ini hanya ditampilkan permintaan sparepart pada bulan ini dan 1 bulan sebelumnya.</b></font>
						<h4 align='right'><font color='green'><u>Sudah Diberi Sparepart</u></font></h4>
                           <div class='row'>
						    <div class='col-lg-12 col-md-12'>
							<div class='table-responsive'>
                                <table class='table table-striped table-hover dataTable js-exportable'>
                                    <thead>
                                        <tr>
											<th align='center' width='10%' style='display:none'>No.</th>
											<th align='center' width='10%'>KODE</th>
											<th align='left' width='15%'>TANGGAL REQ.</th>
											<th align='left' width='15%'>TEKNISI</th>
											<th align='left' width='15%'>NAMA SP</th>
											<th width='10%'>KODE SP</th>
                                            <th align='center'>JUMLAH</th>
											<th align='center'>SATUAN</th>
											<th align='center'>MESIN</th>
                                            <th >UNIT MESIN</th>
											<th >APPROVED OLEH</th>
											<th >TANGGAL APPROVED</th>
											<th >BATAL</th>
                                        </tr>
                                    </thead>
                                    <tbody> -->"; 
                                    if($_SESSION[divisi]=='GA'){
                                    	$cari = "SELECT t.idReq, t.idProb, t.nama_teknisi, t.mesin, t.unit, t.kode_sparepart, t.mesin, t.unit,
											 ta.nama_sparepart, t.qty, t.satuan, t.createdDate, ta.info, ta.createdBy as appBy, ta.createdDate as appDate
											 FROM tsparepart t left join tsparepart_action ta ON t.idReq=ta.idReq
											 where t.lokasi='GGA' AND ta.createdBy IS NOT NULL AND ta.createdDate IS NOT NULL
											 AND year(t.createdDate) = year(CURRENT_DATE())
                       						 and month(t.createdDate) between MONTH(CURRENT_DATE())-1 
                       						 AND MONTH(CURRENT_DATE())" ;
                                    }else{
                                    	$cari = "SELECT t.idReq, t.idProb, t.nama_teknisi, t.mesin, t.unit, t.kode_sparepart, t.mesin, t.unit,
											 ta.nama_sparepart, t.qty, t.satuan, t.createdDate, ta.info, ta.createdBy as appBy, ta.createdDate as appDate
											 FROM tsparepart t left join tsparepart_action ta ON t.idReq=ta.idReq
											 where t.lokasi='G19SP' AND ta.createdBy IS NOT NULL AND ta.createdDate IS NOT NULL
											 AND year(t.createdDate) = year(CURRENT_DATE())
                       						 and month(t.createdDate) between MONTH(CURRENT_DATE())-1 
                       						 AND MONTH(CURRENT_DATE())" ;
                                    }
									
									
									$hasil  = mysqli_query($conn,$cari);
									
									$no=1;
									
									while($r = mysqli_fetch_array($hasil)){
									
									$usernya = mysqli_fetch_array(mysqli_query($conn, "select *from user where username='$r[handling]'"));
									
									
									echo "
									<!--
                                        <tr>
											<td style='display:none' align='center'>$no</td>
											<td><h6><b>$r[idProb]</b></h6></td>
											<td>$r[createdDate]</td>
											<td>$r[nama_teknisi]</td>
											<td>$r[kode_sparepart]</td>
											<td>$r[nama_sparepart]</td>
                                            <td align='center'>$r[qty]</td>
											<td align='center'>".strtoupper($r[satuan])."</td>
                                            <td>$r[mesin]</td>
											<td>$r[unit]</td>
											<td>$r[appBy]</td>
											<td>$r[appDate]</td>
											<td>
												<a href='$aksi?p=sparepart&act=batal&idreq=$r[idReq]'><button type='button' class='btn btn-danger btn-block'>BATAL</button></a>
											</td>
                                        </tr> -->";
										$no++;
									}
										
                              echo"  <!--    </tbody>
                                </table>
                            </div>
							
                        </div>
                    </div></div> -->
							";
	break;
	case "permintaan":
		
		
		
		mysqli_close($conn_sim);
		echo "
		<div class='block-header'>
                <div class='row'>
                    <div class='col-lg-5 col-md-8 col-sm-12'>                        
                        <h2><a href='javascript:void(0);' class='btn btn-xs btn-link btn-toggle-fullwidth'><i class='fa fa-arrow-left'></i></a> Formulir Permintaan Sparepart</h2>
                        <ul class='breadcrumb'>
                            <li class='breadcrumb-item'><a href='?p=dashboard'><i class='icon-home'></i></a></li>
							 <li class='breadcrumb-item'><a href='?p=sparepart'>List Sparepart</a></li>
                            <li class='breadcrumb-item active'>Formulir Sparepart</li>
                        </ul>
                    </div>         
                </div>
            </div>
		
		
		<div class='col-lg-12 col-md-12'>
                    <div class='card'>
                        <div class='body'>
							<form method='POST' action='$aksi?p=sparepart&act=permintaan'>
								
                           <div class='row'>
						    <div class='col-lg-12 col-md-12'>
							<div class='table-responsive'>
                                <table class='table table-striped table-hover dataTable'>
                                    <thead>
                                        <tr>
											<th align='center' width='10%'>No.</th>
											<th align='left' width='15%'>KODE SP</th>
											<th width='10%'>NAMA SP</th>
                                            <th align='center'>JUMLAH</th>
											<th align='center'>PEMILIK</th>
											<th align='center'>SATUAN</th>
                                        </tr>
                                    </thead>
                                    <tbody>";
									
									$jumlah = count($_POST[req]);
									if($jumlah >0){
									$no=1;
									for($i=0; $i<$jumlah; $i++)  
									{
										$idreq = $_POST[req][$i];
										$cari = "SELECT t.idReq, t.idProb, t.nama_teknisi, t.mesin, t.unit, t.kode_sparepart, 
											 ta.nama_sparepart, t.qty, t.satuan, t.createdDate, ta.info, ta.createdBy as appBy, ta.createdDate as appDate 
											 FROM tsparepart t left join tsparepart_action ta ON t.idReq=ta.idReq
											 where t.idReq = '$idreq'" ;
									
										$hasil  = mysqli_query($conn,$cari);
										
										
									
										$r = mysqli_fetch_array($hasil);

										//cek sim

										include "../config/koneksi_sim.php";
										$query_unit = mysqli_query($conn_sim, "SELECT * FROM masterunit");
										$unit = "<option value='' selected disabled>---pilih unit---</option>";
										while ($result = mysqli_fetch_array($query_unit)) {
											
											if ($result['Code']== strtoupper($r['satuan'])) {
												$unit .="<option value='$result[Code]' selected>$result[Name]($result[Code])</option>";
											}
											else {
												$unit .="<option value='$result[Code]'>$result[Name]($result[Code])</option>";
											}
										}
										
										mysqli_close($conn_sim);

										//end ceksim

										$option="";
										if($l[divisi]=='MAINTENANCE')
										{
											$option="<option value='MTC' selected>MTC</option>
													<option value='BpkHar'>Pak Har</option>";
										}
										else {
											$option="<option value='GA' selected>GA</option>";
										}
										echo "
											<tr>
												<td align='center' width='1%'>$no.</td>
												<td width='25%'>
												<input type='hidden' name='idProb[]' class='form-control' value='$r[idProb]'>
												<input type='hidden' name='idReq[]' class='form-control' value='$r[idReq]'>
												<input type='hidden' name='nama_pelapor[]' class='form-control' value='$r[nama_teknisi]'>
												<input type='text' name='nama_sparepart[]' class='form-control' autofocus required /></td>
												<td width='20%'><input type='text' name='kode_sparepart[]' class='form-control' value='$r[kode_sparepart]'></td>
												<td width='15%' align='center'><input type='number' name='qty_ya[]' class='form-control' value='$r[qty]' min=1></td>
												<td width='20%'><select name='pemilik[]' class='form-control'>
													$option
												</select></td>
												<td align='center'><select  name='satuan_ya[]' class='form-control' required>$unit</select></td>
											</tr>";
											$no++;
									}
									}else{
										echo "<tr><td colspan='5' align='center'><font color='red'>Tidak ada permintaan yang dipilih.</font></td></tr>";
									}
										
                              echo"      </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
					<table border='0' width='100%'>
									<tr>
										<td width='81%'></td>
										<td align='right' >";
										if($jumlah >0){
											echo"<a href='?p=sparepart'>
												<button type='button' class='btn btn-block btn-default m-t-20'>Kembali</button></a>
												<button type='submit' class='btn btn-block btn-success m-t-20'>Disetujui</button></td>";
										}else{
											echo"<a href='?p=sparepart'>
												<button type='button' class='btn btn-block btn-default m-t-20'>Kembali</button></a>
												<button type='submit' class='btn btn-block btn-success m-t-20' disabled=''>Disetujui</button></td>";
										}
										echo"
									</tr>
								</table><br />
					</form>
					</div>
					 </div></div>
					 
					 <div class='col-lg-12 col-md-12'>
                    <div class='card'>
                        <div class='body'>
							<form method='POST' action='$aksi?p=sparepart&act=permintaan'>
								<table border='0' width='100%'>
									<tr>
										<td><h6><font color='red'><u>Permintaan Sparepart</u></font></h6></td>
										<td align='right' width='81%'><h4><font color='red'><u></u></font></h4></td>
									</tr>
								</table><br />
                           <div class='row'>
						    <div class='col-lg-12 col-md-12'>
							<div class='table-responsive'>
                                <table class='table table-striped table-hover dataTable'>
                                    <thead>
                                        <tr>
											<th align='center' width='10%' style='display:none'>No.</th>
											<th align='center' width='10%'>KODE</th>
											<th align='left' width='15%'>TANGGAL REQ.</th>
											<th align='left' width='15%'>TEKNISI</th>
											<th align='left' width='15%'>NAMA SP</th>
											<th width='10%'>KODE SP</th>
                                            <th align='center'>JUMLAH</th>
											<th align='center'>SATUAN</th>
											<th align='center'>MESIN</th>
                                            <th width='10%'>UNIT MESIN</th>
                                        </tr>
                                    </thead>
                                    <tbody>";
									
									/*$usernya = mysqli_fetch_array(mysqli_query($conn, "select *from user where username='$r[handling]'"));
									
									$time_inpro = mysqli_fetch_array(mysqli_query($conn, "select idProb, statusProblem, dateAction, handling from thandling where statusProblem = 'IN PROGRESS' AND idProb = '$r[idprob]'"));
									$time_fin = mysqli_fetch_array(mysqli_query($conn, "select idProb, statusProblem, dateAction, handling from thandling where statusProblem = 'FINISH' AND idProb = '$r[idprob]'"));
									$awal  = strtotime($time_inpro[dateAction]); //waktu awal
									$akhir = strtotime($time_fin[dateAction]); //waktu akhir

									$diff  = $akhir - $awal;
								
									// Untuk menghitung jumlah dalam satuan hari:
									$hari = floor($diff/86400);

									// Untuk menghitung jumlah dalam satuan jam:
									$sisa = $diff % 86400;
									$jam = floor($sisa/3600);

									// Untuk menghitung jumlah dalam satuan menit:
									$sisa = $sisa % 3600;
									$menit = floor($sisa/60); */
									
									$jumlah = count($_POST[req]);
									$no=1;
									for($i=0; $i<$jumlah; $i++)  
									{
										$idreq = $_POST[req][$i];
										$cari = "SELECT t.idReq, t.idProb, t.nama_teknisi, t.mesin, t.unit, t.kode_sparepart, t.mesin, t.unit,
											 ta.nama_sparepart, t.qty, t.satuan, t.createdDate, ta.info, ta.createdBy as appBy, ta.createdDate as appDate 
											 FROM tsparepart t left join tsparepart_action ta ON t.idReq=ta.idReq
											 where t.idReq = '$idreq'" ;
									
										$hasil  = mysqli_query($conn,$cari);
									
										
									
										$r = mysqli_fetch_array($hasil);
										echo "
											<tr>
												<td style='display:none' align='center'>$no</td>
											<td><h6><b>$r[idProb]</b></h6></td>
											<td>$r[createdDate]</td>
											<td>$r[nama_teknisi]</td>
											<td>$r[kode_sparepart]</td>
											<td>$r[nama_sparepart]</td>
                                            <td align='center'>$r[qty]</td>
											<td align='center'>".strtoupper($r[satuan])."</td>
                                            <td>$r[mesin]</td>
											<td>$r[unit]</td>
											</tr>";
											$no++;
									}
										
                              echo"      </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
					</form>
					</div>
					 </div></div>
							";
	break;
}
?>
