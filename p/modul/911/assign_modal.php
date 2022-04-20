<?php
error_reporting(0);
session_start();
include("../../../config/koneksi.php");
$aksi="modul/911/act_911.php";
$date = date('Y-m-d');
	date_default_timezone_set('Asia/Jakarta');
$time = date('H:i:s');
if($_POST['idx']) {
        $id = $_POST['idx'];      
        $sql = mysql_query("SELECT * FROM tproblems WHERE idprob = '$id'");
        while ($r = mysql_fetch_array($sql)){
		echo "
        <form class='row clearfix' method='POST' action='$aksi?p=assign&act=assign'>
			<input type='hidden' name='idprob' value='$r[idprob]'>
            <div class='col-sm-12'>
				<div class='form-group row m-b-15'>
					<label class='col-md-4 col-sm-4 col-form-label' for='website'>Assign To*</label>
					<div class='col-md-8 col-sm-8'>
						<select class='default-select2 form-control' name='assign_group' required>
							<option value=''>--Select EDP Personil--</option>";
							$q = mysql_query("select FULLNAME,USERNAME from user where divisi='MAINTENANCE' and active=1 order by fullname asc");
							while($p = mysql_fetch_array($q)){
								if($p[USERNAME]==$r[USERNAME]){
									echo "<option value='$p[USERNAME]' selected>$p[FULLNAME]</option>";
								}
								else{
									echo "<option value='$p[USERNAME]'>$p[FULLNAME]</option>";
								}
							}
							echo "
						</select>
					</div>
				</div>
				<div class='form-group row m-b-15'>
					<label class='col-md-4 col-sm-4 col-form-label' for='website'>EST Handling*</label>
					<div class='col-md-2 col-sm-2'>
						<div class='form-group'>
							<label class='control-label'>DAY</label> <input type='number' name='est_day' class='form-control'>
						</div>
					</div>
					<div class='col-md-2 col-sm-2'>
						<div class='form-group'>
							<label class='control-label'>HOUR</label> <input type='number' name='est_hour' class='form-control'>
						</div>        
					</div>
					<div class='col-md-2 col-sm-2'>
						<div class='form-group'>
							<label class='control-label'>MINUTE</label> <input type='number' name='est_minute' class='form-control'>
						</div>
					</div>
				</div>
				<div class='form-group row m-b-15'>
					<label class='col-md-4 col-sm-4 col-form-label' for='website'>Jenis Problem*</label>
					<div class='col-md-8 col-sm-8'>
					  <div class='form-group'>
						<select class='default-select2 form-control' name='problem_group' required onchange='test()' id='problem_group'>
							<option value=''>--Select Problem Category--</option>";
							$q = mysql_query("select ID_JENIS_PROBLEM,NAMA_JENIS_PROBLEM,NO_ISO from mjenisproblem where is_active=1 order by NAMA_JENIS_PROBLEM asc");
							while($p = mysql_fetch_array($q)){
								if($p[ID_JENIS_PROBLEM]==$r[ID_JENIS_PROBLEM]){
									echo "<option value='$p[ID_JENIS_PROBLEM]|$p[NO_ISO]' selected>$p[NAMA_JENIS_PROBLEM]</option>";
								}
								else{
									echo "<option value='$p[ID_JENIS_PROBLEM]|$p[NO_ISO]'>$p[NAMA_JENIS_PROBLEM]</option>";
								}
							}
							echo "
						</select>
						<label class='control-label' id='ISO' style='color:red;'></label>
						</div>
					</div>
					
				</div>
            </div>
			<table width='100%'>
				<tr>
					<td>
						<div class='modal-footer'>
							<button type='submit' class='btn btn-primary' >SAVE</button>
						</div>  
					</td>
				</tr>
			</table>                             
        </form>";
								   
        } }
		$value = filter_input(INPUT_POST,'problem_group');
		$exploded_value=explode('|',$value);
		$value=$exploded_value[0];
		?>
<script type='text/javascript'>		
function test() {
    var d = document.getElementById("problem_group").value.split('|');
	document.getElementById("ISO").innerHTML = d[1];
}
</script>