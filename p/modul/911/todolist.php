<?php
ob_start ("ob_gzhandler");
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
		
?>
<div class='block-header'>
                <div class='row'>
                    <div class='col-lg-5 col-md-8 col-sm-12'>                        
                        <h2><a href='javascript:void(0);' class='btn btn-xs btn-link btn-toggle-fullwidth'><i class='fa fa-arrow-left'></i></a> To Do List</h2>
                        <ul class='breadcrumb'>
                            <li class='breadcrumb-item'><a href='?p=dashboard'><i class='icon-home'></i></a></li>                            
                            <li class='breadcrumb-item'>911</li>
                            <li class='breadcrumb-item active'>Problem List</li>
                        </ul>
                    </div>         
                </div>
            </div>
	<div class="col-lg-12">
                    <div class="card">
                        <div class="body">
						<?php
						$kategori = "<b>$_GET[category]</b>";
						echo "
							<h6 align='right'>$kategori</h6>
                            <div class='table-responsive'>
                                <table class='table' >
                                    <thead>
                                        <tr>
                                            <th width='1%'>KODE</th>
											<th width='20%'>NAMA PELAPOR</th>
                                            <th width='5%'>WAKTU LAPOR</th>
											<th width='5%'>PRIORITAS</th>
											<th width='5%'>KATEGORI</th>
											<th width='30%'>DETAIL MASALAH</th>
											<th width='10%'>STATUS</th>
                                        </tr>
                                    </thead>
                                    <tbody>";
							$l = mysqli_fetch_array(mysqli_query($conn,"select *from user where username = '$_SESSION[username]'"));
							$date = date('Y-m-d');
							$no=1;
							if($l[divisi]=='PREPRESS' || $l[divisi]=='PPIC'){
								if($_GET[t]=='1'){
									$ro = mysqli_query($conn,"SELECT a.*,mc.category_name, c.PIC_HANDLING FROM `tproblems` a 
															LEFT JOIN mcategories mc ON a.idcat=mc.idcat 
															join tassign c on a.idprob=c.no_pelaporan
													   where a.idcat='$_GET[id]' and c.pic_handling='$_SESSION[username]' and a.status_problem NOT IN ('CLOSED','APPROVED') AND a.divisi_problem IN ('PREPRESS','PPIC') order by a.idcat asc");
								}else{
									$ro = mysqli_query($conn,"SELECT a.*,mc.category_name, c.PIC_HANDLING FROM `tproblems` a 
															LEFT JOIN mcategories mc ON a.idcat=mc.idcat 
															join tassign c on a.idprob=c.no_pelaporan
															where c.pic_handling='$_SESSION[username]' and a.status_problem NOT IN ('CLOSED','APPROVED')  AND a.divisi_problem IN ('PREPRESS','PPIC') order by a.idcat asc");
								}
							}else{
								if($_GET[t]=='1'){
									$ro = mysqli_query($conn,"SELECT a.*,mc.category_name, c.PIC_HANDLING FROM `tproblems` a 
															LEFT JOIN mcategories mc ON a.idcat=mc.idcat 
															join tassign c on a.idprob=c.no_pelaporan
													   where a.idcat='$_GET[id]' and c.pic_handling='$_SESSION[username]' and a.status_problem NOT IN ('CLOSED','APPROVED') 
													   group by a.idprob
													   order by mc.idcat asc");
								}else{
									$ro = mysqli_query($conn,"SELECT a.*,mc.category_name, c.PIC_HANDLING FROM `tproblems` a 
															LEFT JOIN mcategories mc ON a.idcat=mc.idcat 
															join tassign c on a.idprob=c.no_pelaporan
															where c.pic_handling='$_SESSION[username]' and a.status_problem NOT IN ('CLOSED','APPROVED') 
															group by a.idprob
															order by mc.idcat asc");
								}
							}
									while($r = mysqli_fetch_array($ro)){
										$h = mysqli_query($conn,"select *from tlampiran where idprob = '$r[idprob]'");
										$i = mysqli_num_rows($h);
										
										if($r[category_name]=='Kritis'){
											echo"<tr bgcolor='red'>";
											$color = 'white';
										}
										else if($r[category_name]=='Penting'){
											echo"<tr bgcolor='yellow'>";
											$color = 'black';
										}
										else{
											echo"<tr>";
											$color = 'black';
										}
									echo "
											<td><a href='?p=todolist&act=problem-detail&id=$r[idprob]&tek=$r[PIC_HANDLING]&i=as'><b>$r[idprob]</b></a></td>
                                            <td><font color='$color'>$r[namapelapor]</font></td>
                                            <td><font color='$color'>$r[created_at]</font></td>
											<td><font color='$color'>$r[category_name]</font></td>
											<td><font color='$color'>$r[category]</font></td>
											<td width='50%'><font color='$color'>".substr($r[deskripsi], 0, 25)."..."."</font></td>
											<td>";
											$ts = mysqli_query($conn, "select *from tproblems where idprob = '$r[idprob]'");
											$g = mysqli_fetch_array($ts);
											if($g[status_problem] == 'ASSIGN'){
												echo"<a href='$aksi?p=todolist&act=in-progress&id=$r[idprob]'>
													<button type='button' class='btn btn-success btn-sm' >IN PROGRESS</button></a>";
											}else if($g[status_problem] == 'IN PROGRESS' || $g[status_problem] == 'RE-IN PROGRESS' ){
												echo"<a href='?p=todolist&act=problem-detail&id=$r[idprob]&i=as'>
													<button type='button' class='btn btn-info btn-block' data-toggle='modal' data-target='#addnote'>FINISH</button></a>";
											}
											else if($g[status_problem] == 'MENUNGGU SPAREPART'){
												echo"<a href='$aksi?p=todolist&act=menunggusp&id=$r[idprob]'>
													<button type='button' class='btn btn-danger btn-block btn-sm'>MENUNGGU SPAREPART</button></a>";
											}
											else if($g[status_problem] == 'FINISH'){
												echo"<font color='blue'><B>BELUM APPROVED</B></font></a>";
											}
											echo"</td>
										</tr>";
										$no++;
									}
										
                              echo"      </tbody>
                                </table>
                            </div>";
							?>
                        </div>
                    </div>
    </div>
<?php
echo"
<div class='modal fade' id='finished'>
	<div class='modal-dialog'>
		<div class='modal-content'>
			<div class='modal-header'>
				<h4 class='modal-title'>ACTION HANDLING PROBLEM</h4>
				<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
			</div>
			<div class='modal-body'>
				<p>
					<div class='hasil-data'></div>
				</p>
			</div>
		</div>
	</div>
</div>
";
?>

<?php
break;

case "problem-detail":
$date = date('Y-m-d');
	date_default_timezone_set('Asia/Jakarta');
$time = date('H:i:s');
if($_GET[tek]==NULL){
	$r = mysqli_query($conn, "select tp.idprob, tp.namapelapor, tp.created_by, tp.created_at, tp.deskripsi, tm.namaMesin, tu.namaUnit, tp.category, ta.PIC_HANDLING, mc.category_name,
						  ta.EST_DAY, ta.EST_HOUR, ta.EST_MIN, ta.PROBLEM_JOB, tn.category1, tn.category2, tn.category3, tp.status_problem as sttprob from tproblems tp 
						  LEFT JOIN tassign ta ON tp.idprob = ta.no_pelaporan
						  LEFT JOIN mcategories mc ON tp.idcat=mc.idcat
						  LEFT JOIN tmesin tm ON tp.id_mesin = tm.idMesin
						  LEFT JOIN tmesinunit tu ON tp.id_unit_mesin = tu.idUnit
						  LEFT JOIN tproblemnote tn ON tp.idprob=tn.idprob
						  where tp.idprob = '$_GET[id]' order by tp.idprob, ta.NO_ASSIGN desc LIMIT 1");
}else{
	$r = mysqli_query($conn, "select tp.idprob, tp.namapelapor, tp.created_by, tp.created_at, tp.deskripsi, tm.namaMesin, tu.namaUnit, tp.category, ta.PIC_HANDLING, mc.category_name,
						  ta.EST_DAY, ta.EST_HOUR, ta.EST_MIN, ta.PROBLEM_JOB, tn.category1, tn.category2, tn.category3, tp.status_problem as sttprob from tproblems tp 
						  LEFT JOIN tassign ta ON tp.idprob = ta.no_pelaporan
						  LEFT JOIN mcategories mc ON tp.idcat=mc.idcat
						  LEFT JOIN tmesin tm ON tp.id_mesin = tm.idMesin
						  LEFT JOIN tmesinunit tu ON tp.id_unit_mesin = tu.idUnit
						  LEFT JOIN tproblemnote tn ON tp.idprob=tn.idprob
						  where tp.idprob = '$_GET[id]' AND ta.PIC_HANDLING='$_GET[tek]' order by tp.idprob, ta.NO_ASSIGN desc LIMIT 1");
}
$u = mysqli_fetch_array($r);
	echo "<div class='container-fluid'>
			<div class='block-header'>
                <div class='row'>
                    <div class='col-lg-5 col-md-8 col-sm-12'>                        
                        <h2><a href='javascript:void(0);' class='btn btn-xs btn-link btn-toggle-fullwidth'><i class='fa fa-arrow-left'></i></a> Problem Details</h2>
                        <ul class='breadcrumb'>
                            <li class='breadcrumb-item'><a href='?p=dashboard'><i class='icon-home'></i></a></li>                            
                            <li class='breadcrumb-item'>911</li>
                            <li class='breadcrumb-item active'>Problem Detail</li>
                        </ul>
                    </div>         
                </div>
            </div>
            <div class='row clearfix'>
                <div class='col-lg-8 col-md-12 left-box'>
                    <div class='card single_post'>
                        <div class='body'>
                            <h6 align='left'><b>Detail Problem</b></h6><hr>
                            <p>$u[deskripsi]</p>
                        <br>";
						if($_GET[i]=='as'){
						}
						if($_GET[s]=='report'){}
						else{
                            echo"<button type='button' class='btn btn-primary btn-block' data-toggle='modal' data-target='#addnote'>Catatan</button>";}
                        echo"</div>
                    </div>
					
					<div class='card'>
                        <div class='header'>
                            <h2><b>Attachment</b></h2>                                               
                            <div class='input-group'>
							<table class='table-hover dataTable'>";
							$r2 = mysqli_query($conn, "select id_lampiran, idprob, lampiran from tlampiran where idprob = '$_GET[id]' order by id_lampiran desc");
							while($tt = mysqli_fetch_array($r2)){
							$no=1;
							
								echo "
								<tr><td><a href='modul/911/download.php?lampiran=$tt[lampiran]' target='_blank'>$tt[lampiran]</a></td></tr>
								";
								$no++;
							}
							echo "
							</table>
                            </div>
                        </div>
                    </div>
					<hr />
					<div class='card'>
                        <div class='header'>
                            <h2><b>Alasan Pending</b></h2>                                               
                            <div class='input-group'>
							<table class='table-hover dataTable'>";
							$pn = mysqli_query($conn, "SELECT * FROM tpending where idprob = '$_GET[id]' order by idIjinPending desc");
							while($pd = mysqli_fetch_array($pn)){
							$no=1;
							
								echo "
								<tr><td>$pd[Reason] - <font color='blue' size='1'>$pd[dateActionP] by $pd[createdBy]</font></td></tr>
								";
								$no++;
							}
							echo "
							</table>
                            </div>
                        </div>
                    </div>
					<div class='card'>
                        <div class='header'>
                            <h2><b>Permintaan Sparepart</b></h2>
                                               
                            <div class='input-group'>
							<div class='table-responsive'>
                            <table class='table table-striped table-hover dataTable' cellspacing='0' cellpadding='0'>
                            <thead>
							<tr><th>Code</th><th>Qty</th><th>Unit</th><th>ApprovedBy</th><th>ApprovedDate</th><th>#</th></tr>";
							$sp = mysqli_query($conn, "select s.idReq, s.kode_sparepart, sa.nama_sparepart, s.qty, s.satuan, sa.info,
													   sa.createdBy, sa.createdDate
													   from tsparepart s left join tsparepart_action sa on s.idReq=sa.idReq
													   where idprob = '$_GET[id]' order by s.idReq asc");
							echo "</thead>
							<tbody>";
							while($tt = mysqli_fetch_array($sp)){
							$no=1;
							
								echo "
								<tr><td>$tt[kode_sparepart]</td><td>$tt[qty]</td>
									<td>$tt[satuan]</td><td>$tt[createdBy]</td><td>$tt[createdDate]</td>
									<td>";
									if($tt[createdBy]==NULL){
										echo "<a href='$aksi?p=todolist&act=delsp&idreq=$tt[idReq]&id=$_GET[id]&i=$_GET[i]'><font color='red'><b>X</b></font></a></td></tr>";
									}else{
										echo "<font color='grey'><b>X</b></font></td></tr>";
									}
								
								$no++;
							}
							echo "</tbody>
							</table>
							 </div>
                            </div>
                        </div>
                    </div>
                    <div class='card'>
                            <div class='header'>
                                <h2><b>Langkah-langkah Kerja</b></h2>
                            </div><hr>
                            <div class='body'>
                                <ul class='comment-reply list-unstyled'>";
								$w = mysqli_query($conn,"select *from tproblemnote where idprob = '$_GET[id]' and created_by='$_GET[tek]' group by idprob, datenote, timenote order by idnote asc");
								while($h = mysqli_fetch_array($w)){
									$lu = mysqli_fetch_array(mysqli_query($conn,"select *from user where username = '$h[created_by]'"));
                                    echo"<li class='row clearfix'>
                                        <div class='icon-box col-md-2 col-4'>";
										if($lu[photo]==''){
											echo "<img class='img-fluid img-thumbnail' src='modul/master/users/photo/no_image.jpg' alt='Awesome Image'>";
										}
										else{
											echo "<img class='img-fluid img-thumbnail' src='modul/master/users/photo/$lu[photo]' alt='Awesome Image'>";
										}
										echo"</div>
                                        <div class='text-box col-md-10 col-8 p-l-0 p-r0'>
										<table width='100%' border='0'>
                                            <tr><td><h5 class='m-b-0'><u>$lu[fullname] </u></h5></td><td align='right'>";
									if($h[created_by]==$_SESSION[username]){
										if($_GET[s]=="report"){
											echo"
												<a href='$aksi?p=todolist&act=delete-note&id=$_GET[id]&idnote=$h[idnote]&i=$_GET[i]&d=$h[datenote]&t=$h[timenote]' title='Delete' ><i class='icon-trash'></i></a>";
										}else{
											echo"
												<a href='$aksi?p=todolist&act=delete-note&id=$_GET[id]&idnote=$h[idnote]&i=$_GET[i]&d=$h[datenote]&t=$h[timenote]' title='Delete' ><i class='icon-trash'></i></a>";
										}
									}
										echo"</td></tr></table>";
										$qq = mysqli_query($conn,"select *from tproblemnote where idprob = '$_GET[id]' and datenote = '$h[datenote]' and timenote='$h[timenote]' order by idnote asc");
										$qql = mysqli_query($conn,"select *from tlampirannote where idprob = '$_GET[id]' and dtnote = '$h[datenote]' and tmnote='$h[timenote]' order by id_lampirannote asc");
										
										$nomor=1;
										echo"<table width='100%' border='0'>";
										while($y = mysqli_fetch_array($qq)){
											echo"
												<tr><td width='5%'>$nomor.</td><td align='justify'><p>$y[note]</p></td></tr>
											";
											$nomor++;
										}
										echo "<tr><td width='5%' colspan='2'><hr /></td></tr>";
										while($yl = mysqli_fetch_array($qql)){
											echo"
												<tr><td align='justify' colspan='2'><p>
												<a href='modul/911/downloadnote.php?lampirannote=$yl[lampirannote]' target='_blank'>$yl[lampirannote]</p></p></td></tr>
											";
											$nomor++;
										}
                                            echo"
											</table>
                                            <ul class='list-inline'>
                                                <li>
												<table width='100%'>
												<tr><td width='100%'>
													<a href='javascript:void(0);'>".tgl_indo($h[datenote])." - $h[timenote]</a></td>
													<td width='50%'><font color='grey'><i>$h[edited]</i></font></td></tr>
												</table>
												</li>
                                            </ul>
                                        </div>
                                    </li><hr>";
									//$created = $h[created_by];
								}
                               echo" </ul> ";
							   if($u[sttprob] == 'APPROVED'){}
							   else{
									if($u[PIC_HANDLING]==$_SESSION[username]){
										echo"<button type='button' class='btn btn-primary btn-block' data-toggle='modal' data-target='#finish_dua'>Catatan Kerja</button><br />";
									}
									else{}
							   }
                            echo"</div>
                        </div>
                </div>
				";
				if($u[EST_DAY]==NULL){ $est_day = 0; }else{ $est_day = $u[EST_DAY]; }
				if($u[EST_HOUR]==NULL){$est_hour = 0;}else{$est_hour = $u[EST_HOUR];}
				if($u[EST_MIN]==NULL){$est_min = 0;}else{$est_min = $u[EST_MIN];}
				
				if($u[category_name]=='Kritis'){ 
					$bg 	= 'red';
					$font 	= 'white';
				}else if($u[category_name]=='Penting'){
					$bg 	= 'yellow';
					$font 	= 'black';
				}else{
					$bg 	= 'white';
					$font 	= 'black';
				}
				
				echo"
                <div class='col-lg-4 col-md-12 right-box'>
                    <div class='card'>
                        <div class='body widget'>
                            <h6><font color='red'><b>$u[idprob]</b></font></h6>
							<table width='100%'>
							<tr><td colspan='2' align='center'><b><hr /></b></td></tr>
							<tr><td>Dilaporkan Oleh </td><td>: $u[created_by]</td></tr>
							<tr><td>Waktu Lapor </td><td>: $u[created_at]</td></tr>
							<tr><td>Prioritas </td><td bgcolor='$bg'><font color='$font'>: <b>$u[category_name]</b></font></td></tr>
							<tr><td>Mesin </td><td>: $u[namaMesin]</td></tr>
							<tr><td>Unit </td><td>: $u[namaUnit]</td></tr>
							<tr><td>Kategori </td><td>: $u[category]</td></tr>
							<tr><td>Est. Waktu Kerja </td><td>:</td></tr>
							<tr><td colspan='2' align='center'><b>$est_day HARI, $est_hour JAM, $est_min MENIT</b></td></tr>
							<tr><td colspan='2' align='center'><b><hr /></b></td></tr>";
							if($_GET[tek]==NULL){
								$time_inpro = mysqli_fetch_array(mysqli_query($conn, "select idProb, statusProblem, dateAction, handling from thandling where statusProblem = 'IN PROGRESS' AND idProb = '$u[idprob]' ORDER BY dateAction asc LIMIT 1"));
								$time_fin = mysqli_fetch_array(mysqli_query($conn, "select idProb, statusProblem, dateAction, handling from thandling where statusProblem = 'FINISH' AND idProb = '$u[idprob]' "));
								
								$time_menunggusp = mysqli_fetch_array(mysqli_query($conn, "select idProb, statusProblem, dateAction, handling from thandling where statusProblem = 'MENUNGGU SPAREPART' AND idProb = '$u[idprob]' "));
								$time_inpro2 = mysqli_fetch_array(mysqli_query($conn, "select idProb, statusProblem, dateAction, handling from thandling where statusProblem = 'IN PROGRESS' AND idProb = '$u[idprob]' ORDER BY dateAction desc LIMIT 1"));
								
								$time_pending = mysqli_fetch_array(mysqli_query($conn, "select idProb, statusProblem, dateAction, handling from thandling where statusProblem = 'PENDING' AND idProb = '$u[idprob]'"));
								$time_dispending = mysqli_fetch_array(mysqli_query($conn, "select idProb, statusProblem, dateAction, handling from thandling where statusProblem = 'DISPENDING' AND idProb = '$u[idprob]' ORDER BY dateAction desc LIMIT 1"));
								
								$time_app = mysqli_fetch_array(mysqli_query($conn, "select idProb, statusProblem, dateAction, handling from thandling where statusProblem = 'APPROVED' AND idProb = '$u[idprob]'"));
								
								$awal  = strtotime($time_inpro[dateAction]); //waktu awal
								$akhir = strtotime($time_fin[dateAction]); //waktu akhir
								
								$tunggu_in = strtotime($time_inpro2[dateAction]); //waktu menunggu sparepart
								$tunggu_sp = strtotime($time_menunggusp[dateAction]); //waktu menunggu sparepart
								
								$tunggu_dispen = strtotime($time_dispending[dateAction]); //waktu dispending
								$tunggu_pen = strtotime($time_pending[dateAction]); //waktu pending
								
								//RE-IN PROGRESS RE-FINISH
								$time_reinp = mysqli_fetch_array(mysqli_query($conn, "select idProb, statusProblem, dateAction, handling from thandling where statusProblem = 'RE-IN PROGRESS' AND idProb = '$u[idprob]'"));
								$time_refin = mysqli_fetch_array(mysqli_query($conn, "select idProb, statusProblem, dateAction, handling from thandling where statusProblem = 'FINISH' AND idProb = '$u[idprob]' ORDER BY dateAction desc LIMIT 1"));
								
								$time_reinpro = strtotime($time_reinp[dateAction]); //waktu re inprogress
								$time_refinish = strtotime($time_refin[dateAction]); //waktu re finish
							}else{
								$time_inpro = mysqli_fetch_array(mysqli_query($conn, "select idProb, statusProblem, dateAction, handling from thandling where statusProblem = 'IN PROGRESS' AND idProb = '$u[idprob]' AND handling='$u[PIC_HANDLING]' ORDER BY dateAction asc LIMIT 1"));
								$time_fin = mysqli_fetch_array(mysqli_query($conn, "select idProb, statusProblem, dateAction, handling from thandling where statusProblem = 'FINISH' AND idProb = '$u[idprob]' AND handling='$u[PIC_HANDLING]'"));
								
								$time_menunggusp = mysqli_fetch_array(mysqli_query($conn, "select idProb, statusProblem, dateAction, handling from thandling where statusProblem = 'MENUNGGU SPAREPART' AND idProb = '$u[idprob]' AND handling='$u[PIC_HANDLING]'"));
								$time_inpro2 = mysqli_fetch_array(mysqli_query($conn, "select idProb, statusProblem, dateAction, handling from thandling where statusProblem = 'IN PROGRESS' AND idProb = '$u[idprob]' ORDER BY dateAction desc LIMIT 1"));
								
								$time_pending = mysqli_fetch_array(mysqli_query($conn, "select idProb, statusProblem, dateAction, handling from thandling where statusProblem = 'PENDING' AND idProb = '$u[idprob]'"));
								$time_dispending = mysqli_fetch_array(mysqli_query($conn, "select idProb, statusProblem, dateAction, handling from thandling where statusProblem = 'DISPENDING' AND idProb = '$u[idprob]' ORDER BY dateAction desc LIMIT 1"));
								
								$time_app = mysqli_fetch_array(mysqli_query($conn, "select idProb, statusProblem, dateAction, handling from thandling where statusProblem = 'APPROVED' AND idProb = '$u[idprob]'"));
								
								$awal  = strtotime($time_inpro[dateAction]); //waktu awal
								$akhir = strtotime($time_fin[dateAction]); //waktu akhir
								
								$tunggu_in = strtotime($time_inpro2[dateAction]); //waktu menunggu sparepart
								$tunggu_sp = strtotime($time_menunggusp[dateAction]); //waktu menunggu sparepart
								
								$tunggu_dispen = strtotime($time_dispending[dateAction]); //waktu dispending
								$tunggu_pen = strtotime($time_pending[dateAction]); //waktu pending
								
								//RE-IN PROGRESS RE-FINISH
								$time_reinp = mysqli_fetch_array(mysqli_query($conn, "select idProb, statusProblem, dateAction, handling from thandling where statusProblem = 'RE-IN PROGRESS' AND idProb = '$u[idprob]' AND handling='$u[PIC_HANDLING]'"));
								$time_refin = mysqli_fetch_array(mysqli_query($conn, "select idProb, statusProblem, dateAction, handling from thandling where statusProblem = 'FINISH' AND idProb = '$u[idprob]' AND handling='$u[PIC_HANDLING]' ORDER BY dateAction desc LIMIT 1"));
								
								$time_reinpro = strtotime($time_reinp[dateAction]); //waktu re inprogress
								$time_refinish = strtotime($time_refin[dateAction]); //waktu re finish
							}
							
							
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
							
							if($akhir==NULL){ $real_day = 0; $real_hour = 0; $real_min = 0;}else{ $real_day = $hari; $real_hour = $jam; $real_min = $menit;}
							if($differe <=0){$hari_SP = 0; $jam_SP=0; $menit_SP=0;}else{$hari_SP=$hari_SP; $jam_SP=$jam_SP; $menit_SP=$menit_SP;}
							if($_GET[s]=='input_estim' || ($u[EST_DAY]==NULL || $u[EST_HOUR]==NULL || $u[EST_MIN]==NULL)){
								echo"
								<tr><td colspan='2'><p align='center'><font color='red'><b>Belum Ada Estimasi Waktu</b></font></p></td></tr>
								";
							}
							else{
							echo"
							<tr><td>Kategori 1 </td><td>: $u[category1] <br></td></tr>
							<tr><td>Kategori 2 </td><td>: $u[category2]</td></tr>
							<tr><td>Kategori 3 </td><td>: $u[category3]</td></tr>
							<tr><td>In Progress Pada </td><td>: $time_inpro[dateAction]</td></tr>
							<tr><td>In Progress Oleh </td><td>: $time_inpro[handling]</td></tr>
							<tr><td>Menunuggu Sparepart </td><td>: <b>$hari_SP Hari, $jam_SP Jam, $menit_SP Menit </b></td></tr>
							<tr><td>Pending </td><td>: <b>$hari_P Hari, $jam_P Jam, $menit_P Menit</b></td></tr>
							<tr><td>Finished Pada</td><td>: $time_fin[dateAction]</td></tr>
							<tr><td>Finished Oleh </td><td>: $time_fin[handling]</td></tr>
							<tr><td>Approved Pada</td><td>: $time_app[dateAction]</td></tr>
							<tr><td>Approved Oleh </td><td>: $time_app[handling]</td></tr>
							<tr><td>Real Waktu Kerja </td><td>:</td></tr>
							<tr><td colspan='2' align='center'><b>$real_day HARI, $real_hour JAM, $real_min MENIT</b></td></tr>
							<tr><td colspan='2' align='center'><b><hr /></b></td></tr>";
						$ts = mysqli_query($conn, "select status_problem, idprob from tproblems where idprob = '$_GET[id]'");
						$g = mysqli_fetch_array($ts);
						if($akhir==NULL && $g[status_problem]=='OPEN' ){
							echo"<tr><td colspan='2' align='center'><b><font color='blue'>OPEN</font></b></td></tr>";
						}
						else if($akhir==NULL && $g[status_problem]=='MENUNGGU SPAREPART'){
							echo"<tr><td colspan='2' align='center'><b><font color='blue'>MENUNGGU SPAREPART</font></b></td></tr>";
						}
						else if($akhir==NULL && $g[status_problem]=='PENDING'){
							$p = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM tpending where idProb='$u[idprob]'"));
							echo"<tr><td colspan='2' align='center'><b><font color='blue'>PENDING</font></b><hr />($p[Reason])<hr /></td></tr>";
						}
						else if($akhir!=NULL && $g[status_problem]=='RE-IN PROGRESS'){
							echo"<tr><td colspan='2' align='center'><b><font color='blue'>RE-IN PROGRESS</font></b></td></tr>";
						}
						else if($akhir==NULL && ($g[status_problem] == 'FINISH' || $g[status_problem]=='CLOSED' || $g[status_problem]=='APPROVED')){
							echo"<tr><td colspan='2' align='center'><b><font color='red'>NOL <br />(TIDAK ADA PEKERJAAN)</font></b></td></tr>";
						}
						else if($akhir==NULL ){
							echo"<tr><td colspan='2' align='center'><b><font color='blue'>IN PROGRESS</font></b></td></tr>";
						}else{
								if($hari > $u[EST_DAY]){
									echo"<tr><td colspan='2' align='center'><b><font color='red'>OVERDUE</font></b></td></tr>";
								}else if($hari == $u[EST_DAY]){
									if($jam > $u[EST_HOUR]){
										echo"<tr><td colspan='2' align='center'><b><font color='red'>OVERDUE</font></b></td></tr>";
									}else if($jam == $u[EST_HOUR]){
											if($menit > $u[EST_MIN]){
												echo"<tr><td colspan='2' align='center'><b><font color='red'>OVERDUE</font></b></td></tr>";
											}else{
												echo"<tr><td colspan='2' align='center'><b><font color='green'>ON TIME</font></b></td></tr>";
											}
									}else{
										echo"<tr><td colspan='2' align='center'><b><font color='green'>ON TIME</font></b></td></tr>";
									}
								}else{
									echo"<tr><td colspan='2' align='center'><b><font color='green'>ON TIME</font></b></td></tr>";
								}
						}
					}
						//PERMINTAAN SPAREPART
						/* 
						if($g[status_problem]=='OPEN'){
							
						}else{
							echo"<tr><td colspan='2'>
							<br>
							<button type='button' class='btn btn-danger btn-block' data-toggle='modal' data-target='#sparepart'>PERMINTAAN SPAREPART</button></td></tr>";
							
						} */
							
							
							if($_GET[i]=='as'){
								$ts = mysqli_query($conn, "select status_problem, idprob from tproblems where idprob = '$_GET[id]'");
								$g = mysqli_fetch_array($ts);
								if($g[status_problem] == 'ASSIGN'){
									
									echo"
									<tr><td colspan='2'><br> ";
									echo"<a href='$aksi?p=todolist&act=in-progress&id=$_GET[id]'><button type='button' class='btn btn-primary btn-block' >IN PROGRESS</button></a></td></tr>";
								}else if($g[status_problem] == 'IN PROGRESS'){
									echo"<tr><td colspan='2'>
									<br>
									<button type='button' class='btn btn-danger btn-block' data-toggle='modal' data-target='#sparepart'>PERMINTAAN SPAREPART</button></td></tr>";
									echo"
									<tr><td colspan='2'><br> ";
									echo"<button type='button' class='btn btn-success btn-block' data-toggle='modal' data-target='#finish'>FINISH</button></td></tr>";
								}
								else if($g[status_problem] == 'RE-IN PROGRESS'){
									echo"<tr><td colspan='2'>
									<br>
									<button type='button' class='btn btn-danger btn-block' data-toggle='modal' data-target='#sparepart'>PERMINTAAN SPAREPART</button></td></tr>";
									echo"
									<tr><td colspan='2'><br> ";
									echo"<button type='button' class='btn btn-success btn-block' data-toggle='modal' data-target='#re-finish'>RE-FINISH</button></td></tr>";
								}
								else if($g[status_problem] == 'MENUNGGU SPAREPART'){
									echo"<tr><td colspan='2'>
									<br>
									<button type='button' class='btn btn-danger btn-block' data-toggle='modal' data-target='#sparepart'>PERMINTAAN SPAREPART</button></td></tr>";
									echo"
									<tr><td colspan='2'><br> ";
									echo"<button type='button' class='btn btn-success btn-block' data-toggle='modal' data-target='#finish' disabled='disabled' title='Masih Menunggu Sparepart' >FINISH</button></td></tr>";
								}
								else{}
							}
							else if($_GET[s]=='report'){}
							else if($_GET[s]=='app'){
								if($g[status_problem] == 'FINISH'){
									echo"<tr><td colspan='2'><br> <a href='$aksi?p=todolist&act=approved&id=$_GET[id]'><button type='button' class='btn btn-danger btn-block'>APPROVED</button></a></td></tr>";
								}else{}
							}
							else if($_GET[s]=='disapp'){
								echo"<tr><td colspan='2'><br> <a href='$aksi?p=todolist&act=disapproved&id=$_GET[id]'><button type='button' class='btn btn-warning btn-block'>DISAPPROVED</button></a></td></tr>";
							}
							else if($_GET[s]=='input_estim'){
								echo"<tr><td colspan='2'><br><button type='button' class='btn btn-success btn-block' data-toggle='modal' data-target='#estimasi'>INPUT ESTIMASI WAKTU</button></td></tr>";
							}
							else{
								$ts = mysqli_query($conn, "select *from tassign where no_pelaporan = '$_GET[id]'");
								if(mysqli_num_rows($ts)>0){
									echo"<tr><td colspan='2'><br> <button type='button' class='btn btn-warning btn-block' data-toggle='modal' data-target='#assign'>RE-ASSIGN TO</button></td></tr>";
								}else{
									echo"<tr><td colspan='2'><br> <button type='button' class='btn btn-danger btn-block' data-toggle='modal' data-target='#assign'>ASSIGN TO</button></td></tr>";
								}
							}
						
							echo "
							</table>
                        </div>
                    </div>
                    
					
                </div>
            </div>

        </div>
	<div class='modal animated fadeIn' id='addnote' tabindex='-1' role='dialog'>
    <div class='modal-dialog' role='document'>
        <div class='modal-content'>
            <div class='modal-header'>
                <h4 class='title' id='defaultModalLabel'>Add Note</h4>
				<small>Share your solution*</small>
            </div>
            <div class='modal-body'>
                <div class='comment-form'>
                    <form class='row clearfix' method='POST' action='$aksi?p=todolist&act=problem-note&id=$_GET[id]&i=$_GET[i]'>
                        <div class='col-sm-6'>
                            <div class='form-group'>
                                <input type='hidden' class='form-control' name='c_by' value = '$_SESSION[username]' readonly='readonly'>
								<input type='hidden' class='form-control' name='dt_note' value = '$date' readonly='readonly'>
								<input type='hidden' class='form-control' name='tm_note' value = '$time' readonly='readonly'>
                            </div>
                        </div>
                        <div class='col-sm-12'>
                            <div class='form-group'>
                                <textarea class='summernote' name='note' ></textarea>
                            </div>
                        </div> 
                </div>      
            </div>
            <div class='modal-footer'>
                <button type='submit' class='btn btn-primary'>Add</button>
                <button type='button' class='btn btn-outline-secondary' data-dismiss='modal'>CLOSE</button>
            </div>                               
            </form>
        </div>
    </div>
</div>	

<div class='modal animated fadeIn' id='finish' tabindex='-1' role='dialog'>
    <div class='modal-dialog-large' role='document'>
        <div class='modal-content'>
            <div class='modal-header'>
                <h4 class='title' id='defaultModalLabel'>FINISH</h4>
            </div>
            <div class='modal-body'>
                <div class='comment-form'>
                    <form class='row clearfix' method='POST' action='$aksi?p=todolist&act=finished&id=$_GET[id]' enctype='multipart/form-data'>
                        <div class='col-sm-6'>
                            <div class='form-group'>
                                <input type='hidden' class='form-control' name='c_by' value = '$_SESSION[username]' readonly='readonly'>
								<input type='hidden' class='form-control' name='dt_note' value = '$date' readonly='readonly'>
								<input type='hidden' class='form-control' name='tm_note' value = '$time' readonly='readonly'>
                            </div>
                        </div>
								
								<div class='col-md-12 col-sm-12'>
								<label class='col-md-2 col-sm-2 col-form-label' for='website'>Category 1 nnn*</label>
									<select class='form-control show-tick' name='category1' id='idKat1' required>
										<option selected disabled>---Select Category 1---</option>";
										$ts = mysqli_query($conn, "select * from tproblems where idprob = '$_GET[id]'");
										$g = mysqli_fetch_array($ts);
										$r = mysqli_query($conn, "select *from mkategori1 order by idKat1 ASC");
										while($t = mysqli_fetch_array($r)){
											if($g[category]==$t[namaKategori1]){
												echo "<option value = '$t[namaKategori1]' selected>$t[namaKategori1]</option>";
											}else{
												echo "<option value = '$t[namaKategori1]'>$t[namaKategori1]</option>";
											}
										}
									echo"
									</select>
								</div>
								
								<div class='col-md-12 col-sm-12'>
								<label class='col-md-2 col-sm-2 col-form-label' for='website'>Spesifik 1</label>
								<input type='text' name='spek1' class='form-control' required placeholder = '..........Maksimal 2 Kata..........'/>
								";
									
										echo "
								</div>
								
								<div class='col-md-12 col-sm-12'>
								<label class='col-md-2 col-sm-2 col-form-label' for='website'>Spesifik 2</label>
								<input type='text' name='spek2' class='form-control'  required placeholder = '..........Maksimal 2 Kata..........'/>
									";
										echo "
									
								</div>
								<div class='col-md-12 col-sm-12'>
								<label class='col-md-2 col-sm-2 col-form-label' for='website'>Lampiran <font color='red' size='1'>(Tidak Wajib)</font></label>
								<input type='file' name='ffinish[]' class='form-control' multiple='multiple'>
									";
										echo "
									
								</div>
							<br />
                        <div class='col-sm-12'>
                            <div class='form-group'>
							<table border='0' width='100%' id='dynamic_field_langkah'>
							<tr><td colspan='3'>&nbsp;</td></tr>
							<tr><td colspan='3'><b>Langkah-langkah Kerja : *</b><font color='red' size='1'>&nbsp;&nbsp;(WAJIB diisi minimal 3 langkah kerja yang dilakukan. Jika ada tambahan Klik tombol + warna hijau)</font></td></tr>
							<tr><td align='center' width='5%'>1.</td><td width='95%'><input type='text' name='note[]' class='form-control' autofocus required/></td><td></td></tr>
							<tr><td align='center'>2.</td><td><input type='text' name='note[]' class='form-control' required /></td><td></td></tr>
                            <tr><td align='center'>3.</td><td><input type='text' name='note[]' class='form-control' required /></td><td>
							";
								?>
								<button type="button" name="add_langkah" id="add_langkah" class="btn btn-success">+</button>
								
								<?php
					echo"
							</td></tr> 
							</table>
                            </div>
                        </div> 
                </div>      
            </div>
            <div class='modal-footer'>
                <button type='submit' class='btn btn-primary'>Save</button>
                <button type='button' class='btn btn-outline-secondary' data-dismiss='modal'>CLOSE</button>
            </div>                               
            </form>
        </div>
    </div>
</div></div>

<div class='modal animated fadeIn' id='finish_dua' tabindex='-1' role='dialog'>
    <div class='modal-dialog-large' role='document'>
        <div class='modal-content'>
            <div class='modal-header'>
                <h4 class='title' id='defaultModalLabel'>CATATAN KERJA</h4>
            </div>
            <div class='modal-body'>
                <div class='comment-form'>
                    <form class='row clearfix' method='POST' action='$aksi?p=todolist&act=finished_dua&id=$_GET[id]' enctype='multipart/form-data'>
                        <div class='col-sm-6'>
                            <div class='form-group'>
                                <input type='hidden' class='form-control' name='c_by' value = '$_SESSION[username]' readonly='readonly'>
								<input type='hidden' class='form-control' name='dt_note' value = '$date' readonly='readonly'>
								<input type='hidden' class='form-control' name='tm_note' value = '$time' readonly='readonly'>
                            </div>
                        </div>
								
								<div class='col-md-12 col-sm-12'>
								<label class='col-md-2 col-sm-2 col-form-label' for='website'>Category 1 *</label>
									<select class='form-control show-tick' name='category1' id='idKat1' required>
										<option selected disabled>---Select Category 1---</option>";
										$ts = mysqli_query($conn, "select * from tproblems where idprob = '$_GET[id]'");
										$g = mysqli_fetch_array($ts);
										$r = mysqli_query($conn, "select *from mkategori1 order by idKat1 ASC");
										while($t = mysqli_fetch_array($r)){
											if($g[category]==$t[namaKategori1]){
												echo "<option value = '$t[namaKategori1]' selected>$t[namaKategori1]</option>";
											}else{
												echo "<option value = '$t[namaKategori1]'>$t[namaKategori1]</option>";
											}
										}
									echo"
									</select>
								</div>
								
								<div class='col-md-12 col-sm-12'>
								<label class='col-md-2 col-sm-2 col-form-label' for='website'>Spesifik 1</label>
								<input type='text' name='spek1' class='form-control' required placeholder = '..........Maksimal 2 Kata..........'/>
								";
									
										echo "
								</div>
								
								<div class='col-md-12 col-sm-12'>
								<label class='col-md-2 col-sm-2 col-form-label' for='website'>Spesifik 2</label>
								<input type='text' name='spek2' class='form-control'  required placeholder = '..........Maksimal 2 Kata..........'/>
									";
										echo "
									
								</div>
								<div class='col-md-12 col-sm-12'>
								<label class='col-md-2 col-sm-2 col-form-label' for='website'>Lampiran <font color='red' size='1'>(Tidak Wajib)</font></label>
								<input type='file' name='ffinish[]' class='form-control' multiple='multiple'>
									";
										echo "
									
								</div>
							<br />
                        <div class='col-sm-12'>
                            <div class='form-group'>
							<table border='0' width='100%' id='dynamic_field_langkah'>
							<tr><td colspan='3'>&nbsp;</td></tr>
							<tr><td colspan='3'><b>Langkah-langkah Kerja : *</b><font color='red' size='1'>&nbsp;&nbsp;(WAJIB diisi minimal 3 langkah kerja yang dilakukan. Jika ada tambahan Klik tombol + warna hijau)</font></td></tr>
							<tr><td align='center' width='5%'>1.</td><td width='95%'><input type='text' name='note[]' class='form-control' autofocus required/></td><td></td></tr>
							<tr><td align='center'>2.</td><td><input type='text' name='note[]' class='form-control' required /></td><td></td></tr>
                            <tr><td align='center'>3.</td><td><input type='text' name='note[]' class='form-control' required /></td><td>
							";
								?>
								<button type="button" name="add_langkah" id="add_langkah" class="btn btn-success">+</button>
								
								<?php
					echo"
							</td></tr> 
							</table>
                            </div>
                        </div> 
                </div>      
            </div>
            <div class='modal-footer'>
                <button type='submit' class='btn btn-primary'>Save</button>
                <button type='button' class='btn btn-outline-secondary' data-dismiss='modal'>CLOSE</button>
            </div>                               
            </form>
        </div>
    </div>
</div></div>

<div class='modal animated fadeIn' id='re-finish' tabindex='-1' role='dialog'>
    <div class='modal-dialog-large' role='document'>
        <div class='modal-content'>
            <div class='modal-header'>
                <h4 class='title' id='defaultModalLabel'>RE-FINISH</h4>
            </div>
            <div class='modal-body'>
                <div class='comment-form'>
                    <form class='row clearfix' method='POST' action='$aksi?p=todolist&act=re-finished&id=$_GET[id]'>
                        <div class='col-sm-6'>
                            <div class='form-group'>
                                <input type='hidden' class='form-control' name='c_by' value = '$_SESSION[username]' readonly='readonly'>
								<input type='hidden' class='form-control' name='dt_note' value = '$date' readonly='readonly'>
								<input type='hidden' class='form-control' name='tm_note' value = '$time' readonly='readonly'>
                            </div>
                        </div>
								
								<div class='col-md-12 col-sm-12'>
								<label class='col-md-2 col-sm-2 col-form-label' for='website'>Category 1 *</label>
									<select class='form-control show-tick' name='category1' id='idKat1' required>
										<option selected disabled>---Select Category 1---</option>";
										$ts = mysqli_query($conn, "select * from tproblems where idprob = '$_GET[id]'");
										$g = mysqli_fetch_array($ts);
										$r = mysqli_query($conn, "select *from mkategori1 order by idKat1 ASC");
										while($t = mysqli_fetch_array($r)){
											if($g[category]==$t[namaKategori1]){
												echo "<option value = '$t[namaKategori1]' selected>$t[namaKategori1]</option>";
											}else{
												echo "<option value = '$t[namaKategori1]'>$t[namaKategori1]</option>";
											}
										}
									echo"
									</select>
								</div>
								
								<div class='col-md-12 col-sm-12'>
								<label class='col-md-2 col-sm-2 col-form-label' for='website'>Category 2</label>
									<select class='default-select2 form-control' name='category2'>
										<option value=''>--Select Category 2--</option>";
									
										/* $qs = mysqli_query($conn, "select *from tmesinunit u left join tmesin t on u.idMesin=t.idMesin where namaMesin = '$job[PROBLEM_JOB]' order by idUnit desc");
										
										while($ps = mysqli_fetch_array($qs)){
											
												echo "<option value='$ps[idUnit]'>$ps[namaUnit]</option>";
											
										} */
										echo "
									</select>
								</div>
								
								<div class='col-md-12 col-sm-12'>
								<label class='col-md-2 col-sm-2 col-form-label' for='website'>Category 3</label>
									<select class='default-select2 form-control' name='category3'>
										<option value=''>--Select Category 3--</option>";
									
										/* $qs = mysqli_query($conn, "select *from tmesinunit u left join tmesin t on u.idMesin=t.idMesin where namaMesin = '$job[PROBLEM_JOB]' order by idUnit desc");
										
										while($ps = mysqli_fetch_array($qs)){
											
												echo "<option value='$ps[idUnit]'>$ps[namaUnit]</option>";
											
										} */
										echo "
									</select>
								</div>
							<br />
                        <div class='col-sm-12'>
                            <div class='form-group'>
							<table border='0' width='100%' id='dynamic_field_langkah'>
							<tr><td colspan='3'>&nbsp;</td></tr>
							<tr><td colspan='3'><b>Langkah-langkah Kerja : *</b><font color='red' size='1'>&nbsp;&nbsp;(WAJIB diisi minimal 3 langkah kerja yang dilakukan. Jika ada tambahan Klik tombol + warna hijau)</font></td></tr>
							<tr><td align='center' width='5%'>1.</td><td width='95%'><input type='text' name='note[]' class='form-control' autofocus required/></td><td></td></tr>
							<tr><td align='center'>2.</td><td><input type='text' name='note[]' class='form-control' required /></td><td></td></tr>
                            <tr><td align='center'>3.</td><td><input type='text' name='note[]' class='form-control' required /></td><td>
							";
								?>
								<button type="button" name="add_langkah" id="add_langkah" class="btn btn-success">+</button>
								
								<?php
					echo"
							</td></tr> 
							</table>
                            </div>
                        </div> 
                </div>      
            </div>
            <div class='modal-footer'>
                <button type='submit' class='btn btn-primary'>Save</button>
                <button type='button' class='btn btn-outline-secondary' data-dismiss='modal'>CLOSE</button>
            </div>                               
            </form>
        </div>
    </div>
</div></div>

";
echo"
<div class='modal animated fadeIn' id='assign' tabindex='-1' role='dialog'>
	<div class='modal-dialog'>
		<div class='modal-content'>
			<div class='modal-header'>
				<h4 class='modal-title'>ASSIGN TO </h4>
				<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
			</div>
			<div class='modal-body'>
			<p>
			<form class='row clearfix' method='POST' action='$aksi?p=assign&act=assign'>
			<input type='hidden' name='idprob' value='$_GET[id]'>
            <div class='col-sm-12'>
				<div class='form-group row m-b-15'>
					<label class='col-md-4 col-sm-4 col-form-label' for='website'>Assign To*</label>
					<div class='col-md-8 col-sm-8'>
						<select class='default-select2 form-control' name='assign_group' required>
							<option value=''>--Select Personil--</option>";
						$l = mysqli_fetch_array(mysqli_query($conn,"select *from user where username = '$_SESSION[username]'"));
						if($l[divisi]=='PREPRESS' || $l[divisi]=='PPIC'){
							$qs = mysqli_query($conn, "select * from user where divisi IN ('PREPRESS') and active=1 order by fullname asc");
							
						}else{
							$qs = mysqli_query($conn, "select * from user where divisi='MAINTENANCE' AND id_field=3 and active=1 order by fullname asc");
							
						}
							while($ps = mysqli_fetch_array($qs)){
								
									echo "<option value='$ps[username]'>$ps[fullname]</option>";
								
							}
							echo "
						</select>
					</div>
				</div>
				<div class='form-group row m-b-15'>
					<label class='col-md-4 col-sm-4 col-form-label' for='website'>EST Handling*</label>
					<div class='col-md-2 col-sm-2'>
						<div class='form-group'>
							<label class='control-label'>DAY</label> <input type='number' name='est_day' class='form-control'>
						</div>
					</div>
					<div class='col-md-2 col-sm-2'>
						<div class='form-group'>
							<label class='control-label'>HOUR</label> <input type='number' name='est_hour' class='form-control'>
						</div>        
					</div>
					<div class='col-md-2 col-sm-2'>
						<div class='form-group'>
							<label class='control-label'>MINUTE</label> <input type='number' name='est_minute' class='form-control'>
						</div>
					</div>
				</div>
            </div>
			<table width='100%'>
				<tr>
					<td>
						<div class='modal-footer'>
							<button type='submit' class='btn btn-primary' >SAVE</button>
						</div>  
					</td>
				</tr>
			</table>                             
        </form>
			</p>
			</div>
		</div>
	</div>
</div>";

$aa = mysqli_fetch_array(mysqli_query($conn, "select *from tassign ta left join user u on ta.PIC_HANDLING=u.username where NO_PELAPORAN='$_GET[id]'"));
echo"
<div class='modal animated fadeIn' id='estimasi' tabindex='-1' role='dialog'>
	<div class='modal-dialog'>
		<div class='modal-content'>
			<div class='modal-header'>
				<h4 class='modal-title'>ESTIMASI WAKTU </h4>
				<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
			</div>
			<div class='modal-body'>
			<p>
			<form class='row clearfix' method='POST' action='$aksi?p=estimasi&act=input_estimasi'>
			
			<div class='col-md-12 col-sm-12'><label class='control-label'>Kode Problem</label> 
				<div class='form-group'>
						<input type='text' name='idprob' class='form-control' required value='$_GET[id]' readonly='readonly' />
				</div>
			</div>
			<div class='col-md-12 col-sm-12'><label class='control-label'>Teknisi</label> 
				<div class='form-group'>
						<input type='text' class='form-control' required value='$aa[fullname]' readonly='readonly' />
						<input type='hidden' name='teknisi' class='form-control' required value='$aa[PIC_HANDLING]' readonly='readonly' />
				</div>
			</div>
			<div class='col-md-12 col-sm-12'><label class='control-label'><i>Auto Assigned by System</i> pada :</label> 
				<div class='form-group'>
						<input type='text' class='form-control' value='$aa[CREATED_DATE]' readonly='readonly' />
				</div>
			</div>
            <div class='col-sm-12'>
				<div class='form-group row m-b-15'>
					<label class='col-md-4 col-sm-4 col-form-label' for='website'>EST Handling*</label>
					<div class='col-md-2 col-sm-2'>
						<div class='form-group'>
							<label class='control-label'>DAY</label> <input type='number' name='est_day' class='form-control'>
						</div>
					</div>
					<div class='col-md-2 col-sm-2'>
						<div class='form-group'>
							<label class='control-label'>HOUR</label> <input type='number' name='est_hour' class='form-control'>
						</div>        
					</div>
					<div class='col-md-2 col-sm-2'>
						<div class='form-group'>
							<label class='control-label'>MINUTE</label> <input type='number' name='est_minute' class='form-control'>
						</div>
					</div>
				</div>
            </div>
			<table width='100%'>
				<tr>
					<td>
						<div class='modal-footer'>
							<button type='submit' class='btn btn-primary' >SAVE</button>
						</div>  
					</td>
				</tr>
			</table>                             
        </form>
			</p>
			</div>
		</div>
	</div>
</div>";

echo"
<div class='modal animated fadeIn' id='sparepart'>
	<div class='modal-dialog-large'>
		<div class='modal-content'>
			<div class='modal-header'>
				<h4 class='modal-title'>PERMINTAAN SPAREPART </h4>
				<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
			</div>
			<div class='modal-body'>
			<p>
			<form class='row clearfix' method='POST' action='$aksi?p=todolist&act=sparepart&id=$_GET[id]&i=$_GET[i]'>
			<input type='hidden' name='idprob' value='$_GET[id]'>
            <div class='col-sm-12'>
			<div class='form-group row m-b-15'>
					<label class='col-md-4 col-sm-4 col-form-label' for='website'>Nama Teknisi*</label>
					<div class='col-md-8 col-sm-8'>
						<input type='text' class='form-control' name='fullname' value = '$l[fullname]' readonly='readonly'>
					</div>
				</div>
				<div class='form-group row m-b-15'>
					<label class='col-md-4 col-sm-4 col-form-label' for='website'>Problem Code*</label>
					<div class='col-md-8 col-sm-8'>
						<input type='text' class='form-control' name='kode_problem' value = '$_GET[id]' readonly='readonly'>
					</div>
				</div>
				<div class='form-group row m-b-15'>
					<label class='col-md-4 col-sm-4 col-form-label' for='website'>Machine*</label>
					<div class='col-md-8 col-sm-8'>
						<input type='text' class='form-control' name='namaMesin' value = '$u[namaMesin]' readonly='readonly'>
					</div>
				</div>
				<div class='form-group row m-b-15'>
					<label class='col-md-4 col-sm-4 col-form-label' for='website'>Unit Machine*</label>
					<div class='col-md-8 col-sm-8'>
						<input type='text' class='form-control' name='namaUnit' value = '$u[namaUnit]' readonly='readonly'>
					</div>
				</div>
				<div class='form-group row m-b-15'>
					<label class='col-md-4 col-sm-4 col-form-label' for='website'>Sparepart Code*</label>
					<div class='col-md-8 col-sm-8'>
					<table width='100%' border='0' id='dynamic_field'>
					<tr>
						<td width='60%'>
						<input type='text' class='form-control' name='kode_sparepart[]' placeholder = 'Sparepart 1' required autofocus />
						</td>
						<td width='20%'>
						<input type='number' class='form-control' name='qty_sp[]' placeholder = 'Jumlah' required min=1 />
						</td>
						<td width='20%'>
						<input type='text' class='form-control' name='satuan_sp[]' placeholder = 'Satuan' required />
						</td>
						<td align='right'>";
						?>
						<button type="button" name="add" id="add" class="btn btn-success">+</button>
						
						<?php
					echo"
						</td>
					</tr>
					</div>
				</div>
					
            </div>
			<table width='100%'>
				<tr>
					<td>
						<div class='modal-footer'>
							<button type='submit' class='btn btn-primary' >SAVE</button>
						</div>  
					</td>
				</tr>
			</table>                             
        </form>
			</p>
			</div>
		</div>
	</div>
</div>";
break;

}
?>
</div>
<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
  <script type="text/javascript">
    $(document).ready(function(){
        $('#editnote').on('show.bs.modal', function (e) {
            var idx = $(e.relatedTarget).data('id');
            //menggunakan fungsi ajax untuk pengambilan data
            $.ajax({
                type : 'post',
                url : 'modul/911/assign_modal.php',
                data :  'idx='+ idx,
                success : function(data){
                $('.hasil-data').html(data);//menampilkan data ke dalam modal
                }
            });
         });
		 
		 $('#reassign').on('show.bs.modal', function (e) {
            var idx = $(e.relatedTarget).data('id');
            //menggunakan fungsi ajax untuk pengambilan data
            $.ajax({
                type : 'post',
                url : 'modul/911/reassign_modal.php',
                data :  'idx='+ idx,
                success : function(data){
                $('.hasil-data2').html(data);//menampilkan data ke dalam modal
                }
            });
         });
    });
  </script>
  <script type="text/javascript">
    $(document).ready(function(){
        $('#finished').on('show.bs.modal', function (e) {
            var idx = $(e.relatedTarget).data('id');
            //menggunakan fungsi ajax untuk pengambilan data
            $.ajax({
                type : 'post',
                url : 'modul/911/finished_modal.php',
                data :  'idx='+ idx,
                success : function(data){
                $('.hasil-data').html(data);//menampilkan data ke dalam modal
                }
            });
         });
		 
    });
  </script>
  
  <script>  
 $(document).ready(function(){  
      var i=1;  
      $('#add').click(function(){  
           i++;  
           $('#dynamic_field').append('<tr id="row'+i+'">'+
		   '<td><input type="hidden" name="idProb[]" class="form-control" value="<?php echo $_GET[id]; ?>"/>'+
		   '<input type="text" class="form-control" name="kode_sparepart[]" placeholder = "Sparepart '+i+'" required /></td>'+
		   '<td width="20%"><input type="text" class="form-control" name="qty_sp[]" placeholder = "Jumlah" required /></td>'+
		   '<td width="20%"><input type="text" class="form-control" name="satuan_sp[]" placeholder = "Satuan" required /></td>'+
		   '<td align="right"><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>');  
      });  
      $(document).on('click', '.btn_remove', function(){  
           var button_id = $(this).attr("id");   
           $('#row'+button_id+'').remove(); 
		   i--;
      });
 });  
 </script>
 
  <script>  
 $(document).ready(function(){  
      var i=3;  
      $('#add_langkah').click(function(){  
           i++;  
           $('#dynamic_field_langkah').append('<tr id="row'+i+'">'+
		   '<td align="center">'+i+'. </td><td><input type="text" class="form-control" name="note[]" required /></td>'+
		   '<td align="left"><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>');  
      });  
      $(document).on('click', '.btn_remove', function(){  
           var button_id = $(this).attr("id");   
           $('#row'+button_id+'').remove(); 
		   i--;
      });
 });  
 </script>