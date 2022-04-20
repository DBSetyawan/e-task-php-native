<?php
$date = date('Y-m-d');
$month = date('m');
error_reporting(0);
session_start();
?>
<div class="block-header">
                <div class="row">
                    <div class="col-lg-6 col-md-8 col-sm-12">
                        <h2><a href="?p=dashboard" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a> Dashboard</h2>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="?p=dashboard"><i class="icon-home"></i></a></li>                            
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ul>
                    </div>      
                </div>
            </div>

            <div class="row clearfix">
			<?php
			$div = mysqli_fetch_array(mysqli_query($conn, "select *from user where username='$_SESSION[username]'"));
				$ww = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM tassign t where EST_DAY IS NULL OR EST_HOUR IS NULL OR EST_MIN IS NULL;"));
				if($ww > 0 && $div[divisi]=='MAINTENANCE' && $div[level]=='superadmin'){
			?>
			<div class="col-lg-4 col-md-4">
				 <div class="card top_counter">
                        <div class="body">
							<a href='?p=input-est-time'><div class="icon"><img src='modul/bell.gif' width='95%' /> </div></a>
							<div class="content">
								<div class="text"><b><font color='red'>Belum Input Estimasi Waktu</font></b></div>
								<h1 class="number">
								<?php
									$p = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM tassign t where EST_DAY IS NULL OR EST_HOUR IS NULL OR EST_MIN IS NULL;"));

									echo $p;
								?>
								</h1>
							</div>
						</div>	
                    </div>
				</div>
				<?php
				}
				else{}
				?>
			<div class="col-lg-4 col-md-4">
				 <div class="card top_counter">
                        <div class="body">
							<a href='?p=dashboard&act=open'><div class="icon"><i class="fa fa-hourglass-half"></i> </div></a>
							<div class="content">
								<div class="text"><b>Open</b></div>
								<h1 class="number">
								<?php
									$p = mysqli_num_rows(mysqli_query($conn,"select *from tproblems p
									where status_problem ='OPEN'"));

									echo $p;
								?>
								</h1>
							</div>
						</div>	
                    </div>
				</div>
				
				<div class="col-lg-4 col-md-4">
					<div class="card top_counter">
                        <div class="body">
							<a href='?p=dashboard&act=assign'><div class="icon"><i class="fa fa-signature"></i> </div></a>
							<div class="content">
								<div class="text"><b>Assigned</b></div>
								<h1 class="number">
								<?php
									$p = mysqli_num_rows(mysqli_query($conn,"select *from tproblems p
									where status_problem ='ASSIGN'"));

									echo $p;
								?>
								</h1>
							</div>
						</div>	
                    </div>
				</div>
				<div class="col-lg-4 col-md-4">
					<div class="card top_counter">
                        <div class="body">
							<a href='?p=dashboard&act=inprogress'><div class="icon"><i class="fa fa-spinner"></i> </div></a>
							<div class="content">
								<div class="text"><b>In Progress</b></div>
								<h1 class="number">
								<?php
									$p = mysqli_num_rows(mysqli_query($conn,"select *from tproblems p
									where status_problem ='IN PROGRESS'"));

									echo $p;
								?>
								</h1>
							</div>
						</div>	
                    </div>
				</div>
				<!-- <div class="col-lg-4 col-md-4">
					<div class="card top_counter">
                        <div class="body">
						<table border='0' width='100%'>
								<tr><td colspan='5' align='left'><div class="text"><b>Menunggu Sparepart</b></div></td></tr>
								<tr><td rowspan='3' width='10%'><div class="icon"><i class="fa fa-cog"></i> </div></td>
									<td rowspan='3' align='left'><h1 class="number">
										<?php
											/* $p = mysqli_num_rows(mysqli_query($conn,"select *from tproblems p
											where status_problem ='MENUNGGU SPAREPART'"));

											echo $p; */
										?>
								</h1></td>
									<td>Kritis</td><td>:</td><td>0</td></tr>
								<tr><td>Penting</td><td>:</td><td>0</td></tr>
								<tr><td>Normal</td><td>:</td><td>0</td></tr>
								</table>
							
						</div>	
                    </div>
				</div> -->
				<div class="col-lg-4 col-md-4">
					<div class="card top_counter">
                        <div class="body">
							<a href='?p=dashboard&act=menunggusp'><div class="icon"><i class="fa fa-cog"></i> </div></a>
							<div class="content">
								<div class="text"><b>Menunggu Sparepart</b></div>
								<h1 class="number">
								<?php
									$p = mysqli_num_rows(mysqli_query($conn,"select *from tproblems p
									where status_problem ='MENUNGGU SPAREPART'"));

									echo $p;
								?>
								</h1>
							</div>
						</div>	
                    </div>
				</div>
				<div class="col-lg-4 col-md-4">
					<div class="card top_counter">
                        <div class="body">
							<a href='?p=dashboard&act=finish'><div class="icon"><i class="fa fa-check"></i> </div></a>
							<div class="content">
								<div class="text"><b>Finish</b></div>
								<h1 class="number">
								<?php
									$p = mysqli_num_rows(mysqli_query($conn,"select *from tproblems p
									where status_problem ='FINISH'"));

									echo $p;
								?>
								</h1>
							</div>
						</div>	
                    </div>
				</div>
				<div class="col-lg-4 col-md-4">
					<div class="card top_counter">
                        <div class="body">
							<a href='?p=dashboard&act=approved'><div class="icon"><i class="fa fa-user"></i> </div></a>
							<div class="content">
								<div class="text"><b>Approved (Belum Closed)</b></div>
								<h1 class="number">
								<?php
									$p = mysqli_num_rows(mysqli_query($conn,"select *from tproblems p
									where status_problem ='APPROVED'"));

									echo $p;
								?>
								</h1>
							</div>
						</div>	
                    </div>
				</div>
	
			<div class="col-lg-12 col-md-12">
			<div class="card">
			<?php
				switch($_GET[act]){
									default:
											$prob = "SELECT * FROM tproblems p
												left join mcategories c on p.idcat = c.idcat
												left join tmesin m on p.id_mesin = m.idMesin
												left join tmesinunit n on p.id_unit_mesin = n.idUnit
												left join tassign ta on p.idprob = ta.no_pelaporan
												left join user u on u.username = ta.pic_handling
												where p.status_problem NOT IN ('CLOSED')";
												if($_GET[show]=='pribadi'){
													$prob .= " AND p.created_by = '$_SESSION[username]' ";
												}else{}
												
												$prob .= "group by p.idprob, ta.PIC_HANDLING
												order by p.idcat asc";
											$ptampil = mysqli_query($conn,$prob);
										break;
										case "bulanini" :
											$prob = "SELECT * FROM tproblems p
												left join mcategories c on p.idcat = c.idcat
												left join tmesin m on p.id_mesin = m.idMesin
												left join tmesinunit n on p.id_unit_mesin = n.idUnit
												left join tassign ta on p.idprob = ta.no_pelaporan
												left join user u on u.username = ta.pic_handling
												where MONTH(dateprob) = '$month'";
												if($_GET[show]=='pribadi'){
													$prob .= " AND p.created_by = '$_SESSION[username]' ";
												}else{}
												
												$prob .= "group by p.idprob
												order by p.idcat asc";
											$ptampil = mysqli_query($conn,$prob);
											
											$stt = " - MASALAH BULAN INI";
										break;
										case "open" :
											$prob = "SELECT * FROM tproblems p
												left join mcategories c on p.idcat = c.idcat 
												left join tmesin m on p.id_mesin = m.idMesin
												left join tmesinunit n on p.id_unit_mesin = n.idUnit
												left join tassign ta on p.idprob = ta.no_pelaporan
												left join user u on u.username = ta.pic_handling
												where p.status_problem='OPEN'";
												if($_GET[show]=='pribadi'){
													$prob .= " AND p.created_by = '$_SESSION[username]' ";
												}else{}
												
												$prob .= "group by p.idprob
												order by p.idcat asc";
											$ptampil = mysqli_query($conn,$prob);
											
											$stt = " - STATUS OPEN";
										break;
										case "assign" :
											$prob = "SELECT * FROM tproblems p
												left join mcategories c on p.idcat = c.idcat 
												left join tmesin m on p.id_mesin = m.idMesin
												left join tmesinunit n on p.id_unit_mesin = n.idUnit
												left join tassign ta on p.idprob = ta.no_pelaporan
												left join user u on u.username = ta.pic_handling
												where p.status_problem='ASSIGN'";
												if($_GET[show]=='pribadi'){
													$prob .= " AND p.created_by = '$_SESSION[username]' ";
												}else{}
												
												$prob .= "group by p.idprob
												order by p.idcat asc";
											$ptampil = mysqli_query($conn,$prob);
												
												$stt = " - STATUS ASSIGN TO";
										break;
										case "inprogress" :
											$prob = "SELECT * FROM tproblems p
												left join mcategories c on p.idcat = c.idcat 
												left join tmesin m on p.id_mesin = m.idMesin
												left join tmesinunit n on p.id_unit_mesin = n.idUnit
												left join tassign ta on p.idprob = ta.no_pelaporan
												left join user u on u.username = ta.pic_handling
												where p.status_problem='IN PROGRESS'";
												if($_GET[show]=='pribadi'){
													$prob .= " AND p.created_by = '$_SESSION[username]' ";
												}else{}
												
												$prob .= "group by p.idprob
												order by p.idcat asc";
											$ptampil = mysqli_query($conn,$prob);
												
												$stt = " - STATUS IN PROGRESS";
										break;
										case "menunggusp":
											$prob = "SELECT * FROM tproblems p
												left join mcategories c on p.idcat = c.idcat 
												left join tmesin m on p.id_mesin = m.idMesin
												left join tmesinunit n on p.id_unit_mesin = n.idUnit
												left join tassign ta on p.idprob = ta.no_pelaporan
												left join user u on u.username = ta.pic_handling
												where p.status_problem='MENUNGGU SPAREPART'";
												if($_GET[show]=='pribadi'){
													$prob .= " AND p.created_by = '$_SESSION[username]' ";
												}else{}
												
												$prob .= "group by p.idprob
												order by p.idcat asc";
											$ptampil = mysqli_query($conn,$prob);
												
												$stt = " - STATUS MENUNGGU SPAREPART";
										break;
										case "finish":
										$prob = "SELECT * FROM tproblems p
												left join mcategories c on p.idcat = c.idcat 
												left join tmesin m on p.id_mesin = m.idMesin
												left join tmesinunit n on p.id_unit_mesin = n.idUnit
												left join tassign ta on p.idprob = ta.no_pelaporan
												left join user u on u.username = ta.pic_handling
												where p.status_problem='FINISH'";
												if($_GET[show]=='pribadi'){
													$prob .= " AND p.created_by = '$_SESSION[username]' ";
												}else{}
												
												$prob .= "group by p.idprob
												order by p.idcat asc";
											$ptampil = mysqli_query($conn,$prob);
												
												$stt = " - STATUS FINISH";
										break;
										case "today":
										$prob = "SELECT * FROM tproblems p
												left join mcategories c on p.idcat = c.idcat 
												left join tmesin m on p.id_mesin = m.idMesin
												left join tmesinunit n on p.id_unit_mesin = n.idUnit
												left join tassign ta on p.idprob = ta.no_pelaporan
												left join user u on u.username = ta.pic_handling
												where p.dateprob = '$date'";
												if($_GET[show]=='pribadi'){
													$prob .= " AND p.created_by = '$_SESSION[username]' ";
												}else{}
												
												$prob .= "group by p.idprob
												order by p.idcat asc";
											$ptampil = mysqli_query($conn,$prob);
												
												$stt = " - MASALAH HARI INI";
										break;
										case "approved":
										$prob = "SELECT * FROM tproblems p
												left join mcategories c on p.idcat = c.idcat 
												left join tmesin m on p.id_mesin = m.idMesin
												left join tmesinunit n on p.id_unit_mesin = n.idUnit
												left join tassign ta on p.idprob = ta.no_pelaporan
												left join user u on u.username = ta.pic_handling
												where p.status_problem='APPROVED'";
												if($_GET[show]=='pribadi'){
													$prob .= " AND p.created_by = '$_SESSION[username]' ";
												}else{}
												
												$prob .= "group by p.idprob
												order by p.idcat asc";
											$ptampil = mysqli_query($conn,$prob);
												
												$stt = " - MASALAH APPROVED";
										break;
									}
						$c = mysqli_query($conn, "select *from user where username='$_SESSION[username]'");
						$h = mysqli_fetch_array($c);
			?>
                        <div class="header">
						<table border='0' width='100%'>
						<tr><td width='90%'><h2><u>Daftar Laporan Kerusakan</u><font color='red'><b><?php echo $stt; ?></b></font></h2></td>
							<td><a href='<?php echo "?p=dashboard&show=pribadi&act=$_GET[act]";?>' title='Klik untuk melihat laporan milik Anda' class='btn btn-sm btn-success'>Pribadi</a></td>
							<td><a href='<?php echo "?p=dashboard&act=$_GET[act]";?>' title='Klik untuk melihat semua laporan' class='btn btn-sm btn-warning'>Semua</a></td></tr>
						<tr><td colspan='3'><font color='red' size='1'><b>**Daftar ini menampilkan masalah yang dilaporkan dengan status BUKAN CLOSED<br />
						**Jika ingin membatalkan masalah yang dilaporkan, silahkan Klik BATAL pada kolom Action (Hanya jika masalah masih berstatus OPEN)</b></font></td></tr>
						</table>
                        </div>
                        <div class="body">                           
                            <ul class="right_chat list-unstyled">
							<div class='row'>
						    <div class='col-lg-12 col-md-12'>
							<div class='table-responsive'>
								<table class='table table-striped table-hover dataTable js-exportable'>
                                    <thead>
                                        <tr>
											<th align='center' width='10%' >No.</th>
                                            <th align='center'>PRIORITAS</th>
											<th align='center'>MASALAH</th>
											<th align='center'>PELAPOR</th>
											<th align='center'>MESIN</th>
											<th align='center'>UNIT MESIN</th>
											<th width='10%'>TEKNISI</th>
											<th align='center'>TANGGAL</th>
											<th width='10%'>STATUS</th>
											<?php
											
											
											if($h[divisi]=='PRODUKSI'){
												echo"<th width='10%'>ACTION</th>";
											}else{
												echo"<th width='10%'>#</th>";
											}
											?>
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php
									
										$no = 1;
										while ($data = mysqli_fetch_assoc($ptampil))
										{
											echo "
											<tr>
												";
												if($data[category_name] == 'Kritis'){
													echo"
														<td bgcolor='red'><font color='white'>$no</font></td>
														<td bgcolor='red'><font color='white'><b>$data[category_name]</b></font></td>
														<td bgcolor='red'><font color='white'><a href='?p=todolist&act=problem-detail&id=$data[idprob]&s=report&tek=$data[PIC_HANDLING]'><b>$data[idprob]</b></a></font></td>
														<td bgcolor='red'><font color='white'>$data[namapelapor]</font></td>
														<td bgcolor='red'><font color='white'>$data[namaMesin]</font></td>
														<td bgcolor='red'><font color='white'>$data[namaUnit]</font></td>
														<td bgcolor='red'><font color='white'>$data[fullname]</font></td>
														<td bgcolor='red'><font color='white'>$data[dateprob]</font></td>";
												}
												else if($data[category_name] == 'Penting'){
													echo"	
														<td bgcolor='yellow'>$no</font></td>
														<td bgcolor='yellow'><b>$data[category_name]</b></td>
														<td bgcolor='yellow'><a href='?p=todolist&act=problem-detail&id=$data[idprob]&s=report&tek=$data[PIC_HANDLING]'><b>$data[idprob]</b></a></td>
														<td bgcolor='yellow'>$data[namapelapor]</td>
														<td bgcolor='yellow'>$data[namaMesin]</td>
														<td bgcolor='yellow'>$data[namaUnit]</td>
														<td bgcolor='yellow'>$data[fullname]</td>
														<td bgcolor='yellow'>$data[dateprob]</td>";
												}
												else{
													echo"
														<td>$no</td>
														<td><b>$data[category_name]</b></font></td>
														<td><a href='?p=todolist&act=problem-detail&id=$data[idprob]&s=report&tek=$data[PIC_HANDLING]'><b>$data[idprob]</b></a></td>
														<td>$data[namapelapor]</td>
														<td>$data[namaMesin]</td>
														<td>$data[namaUnit]</td>
														<td>$data[fullname]</td>
														<td>$data[dateprob]</td>";
												}
												echo"
												
												";
											//if($h[divisi]=='PRODUKSI'){
												if($data[status_problem] == 'APPROVED'){
													echo "<td>APPROVED </td>";
													if(strtolower($data[created_by]) == strtolower($_SESSION[username])){
														echo "<td><a href='modul/911/aksi_911.php?p=close&act=close&id=$data[idprob]' title='Klik for closing problem' class='btn btn-sm btn-danger'>CLOSE</a></td>";
													}else{
														echo "<td>&nbsp;</td>";
													}
												}
												else if($data[status_problem] == 'OPEN'){
													echo "<td>OPEN </td>";
													if($data[created_by] == $_SESSION[username]){
														?>
														<td><a href='<?php echo "modul/911/aksi_911.php?p=todolist&act=delete-problem&id=$data[idprob]&dash=1";?>' title='Klik for delete problem' class='btn btn-sm btn-info' onclick="return confirm('Apakah Anda yakin MEM-BATAL-KAN Masalah Ini?');">BATAL</a></td>
														<?php
													}else{
														echo "<td>&nbsp;</td>";
													}
												}
												else if($data[status_problem] == 'ASSIGN'){
													echo "<td>ASSIGN </td>";
													if($data[created_by] == $_SESSION[username]){
														?>
														<td><a href='<?php echo "?p=edit-problem&id=$data[idprob]";?>' title='Klik for editing problem' class='btn btn-sm btn-success'>EDIT PROBLEM</a></td>
														<?php
													}else{
														echo "<td>&nbsp;</td>";
													}
												}
												else if($data[status_problem] == 'IN PROGRESS'){
													echo "<td>IN PROGRESS </td>";
													if($data[created_by] == $_SESSION[username]){
														?>
														<td><a href='<?php echo "?p=edit-problem&id=$data[idprob]";?>' title='Klik for editing problem' class='btn btn-sm btn-success'>EDIT PROBLEM</a></td>
														<?php
													}else{
														echo "<td>&nbsp;</td>";
													}
												}
												else{
													echo "<td>$data[status_problem]</td>
														  <td>&nbsp;</td>";
												}
											/*}
											else{
												echo "<td>$data[status_problem]</td><td>&nbsp;</td>";
												
											}*/
											echo"</tr>";
											$no++;
										}
										
									?>
									</tbody>
								</table>
								</div>
								</div>
								</div>
                            </ul>
                        </div>
                    </div>
				</div>
				
				<div class="col-lg-7 col-md-8">
				
				</div>
                
				
            </div>            
            </div>

            