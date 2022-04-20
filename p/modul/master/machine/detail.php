<?php
error_reporting(0);
session_start();
include('../../../../config/koneksi.php');
$aksi="modul/master/machine/act_machine.php";
if($_POST['idx']) {
        $id = $_POST['idx'];      
        $sql = mysqli_query($conn,"SELECT * FROM tmesin WHERE idMesin = $id");
        while ($r = mysqli_fetch_array($sql)){
		echo "
        <form id='basic-form' class='row clearfix' method='POST' action='$aksi?p=machines&act=update'>
		<input type='hidden' value='$r[idMesin]' name='id'>
                        <div class='col-sm-12'>
                            <div class='form-group'>
							<label>machine Name*</label>
                                <input type='text' class='form-control' name='mesin_nm' placeholder='Enter machine Name' value='$r[namaMesin]' required>
                            </div>
                            <div class='form-group'>
							<label>machine Category*</label>
                                <input type='text' class='form-control' name='mesin_cat' placeholder='Enter machine Category (ex. : MTC / UMUM / PGA)' value='$r[kategori]' required>
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