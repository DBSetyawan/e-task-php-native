<?php
error_reporting(0);
session_start(); 
$m = date(m);$d = date(d);$y = date(Y);
$aksi="modul/911/aksi_911.php";
$dated = date('Y-m-d');
$user = mysqli_query($conn, "select *from user where username='$_SESSION[username]'");
$u = mysqli_fetch_array($user);
echo"
<div class='block-header'>
                <div class='row'>
                    <div class='col-lg-5 col-md-8 col-sm-12'>                        
                        <h2><a href='javascript:void(0);' class='btn btn-xs btn-link btn-toggle-fullwidth'><i class='fa fa-arrow-left'></i></a> Add New Problem</h2>
                        <ul class='breadcrumb'>
                            <li class='breadcrumb-item'><a href='?p=dashboard'><i class='icon-home'></i></a></li>                            
                            <li class='breadcrumb-item'>E-Task</li>
                            <li class='breadcrumb-item active'>New Problem</li>
                        </ul>
                    </div>         
                </div>
            </div>
            <div class='row clearfix'>
				<div class='col-lg-4 col-md-4 col-sm-4'>
                    <div class='card'>
                        <div class='body'>
                            <div class='row clearfix'>                               
                                <div class='col-sm-12'>";
										$dated = date('Y-m-d');
										$t = mysqli_fetch_array(mysqli_query($conn,"select  year(NOW())y, (DATE_FORMAT(CURDATE(),'%m'))m, 
																					(DATE_FORMAT(CURDATE(),'%d'))d,max(idprob) as no , dateprob 
																					from tproblems where dateprob=date(NOW()) AND idprob like 'TSK%'"));
										$ye = $t['y']; $mo = $t['m']; $da = $t['d'];
										$noUrut = (int) substr($t[no], 13, 3);
										$noUrut++;
										$char = "TSK-$ye$mo$da-";
										$newID = $char . sprintf("%03s", $noUrut);
                                    
									echo "<table border='0' width='100%'>
										<p align='right'><font color=red><b>$newID</b></font></p>";    
										$date = date('Y-m-d');
											date_default_timezone_set('Asia/Jakarta');
											$time = date('H:i:s');
										echo "<tr><td>Log Date: </td><td><input type='text' class='form-control' value='".tgl_indo($date)."' readonly=readonly>
											<input type='hidden' name='date' value='$date'><input type='hidden' name='time' value='$time'></td>";
										echo "	
											</tr>
											<tr><td></td><td align='right'></td></tr><tr><td></td><td align='right'></td></tr><tr><td></td><td align='right'></td></tr>
											<tr><td colspan='2'><br>Priority Notess :</td></tr>
											<tr><td valign='top'>1.</td><td align='justify'><b>Kritis</b></td></tr>
											<tr><td align='center'>-</td><td> mesin berhenti tidak bisa berjalan </td></tr>
											<tr><td align='center'>-</td><td>mesin berjalan tetapi hasil rusak</td></tr>
											<tr><td valign='top'>2.</td><td align='justify'><b>Penting</b></td></tr>
											<tr><td align='center'>-</td><td>mesin bisa berjalan ,hasil berpotensi rusak tapi bisa diakali</td></tr>
											<tr><td valign='top'>3.</td><td align='justify'><b>Normal</b></td></tr>
											<tr><td align='center'>-</td><td>mesin berjalan , problem mengganggu</td></tr>
											<tr><td align='center'>-</td><td>bisa menghasilkan hasil yang baik</td></tr>
											<tr><td valign='top'>4.</td><td align='justify'><b>Saran</b></td><td></td></tr>
											<tr><td align='center'>-</td><td>ada penambahan fungsi sehingga mempermudah kerja</td></tr>
											
											<form method='POST' action='$aksi?p=input-problem&act=input' enctype='multipart/form-data'>";
											$j=$_GET[j];
											for($i=1;$i<=$j;$i++){
												echo "<tr><td width='5%' align='right'></td><td><input type='text' name='nodoc[$i]' class='form-control' placeholder='Document $i'></td></tr>";
											}
											echo"</table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>";
			$dated = date('Y-m-d');
						$t = mysqli_fetch_array(mysqli_query($conn,"select  year(NOW())y, (DATE_FORMAT(CURDATE(),'%m'))m, 
																			(DATE_FORMAT(CURDATE(),'%d'))d,max(idprob) as no , dateprob 
																			from tproblems where dateprob=date(NOW()) AND idprob like 'TSK%'"));
										$ye = $t['y']; $mo = $t['m']; $da = $t['d'];
										$noUrut = (int) substr($t[no], 13, 3);
										$noUrut++;
										$char = "TSK-$ye$mo$da-";
										$newID = $char . sprintf("%03s", $noUrut);
						echo "
						<input type='hidden' name='kodeprob' value='$newID'>
						<input type='hidden' name='date' value='$date'><input type='hidden' name='time' value='$time'>
						<input type='hidden' name='c_at' value='$date'><input type='hidden' name='c_by' value='$_SESSION[username]'>
						<input type='hidden' name='u_by' value='$_SESSION[username]'>
						<input type='hidden' name='divisi' value='$u[divisi]'>
						";
			echo"
                <div class='col-lg-8 col-md-8 col-sm-8'>
                    <div class='card'>
                        <div class='body'>
                            <div class='row clearfix'>                               
                                <div class='col-sm-12'>
									<div class='form-group'>
									<label>Nama Pelapor:</label>
										<input type='text' class='form-control' name='nama_pelapor' value='$u[fullname]'  readonly=''/>
									</div>
									<div class='form-group'>
									<label>Prioritas:</label>
										<select class='form-control show-tick' name='idpriority' required>
											<option selected disabled>---Select Prioritas---</option>";
											$r = mysqli_query($conn, "select *from mcategories where category_ket = '911' order by idcat asc");
											while($c = mysqli_fetch_array($r)){
													echo "<option value='$c[idcat]'>$c[category_name]</option>";
												}
											echo "
										</select>
									</div>
									<div class='form-group'>
									<label>Mesin:</label>
									<select class='form-control show-tick' name='idmesin' id='idmesin' required>
										<option selected disabled>---Select Mesin---</option>";
										$r = mysqli_query($conn, "select *from tmesin order by namaMesin ASC");
										while($c = mysqli_fetch_array($r)){
												echo "<option value='$c[idMesin]'>$c[namaMesin]</option>";
											}
										echo "
									</select>
									</div>

									

									<div class='form-group'>
									<label>Unit:</label>
									<select class='form-control show-tick' name='idunit' id='unit' required>
										<option selected disabled>---Select Unit---</option>
									</select>
									</div>

									<div class='form-group'>
									<label>Kategori :</label>
									<select class='form-control show-tick' name='category' id='idmesin' required>
										<option selected disabled>---Select Category 1---</option>";
										$r = mysqli_query($conn, "select *from mkategori1 order by idKat1 ASC");
										while($t = mysqli_fetch_array($r)){
											echo "<option value = '$t[namaKategori1]'>$t[namaKategori1]</option>";
										}
									echo"
									</select>
									</div>

									<label>Deskripsi:</label>
                                    <textarea cols='80' rows='10' name='des' required class='form-control'></textarea>
									<div class='form-group'>
									<label>Lampiran:</label>
										<input type='file' name='fupload[]' class='form-control' multiple='multiple'>
									</div>
                                </div>
                                <div class='col-sm-12'>
                                    <div class='mt-4'>
                                        <button type='submit' class='btn btn-block btn-primary m-t-20'>Post</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
				</form>
            </div>
        </div>
    </div>
    
</div>";
?>


