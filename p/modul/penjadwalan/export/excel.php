<?php
error_reporting(0);
session_start();
$d=date('d');$m=date('m');$y=date('y');
include('../../../../config/koneksi.php');
// Fungsi header dengan mengirimkan raw data excel
header("Content-type: application/vnd-ms-excel");
 
// Mendefinisikan nama file ekspor "hasil-export.xls"
header("Content-Disposition: attachment; filename=ReportETaskJadwalPemeliharaan_$y$m$d.xls");
 
// Tambahkan table

$th = substr($_GET[periode], 0, 4); //tahun
$bl = substr($_GET[periode], 5, 2); //bulan
$tg = substr($_GET[periode], 8, 2); //tanggal

$kalender = CAL_GREGORIAN;
$bulan = date('m');
$tahun = date('Y');
$hari = cal_days_in_month($kalender, $bulan, $tahun);
$col = $hari*2;

if($bl=='01'){$bul = 'January';}
if($bl=='02'){$bul = 'February';}
if($bl=='03'){$bul = 'Maret';}
if($bl=='04'){$bul = 'April';}
if($bl=='05'){$bul = 'May';}
if($bl=='06'){$bul = 'June';}
if($bl=='07'){$bul = 'July';}
if($bl=='08'){$bul = 'August';}
if($bl=='09'){$bul = 'September';}
if($bl=='10'){$bul = 'October';}
if($bl=='11'){$bul = 'November';}
if($bl=='12'){$bul = 'December';}

echo"
<h2 align='center'>JADWAL PEMELIHARAAN MESIN</h2>
<h3 align='center'>Bulan : $bul $th</h3>";

echo " <table border='1' width='100%'>
                                    <thead>
										<tr><th rowspan='2'></th><th colspan='$col'>Tanggal</th></tr>
                                        <tr>";
											for($i=1;$i<=$hari;$i++){
												echo "<th align='center' colspan='2'>$i</th>";
											}										
										echo"
                                        </tr>
                                    </thead>
                                    <tbody>
									<tr><th>Mesin</th>";
									for($i=1;$i<=$hari;$i++){
										echo "<td width='2%'>P</td><td width='2%'>D</td>";
									}
									echo"
									</tr>
									";
									$jadwal = mysqli_query($conn, "CALL ReportJadwal('$bl','$bl','$th', '$th');");
									while($jad = mysqli_fetch_array($jadwal)){
										echo "
										<tr>";
											for($t=0;$t<=($hari*2);$t++){
												if($t != 0 && $jad[$t] != " " && ($t % 2 ==0)){
													$color='#0071c5';
													$font = 'white';
													$check = '&#10004;';
												}
												else if($t != 0 && $jad[$t] != " " && ($t % 2 !=0)){
													$color='#FFD700';
													$font = 'black';
													$check = '&#10004;';
												}
												else{
													$color='white';
													$font = 'black';
													$check = $jad[$t];
												}
												//echo "<td bgcolor='$color'><font color='$font'>$jad[$t]</font></td>";
												echo "<td bgcolor='$color'><font color='$font'>$check</font></td>";
											}
										echo"
										</tr>";
										}
									echo"
							
							
								";	
									
                              echo" </tbody>
                                </table>";
	echo"<table border='0' width='100%'>
                                    <thead>
										
                                    </thead>
                                    <tbody>
									<tr ><th style='display:none;'>&nbsp;</th>";
									for($i=1;$i<=$hari;$i++){
										echo "<td width='2%'>&nbsp;</td><td width='2%'>&nbsp;</td>";
									}
									echo"<td width='2%'>&nbsp;</td>
									</tr>
									";
									$jadwal = mysqli_query($conn, "CALL ReportJadwal('$bl','$bl','$th', '$th');");
									while($jad = mysqli_fetch_array($jadwal)){
										echo "
										<tr>";
											for($t=0;$t<=($hari*2);$t++){
												
												//echo "<td bgcolor='$color'><font color='$font'>$jad[$t]</font></td>";
												echo "<td bgcolor='$color'>&nbsp;</td>";
											}
										echo"
										</tr>";
										}
									echo"
							
							
							<!-- BAGIAN TANDA TANGAN DAN KETERANGAN -->
								<tr><td colspan='".(($hari*2)+1)."'>&nbsp;</td></tr>
								<tr><td colspan='".(($hari*2)+1)."'>Centang ( &#10004; ) pada kolom yang tersedia</td></tr>
								<tr><td>Ket.</td><td>&nbsp;</td><td colspan='3'>P : Plan</td><td bgcolor='#FFD700' colspan='2' align='center'>&#10004;</td><td width='3%'>&nbsp;</td>
										<td colspan='7'>Done : Dikerjakan</td><td bgcolor='#0071c5' colspan='2' align='center'>&#10004;</td></tr>
								<tr><td>&nbsp;</td><td>&nbsp;</td><td colspan='4'><b>NOTED :</b></td><td colspan='".(($hari*2)-5)."'>Toleransi pending untuk jadwal pemeliharaan mesin yang belum terlaksana MAKS 2 minggu.</td></tr>
								<tr><td colspan='".(($hari*2)+1)."'>&nbsp;</td></tr>
								<tr><td colspan='".(($hari*2)+1)."'>&nbsp;</td></tr>
								<tr><td colspan='".(($hari*2)+1)."'>&nbsp;</td></tr>
								<tr><td colspan='".(($hari*2))."' align='right'>Surabaya, ..................................................................</td><td>&nbsp;</td></tr>
								<tr><td  colspan='".(($hari-10))."' align='center'>Mengetahui,</td>
									<td  colspan='".(($hari-13))."'>&nbsp;</td>
									<td  colspan='".(($hari-7))."' align='center'>Dibuat Oleh,</td>
								</tr>
								<tr><td colspan='".(($hari*2)+1)."'>&nbsp;</td></tr>
								<tr><td colspan='".(($hari*2)+1)."'>&nbsp;</td></tr>
								<tr><td colspan='".(($hari*2)+1)."'>&nbsp;</td></tr>
								<tr><td colspan='".(($hari*2)+1)."'>&nbsp;</td></tr>
								<tr><td  colspan='".(($hari-10))."' align='center'>(R&M Head)</td>
									<td  colspan='".(($hari-13))."'>&nbsp;</td>
									<td  colspan='".(($hari-7))."' align='center'>(R&M Admin)</td>
								</tr>
								<tr><td colspan='".(($hari*2)+1)."'>&nbsp;</td></tr>
								<tr><td colspan='".(($hari*2)+1)."'>QF.KOP-RM-7.1.3-002 REV : 04</td></tr>
								";	
									
                              echo" </tbody>
                                </table>";