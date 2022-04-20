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
                        <h2><a href='javascript:void(0);' class='btn btn-xs btn-link btn-toggle-fullwidth'><i class='fa fa-arrow-left'></i></a> Edit Problem</h2>
                        <ul class='breadcrumb'>
                            <li class='breadcrumb-item'><a href='?p=dashboard'><i class='icon-home'></i></a></li>                            
                            <li class='breadcrumb-item'>E-Task</li>
                            <li class='breadcrumb-item active'>Edit Problem</li>
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
										$t = mysqli_fetch_array(mysqli_query($conn,"select *from tproblems where idprob='$_GET[id]'"));
                                    
									echo "<table border='0' width='100%'>
										<p align='right'><font color=red><b>$t[idprob]</b></font></p>";    
										$date = date('Y-m-d');
											date_default_timezone_set('Asia/Jakarta');
											$time = date('H:i:s');
										echo "<tr><td>Log Date: </td><td><input type='text' class='form-control' value='".tgl_indo($t[dateprob])."' readonly=readonly>
											</td>";
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
											
											<form method='POST' action='$aksi?p=edit-problem&act=edit' enctype='multipart/form-data'>";
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
						$t = mysqli_fetch_array(mysqli_query($conn,"select *from tproblems where idprob='$_GET[id]'"));
										
						echo "
						<input type='hidden' name='kodeprob' value='$_GET[id]'>
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
												if($t[idcat]==$c[idcat]){
													echo "<option value='$c[idcat]' selected>$c[category_name]</option>";
												}else{
													echo "<option value='$c[idcat]'>$c[category_name]</option>";
												}	
											}
											echo "
										</select>
									</div>
									<div class='form-group'>
									<label>Mesin:</label>
									<select class='form-control show-tick' name='idmesin' id='idmesin' required readonly='readonly'>
										<option selected disabled>---Select Mesin---</option>";
										$r = mysqli_query($conn, "select *from tmesin ");
										while($c = mysqli_fetch_array($r)){
											if($t[id_mesin]==$c[idMesin]){
												echo "<option value='$c[idMesin]' selected>$c[namaMesin]</option>";
											}else{
												echo "<option value='$c[idMesin]'>$c[namaMesin]</option>";
											}
										}
										echo "
									</select>
									</div>
									<div class='form-group'>
									<label>Unit:</label>
									<select class='form-control show-tick' name='idunit' id='unit' required readonly='readonly'>
										<option selected disabled>---Select Unit---</option>";
										$r = mysqli_query($conn, "select *from tmesinunit ");
										while($c = mysqli_fetch_array($r)){
											if($t[id_unit_mesin]==$c[idUnit]){
												echo "<option value='$c[idUnit]' selected>$c[namaUnit]</option>";
											}else{
												echo "<option value='$c[idUnit]'>$c[namaUnit]</option>";
											}
										}
									echo"
									</select>
									</div>

									<div class='form-group'>
									<label>Kategori :</label>
									<select class='form-control show-tick' name='category' required readonly='readonly'>
										<option selected disabled>---Select Category 1---</option>";
										$r = mysqli_query($conn, "select *from mkategori1 order by idKat1 ASC");
										while($tr = mysqli_fetch_array($r)){
											if($t[category]==$tr[namaKategori1]){
												echo "<option value = '$tr[namaKategori1]' selected>$tr[namaKategori1]</option>";
											}else{
												echo "<option value = '$tr[namaKategori1]'>$tr[namaKategori1]</option>";
											}
										}
									echo"
									</select>
									</div>

									<label>Deskripsi:</label>
                                    <textarea cols='80' rows='10' name='des' required class='form-control' readonly='readonly'>$t[deskripsi]</textarea>
									
                                </div>
                                <div class='col-sm-12'>
                                    <div class='mt-4'>
                                        <button type='submit' class='btn btn-block btn-success m-t-20'>Update</button>
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


