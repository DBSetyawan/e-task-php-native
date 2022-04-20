 <?php
 error_reporting(0);
session_start(); 
$m = date(m);$d = date(d);$y = date(Y);
$aksi="modul/911/aksi_911.php";
$y = date('Y');
$m = date('m');
$d = date('d');
 ?>
 <div class="container-fluid">
			<?php
switch($_GET[act]){
default:
			echo"
			<div class='block-header'>
                <div class='row'>
                    <div class='col-lg-5 col-md-8 col-sm-12'>                        
                        <h2><a href='javascript:void(0);' class='btn btn-xs btn-link btn-toggle-fullwidth'><i class='fa fa-arrow-left'></i></a> Report Maintenance</h2>
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
							<u><h6>Jadwal Pemeliharaan Mesin</h6></u><br />
							<form method='post' action='?p=report-jadwalmtc&act=list_reportjadwal'>
								<table border='0' width='100%'>
							<!--	<tr><td width='20%'>Bulan Pemeliharaan</td><td><input type='date' name='begda' class='form-control' value= '$y-$m-01'></td><td>&nbsp;</td></tr> -->
								<tr><td width='20%'>Tanggal Pemeliharaan</td><td><input type='date' name='begda' class='form-control' value= '$y-$m-01'></td><td>&nbsp;</td>
									<td width='10%' align='center'>Sampai </td><td width='33%'><input type='date' name='endda' class='form-control' value= '$y-$m-$d' ></td></tr>
									<tr><td width='15%'>Mesin </td><td>
											<select class='form-control show-tick' name='mesin' id='mesin'>
												<option  value='' >---Select Mesin---</option>";
												$r = mysqli_query($conn, "select *from tmesin ");
												while($c = mysqli_fetch_array($r)){
														echo "<option value='$c[namaMesin]'>$c[namaMesin]</option>";
													}
												echo "
											</select>
											</td><td>&nbsp;</td><td width='15%'>&nbsp;</td><td>&nbsp;</td></tr>
								<tr><td width='15%'>Jenis Pekerjaan </td><td>
											<select class='form-control show-tick' name='jen_kerja' id='jen_kerja'>
												<option  value='' >---Select Jenis Pekerjaan---</option>";
												$r = mysqli_query($conn, "select *from mpekerjaan ");
												while($c = mysqli_fetch_array($r)){
														echo "<option value='$c[namaPekerjaan]'>$c[namaPekerjaan]</option>";
													}
												echo "
											</select>
											</td><td>&nbsp;</td><td width='15%'>&nbsp;</td><td>&nbsp;</td></tr>
									<tr><td width='15%'>Teknisi </td><td>
										<select class='default-select2 form-control' name='nm_teknisi'>
											<option value=''>---Select Teknisi---</option>";
											$q = mysqli_query($conn, "select FULLNAME,USERNAME from user where divisi='MAINTENANCE' and active=1 order by fullname asc");
											while($p = mysqli_fetch_array($q)){
													echo "<option value='$p[USERNAME]'>$p[FULLNAME]</option>";
											}
											echo "
										</select>
									</td><td>&nbsp;</td>
									<td width='15%'>&nbsp;</td><td>&nbsp;</td></tr>
									
								</table><br /><br />
								<p align='right'>";
								?>
								<button class="btn btn-success" type="submit"><b>Tampilkan</button>
								<?php
								echo"
							</form>
							
                        </div>
                    </div></div>
							";
	break;
	case "list_reportjadwal":
	echo"
	<div class='block-header'>
                <div class='row'>
                    <div class='col-lg-5 col-md-8 col-sm-12'>                        
                        <h2><a href='javascript:void(0);' class='btn btn-xs btn-link btn-toggle-fullwidth'><i class='fa fa-arrow-left'></i></a> Report Maintenance</h2>
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
											<th align='center' width='10%'>KODE</th>
											<th align='left' width='15%'>PRIORITAS</th>
											<th align='left' width='15%'>MESIN</th>
                                            <th align='center'>JENIS PEKERJAAN</th>
											<th width='10%'>TEKNISI</th>
											<th align='center'>JADWAL PADA</th>
											<th align='center'>DIKERJAKAN PADA</th>
											<th align='center'>ESTIMASI PENGERJAAN</th>
											<th align='center'>REAL PENGERJAAN</th>
											<th align='center'>STATUS LAPORAN</th>
											<th align='center'>AKSI</th>
                                        </tr>
                                    </thead>
                                    <tbody>";
									$no=1;
										//$c = mysqli_query($conn, "select *from tpenjadwalan where status_tugas='PLAN' group by kode_tugas");
										// $cari = "select *from tpenjadwalan where status_tugas='PLAN' AND MONTH(datetgs) = MONTH('$_POST[begda]')  ";
										$cari = "select *from tpenjadwalan where status_tugas='PLAN' AND datetgs between '$_POST[begda]' and '$_POST[endda]' ";   
										if($_POST[nm_teknisi] != NULL){
											$cari .= "AND teknisi = '$_POST[nm_teknisi]'";
										}
										if($_POST[mesin] != NULL){
											$cari .="  AND mesin='$_POST[mesin]'";
										}
										if($_POST[jen_kerja] != NULL){
											$cari .= " AND title_only ='$_POST[jen_kerja]'";
										}
										$cari .= "group by kode_tugas";
											$hasil  = mysqli_query($conn,$cari);
										while($r = mysqli_fetch_array($hasil)){
											$k = mysqli_fetch_array(mysqli_query($conn, "select *from tpenjadwalan 
																							where status_tugas='DIKERJAKAN' and kode_tugas='$r[kode_tugas]'
																							group by kode_tugas"));
											$s = mysqli_fetch_array(mysqli_query($conn, "select *from tpenjadwalan 
																							where status_tugas NOT IN ('PLAN') and kode_tugas='$r[kode_tugas]'
																							group by kode_tugas"));
											$p = mysqli_fetch_array(mysqli_query($conn, "select *from tproblems p left join mcategories m on p.idcat=m.idcat where idprob='$r[kode_tugas]'"));
											$u = mysqli_fetch_array(mysqli_query($conn, "select *from user where username='$r[teknisi]'"));


											//REJECT jumlah
									
											$re = "select a.NoLaporan, a.JumlahReject
												from (
													  SELECT problem.idProb as NoLaporan, problem.dateprob, count(*) as JumlahReject
													  FROM tproblems problem
													  join tproblemnote note on problem.idProb=note.idProb
													  where note.category1='REJECTED'
													  group by problem.idProb
													 ) a
												join (SELECT idProb,handling,dateAction,max(dateAction)
													  FROM thandling handling
													  where statusProblem='FINISH'
													  group by idProb
													 ) b on a.NoLaporan=b.idProb
												join user c on b.handling=c.username where NoLaporan='$r[kode_tugas]'";
												$rej  = mysqli_query($conn,$re);
												$reject = mysqli_fetch_array($rej);
											if($reject[JumlahReject] == NULL){
												$jumreject = 0;
											}else{	
												$jumreject = $reject[JumlahReject];
											}

											//TOTAL WAKTU SETELAH PAUSE DAN IN PROGRESS
										$at = mysqli_query($conn, "SELECT idprob, `no`, statusProblem, dateAction FROM thandling t where statusProblem = 'PAUSED' and idprob='$r[kode_tugas]' order by idprob asc");
										$ct = mysqli_fetch_array($at);
										$bt = mysqli_query($conn, "SELECT idprob, `no`, statusProblem, dateAction  FROM thandling t where no = '$ct[no]' and idprob = '$ct[idprob]' and statusProblem = 'IN PROGRESS'");
											  $dt = mysqli_fetch_array($bt);
											  	$tpause = 0;
											  	$tinpro = 0;
											  	$tpause = strtotime($ct[dateAction]);
											  	$tinpro = strtotime($dt[dateAction]);
											  
											  
											 // $hasilw = $tinpro - $tpause;
											
											  $total = $tinpro - $tpause;
											  //$total += $hasilw;
											  $id = $ct[idprob];
											 // ECHO "NOMOR : $r[cdprob] - $ct[no] - $total<br />";
										 
										   //$total = $tot;
												  
										$usernya = mysqli_fetch_array(mysqli_query($conn, "select *from user where username='$r[teknisi]'"));
											
										$time_start = mysqli_fetch_array(mysqli_query($conn, "select idProb, statusProblem, dateAction, handling from thandling where (statusProblem = 'STARTED' OR statusProblem = 'IN PROGRESS') AND idProb = '$r[kode_tugas]' AND handling = '$r[teknisi]' ORDER BY dateAction asc LIMIT 1"));
										$time_fin = mysqli_fetch_array(mysqli_query($conn, "select idProb, statusProblem, dateAction, handling from thandling where statusProblem = 'FINISH' AND idProb = '$r[kode_tugas]' order by dateAction DESC LIMIT 1 "));
										$time_fin_awal = mysqli_fetch_array(mysqli_query($conn, "select idProb, statusProblem, dateAction, handling from thandling where statusProblem = 'FINISH' AND idProb = '$r[kode_tugas]' order by dateAction ASC LIMIT 1 "));
										$time_fin_rej = mysqli_fetch_array(mysqli_query($conn, "select idProb, statusProblem, dateAction, handling from thandling where statusProblem = 'REJECTED' AND idProb = '$r[kode_tugas]' order by dateAction DESC LIMIT 1 "));
										
										$time_menunggusp = mysqli_fetch_array(mysqli_query($conn, "select idProb, statusProblem, dateAction, handling from thandling where statusProblem = 'MENUNGGU SPAREPART' AND idProb = '$r[kode_tugas]' ORDER BY dateAction desc LIMIT 1"));
										$time_inpro2 = mysqli_fetch_array(mysqli_query($conn, "select idProb, statusProblem, dateAction, handling from thandling where statusProblem = 'IN PROGRESS' AND idProb = '$r[kode_tugas]' ORDER BY dateAction desc LIMIT 1"));
										
										$time_pending = mysqli_fetch_array(mysqli_query($conn, "select idProb, statusProblem, dateAction, handling from thandling where (statusProblem = 'PENDING') AND idProb = '$r[kode_tugas]' ORDER BY dateAction desc LIMIT 1"));
										$time_dispending = mysqli_fetch_array(mysqli_query($conn, "select idProb, statusProblem, dateAction, handling from thandling where statusProblem = 'DISPENDING' AND idProb = '$r[kode_tugas]' ORDER BY dateAction desc LIMIT 1"));
										
										$time_app = mysqli_fetch_array(mysqli_query($conn, "select idProb, statusProblem, dateAction, handling from thandling where statusProblem = 'APPROVED' AND idProb = '$r[kode_tugas]'"));
										
										$awal  = strtotime($time_start[dateAction]); //waktu awal
										$akhir = strtotime($time_fin[dateAction]); //waktu akhir
										
										$tunggu_in = strtotime($time_inpro2[dateAction]); //waktu menunggu sparepart
										$tunggu_sp = strtotime($time_menunggusp[dateAction]); //waktu menunggu sparepart
										
										$tunggu_dispen = strtotime($time_dispending[dateAction]); //waktu dispending
										$tunggu_pen = strtotime($time_pending[dateAction]); //waktu pending
										
										//RE-IN PROGRESS RE-FINISH
										$time_reinp = mysqli_fetch_array(mysqli_query($conn, "select idProb, statusProblem, dateAction, handling from thandling where statusProblem = 'RE-IN PROGRESS' AND idProb = '$r[kode_tugas]'"));
										$time_refin = mysqli_fetch_array(mysqli_query($conn, "select idProb, statusProblem, dateAction, handling from thandling where statusProblem = 'FINISH' AND idProb = '$r[kode_tugas]' ORDER BY dateAction desc LIMIT 1"));
										
										$time_reinpro = strtotime($time_reinp[dateAction]); //waktu re inprogress
										$time_refinish = strtotime($time_refin[dateAction]); //waktu re finish
										
										$fawal  = strtotime($time_fin_awal[dateAction]); //Finish waktu awal
										$rej    = strtotime($time_fin_rej[dateAction]); //Rejevt waktu
									
									if($time_reinp[idProb]==NULL){
										if($time_menunggusp[idProb]==NULL){
											if($tunggu_pen==NULL){
												$diff_pen = 0;
												$diff  = ($akhir - $awal);
												$all = $diff - $total;
											}else{
												$differ  = ($akhir - $awal);
												$diff_pen = ($tunggu_dispen - $tunggu_pen)+$total;
												$diff = $differ - $diff_pen;
												$all = $diff - $total;
											}
										}
										else{
											if($tunggu_pen==NULL){
												$differ  = ($akhir - $awal); //waktu normal
												$diff_pen = 0;
												$differe  = ($tunggu_in - $tunggu_sp); //in progress setelah menunggu sarepart - menunggu sarepart
												$diff 	 = $differ - $differe;
												$all = $diff - $total;
											}else{
												$differ  = ($akhir - $awal); //waktu normal
												$diff_pen = ($tunggu_dispen - $tunggu_pen)+$total; //waktu pending
												$differe  = ($tunggu_in - $tunggu_sp); //in progress setelah menunggu sarepart - menunggu sarepart
												$diff 	 = $differ - $differe - $diff_pen;
												$all = $diff - $total;
											}
										}
									}else{
										if($time_menunggusp[idProb]==NULL){
											if($tunggu_pen==NULL){
												$differ  = ($akhir - $awal);
												$diff_pen = 0;
												$diff_ke2 = ($time_refinish - $time_reinpro);
												$diff 	 = ($differ + $diff_ke2);
												$all = $diff - $total;
											}else{
												$differ  = ($akhir - $awal);
												$diff_pen = ($tunggu_dispen - $tunggu_pen)+$total;
												$diff_ke2 = ($time_refinish - $time_reinpro);
												$diff 	 = ($differ + $diff_ke2)-$diff_pen;
												$all = $diff - $total;
											}
										}
										else{
											if($tunggu_pen==NULL){
												$differ  = ($akhir - $awal);
												$differe  = ($tunggu_in - $tunggu_sp);
												$diff_pen = 0;
												$diff_ke2 = ($time_refinish - $time_reinpro);
												$diff 	 = ($differ - $differe)+$diff_ke2;
												$all = $diff - $total;
											}else{
												$differ  = ($akhir - $awal);
												$differe  = ($tunggu_in - $tunggu_sp);
												$diff_pen = ($tunggu_dispen - $tunggu_pen)+$total;
												$diff_ke2 = ($time_refinish - $time_reinpro);
												$diff 	 = ($differ - $differe - $diff_pen)+$diff_ke2;
												$all = $diff - $total;
											}
										}
										
									}
									
									if($rej==0){
										$all = $all;
									}else{
										$all = $all - ($rej-$fawal);
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
									
									//PENDING ATASAN -----------------------------------
									// Untuk menghitung jumlah dalam satuan hari:
									$hari_P = floor($diff_pen/86400);

									// Untuk menghitung jumlah dalam satuan jam:
									$sisa_P = $diff_pen % 86400;
									$jam_P = floor($sisa_P/3600);

									// Untuk menghitung jumlah dalam satuan menit:
									$sisa_P = $sisa_P % 3600;
									$menit_P = floor($sisa_P/60);
									
									//PENDING PRIBADI-----------------------------------
									// Untuk menghitung jumlah dalam satuan hari:
									$h_P = floor($total/86400);

									// Untuk menghitung jumlah dalam satuan jam:
									$s_P = $total % 86400;
									$j_P = floor($s_P/3600);

									// Untuk menghitung jumlah dalam satuan menit:
									$s_P = $s_P % 3600;
									$m_P = floor($s_P/60);
									
									//-----------------------------------------------------
									
									// Untuk menghitung jumlah dalam satuan detik:
									
									if($akhir<=NULL || $all <=0){ $real_day = 0; $real_hour = 0; $real_min = 0;}else{ $real_day = $hari; $real_hour = $jam; $real_min = $menit;}
									if($differe <=0){$hari_SP = 0; $jam_SP=0; $menit_SP=0;}else{$hari_SP=$hari_SP; $jam_SP=$jam_SP; $menit_SP=$menit_SP;}
									if($diff_pen <=0){$hari_P = 0; $jam_P=0; $menit_P=0;}else{$hari_P=$hari_P; $jam_P=$jam_P; $menit_P=$menit_P;}
									if($total <=0){$h_P = 0; $j_P=0; $m_P=0;}else{$h_P=$h_P; $j_P=$j_P; $m_P=$m_P;}
											


											echo "
												<tr>
												<td>$r[kode_tugas]</td>
												<!-- <td>$p[category_name]</td> -->
												<td>Normal</td>
												<td>$r[mesin]</td>
												<td>$r[title_only]</td>
												<td>$u[fullname]</td>
												<td align='center'>$r[datetgs]</td>
												<td align='center'>$k[datetgs]</td>
												<td align='center'>$r[est_day] DAYS $r[est_hour] HOURS $r[est_min] MINUTES</td>";
												if(($k[est_day] == NULL && $k[est_hour] ==NULL && $k[est_min] == NULL))
												{
													echo"<td align='center'>-</td>";
												}else{
													echo"<td align='center'>$k[est_day] DAYS $k[est_hour] HOURS $k[est_min] MINUTES</td>";
												}
												if($p[status_problem]==NULL){
													$status = $s[status_tugas];
													if($s[status_tugas]==NULL){
														$status = "PLAN";
													}
												}else{
													$status = $p[status_problem];
												}
												echo"<td>$status</td>";
												echo"<td>";
												if($k[datetgs]==NULL){
													echo"<b><font color='black'>-</font></b>";
												}
												else if($k[est_day] > $r[est_day]){
													echo"<b><font color='red'>OVERDUE</font></b>";
												}else if($k[est_day] == $r[est_day]){
													if($k[est_hour] > $r[est_hour]){
														echo"<b><font color='red'>OVERDUE</font></b>";
													}else if($k[est_hour] == $r[est_hour]){
															if($k[est_min] > $r[est_min]){
																echo"<b><font color='red'>OVERDUE</font></b>";
															}else{
																echo"<b><font color='green'>ON TIME</font></b>";
															}
													}else{
														echo"<b><font color='green'>ON TIME</font></b>";
													}
												}else{
													echo"<b><font color='green'>ON TIME</font></b>";
												}
											echo"</td>";
												
											$no++;
										}
										
                              echo"      </tbody>
                                </table>
                            </div>
							
                        </div>
                    </div></div>";
	break;
}
mysqli_close($conn);
?>
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