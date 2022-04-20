<?php
error_reporting(1);
session_start(); 
include('../config/koneksi.php');
include('../config/fungsi_indotgl.php');

?>

<!doctype html>
<html lang="en">
<head>
<title>:: E-Task :: <?php echo $u2[divisi]; ?></title>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<meta name="description" content="Lucid Bootstrap 4.1.1 Admin Template">
<meta name="author" content="WrapTheme, design by: ThemeMakker.com">

<link rel="icon" href="../assets/images/icon.jpg" type="image/x-icon">
<link rel="stylesheet" href="assets/css/blog.css">
<link rel="stylesheet" href="assets/css/main.css">
<!-- VENDOR CSS -->
<link rel="stylesheet" href="../assets/vendor/bootstrap/css/bootstrap.min.css">
<link href="../assets/fontawesome-free-5.1.0-web/css/all.css" rel="stylesheet" />

<link rel="stylesheet" href="../assets/vendor/chartist/css/chartist.min.css">
<link rel="stylesheet" href="../assets/vendor/chartist-plugin-tooltip/chartist-plugin-tooltip.css">
<link rel="stylesheet" href="../assets/vendor/summernote/dist/summernote.css"/>
<link rel="stylesheet" href="../assets/vendor/dropify/css/dropify.min.css">

<link rel="stylesheet" href="../assets/vendor/jquery-datatable/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="../assets/vendor/jquery-datatable/fixedeader/dataTables.fixedcolumns.bootstrap4.min.css">
<link rel="stylesheet" href="../assets/vendor/jquery-datatable/fixedeader/dataTables.fixedheader.bootstrap4.min.css">
<link rel="stylesheet" href="../assets/vendor/sweetalert/sweetalert.css"/>

<link rel="stylesheet" href="../assets/vendor/bootstrap-multiselect/bootstrap-multiselect.css">
<link rel="stylesheet" href="../assets/vendor/parsleyjs/css/parsley.css">
<style>
    td.details-control {
    background: url('../assets/images/details_open.png') no-repeat center center;
    cursor: pointer;
}
    tr.shown td.details-control {
        background: url('../assets/images/details_close.png') no-repeat center center;
    }
    .demo-card label{ display: block; position: relative;}
    .demo-card .col-lg-4{ margin-bottom: 30px;}
</style>

<!-- MAIN CSS -->
<link rel="stylesheet" href="assets/css/main.css">
<link rel="stylesheet" href="assets/css/blog.css">
<link rel="stylesheet" href="assets/css/main.css">
<link rel="stylesheet" href="assets/css/color_skins.css">
</head>


		<body background='black'>
            <?php 
				error_reporting(0);
session_start(); 
$m = date(m);$d = date(d);$y = date(Y);
$aksi="modul/911/aksi_911.php";
$dated = date('Y-m-d');
$user = mysqli_query($conn, "select *from user where username='$_SESSION[username]'");
$u = mysqli_fetch_array($user);
echo"
<div class='block-header'>
                <div class='row'>
                    <div class='col-lg-12 col-md-12 col-sm-12'>                        
                        <h1 align='center'> DASHBOARD MONITORING</h1>
                       <h1 align='center'> Laporan Kerusakan Mesin</h1>
                    </div>         
                </div>
            </div>
            ";
			$dated = date('Y-m-d');
						$t = mysqli_fetch_array(mysqli_query($conn,"select max(idprob) as no , dateprob from tproblems where dateprob='$dated' "));
										$noUrut = (int) substr($t[no], 13, 3);
										$noUrut++;
										$char = "TSK-$y$m$d-";
										$newID = $char . sprintf("%03s", $noUrut);
						
			echo"
                <div class='col-lg-12 col-md-12 col-sm-12'>
                    <div class='card'>
                        <div class='body'>
                            <div class='row clearfix'>                               
                                <div class='col-sm-12'>
									";
									?>
									<?php
				switch($_GET[act]){
									default:
											$prob = "SELECT * FROM tproblems p
												left join mcategories c on p.idcat = c.idcat
												left join tmesin m on p.id_mesin = m.idMesin
												left join tmesinunit n on p.id_unit_mesin = n.idUnit
												left join tassign ta on p.idprob = ta.no_pelaporan
												left join user u on u.username = ta.pic_handling
												where p.status_problem NOT IN ('CLOSED')
												and ta.created_date IN
														(select max(created_date) from tassign group by no_pelaporan)";
												if($_GET[show]=='pribadi'){
													$prob .= " AND p.created_by = '$_SESSION[username]' ";
												}else{}
												
												$prob .= "group by ta.no_pelaporan
												order by p.idcat asc";
											$ptampil = mysqli_query($conn,$prob);
										break;
										case "bulanini" :
											$prob = "SELECT * FROM tproblems p
												left join mcategories c on p.idcat = c.idcat
												left join tmesin m on p.id_mesin = m.idMesin
												left join tmesinunit n on p.id_unit_mesin = n.idUnit
												left join tassign ta on p.idprob = ta.no_pelaporan
												left join user u on u.username = ta.pic_handling
												where MONTH(dateprob) = '$month'";
												if($_GET[show]=='pribadi'){
													$prob .= " AND p.created_by = '$_SESSION[username]' ";
												}else{}
												
												$prob .= "group by p.idprob
												order by p.idcat asc";
											$ptampil = mysqli_query($conn,$prob);
											
											$stt = " - MASALAH BULAN INI";
										break;
										case "open" :
											$prob = "SELECT * FROM tproblems p
												left join mcategories c on p.idcat = c.idcat 
												left join tmesin m on p.id_mesin = m.idMesin
												left join tmesinunit n on p.id_unit_mesin = n.idUnit
												left join tassign ta on p.idprob = ta.no_pelaporan
												left join user u on u.username = ta.pic_handling
												where p.status_problem='OPEN'";
												if($_GET[show]=='pribadi'){
													$prob .= " AND p.created_by = '$_SESSION[username]' ";
												}else{}
												
												$prob .= "group by p.idprob
												order by p.idcat asc";
											$ptampil = mysqli_query($conn,$prob);
											
											$stt = " - STATUS OPEN";
										break;
										case "inprogress" :
											$prob = "SELECT * FROM tproblems p
												left join mcategories c on p.idcat = c.idcat 
												left join tmesin m on p.id_mesin = m.idMesin
												left join tmesinunit n on p.id_unit_mesin = n.idUnit
												left join tassign ta on p.idprob = ta.no_pelaporan
												left join user u on u.username = ta.pic_handling
												where p.status_problem='IN PROGRESS'";
												if($_GET[show]=='pribadi'){
													$prob .= " AND p.created_by = '$_SESSION[username]' ";
												}else{}
												
												$prob .= "group by p.idprob
												order by p.idcat asc";
											$ptampil = mysqli_query($conn,$prob);
												
												$stt = " - STATUS IN PROGRESS";
										break;
										case "menunggusp":
											$prob = "SELECT * FROM tproblems p
												left join mcategories c on p.idcat = c.idcat 
												left join tmesin m on p.id_mesin = m.idMesin
												left join tmesinunit n on p.id_unit_mesin = n.idUnit
												left join tassign ta on p.idprob = ta.no_pelaporan
												left join user u on u.username = ta.pic_handling
												where p.status_problem='MENUNGGU SPAREPART'";
												if($_GET[show]=='pribadi'){
													$prob .= " AND p.created_by = '$_SESSION[username]' ";
												}else{}
												
												$prob .= "group by p.idprob
												order by p.idcat asc";
											$ptampil = mysqli_query($conn,$prob);
												
												$stt = " - STATUS MENUNGGU SPAREPART";
										break;
										case "finish":
										$prob = "SELECT * FROM tproblems p
												left join mcategories c on p.idcat = c.idcat 
												left join tmesin m on p.id_mesin = m.idMesin
												left join tmesinunit n on p.id_unit_mesin = n.idUnit
												left join tassign ta on p.idprob = ta.no_pelaporan
												left join user u on u.username = ta.pic_handling
												where p.status_problem='FINISH'";
												if($_GET[show]=='pribadi'){
													$prob .= " AND p.created_by = '$_SESSION[username]' ";
												}else{}
												
												$prob .= "group by p.idprob
												order by p.idcat asc";
											$ptampil = mysqli_query($conn,$prob);
												
												$stt = " - STATUS FINISH";
										break;
										case "today":
										$prob = "SELECT * FROM tproblems p
												left join mcategories c on p.idcat = c.idcat 
												left join tmesin m on p.id_mesin = m.idMesin
												left join tmesinunit n on p.id_unit_mesin = n.idUnit
												left join tassign ta on p.idprob = ta.no_pelaporan
												left join user u on u.username = ta.pic_handling
												where p.dateprob = '$date'";
												if($_GET[show]=='pribadi'){
													$prob .= " AND p.created_by = '$_SESSION[username]' ";
												}else{}
												
												$prob .= "group by p.idprob
												order by p.idcat asc";
											$ptampil = mysqli_query($conn,$prob);
												
												$stt = " - MASALAH HARI INI";
										break;
										case "approved":
										$prob = "SELECT * FROM tproblems p
												left join mcategories c on p.idcat = c.idcat 
												left join tmesin m on p.id_mesin = m.idMesin
												left join tmesinunit n on p.id_unit_mesin = n.idUnit
												left join tassign ta on p.idprob = ta.no_pelaporan
												left join user u on u.username = ta.pic_handling
												where p.status_problem='APPROVED'";
												if($_GET[show]=='pribadi'){
													$prob .= " AND p.created_by = '$_SESSION[username]' ";
												}else{}
												
												$prob .= "group by p.idprob
												order by p.idcat asc";
											$ptampil = mysqli_query($conn,$prob);
												
												$stt = " - MASALAH APPROVED";
										break;
									}
						$c = mysqli_query($conn, "select *from user where username='$_SESSION[username]'");
						$h = mysqli_fetch_array($c);
			?>
                        <div class="header">
						<h2><u>Daftar Laporan Kerusakan</u><font color='red'><b><?php echo $stt; ?></b></font></h2>
                        </div>
                        <div class="body">                           
                            <ul class="right_chat list-unstyled">
							<div class='row'>
						    <div class='col-lg-12 col-md-12'>
							<div class='table-responsive'>
								<table class='table table-striped table-hover dataTable'>
                                    <thead>
                                        <tr>
											<th align='center' width='10%' >No.</th>
											<th align='center'>MASALAH</th>
											<th align='center'>PELAPOR</th>
											<th align='center'>MESIN</th>
											<th align='center'>UNIT MESIN</th>
											<th width='10%'>TEKNISI</th>
											<th width='10%'>STATUS</th>
											<?php
											
											
											if($h[divisi]=='PRODUKSI'){
												echo"<th width='10%'>ACTION</th>";
											}else{
												echo"<th width='10%'>#</th>";
											}
											?>
                                        </tr>
                                    </thead>
                                    <tbody id='btabel'>
									<?php
									
										$no = 1;
										while ($data = mysqli_fetch_assoc($ptampil))
										{
											echo "
											<tr>
												";
												if($data[category_name] == 'Kritis'){
													echo"
														<td bgcolor='red'><font color='white'>$no</font></td>
														<td bgcolor='red'><a href='?p=todolist&act=problem-detail&id=$data[idprob]&s=report'><font color='white'><b>$data[idprob]</b></font></a></td>
														<td bgcolor='red'><font color='white'>$data[namapelapor]</font></td>
														<td bgcolor='red'><font color='white'>$data[namaMesin]</font></td>
														<td bgcolor='red'><font color='white'>$data[namaUnit]</font></td>
														<td bgcolor='red'><font color='white'>$data[fullname]</font></td>";
												}
												else if($data[category_name] == 'Penting'){
													echo"	
														<td bgcolor='yellow'>$no</font></td>
														<td bgcolor='yellow'><a href='?p=todolist&act=problem-detail&id=$data[idprob]&s=report'><b>$data[idprob]</b></a></td>
														<td bgcolor='yellow'>$data[namapelapor]</td>
														<td bgcolor='yellow'>$data[namaMesin]</td>
														<td bgcolor='yellow'>$data[namaUnit]</td>
														<td bgcolor='yellow'>$data[fullname]</td>";
												}
												else{
													echo"
														<td>$no</td>
														<td><a href='?p=todolist&act=problem-detail&id=$data[idprob]&s=report'><b>$data[idprob]</b></a></td>
														<td>$data[namapelapor]</td>
														<td>$data[namaMesin]</td>
														<td>$data[namaUnit]</td>
														<td>$data[fullname]</td>";
												}
												echo"
												
												";
											if($h[divisi]=='PRODUKSI'){
												if($data[status_problem] == 'APPROVED'){
													echo "<td>APPROVED </td>";
													if($data[created_by] == $_SESSION[username]){
														echo "<td><a href='modul/911/aksi_911.php?p=close&act=close&id=$data[idprob]' title='Klik for closing problem' class='btn btn-sm btn-danger'>CLOSE</a></td>";
													}else{
														echo "<td>&nbsp;</td>";
													}
												}else{
													echo "<td><font color='blue'><b>$data[status_problem]<b></font></td>
														  <td>&nbsp;</td>";
												}
											}
											else{
												echo "<td><font color='blue'><b>$data[status_problem]</b></font></td><td>&nbsp;</td>";
												
											}
											echo"</tr>";
											$no++;
										}
										
									?>
									</tbody>
								</table>
									<?php
									echo"
            </div>
        </div>
    </div>
    
</div>";
			?>
			</body>

  
<!-- Javascript -->
<script src="assets/bundles/libscripts.bundle.js"></script>
<script src="assets/bundles/vendorscripts.bundle.js"></script>

<script src="../assets/vendor/toastr/toastr.js"></script>
<script src="assets/bundles/chartist.bundle.js"></script>


<script src="assets/bundles/mainscripts.bundle.js"></script>
<script src="assets/js/index.js"></script>
<script src="../assets/vendor/summernote/dist/summernote.js"></script>
<script src="../assets/vendor/dropify/js/dropify.min.js"></script>
<script src="assets/js/pages/forms/dropify.js"></script>

<script src="assets/bundles/datatablescripts.bundle.js"></script>
<script src="../assets/vendor/jquery-datatable/buttons/dataTables.buttons.min.js"></script>
<script src="../assets/vendor/jquery-datatable/buttons/buttons.bootstrap4.min.js"></script>
<script src="../assets/vendor/jquery-datatable/buttons/buttons.colVis.min.js"></script>
<script src="../assets/vendor/jquery-datatable/buttons/buttons.html5.min.js"></script>
<script src="../assets/vendor/jquery-datatable/buttons/buttons.print.min.js"></script>
<link rel="stylesheet" href="../assets/vendor/bootstrap-multiselect/bootstrap-multiselect.css">
<link rel="stylesheet" href="../assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker3.min.css">
<link rel="stylesheet" href="../assets/vendor/bootstrap-colorpicker/css/bootstrap-colorpicker.css" />
<link rel="stylesheet" href="../assets/vendor/multi-select/css/multi-select.css">
<link rel="stylesheet" href="../assets/vendor/bootstrap-tagsinput/bootstrap-tagsinput.css">
<link rel="stylesheet" href="../assets/vendor/nouislider/nouislider.min.css" />

<script src="../assets/vendor/sweetalert/sweetalert.min.js"></script> <!-- SweetAlert Plugin Js --> 
<script src="../assets/vendor/parsleyjs/js/parsley.min.js"></script>
<script src="assets/js/pages/tables/jquery-datatable.js"></script>

<script src="../assets/vendor/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script> <!-- Bootstrap Colorpicker Js --> 
<script src="../assets/vendor/jquery-inputmask/jquery.inputmask.bundle.js"></script> <!-- Input Mask Plugin Js --> 
<script src="../assets/vendor/jquery.maskedinput/jquery.maskedinput.min.js"></script>
<script src="../assets/vendor/multi-select/js/jquery.multi-select.js"></script> <!-- Multi Select Plugin Js -->
<script src="../assets/vendor/bootstrap-multiselect/bootstrap-multiselect.js"></script>
<script src="../assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<script src="../assets/vendor/bootstrap-tagsinput/bootstrap-tagsinput.js"></script> <!-- Bootstrap Tags Input Plugin Js --> 
<script src="../assets/vendor/nouislider/nouislider.js"></script> <!-- noUISlider Plugin Js --> 
<script src="assets/js/pages/ui/dialogs.js"></script>    
<script src="assets/js/pages/forms/advanced-form-elements.js"></script>

<script type="text/javascript">
	
	$("document").ready(function(){
		$.ajax({
					type: "POST",
					dataType: "json",
					url: "act_pagemonitor.php?aksi=data",//request
					success: function(data) {
						console.log(data);
					}
				});
		setInterval(function(){

			setTimeout(run, 2000);
		}
			,30000);
	});

	function run() {
		$.post("act_pagemonitor.php?aksi=data", function( data ){
			$("#btabel").html(data);
			
			});
		$.post("act_pagemonitor.php?aksi=open", function( data ){
			$("#open").html(data);
			
			});
		$.post("act_pagemonitor.php?aksi=assign", function( data ){
			$("#assign").html(data);
			
			});
		$.post("act_pagemonitor.php?aksi=inprogress", function( data ){
			$("#inprogress").html(data);
			
			});
		$.post("act_pagemonitor.php?aksi=sparepart", function( data ){
			$("#sparepart").html(data);
			
			});
		$.post("act_pagemonitor.php?aksi=finish", function( data ){
			$("#finish").html(data);
			
			});
		$.post("act_pagemonitor.php?aksi=approved", function( data ){
			$("#approved").html(data);
			
			});
	};
</script>
<script type="text/javascript">
	
</script>
</body>
</html>
