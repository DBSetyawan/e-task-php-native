<?php
error_reporting(0);
session_start();
include('../../../../config/koneksi.php');
$aksi="modul/master/checkdata/act_checkdata.php";
if($_POST['idx']) {
        $id = $_POST['idx'];      
        $sql = mysqli_query($conn, "SELECT * FROM tproblems WHERE idprob = '$id'");
        while ($r = mysqli_fetch_array($sql)){
		echo "
        <form id='basic-form' class='row clearfix' method='POST' action='$aksi?p=checkdata&act=update_prob'>
		<input type='hidden' value='$r[idprob]' name='id'>
                        <div class='col-sm-12'>
                            <div class='form-group'>
							<label>ID Prob*</label>
                                <input type='text' class='form-control' name='idprob' value='$r[idprob]' required readonly='readonly'>
                            </div>
                        </div>
                         <div class='col-sm-12'>
                            <div class='form-group'>
							<label>Status Awal</label>
                                <input type='text' class='form-control' name='status_prob_awal' value='$r[status_problem]' required readonly='readonly'>
                            </div>
                        </div>
						<div class='col-sm-12'>
                            <div class='form-group'>
							<label>Status Problem</label>
                                <select class='form-control show-tick' name='status_prob' required>
											<option value=''>---Select Status---</option>
											<option value='OPEN'>OPEN</option>
											<option value='ASSIGN'>ASSIGN</option>
											<option value='IN PROGRESS'>IN PROGRESS</option>
											<option value='MENUNGGU SPAREPART'>MENUNGGU SPAREPART</option>
											<option value='FINISH'>FINISH</option>
											<option value='APPROVED'>APPROVED</option>
											<option value='CLOSED'>CLOSED</option>
											<option value='DELETED'>DELETED</option>
										</select>
                            </div>
                        </div>
                         <div class='col-sm-12'>
                            <div class='form-group'>
							<label>Alasan</label>
                                <input type='text' class='form-control' name='alasan' required >
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