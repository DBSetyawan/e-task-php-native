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
							<u><h6>Report dengan Langkah Kerja</h6></u><br />
							<form method='post' action='modul/report/export/excel.php'>
								<table border='0' width='100%'>
									<tr><td width='15%'>Teknisi </td><td>
										<select class='default-select2 form-control' name='nm_teknisi'>
											<option value=''>---Select Teknisi---</option>";
											$q = mysqli_query($conn, "select FULLNAME,USERNAME from user where divisi='$u[divisi]' and active=1 order by fullname asc");
											while($p = mysqli_fetch_array($q)){
													echo "<option value='$p[USERNAME]'>$p[FULLNAME]</option>";
											}
											echo "
										</select>
									</td><td>&nbsp;</td>
									<td width='15%'>&nbsp;</td><td>&nbsp;</td></tr>
									<tr><td width='20%'>Tanggal Problem Mulai</td><td><input type='date' name='begda' class='form-control' value= '$y-$m-01'></td><td>&nbsp;</td>
									<td width='10%' align='center'>Sampai </td><td width='33%'><input type='date' name='endda' class='form-control' value= '$y-$m-$d' ></td></tr>
									<tr><td width='15%'>Prioritas </td><td>
											<select class='form-control show-tick' name='idpriority'>
											<option selected disabled>---Select Prioritas---</option>";
											$r = mysqli_query($conn, "select *from mcategories where category_ket = '911' order by idcat asc");
											while($c = mysqli_fetch_array($r)){
													echo "<option value='$c[idcat]'>$c[category_name]</option>";
												}
											echo "
										</select>
											</td><td>&nbsp;</td><td width='15%'>&nbsp;</td><td>&nbsp;</td></tr>
									<tr><td width='15%'>Mesin </td><td>
											<select class='form-control show-tick' name='idmesin' id='idmesin'>
												<option selected disabled>---Select Mesin---</option>";
												$r = mysqli_query($conn, "select *from tmesin ");
												while($c = mysqli_fetch_array($r)){
														echo "<option value='$c[idMesin]'>$c[namaMesin]</option>";
													}
												echo "
											</select>
											</td><td>&nbsp;</td><td width='15%'>&nbsp;</td><td>&nbsp;</td></tr>
									<tr><td width='15%'>Status </td><td>
										<select class='form-control show-tick' name='status_p'>
											<option selected disabled>---Select Status---</option>
											<option value='OPEN'>OPEN</option>
											<option value='ASSIGN'>ASSIGN</option>
											<option value='IN PROGRESS'>IN PROGRESS</option>
											<option value='MENUNGGU SPAREPART'>MENUNGGU SPAREPART</option>
											<option value='FINISH'>FINISH</option>
											<option value='APPROVED'>APPROVED</option>
											<option value='CLOSED'>CLOSED</option>
										</select>
									</td><td>&nbsp;</td><td width='15%'>&nbsp;</td><td>&nbsp;</td></tr>
								</table><br /><br />
								<p align='right'>";
								?>
								<button class="btn btn-success" type="submit"><b><i class='fa fa-print'></i>&nbsp; &nbsp; EKSPOR</button>
								<?php
								echo"
							</form>
							
                        </div>
                    </div></div>
							";
	break;
}
mysqli_close($conn);
?>
