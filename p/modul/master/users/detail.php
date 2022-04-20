<?php
error_reporting(0);
session_start();
include('../../../../config/koneksi.php');
$aksi="modul/master/users/act_user.php";
if($_POST['idx']) {
        $id = $_POST['idx'];      
        $sql = mysqli_query($conn,"SELECT * FROM user u left join tdepartment d on u.id_dep=d.id_dep WHERE iduser = $id");
        while ($r = mysqli_fetch_array($sql)){
		echo "
        <form id='basic-form' class='row clearfix' method='POST' action='$aksi?p=users&act=update'>
		<input type='hidden' value='$r[iduser]' name='id'>
                        <div class='col-sm-12'>
                            <div class='form-group'>
							<label>Fullname*</label>
                                <input type='text' class='form-control' name='fullname' placeholder='Enter Fullname' value='$r[fullname]' required>
                            </div>
                        </div>
						<div class='col-sm-6'>
                            <div class='form-group'>
							<label>Username</label>
                                <input type='text' class='form-control' name='username' placeholder='Enter Username' value='$r[username]' readonly='readonly'>
                            </div>
                        </div>
						<div class='col-sm-12'>
                            <div class='form-group'>
							<label>Email*</label>
                                <input type='email' class='form-control' name='email' placeholder='Enter Email' value='$r[email]' required>
                            </div>
                        </div>
						<div class='col-sm-6'>
                            <div class='form-group'>
							<label>Department</label><br>
                                <select name='department' class='form-control'>
                                        <option>--Select Department--</option>";
										$t = mysqli_query($conn,"select *from tdepartment order by id_dep desc");
										while($row = mysqli_fetch_array($t)){
											if($r[id_dep]==$row[id_dep]){
												echo "<option value='$row[id_dep]' selected>$row[nama_dep]</option>";
											}
											else{
												echo "<option value='$row[id_dep]'>$row[nama_dep]</option>";
											}
										}
                                    echo "</select>
                            </div>
                        </div>
						<div class='col-sm-6'>
                            <div class='form-group'>
							<label>Field</label><br>
                                <select name='field' class='form-control'>
                                        <option>--Select Field--</option>";
										$t2 = mysqli_query($conn,"select *from tfield order by id_field desc");
										while($r2 = mysqli_fetch_array($t2)){
											if($r[id_field]==$r2[id_field]){
												echo "<option value='$r2[id_field]' selected>$r2[nama_field]</option>";
											}else{
												echo "<option value='$r2[id_field]'>$r2[nama_field]</option>";
											}
										}
                                    echo "</select>
                            </div>
                        </div>
						<div class='col-sm-6'>
                            <div class='form-group'>
							</div>
						</div>
						<div class='col-sm-6'>
                            <div class='form-group'>
							<label>Level</label><br>";
							if($r[level]=='superadmin'){
                               echo " 
							   <label class='fancy-radio custom-color-green'><input name='level' value='superadmin' type='radio' checked><span><i></i>Super Admin</span></label>
							   <label class='fancy-radio custom-color-green'><input name='level' value='admin' type='radio'><span><i></i>Admin</span></label>
                                <label class='fancy-radio custom-color-green'><input name='level' value='user' type='radio'><span><i></i>User</span></label>
								<label class='fancy-radio custom-color-green'><input name='level' value='user_sparepart' type='radio'><span><i></i>User Sparepart</span></label>";
                            }
							else if($r[level]=='admin'){
                               echo " 
							    <label class='fancy-radio custom-color-green'><input name='level' value='superadmin' type='radio'><span><i></i>Super Admin</span></label>
							   <label class='fancy-radio custom-color-green'><input name='level' value='admin' type='radio' checked><span><i></i>Admin</span></label>
							   <label class='fancy-radio custom-color-green'><input name='level' value='user' type='radio'><span><i></i>User</span></label>
                                <label class='fancy-radio custom-color-green'><input name='level' value='user_sparepart' type='radio'><span><i></i>User Sparepart</span></label>";
                            }
							else if($r[level]=='user'){
								echo " 
								 <label class='fancy-radio custom-color-green'><input name='level' value='superadmin' type='radio'><span><i></i>Super Admin</span></label>
								<label class='fancy-radio custom-color-green'><input name='level' value='admin' type='radio'><span><i></i>Admin</span></label>
								<label class='fancy-radio custom-color-green'><input name='level' value='user' type='radio' checked><span><i></i>User</span></label>
                                <label class='fancy-radio custom-color-green'><input name='level' value='user_sparepart' type='radio'><span><i></i>User Sparepart</span></label>";
							}
							else{
								echo " 
								 <label class='fancy-radio custom-color-green'><input name='level' value='superadmin' type='radio'><span><i></i>Super Admin</span></label>
								<label class='fancy-radio custom-color-green'><input name='level' value='admin' type='radio'><span><i></i>Admin</span></label>
								<label class='fancy-radio custom-color-green'><input name='level' value='user' type='radio' ><span><i></i>User</span></label>
                                <label class='fancy-radio custom-color-green'><input name='level' value='user_sparepart' type='radio' checked><span><i></i>User Sparepart</span></label>";
							}
							echo "</div>
                        </div>
						<div class='col-sm-6'>
                            <div class='form-group'>
							</div>
						</div>
               </div>      
            </div>
			<div class='col-sm-12'>
				<div class='modal-footer'>
					<button type='submit' class='btn btn-primary'>Update</button>
					<button type='button' class='btn btn-outline-secondary' data-dismiss='modal'>Close</button>
				</div>
			</div>			
        </form>
		</div>
    </div>";
								   
        } }