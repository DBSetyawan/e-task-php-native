<?php
error_reporting(0);
session_start();
include('../../../../config/koneksi.php');
$aksi="modul/master/job/act_job.php";
if($_POST['idx']) {
        $id = $_POST['idx'];      
        $sql = mysqli_query($conn,"SELECT * FROM tprepress WHERE idPrepress = '$id'");
        while ($r = mysqli_fetch_array($sql)){
		echo "
        <form id='basic-form' class='row clearfix' method='POST' action='$aksi?p=job&act=update'>
		<input type='hidden' value='$r[idPrepress]' name='id'>
                        <div class='col-sm-12'>
                            <div class='form-group'>
							<label>job Name*</label>
                                <input type='text' class='form-control' name='pre_nm' placeholder='Enter job Name' value='$r[namaPrepress]' required>
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