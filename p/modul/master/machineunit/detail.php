<?php
error_reporting(0);
session_start();
include('../../../../config/koneksi.php');
$aksi="modul/master/machineunit/act_machineunit.php";
if($_POST['idx']) {
        $id = $_POST['idx'];      
        $sql = mysqli_query($conn,"SELECT * FROM tmesinunit u left join tmesin m on u.idMesin=m.idMesin WHERE idUnit = $id");
        while ($r = mysqli_fetch_array($sql)){
		echo "
        <form id='basic-form' class='row clearfix' method='POST' action='$aksi?p=machinesunit&act=update'>
		<input type='hidden' value='$r[idUnit]' name='id'>
                       <div class='col-sm-6'>
                            <div class='form-group'>
							<label>Machine*</label><br>
                                <select name='mesin' class='form-control'>
                                        <option>--Select Machine--</option>";
										$t = mysqli_query($conn,"select *from tmesin order by idMesin desc");
										while($row = mysqli_fetch_array($t)){
											if($r[idMesin]==$row[idMesin]){
												echo "<option value='$row[idMesin]' selected>$row[namaMesin]</option>";
											}
											else{
												echo "<option value='$row[idMesin]'>$row[namaMesin]</option>";
											}
										}
                                    echo "</select>
                            </div>
                        </div>
						<div class='col-sm-6'>
                            <div class='form-group'>
							<label>Unit Name</label>
                                <input type='text' class='form-control' name='unit_mesin' placeholder='Enter Unit Name' value='$r[namaUnit]'>
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