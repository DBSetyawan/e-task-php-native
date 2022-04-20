<style>
		.fixed{
			  position: fixed;
			  top: 13%;
			  left: 80%;
			  width:100%
		}
		@media only screen and (max-device-width : 1400px) {
			.fixed {
			  position: fixed;
			  top: 13%;
			  left: 80%;
			  width:100%
			}
		}
		@media only screen and (max-device-width : 728px) {
			.fixed {
			  position: relative;
			  top: 0%;
			  left: 0%;
			  width:100%
			}
		}
</style>

<?php
$date = date('Y-m-d');
$month = date('m');
/*ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);*/
error_reporting(0);
session_start();
?>

            <div class="row clearfix">
			<div class="col-lg-9 col-md-9">
				 <div class="card top_counter">
                        <div class="body">
						<?php
				// status finish 2
				$finish2 = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM tproblems where status_problem='X' and idprob LIKE 'TSK%';"));	
				//PENDING
				
				$pending = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM tproblems where status_problem='PENDING' and idprob LIKE 'TSK%';"));
				
				//ESTIMASI WAKTU
				$div = mysqli_fetch_array(mysqli_query($conn, "select *from user where username='$_SESSION[username]'"));
					$ww = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM tassign t where (EST_DAY IS NULL OR EST_HOUR IS NULL OR EST_MIN IS NULL) and NO_PELAPORAN LIKE 'TSK%';"));
							
								switch($_GET[act]){
									default:
											$prob = "SELECT * FROM tproblems p
												left join mcategories c on p.idcat = c.idcat
												left join tmesin m on p.id_mesin = m.idMesin
												left join tmesinunit n on p.id_unit_mesin = n.idUnit
												left join tassign ta on p.idprob = ta.no_pelaporan
												left join user u on u.username = ta.pic_handling
												 WHERE ((p.status_problem NOT IN ('CLOSED') AND ta.created_date IN
														(select max(created_date) from tassign group by no_pelaporan)) OR p.status_problem IN ('OPEN', 'PLAN')) and (idprob LIKE 'TSK%' OR idprob LIKE 'MTC%')";
												if($_GET[show]=='pribadi'){
													$prob .= " AND p.created_by = '$_SESSION[username]' ";
												}else{}
												
												$prob .= "group by p.idprob
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
												where MONTH(dateprob) = '$month'
												and ta.created_date IN
														(select max(created_date) from tassign group by no_pelaporan) and idprob LIKE 'TSK%'";
												if($_GET[show]=='pribadi'){
													$prob .= " AND p.created_by = '$_SESSION[username]' ";
												}else{}
												
												$prob .= "group by ta.no_pelaporan
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
												where p.status_problem='OPEN' and (idprob LIKE 'TSK%' OR idprob LIKE 'MTC%')";
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
												where p.status_problem IN ('ASSIGN', 'PLAN') and (idprob LIKE 'TSK%' OR idprob LIKE 'MTC%')
												and ta.created_date IN
														(select max(created_date) from tassign group by no_pelaporan)";
												if($_GET[show]=='pribadi'){
													$prob .= " AND p.created_by = '$_SESSION[username]' ";
												}else{}
												
												$prob .= "group by ta.no_pelaporan
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
												where p.status_problem='IN PROGRESS' and (idprob LIKE 'TSK%' OR idprob LIKE 'MTC%')	and ta.created_date IN
														(select max(created_date) from tassign group by no_pelaporan)";
												if($_GET[show]=='pribadi'){
													$prob .= " AND p.created_by = '$_SESSION[username]' ";
												}else{}
												
												$prob .= "group by ta.no_pelaporan
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
												where p.status_problem='MENUNGGU SPAREPART'
												and ta.created_date IN
														(select max(created_date) from tassign group by no_pelaporan)";
												if($_GET[show]=='pribadi'){
													$prob .= " AND p.created_by = '$_SESSION[username]' ";
												}else{}
												
												$prob .= "group by ta.no_pelaporan
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
												where (p.status_problem='FINISH' or p.status_problem='X')  and (idprob LIKE 'TSK%' OR idprob LIKE 'MTC%')
												and ta.created_date IN
														(select max(created_date) from tassign group by no_pelaporan)";
												if($_GET[show]=='pribadi'){
													$prob .= " AND p.created_by = '$_SESSION[username]' ";
												}else{}
												
												$prob .= "group by ta.no_pelaporan
												order by p.idcat asc";
											$ptampil = mysqli_query($conn,$prob);
												
												$stt = " - STATUS FINISH";
										break;
										case "rejected":
										$prob = "SELECT * FROM tproblems p
												left join mcategories c on p.idcat = c.idcat 
												left join tmesin m on p.id_mesin = m.idMesin
												left join tmesinunit n on p.id_unit_mesin = n.idUnit
												left join tassign ta on p.idprob = ta.no_pelaporan
												left join user u on u.username = ta.pic_handling
												where p.status_problem='REJECTED' and (idprob LIKE 'TSK%' OR idprob LIKE 'MTC%')
												and ta.created_date IN
														(select max(created_date) from tassign group by no_pelaporan)";
												if($_GET[show]=='pribadi'){
													$prob .= " AND p.created_by = '$_SESSION[username]' ";
												}else{}
												
												$prob .= "group by ta.no_pelaporan
												order by p.idcat asc";
											$ptampil = mysqli_query($conn,$prob);
												
												$stt = " - STATUS REJECTED";
										break;
										case "today":
										$prob = "SELECT * FROM tproblems p
												left join mcategories c on p.idcat = c.idcat 
												left join tmesin m on p.id_mesin = m.idMesin
												left join tmesinunit n on p.id_unit_mesin = n.idUnit
												left join tassign ta on p.idprob = ta.no_pelaporan
												left join user u on u.username = ta.pic_handling
												where p.dateprob = '$date'
												and ta.created_date IN
														(select max(created_date) from tassign group by no_pelaporan) and (idprob LIKE 'TSK%' OR idprob LIKE 'MTC%')";
												if($_GET[show]=='pribadi'){
													$prob .= " AND p.created_by = '$_SESSION[username]' ";
												}else{}
												
												$prob .= "group by ta.no_pelaporan
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
												where p.status_problem='APPROVED' and (idprob LIKE 'TSK%' OR idprob LIKE 'MTC%')
												and ta.created_date IN
														(select max(created_date) from tassign group by no_pelaporan)";
												if($_GET[show]=='pribadi'){
													$prob .= " AND p.created_by = '$_SESSION[username]' ";
												}else{}
												
												$prob .= "group by ta.no_pelaporan
												order by p.idcat asc";
											$ptampil = mysqli_query($conn,$prob);
												
												$stt = " - MASALAH APPROVED";
										break;
										case "blmclosed":
										$prob = "SELECT * FROM tproblems p
												left join mcategories c on p.idcat = c.idcat 
												left join tmesin m on p.id_mesin = m.idMesin
												left join tmesinunit n on p.id_unit_mesin = n.idUnit
												left join tassign ta on p.idprob = ta.no_pelaporan
												left join user u on u.username = ta.pic_handling
												where p.status_problem='X'
												and ta.created_date IN
														(select max(created_date) from tassign group by no_pelaporan) and (idprob LIKE 'TSK%' OR idprob LIKE 'MTC%')";
												if($_GET[show]=='pribadi'){
													$prob .= " AND p.created_by = '$_SESSION[username]' ";
												}else{}
												
												$prob .= "group by ta.no_pelaporan
												order by p.idcat asc";
											$ptampil = mysqli_query($conn,$prob);
												
												$stt = " - MASALAH BELUM APPROVED";
										break;
									}
						$c = mysqli_query($conn, "select *from user where username='$_SESSION[username]'");
						$h = mysqli_fetch_array($c);
			?>
                        <div class="header">
						<table border='0' width='100%'>
						<tr><td width='90%'><h2><u>Daftar Laporan Kerusakan</u><font color='red'><b><?php echo $stt; ?></b></font></h2></td>
							<td><a href='<?php echo "?p=dashboard&show=pribadi&act=$_GET[act]";?>' title='Klik untuk melihat laporan milik Anda' class='btn btn-sm btn-success'>Pribadi</a></td>
							<td><a href='<?php echo "?p=dashboard&act=$_GET[act]";?>' title='Klik untuk melihat semua laporan' class='btn btn-sm btn-warning'>Semua</a></td>

							<!-- <td><a  title='Klik untuk menghapus kotak search' class='btn btn-sm btn-primary' onclick='$("#DataTables_Table_0_filter input").val(null);'>clear</a></td> -->
						</tr>
						
						</table>
                        </div>                        
                            <ul class="right_chat list-unstyled">
							<div class='row'>
						    <div class='col-lg-12 col-md-12'>
							<div class='table-responsive'>
								<table class='table table-striped table-hover dataTable js-exportable'>
                                    <thead>
                                        <tr>
											<th align='center' width='10%' >No.</th>
											<th align='center'>MASALAH</th>
											<th width='10%'>DESKRIPSI</th>
											<th align='center'>MESIN</th>
											<th align='center'  width='10%'>STATUS</th>
											<?php
											if($h[divisi]=='PRODUKSI'){
												echo"<th width='10%'>ACTION</th>";
											}else{
												echo"<th width='10%'>#</th>";
											}
											?>
											<th width='10%'>PELAPOR</th>
											<th width='10%'>TEKNISI</th>
											
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php
									
										$no = 1;
										while ($data = mysqli_fetch_assoc($ptampil))
										{
											
											$c2 = mysqli_query($conn, "select *from user where username='$[username]'");
											$h2 = mysqli_fetch_array($c);
											if($div[level]=='superadmin'){
												if($data[status_problem]=='OPEN'){$kirim = "?p=todolist&act=problem-detail&ds=open&id=$data[idprob]";}
												if($data[status_problem]=='ASSIGN' || $data[status_problem]=='PLAN'){$kirim = "?p=todolist&act=problem-detail&ds=assign&id=$data[idprob]&tek=$data[PIC_HANDLING]";}
												if($data[status_problem]=='IN PROGRESS'){$kirim = "?p=todolist&act=problem-detail&ds=inprogress&id=$data[idprob]&tek=$data[PIC_HANDLING]";}
												if($data[status_problem]=='MENUNGGU SPAREPART'){$kirim = "?p=todolist&act=problem-detail&ds=menunggusp&id=$data[idprob]&s=report&tek=$data[PIC_HANDLING]";}
												if($data[status_problem]=='FINISH' || $data[status_problem]=='X'){$kirim = "?p=todolist&act=problem-detail&ds=finish&id=$data[idprob]&s=app&tek=$data[PIC_HANDLING]";}
												// if($data[status_problem]=='CLOSED'){$kirim = "?p=todolist&act=problem-detail&ds=finish&id=$data[idprob]&s=app&tek=$data[PIC_HANDLING]";}
												if($data[status_problem]=='APPROVED'){$kirim = "?p=todolist&act=problem-detail&ds=approved&id=$data[idprob]&s=report&tek=$data[PIC_HANDLING]&s=close";}
												if($data[status_problem]=='PENDING'){$kirim = "?p=todolist&act=problem-detail&ds=pending&id=$data[idprob]&tek=$data[PIC_HANDLING]&s=app";}
												if($data[status_problem]=='REJECTED'){$kirim = "?p=todolist&act=problem-detail&ds=rejected&id=$data[idprob]&tek=$data[PIC_HANDLING]";}
											}else{
												$kirim = "?p=todolist&act=problem-detail&id=$data[idprob]&s=report&tek=$data[PIC_HANDLING]";
											}
											
											echo "
											<tr>
												";
												if($data[category_name] == 'Kritis'){
													echo"
														<td bgcolor='red' valign='top'><font color='white'>$no</font></td>
														<td bgcolor='red' valign='top'><font color='white'><a href='$kirim'><b><font color='white'>$data[idprob]</font></b></a></font></td>
														<td bgcolor='red'><font color='white'>$data[deskripsi]</font></td>
														<td bgcolor='red' valign='top'><font color='white'>$data[namaMesin]</font></td>
														";
												}
												else if($data[category_name] == 'Penting'){
													echo"	
														<td bgcolor='yellow' valign='top'>$no</font></td>
														<td bgcolor='yellow' valign='top'><a href='$kirim'><b>$data[idprob]</b></a></td>
														<td bgcolor='yellow'>$data[deskripsi]</td>
														<td bgcolor='yellow' valign='top'>$data[namaMesin]</td>";
												}
												else{
													echo"
														<td valign='top'>$no</td>
														<td valign='top'><a href='$kirim'><b>$data[idprob]</b></a></td>
														<td>$data[deskripsi]</td>
														<td valign='top'>$data[namaMesin]</td>
														";
												}
												echo"
												
												";
											//if($h[divisi]=='PRODUKSI'){
												if($data[status_problem] == 'FINISH' || $data[status_problem] == 'X'){
													if($data[status_problem] == 'X')
													{
														echo "<td>BELUM APPROVED</td>";
													}
													else
													{
														echo "<td>FINISHED </td>";

													}
													if(strtolower($data[created_by]) == strtolower($_SESSION[username])){
														/*echo "<td><a href='modul/911/aksi_911.php?p=approve&act=approve&id=$data[idprob]' title='Klik for approval problem' class='btn btn-sm btn-danger'>APPROVE</a> &nbsp;
																  <a href='#reject' title='Klik for rejecting' data-toggle='modal' data-id='$data[idprob]' class='btn btn-sm btn-info'  >REJECT</a>
															  </td>";*/
															  echo "<td></td>";
													}else{
														echo "<td>&nbsp;</td>";
													}
												}
												else if($data[status_problem] == 'APPROVED'){
													echo "<td>APPROVED </td>";
													// $l = mysqli_fetch_array(mysqli_query($conn,"select *from user where username = '$_SESSION[username]'"));
													// $app= mysqli_num_rows(mysqli_query($conn, "select * from mapproval a left join tuserapproval b on a.idApproval=b.idApproval 
													// 	where idUser = '$l[iduser]'"));
													// if($app > 0){
													// echo "
													// 	<td><a href='modul/911/aksi_911.php?p=todolist&act=closed&ds=approved&id=$data[idprob]' class='btn btn-sm btn-danger' title='Klik for closed problem'>CLOSED</a>&nbsp;&nbsp;
													// 	<a href='#reject' title='Klik for rejecting' data-toggle='modal' data-id='$data[idprob]' class='btn btn-sm btn-info'  >REJECT</a></td>";
													// }else{
														echo "<td>&nbsp;</td>";
													// }
												}
												else if($data[status_problem] == 'OPEN'){
													echo "<td>OPEN </td>";
													if($data[created_by] == $_SESSION[username]){
														?>
														<!-- <td><a href='<?php echo "modul/911/aksi_911.php?p=todolist&act=delete-problem&id=$data[idprob]&dash=1";?>' title='Klik for delete problem' class='btn btn-sm btn-info' onclick="return confirm('Apakah Anda yakin MEM-BATAL-KAN Masalah Ini?');">BATAL</a></td> -->

														<td></td>
														<?php
													}else{
														echo "<td>&nbsp;</td>";
													}
												}
												else if($data[status_problem] == 'ASSIGN'){
													echo "<td>ASSIGN </td>";
													if($data[created_by] == $_SESSION[username]){
														?>
														<!-- <td><a href='<?php echo "?p=edit-problem&id=$data[idprob]";?>' title='Klik for editing problem' class='btn btn-sm btn-success'>EDIT PROBLEM</a></td> -->
														<td></td>
														<?php
													}else{
														echo "<td>&nbsp;</td>";
													}
												}
												else if($data[status_problem] == 'IN PROGRESS'){
													echo "<td>IN PROGRESS </td>";
													if($data[created_by] == $_SESSION[username]){
														//perubahan tidak boleh ada tombol di dashboard
														?>
														<!-- <td><a href='<?php echo "?p=edit-problem&id=$data[idprob]";?>' title='Klik for editing problem' class='btn btn-sm btn-success'>EDIT PROBLEM</a></td> -->
														<td></td>
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
											$user_buat = mysqli_fetch_array(mysqli_query($conn, "SELECT *FROM `user` s left join tfield f on s.id_field=f.id_field where username='$data[created_by]';"));
											echo"
											<td>$user_buat[fullname]</td>
											<td>$data[fullname]</td>
											</tr>";
											$no++;
										}
									echo "
<div class='modal animated fadeIn' id='reject' tabindex='-1' role='dialog'>
	<div class='modal-dialog' role='document'>
        <div class='modal-content'>
            <div class='modal-header'>
                <h4 class='title' id='defaultModalLabel'>REJECT</h4>
				<small>Reject*</small>
            </div>
            <div class='modal-body'>
                <div class='comment-form'>
                   <div class='hasil-data'></div>
			
			</div>
		</div>
    </div>
</div>
		";
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
				
				<div class="col-lg-3 col-md-3">
				<div class="fixed">
				<?php
					if($ww > 0 && $div[divisi]=='MAINTENANCE' && $div[level]=='superadmin'){
				?>
				<div class="col-lg-12 col-md-12">
				 <div class="cardds top_counter">
                        <div class="body">
							<a href='?p=input-est-time'><div class="icon"><img src='modul/bell.gif' width='95%' /> </div></a>
							<div class="content">
								<div class="text"><b><font color='red'>Estimasi?</font></b></div>
								<h4 class="number">
								<?php
									$p = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM tassign t where (EST_DAY IS NULL OR EST_HOUR IS NULL OR EST_MIN IS NULL) and NO_PELAPORAN LIKE 'TSK%';"));

									echo $p;
								?>
								</h4>
							</div>
						</div>	
                    </div>
				</div>
				<?php
				}
				else{}
				if($pending > 0 && $div[divisi]=='MAINTENANCE' && $div[level]=='superadmin'){
					?>
			<div class="col-lg-12 col-md-12">
				 <div class="cardds top_counter">
                        <div class="body">
							<a href='?p=pendingproblem'><div class="icon"><img src='modul/pending.gif' width='100%' /> </div></a>
							<div class="content">
								<div class="text"><b><font color='red'>Pending</font></b></div>
								<h4 class="number">
								<?php
									$p = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM tproblems where status_problem='PENDING' and (idprob LIKE 'TSK%' OR idprob LIKE 'MTC%');"));

									echo $p;
								?>
								</h4>
							</div>
						</div>	
                    </div>
				</div>
					<?php
				}if ($finish2 > 0 && $div[divisi]=='MAINTENANCE' && $div[level]=='superadmin' ) {
					?>
			<div class="col-lg-12 col-md-12">
				 <div class="cardds top_counter">
                        <div class="body">
							<a href='?p=dashboard&act=blmclosed'><div class="icon"><img src='modul/pending.gif' width='100%' /> </div></a>
							<div class="content">
								<div class="text"><b><font color='red'>Belum Approved (Closed)</font></b></div>
								<h4 class="number">
								<?php
									$p = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM tproblems where status_problem='X' and (idprob LIKE 'TSK%' OR idprob LIKE 'MTC%');"));

									echo $p;
								?>
								</h4>
							</div>
						</div>	
                    </div>
				</div>
					<?php
				}

				else{}

					if ( $div[divisi]=='MAINTENANCE' && $div[level]=='superadmin' ) {
					
				?>
				<div class="col-lg-12 col-md-12">
				 <div class="cardds top_counter">
                        <div class="body">
							<a href='?p=dashboard&act=open'><div class="icon"><i class="fa fa-hourglass-half"></i> </div></a>
							<div class="content">
								<div class="text"><b>Open</b></div>
								<h4 class="number">
								<?php
									$p = mysqli_num_rows(mysqli_query($conn,"select *from tproblems p
									where status_problem ='OPEN' and (idprob LIKE 'TSK%' OR idprob LIKE 'MTC%')"));

									echo $p;
								?>
								</h4>
							</div>
						</div>	
                    </div>
				</div>
				<div class="col-lg-12 col-md-12">
					<div class="cardds top_counter">
                        <div class="body">
							<a href='?p=dashboard&act=assign'><div class="icon"><i class="fa fa-signature"></i> </div></a>
							<div class="content">
								<div class="text"><b>Assigned</b></div>
								<h4 class="number">
								<?php
									$p = mysqli_num_rows(mysqli_query($conn,"select *from tproblems p
									where status_problem ='ASSIGN' and idprob LIKE 'TSK%'"));

									echo $p;
								?>
								</h4>
							</div>
						</div>	
                    </div>
				</div>
				<div class="col-lg-12 col-md-12">
					<div class="cardds top_counter">
                        <div class="body">
							<a href='?p=dashboard&act=inprogress'><div class="icon"><i class="fa fa-spinner"></i> </div></a>
							<div class="content">
								<div class="text"><b>In Progress</b></div>
								<h4 class="number">
								<?php
									$p = mysqli_num_rows(mysqli_query($conn,"select *from tproblems p
									where status_problem ='IN PROGRESS' and (idprob LIKE 'TSK%' OR idprob LIKE 'MTC%')"));

									echo $p;
								?>
								</h4>
							</div>
						</div>	
                    </div>
				</div>
				<div class="col-lg-12 col-md-12">
					<div class="cardds top_counter">
                        <div class="body">
							<a href='?p=dashboard&act=menunggusp' title='Menunggu Sparepart'><div class="icon"><i class="fa fa-cog"></i> </div></a>
							<div class="content">
								<div class="text"><b>Sparepart</b></div>
								<h4 class="number">
								<?php
									$p = mysqli_num_rows(mysqli_query($conn,"select *from tproblems p
									where status_problem ='MENUNGGU SPAREPART' "));
									//Tidak difilter khusus TSK, karena bisa menerima permintaan sparepart dari GA
									echo $p;
								?>
								</h4>
							</div>
						</div>	
                    </div>
				</div>
				<div class="col-lg-12 col-md-12">
					<div class="cardds top_counter">
                        <div class="body">
							<a href='?p=dashboard&act=finish'><div class="icon"><i class="fa fa-check"></i> </div></a>
							<div class="content">
								<div class="text"><b>Finish</b></div>
								<h4 class="number">
								<?php
									$p = mysqli_num_rows(mysqli_query($conn,"select *from tproblems p
									where status_problem ='FINISH' and (idprob LIKE 'TSK%' OR idprob LIKE 'MTC%')"));

									echo $p;
								?>
								</h4>
							</div>
						</div>	
                    </div>
				</div>
				<div class="col-lg-12 col-md-12">
					<div class="cardds top_counter">
                        <div class="body">
							<a href='?p=dashboard&act=approved'><div class="icon"><i class="fa fa-user"></i> </div></a>
							<div class="content">
								<div class="text"><b>Approved</b></div>
								<h4 class="number">
								<?php
									$p = mysqli_num_rows(mysqli_query($conn,"select *from tproblems p
									where status_problem ='APPROVED' and (idprob LIKE 'TSK%' OR idprob LIKE 'MTC%')"));

									echo $p;
								?>
								</h4>
							</div>
						</div>	
                    </div>
				</div>
				<div class="col-lg-12 col-md-12">
					<div class="cardds top_counter">
                        <div class="body">
							<a href='?p=dashboard&act=rejected'><div class="icon"><i class="fa fa-window-close"></i> </div></a>
							<div class="content">
								<div class="text"><b>Rejected</b></div>
								<h4 class="number">
								<?php
									$p = mysqli_num_rows(mysqli_query($conn,"select *from tproblems p
									where status_problem ='REJECTED' and (idprob LIKE 'TSK%' OR idprob LIKE 'MTC%')"));

									echo $p;
								?>
								</h4>
							</div>
						</div>	
                    </div>
				</div>
				<?php

					}
					else
					{
						?>
						<div class="col-lg-12 col-md-12">
					<div class="cardds top_counter">
                        <div class="body">
							<a href='?p=dashboard&act=inprogress'><div class="icon"><i class="fa fa-spinner"></i> </div></a>
							<div class="content">
								<div class="text"><b>In Progress</b></div>
								<h4 class="number">
								<?php
									$p = mysqli_num_rows(mysqli_query($conn,"select *from tproblems p
									where status_problem ='IN PROGRESS' and (idprob LIKE 'TSK%' OR idprob LIKE 'MTC%')"));

									echo $p;
								?>
								</h4>
							</div>
						</div>	
                    </div>
				</div>
						<?php
					}
				?>
			</div>
		</div>
				
			
  <script src="modul/911/jquery-3.1.1.min.js"></script>
  <script type="text/javascript">
    $(document).ready(function(){
        $('#reject').on('show.bs.modal', function (e) {
            var idx = $(e.relatedTarget).data('id');
            //menggunakan fungsi ajax untuk pengambilan data
            $.ajax({
                type : 'post',
                url : 'modul/911/rejectproblem.php',
                data :  'idx='+ idx,
                success : function(data){
                $('.hasil-data').html(data);//menampilkan data ke dalam modal
                }
            });
         });
    });
  </script>
                      