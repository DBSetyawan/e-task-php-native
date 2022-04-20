 <?php
 error_reporting(0);
session_start(); 
$m = date(m);$d = date(d);$y = date(Y);
$aksi="modul/911/aksi_911.php";
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
											<th align='center' width='10%'>CODE</th>
											<th align='left' width='15%'>PELAPOR</th>
											<th align='left' width='15%'>DIVISI</th>
											<th width='10%'>TEKNISI</th>
                                            <th align='center'>MASALAH</th>
											<th align='center'>PRIORITAS</th>
											<th align='center'>MESIN</th>
											<th align='center'>UNIT MESIN</th>
                                            <th width='10%'>WAKTU LAPOR</th>
											<th width='10%'>STATUS</th>
											<th width='10%'>EST. WAKTU PERBAIKAN</th>
											<th width='10%'>MENUNGGU SPAREPART</th>
											<th width='10%'>PENDING</th>
											<th width='8%'>REAL WAKTU PERBAIKAN</th>
											<th width='8%'>KERJA</th>
											<th width='8%'>AKSI</th>
                                        </tr>
                                    </thead>
                                    <tbody>";
										
										$cari = "SELECT tp.idprob as cdprob, tp.namapelapor, tp.dateprob, tp.timeprob, tp.deskripsi, tp.created_by, tp.divisi_problem,
												   tp.created_at,tp.updated_at, tp.status_problem, tp.id_mesin, tp.id_unit_mesin, tp.category, mc.*, t.*, th.*, tn.*,
												   tm.*, tu.*
													FROM tproblems tp LEFT JOIN mcategories mc ON tp.idcat=mc.idcat
												 LEFT JOIN tassign t ON tp.idProb = t.NO_PELAPORAN
												 LEFT JOIN thandling th ON tp.idProb = th.idProb
												 LEFT JOIN tproblemnote tn ON tp.idProb = tn.idprob
												 LEFT JOIN tmesin tm ON tm.idMesin=tp.id_mesin
												 LEFT JOIN tmesinunit tu ON tp.id_unit_mesin = tu.idUnit
												 WHERE t.created_date IN
													(select max(created_date) from tassign group by no_pelaporan)
												 GROUP BY tp.idProb order by substring(tp.idprob,5,12) DESC";
									
									$hasil  = mysqli_query($conn,$cari);
									$ketemu = mysqli_num_rows($hasil);
									echo "<h6 align='right'><font color='red'> $ketemu </font>entries.</h6>";
									
									$no=1;
									
									while($r = mysqli_fetch_array($hasil)){
									
									$usernya = mysqli_fetch_array(mysqli_query($conn, "select *from user where username='$r[PIC_HANDLING]'"));
									
									/* $time_inpro = mysqli_fetch_array(mysqli_query($conn, "select idProb, statusProblem, dateAction, handling from thandling where statusProblem = 'IN PROGRESS' AND idProb = '$r[idprob]'"));
									$time_fin = mysqli_fetch_array(mysqli_query($conn, "select idProb, statusProblem, dateAction, handling from thandling where statusProblem = 'FINISH' AND idProb = '$r[idprob]' order by dateAction DESC LIMIT 1"));
									$awal  = strtotime($time_inpro[dateAction]); //waktu awal
									$akhir = strtotime($time_fin[dateAction]); //waktu akhir */

									$time_inpro = mysqli_fetch_array(mysqli_query($conn, "select idProb, statusProblem, dateAction, handling from thandling where statusProblem = 'IN PROGRESS' AND idProb = '$r[idprob]' ORDER BY dateAction asc LIMIT 1"));
									$time_fin = mysqli_fetch_array(mysqli_query($conn, "select idProb, statusProblem, dateAction, handling from thandling where statusProblem = 'FINISH' AND idProb = '$r[idprob]' order by dateAction DESC LIMIT 1"));
									
									$time_menunggusp = mysqli_fetch_array(mysqli_query($conn, "select idProb, statusProblem, dateAction, handling from thandling where statusProblem = 'MENUNGGU SPAREPART' AND idProb = '$r[idprob]'"));
									$time_inpro2 = mysqli_fetch_array(mysqli_query($conn, "select idProb, statusProblem, dateAction, handling from thandling where statusProblem = 'IN PROGRESS' AND idProb = '$r[idprob]' ORDER BY dateAction desc LIMIT 1"));
									
									$time_pending = mysqli_fetch_array(mysqli_query($conn, "select idProb, statusProblem, dateAction, handling from thandling where statusProblem = 'PENDING' AND idProb = '$r[idprob]'"));
									$time_dispending = mysqli_fetch_array(mysqli_query($conn, "select idProb, statusProblem, dateAction, handling from thandling where statusProblem = 'DISPENDING' AND idProb = '$r[idprob]' ORDER BY dateAction desc LIMIT 1"));
								
									$awal  = strtotime($time_inpro[dateAction]); //waktu awal
									$akhir = strtotime($time_fin[dateAction]); //waktu akhir
									
									$tunggu_in = strtotime($time_inpro2[dateAction]); //waktu menunggu sparepart
									$tunggu_sp = strtotime($time_menunggusp[dateAction]); //waktu menunggu sparepart
									
									$tunggu_dispen = strtotime($time_dispending[dateAction]); //waktu dispending
									$tunggu_pen = strtotime($time_pending[dateAction]); //waktu pending
								

									//RE-IN PROGRESS RE-FINISH
										$time_reinp = mysqli_fetch_array(mysqli_query($conn, "select idProb, statusProblem, dateAction, handling from thandling where statusProblem = 'RE-IN PROGRESS' AND idProb = '$r[idprob]'"));
										$time_refin = mysqli_fetch_array(mysqli_query($conn, "select idProb, statusProblem, dateAction, handling from thandling where statusProblem = 'FINISH' AND idProb = '$r[idprob]' ORDER BY dateAction desc LIMIT 1"));
										
										$time_reinpro = strtotime($time_reinp[dateAction]); //waktu re inprogress
										$time_refinish = strtotime($time_refin[dateAction]); //waktu re finish
										
										
							/* if($time_reinp[idProb]==NULL){
								if($time_menunggusp[idProb]==NULL){
									if($tunggu_pen[idProb]==NULL){
										$diff_pen = 0;
										$diff  = ($akhir - $awal);
									}else{
										$differ  = ($akhir - $awal);
										$diff_pen = ($tunggu_dispen - $tunggu_pen);
										$diff = $differ - $diff_pen; 
									}
								}
								else{
									if($tunggu_pen==NULL){
										$differ  = ($akhir - $awal); //waktu normal
										$differe  = ($tunggu_in - $tunggu_sp); //in progress setelah menunggu sarepart - menunggu sarepart
										$diff_pen = 0;
										$diff 	 = $differ - $differe - $diff_pen;
									}else{
										$differ  = ($akhir - $awal); //waktu normal
										$diff_pen = ($tunggu_dispen - $tunggu_pen); //waktu pending
										$differe  = ($tunggu_in - $tunggu_sp); //in progress setelah menunggu sarepart - menunggu sarepart
										$diff 	 = $differ - $differe - $diff_pen;
									}
								}
							}else{
								if($time_menunggusp[idProb]==NULL){
									if($tunggu_pen==NULL){
										$diff_pen = 0;
										$differ  = ($akhir - $awal);
										$diff_ke2 = ($time_refinish - $time_reinpro);
										$diff 	 = ($differ + $diff_ke2);
									}else{
										$differ  = ($akhir - $awal);
										$diff_pen = ($tunggu_dispen - $tunggu_pen);
										$diff_ke2 = ($time_refinish - $time_reinpro);
										$diff 	 = ($differ + $diff_ke2)-$diff_pen;
									}
								}
								else{
									if($tunggu_pen==NULL){
										$diff_pen = 0;
										$differ  = ($akhir - $awal);
										$differe  = ($tunggu_in - $tunggu_sp);
										$diff_ke2 = ($time_refinish - $time_reinpro);
										$diff 	 = ($differ - $differe)+$diff_ke2;
									}else{
										$differ  = ($akhir - $awal);
										$differe  = ($tunggu_in - $tunggu_sp);
										$diff_pen = ($tunggu_dispen - $tunggu_pen);
										$diff_ke2 = ($time_refinish - $time_reinpro);
										$diff 	 = ($differ - $differe - $diff_pen)+$diff_ke2;
									}
								}
								
							} */
							
							if($time_reinp[idProb]==NULL){
								if($time_menunggusp[idProb]==NULL){
									if($tunggu_pen[idProb]==NULL){
										$diff_pen = 0;
										$diff  = ($akhir - $awal);
									}else{
										$differ  = ($akhir - $awal);
										$diff_pen = ($tunggu_dispen - $tunggu_pen);
										$diff = $differ - $diff_pen; 
									}
								}
								else{
									if($tunggu_pen==NULL){
										$differ  = ($akhir - $awal); //waktu normal
										$diff_pen = 0;
										$differe  = ($tunggu_in - $tunggu_sp); //in progress setelah menunggu sarepart - menunggu sarepart
										$diff 	 = $differ - $differe;
									}else{
										$differ  = ($akhir - $awal); //waktu normal
										$diff_pen = $tunggu_dispen - $tunggu_pen; //waktu pending
										$differe  = ($tunggu_in - $tunggu_sp); //in progress setelah menunggu sarepart - menunggu sarepart
										$diff 	 = $differ - $differe - $diff_pen;
									}
								}
							}else{
								if($time_menunggusp[idProb]==NULL){
									if($tunggu_pen==NULL){
										$differ  = ($akhir - $awal);
										$diff_pen = 0;
										$diff_ke2 = ($time_refinish - $time_reinpro);
										$diff 	 = ($differ + $diff_ke2);
									}else{
										$differ  = ($akhir - $awal);
										$diff_pen = ($tunggu_dispen - $tunggu_pen);
										$diff_ke2 = ($time_refinish - $time_reinpro);
										$diff 	 = ($differ + $diff_ke2)-$diff_pen;
									}
								}
								else{
									if($tunggu_pen==NULL){
										$differ  = ($akhir - $awal);
										$differe  = ($tunggu_in - $tunggu_sp);
										$diff_pen = 0;
										$diff_ke2 = ($time_refinish - $time_reinpro);
										$diff 	 = ($differ - $differe)+$diff_ke2;
									}else{
										$differ  = ($akhir - $awal);
										$differe  = ($tunggu_in - $tunggu_sp);
										$diff_pen = ($tunggu_dispen - $tunggu_pen);
										$diff_ke2 = ($time_refinish - $time_reinpro);
										$diff 	 = ($differ - $differe - $diff_pen)+$diff_ke2;
									}
								}
								
							}
									
								
							// Untuk menghitung jumlah dalam satuan hari:
							$hari = floor($diff/86400);

							// Untuk menghitung jumlah dalam satuan jam:
							$sisa = $diff % 86400;
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
							
							//PENDING -----------------------------------
							// Untuk menghitung jumlah dalam satuan hari:
							$hari_P = floor($diff_pen/86400);

							// Untuk menghitung jumlah dalam satuan jam:
							$sisa_P = $diff_pen % 86400;
							$jam_P = floor($sisa_P/3600);

							// Untuk menghitung jumlah dalam satuan menit:
							$sisa_P = $sisa_P % 3600;
							$menit_P = floor($sisa_P/60);
							
							//-----------------------------------------------------
							
							// Untuk menghitung jumlah dalam satuan detik:
							
							if($akhir==NULL || $r[status_problem]=='IN PROGRESS' || $r[status_problem]=='ASSIGN' || $r[status_problem]=='MENUNGGU SPAREPART')
								{ $real_day = 0; $real_hour = 0; $real_min = 0;}else{ $real_day = $hari; $real_hour = $jam; $real_min = $menit;}
							if($differe <=0){$hari_SP = 0; $jam_SP=0; $menit_SP=0;}else{$hari_SP=$hari_SP; $jam_SP=$jam_SP; $menit_SP=$menit_SP;}
							if($diff_pen <=0){$hari_P = 0; $jam_P=0; $menit_P=0;}else{$hari_P=$hari_P; $jam_P=$jam_P; $menit_P=$menit_P;}
									
									echo "
                                        <tr>
											<td style='display:none' align='center'>$no</td>
											<td><a href='?p=todolist&act=problem-detail&id=$r[cdprob]&tek=$r[PIC_HANDLING]&s=report'><h6><b>".$r[cdprob]."</b></h6></a></td>
											<td>$r[namapelapor]</td>
											<td>$r[divisi_problem]</td>
											<td>$usernya[fullname]</td>
                                            <td>     $r[deskripsi]
											</td>
											<td>$r[category_name]</td>
											<td>$r[namaMesin]</td>
											<td>$r[namaUnit]</td>
                                            <td>$r[created_at]</td>
											<td bgcolor='yellow'>$r[status_problem]</td>
											<td>$r[EST_DAY] DAYS, $r[EST_HOUR] HOURS, $r[EST_MIN] MINUTES</td>
											<td>$hari_SP DAYS, $jam_SP  HOUR, $menit_SP MINUTES</td>
											<td>$hari_P DAYS, $jam_P  HOUR, $menit_P MINUTES</td>
											<td>$real_day DAYS, $real_hour  HOUR, $real_min MINUTES</td>";
											
											if(($r[status_problem] == 'FINISH' || $r[status_problem]=='CLOSED' || $r[status_problem]=='APPROVED' || $r[status_problem]=='OPEN' || $r[status_problem]=='ASSIGN') && ($hari==0 && $jam==0 && $menit==0)){
												$kerja = "TIDAK ADA PEKERJAAN";
												echo "<td bgcolor='red'><b><font color='white'>TIDAK ADA PEKERJAAN</font></b></td>";
											}else{
												$kerja = "ADA PEKERJAAN";
												echo "<td bgcolor='#d3de32'><b>ADA PEKERJAAN</b></td>";
											}
											
											echo"<td>";
											if($kerja == "TIDAK ADA PEKERJAAN"){
												echo"<b><font color='BLUE'>NOL</font></b>";
											}
											else if($r[status_problem]=='IN PROGRESS' || $r[status_problem]=='ASSIGN' || $r[status_problem]=='MENUNGGU SPAREPART'){
												echo"<b><font color='BLUE'>-</font></b>";
											}
											else{
											if($hari > $r[EST_DAY]){
													echo"<b><font color='red'>OVERDUE</font></b>";
												}else if($hari == $r[EST_DAY]){
													if($jam > $r[EST_HOUR]){
														echo"<b><font color='red'>OVERDUE</font></b>";
													}else if($jam == $r[EST_HOUR]){
															if($menit > $r[EST_MIN]){
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
											}
											echo"</td>
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
