<?php
error_reporting(0);
session_start();
include('../../../config/koneksi.php');
$date = date('Y-m-d');
	date_default_timezone_set('Asia/Jakarta');
$time = date('H:i:s');
$aksi="modul/911/aksi_911.php";
$value = filter_input(INPUT_POST, 'idx');
								$exploded_value = explode('|', $value);
								$value = $exploded_value[0];
$value1 = filter_input(INPUT_POST, 'idx');
								$exploded_value1 = explode('|', $value1);
								$value1 = $exploded_value1[1];
if($value) {
        $id = $value;      
        $sql = mysqli_query($conn,"SELECT * FROM tproblems p
												left join mcategories c on p.idcat = c.idcat
												left join tmesin m on p.id_mesin = m.idMesin
												left join tmesinunit n on p.id_unit_mesin = n.idUnit
												left join tassign ta on p.idprob = ta.no_pelaporan
												left join user u on u.username = ta.pic_handling
												where p.idProb='$id' and ta.created_date IN
													(select max(created_date) from tassign group by no_pelaporan)");
        while ($r = mysqli_fetch_array($sql)){
		echo "
        <form id='basic-form' class='row clearfix' method='POST' action='$aksi?p=todolist&act=rejected&id=$id&s=dash&ds=$value1'>
		<input type='hidden' value='$r[username]' name='user'>
		<input type='hidden' class='form-control' name='c_by' value = '$_SESSION[username]' readonly='readonly'>
		<input type='hidden' class='form-control' name='dt_note' value = '$date' readonly='readonly'>
		<input type='hidden' class='form-control' name='tm_note' value = '$time' readonly='readonly'>
                        <div class='col-sm-12'>
                            <div class='form-group'>
							<label><font color='red'>Anda melakukan rejecting problem dengan kode $id</font></label>
                            </div>
                        </div>
						<div class='col-sm-12'>
                            <div class='form-group'>
							<label>Teknisi</label>
                                <input type='text' class='form-control' name='teknisi' value='$r[fullname]' required disabled='disabled'>
                            </div>
                        </div>
						<div class='col-sm-12'>
                            <div class='form-group'>
							<label>Alasan Rejected</label>
                                <input type='text' class='form-control' name='alasan_reject' placeholder='Masukan alasan melakukan reject' required autofocus>
                            </div>
                        </div>
               </div>      
            </div>
			<div class='col-sm-12'>
				<div class='modal-footer'>
					<button type='submit' class='btn btn-danger'>Rejected</button>
					<button type='button' class='btn btn-outline-secondary' data-dismiss='modal'>Batal</button>
				</div>
			</div>			
        </form>
		</div>
    </div>";
								   
        } }