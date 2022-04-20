<?php
error_reporting(0);
session_start();
include('../../../../config/koneksi.php');
$aksi="modul/master/division/act_division.php";
if($_POST['idx']) {
        $id = $_POST['idx'];      
        $sql = mysqli_query($conn, "SELECT * FROM tdepartment WHERE id_dep = '$id'");
        while ($r = mysqli_fetch_array($sql)){
		echo "
        <form id='basic-form' class='row clearfix' method='POST' action='$aksi?p=division&act=update'>
		<input type='hidden' value='$r[id_dep]' name='id'>
                        <div class='col-sm-12'>
                            <div class='form-group'>
							<label>division Name*</label>
                                <input type='text' class='form-control' name='div_nm' placeholder='Enter division Name' value='$r[nama_dep]' required>
                            </div>
                        </div>
						<div class='col-sm-12'>
                            <div class='form-group'>
							<label>Information</label>
                                <input type='text' class='form-control' name='info' placeholder='Enter Information' value='$r[ket_dep]' required>
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