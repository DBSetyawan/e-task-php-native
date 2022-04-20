<?php
error_reporting(0);
session_start();
include('../../../config/koneksi.php');
$aksi="modul/911/aksi_911.php";
if($_POST['idx']) {
        $id = $_POST['idx'];      
        $sql = mysqli_query($conn,"SELECT * FROM tproblems p
												left join mcategories c on p.idcat = c.idcat
												left join tmesin m on p.id_mesin = m.idMesin
												left join tmesinunit n on p.id_unit_mesin = n.idUnit
												left join tassign ta on p.idprob = ta.no_pelaporan
												left join user u on u.username = ta.pic_handling
												where p.idProb='$id'
												and ta.created_date IN
															  (select max(created_date) from tassign group by no_pelaporan)");
        while ($r = mysqli_fetch_array($sql)){
		echo "
        <form id='basic-form' class='row clearfix' method='POST' action='$aksi?p=todolist&act=pending&id=$id'>
		<input type='hidden' value='$r[username]' name='user'>
                        <div class='col-sm-12'>
                            <div class='form-group'>
							<label><font color='red'>Anda melakukan pending problem dengan kode $id</font></label>
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
							<label>Alasan Pending</label>
                                <input type='text' class='form-control' name='alasan' placeholder='Masukan alasan melakukan pending' required autofocus>
                            </div>
                        </div>
               </div>      
            </div>
			<div class='col-sm-12'>
				<div class='modal-footer'>
					<button type='submit' class='btn btn-danger'>Pending</button>
					<button type='button' class='btn btn-outline-secondary' data-dismiss='modal'>Batal</button>
				</div>
			</div>			
        </form>
		</div>
    </div>";
								   
        } }