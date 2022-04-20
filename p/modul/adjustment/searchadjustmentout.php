<?php
error_reporting(1);
session_start(); 
$m = date(m);$d = date(d);$y = date(Y);
$aksi="modul/911/aksi_911.php";
$y = date('Y');
$m = date('m');
$d = date('d');
 ?>
 <link rel="stylesheet" href="">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/css/select2.min.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js"></script>
 <div class="container-fluid">
			<?php
switch($_GET[act]){
default:
$tbody="";
if (isset($_POST['awal'])&& isset($_POST['akhir'])) {
	$query = mysqli_query($conn, "SELECT distinct t.DocNo , ts.mesin ,t.DateAdjOut From tadjustoutmaterial t left join  tsparepart ts on ts.idreq = t.idreq");
	$no=1;

	$servername_sim = "192.168.88.5";
	$username_sim = "root";
	$password_sim = "19K23O15P";
	$db_sim = "kristest";

	// Create connection
	$conn_sim = mysqli_connect($servername_sim, $username_sim, $password_sim, $db_sim);

	if (!$conn_sim) {
		die("Connection failed: " . mysqli_connect_error());
	}
	
	while($result = mysqli_fetch_array($query))
	{
	
		
		

		$query_sim= mysqli_query($conn_sim,"SELECT * FROM adjustouth WHERE docno = '$result[DocNo]' and approvedby !='' ");
		if (mysqli_num_rows($query_sim)>0) {
			$tbody.="
				<tr>
					<td><input type='checkbox' name='select[]' value='$result[DocNo]'></td>
					<td>$no</td>
					<td>$result[DocNo]</td>
					<td>$result[mesin]</td>
					<td>$result[DateAdjOut]<input name='date[]' style='display:none;' value='$result[DateAdjOut]'></td>
					<td></td>
				</tr>
			";

			
			$no++;
		} 
		
	}

}
			echo"
			<div class='block-header'>
                <div class='row'>
                    <div class='col-lg-5 col-md-8 col-sm-12'>                        
                        <h2><a href='javascript:void(0);' class='btn btn-xs btn-link btn-toggle-fullwidth'><i class='fa fa-arrow-left'></i></a> Problem Report</h2>
                        <ul class='breadcrumb'>
                            <li class='breadcrumb-item'><a href='?p=dashboard'><i class='icon-home'></i></a></li>                            
                            <li class='breadcrumb-item active'>Report</li>
                        </ul>
                    </div>         
                </div>
            </div>
				<div class='col-lg-12 col-md-12'>
                    <div class='card'>
                        <div class='body'>
                           <div class='row'>
						    <div class='col-lg-12 col-md-12'>
							<u><h6>Report Adjustmentout</h6></u><br />
							<form method='POST' action='page.php?p=searchadjustmentout'>
								<table border='0' width='100%'>
								
									
									<tr><td width='20%'>Tanggal Problem Mulai</td><td><input type='date' name='awal' class='form-control' value= '$y-$m-01'></td><td>&nbsp;</td>
									<td width='10%' align='center'>Sampai </td><td width='33%'><input type='date' name='akhir' class='form-control' value= '$y-$m-$d' ></td></tr>
									<!-- <tr><td width='20%'>Tanggal Finish Problem</td><td><input type='date' name='begda_f' class='form-control'></td><td>&nbsp;</td> 
									<td width='10%' align='center'>Sampai </td><td width='33%'><input type='date' name='endda_f' class='form-control' ></td></tr>-->
									
										
								</table><br /><br />
								<p align='right'>";
								?>
								<button class="btn btn-danger" type="submit"><b><i class='fa fa-print'></i>&nbsp; &nbsp; TAMPILKAN</button>
								<?php
								echo"
							</form>
							
                        </div>
						<div 
                    </div class='col-lg-12 col-md-12'>
						<form action='modul/adjustment/print.php' target='_blank' method='POST'>
							<table class='table table-hover js-custom-example dataTable table-custom m-b-0'>
								<thead>
									<tr>
										<th>Select</th>
										<th>No</th>
										<th>DocNo</th>
										<th>Mesin</th>
										<th>Date</th>
									</tr>
								</thead>
								<tbody>
									$tbody
								</tbody>
							</table>
							<button class='btn btn-primary' type='submit'><b><i class='fa fa-print'></i>&nbsp; &nbsp; Print</button>
						</form>
					</div>
							";
		
	break;
}
mysqli_close($conn);
?>
<script>
	$(".theSelect").select2();
</script>
