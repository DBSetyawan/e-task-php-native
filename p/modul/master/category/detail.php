<?php
error_reporting(0);
session_start();
include('../../../../config/koneksi.php');
$aksi="modul/master/category/act_category.php";
if($_POST['idx']) {
        $id = $_POST['idx'];      
        $sql = mysql_query("SELECT * FROM mcategories WHERE idcat = $id");
        while ($r = mysql_fetch_array($sql)){
		echo "
        <form id='basic-form' class='row clearfix' method='POST' action='$aksi?p=categories&act=update'>
		<input type='hidden' value='$r[idcat]' name='id'>
                        <div class='col-sm-12'>
                            <div class='form-group'>
							<label>Category Name*</label>
                                <input type='text' class='form-control' name='cat_nm' placeholder='Enter Category Name' value='$r[category_name]' required>
                            </div>
                        </div>
						<div class='col-sm-12'>
                            <div class='form-group'>
							<label>Information</label>
                                <input type='text' class='form-control' name='info' placeholder='Enter Information' value='$r[category_ket]' required>
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