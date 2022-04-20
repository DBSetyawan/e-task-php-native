<?php
error_reporting(0);
session_start();
$d=date('d');$m=date('m');$y=date('y');
include('../../../../config/koneksi.php');
// Fungsi header dengan mengirimkan raw data excel
header("Content-type: application/vnd-ms-excel");
 
// Mendefinisikan nama file ekspor "hasil-export.xls"
header("Content-Disposition: attachment; filename=ReportETaskLangkah_Kerja_$y$m$d.xls");
 
// Tambahkan table
$sql2 = mysqli_query($conn,"select *from user where username='$_SESSION[username]'");
$u = mysqli_fetch_array($sql2);
?>
<h2 align='center'>Laporan Kerja Maintenance</h2>
<h3 align='center'>Periode <?php echo $_POST[begda]." s/d ".$_POST[endda]; ?></h3>
<?php
echo " <table class='table table-striped' border='1'>
                                    <thead>
                                        <tr>
											<th align='center' width='10%' style='display:none'>No.</th>
											<th align='center' width='10%'>CODE</th>
											<th align='left' width='15%'>PELAPOR</th>
											<th align='left' width='15%'>DIVISI</th>
											<th width='10%'>TEKNISI</th>
											<th align='center'>PRIORITAS</th>
											<th align='center'>MESIN</th>
											<th align='center'>UNIT MESIN</th>
                                            <th width='10%'>WAKTU LAPOR</th>
											<th width='10%'>STATUS</th>
											<th width='10%'>EST. WAKTU PERBAIKAN</th>
											<th width='10%'>MENUNGGU SPAREPART</th>
											<th width='10%'>PENDING</th>
											<th width='8%'>REAL WAKTU PERBAIKAN</th>
											<th width='8%'>AKSI</th>
                                        </tr>
                                    </thead>
                                    <tbody>";
										
										$cari = "SELECT * FROM tproblems tp LEFT JOIN mcategories mc ON tp.idcat=mc.idcat
												 LEFT JOIN tassign t ON tp.idProb = t.NO_PELAPORAN
												 LEFT JOIN thandling th ON tp.idProb = th.idProb 
												 LEFT JOIN tproblemnote tn ON tp.idProb = tn.idprob
												 LEFT JOIN tmesin tm ON tm.idMesin=tp.id_mesin
												 LEFT JOIN tmesinunit tu ON tp.id_unit_mesin = tu.idUnit
												 WHERE (tp.dateprob between '$_POST[begda]' AND '$_POST[endda]') ";
											if($u[divisi]=='GA'){
            						//dokumnen series
            						$cari .= "  AND LEFT(tp.idprob,3) = 'PGA'";	
            					}if($u[divisi]!='GA'){
            						//dokumnen series
            						$cari .= "  AND LEFT(tp.idprob,3) = 'TSK'";	
            					}if($_POST[nm_teknisi]!=NULL){
												// ada tanggal yg lain tidak												
												$cari .= " AND t.PIC_HANDLING = '$_POST[nm_teknisi]' ";
											}if($_POST[idmesin]!=NULL){
												//Ad teknisi yg lain tidak
												$cari .= " AND tm.idMesin='$_POST[idmesin]' ";
											} if($_POST[status_p]!=NULL){
												//Ad mesin yg lain tidak
												$cari .= " AND tp.status_problem ='$_POST[status_p]' ";
											}if($_POST[idpriority]!=NULL){
												//Ad status yg lain tidak
												$cari .= " AND tp.idcat ='$_POST[idpriority]' ";
											}
												 $cari .= " GROUP BY tp.idProb, t.PIC_HANDLING order by substring(tp.idprob,5,12) DESC";
										
									$hasil  = mysqli_query($conn,$cari);
									$ketemu = mysqli_num_rows($hasil);
									echo "<h6 align='right'><font color='red'> $ketemu </font>entries.</h6>";
									
									$no=1;
									
									while($r = mysqli_fetch_array($hasil)){
									
									$usernya = mysqli_fetch_array(mysqli_query($conn, "select *from user where username='$r[PIC_HANDLING]'"));
									
									$time_start = mysqli_fetch_array(mysqli_query($conn, "select idProb, statusProblem, dateAction, handling from thandling where (statusProblem = 'STARTED' OR statusProblem = 'IN PROGRESS') AND idProb = '$r[idprob]' AND handling = '$r[PIC_HANDLING]' ORDER BY dateAction asc LIMIT 1"));
								$time_fin = mysqli_fetch_array(mysqli_query($conn, "select idProb, statusProblem, dateAction, handling from thandling where statusProblem = 'FINISH' AND idProb = '$r[idprob]' order by dateAction DESC LIMIT 1 "));
								$time_fin_awal = mysqli_fetch_array(mysqli_query($conn, "select idProb, statusProblem, dateAction, handling from thandling where statusProblem = 'FINISH' AND idProb = '$r[idprob]' order by dateAction ASC LIMIT 1 "));
								$time_fin_rej = mysqli_fetch_array(mysqli_query($conn, "select idProb, statusProblem, dateAction, handling from thandling where statusProblem = 'REJECTED' AND idProb = '$r[idprob]' order by dateAction DESC LIMIT 1 "));
								
								$time_menunggusp = mysqli_fetch_array(mysqli_query($conn, "select idProb, statusProblem, dateAction, handling from thandling where statusProblem = 'MENUNGGU SPAREPART' AND idProb = '$r[idprob]' ORDER BY dateAction desc LIMIT 1"));
								$time_inpro2 = mysqli_fetch_array(mysqli_query($conn, "select idProb, statusProblem, dateAction, handling from thandling where statusProblem = 'IN PROGRESS' AND idProb = '$r[idprob]' ORDER BY dateAction desc LIMIT 1"));
								
								$time_pending = mysqli_fetch_array(mysqli_query($conn, "select idProb, statusProblem, dateAction, handling from thandling where (statusProblem = 'PENDING') AND idProb = '$r[idprob]' ORDER BY dateAction desc LIMIT 1"));
								$time_dispending = mysqli_fetch_array(mysqli_query($conn, "select idProb, statusProblem, dateAction, handling from thandling where statusProblem = 'DISPENDING' AND idProb = '$r[idprob]' ORDER BY dateAction desc LIMIT 1"));
								
								$time_app = mysqli_fetch_array(mysqli_query($conn, "select idProb, statusProblem, dateAction, handling from thandling where statusProblem = 'APPROVED' AND idProb = '$r[idprob]'"));
								
								$awal  = strtotime($time_start[dateAction]); //waktu awal
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
											<td style='display:none' align='center'>$no</td>
											<td><a href='?p=todolist&act=problem-detail&id=$r[NO_PELAPORAN]&s=report'><h6><b>".$r[NO_PELAPORAN]."</b></h6></a></td>
											<td>$r[namapelapor]</td>
											<td>$r[divisi_problem]</td>
											<td>$usernya[fullname]</td>
											<td>$r[category_name]</td>
											<td>$r[namaMesin]</td>
											<td>$r[namaUnit]</td>
                                            <td>$r[created_at]</td>
											<td bgcolor='yellow'>$r[status_problem]</td>
											<td>$r[EST_DAY] DAYS, $r[EST_HOUR] HOURS, $r[EST_MIN] MINUTES</td>
											<td>$hari_SP DAYS, $jam_SP  HOUR, $menit_SP MINUTES</td>
											<td>$hari_P DAYS, $jam_P  HOUR, $menit_P MINUTES</td>
											<td>$real_day DAYS, $real_hour  HOUR, $real_min MINUTES</td>
											<td>";
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
											echo"</td>
                                        </tr>
										<tr>
											<td>&nbsp;</td><td colspan='2'><b>Problem :</b></td><td colspan='11'>&nbsp;$r[deskripsi]</td>
										</tr>
										<tr>
											<td>&nbsp;</td><td colspan='2' valign='top'><b>Langkah-langkah Kerja :</b></td><td colspan='11'>
											<table border='1' width='100%'>";
											$lnd = mysqli_query($conn, "select *from tproblemnote where idprob='$r[NO_PELAPORAN]' order by idnote asc");
											$no=1;
												while($lng = mysqli_fetch_array($lnd)){
													echo"<tr><td valign='top'>$no. </td><td colspan='10'>$lng[note]</td></tr>";
													$no++;
												}
											echo"	
											</table>
											</td>
										</tr>";
										$no++;
									}
										
                              echo"      </tbody>
                                </table>";