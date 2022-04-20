<?php
error_reporting(0);
session_start();
require_once('bdd.php');
if($_GET[periode]==NULL){
		$date = date('Y-m-d');
	}else{
		$date = $_GET[periode];
	}
?>
<script src="http://code.jquery.com/jquery-2.2.1.min.js"></script>
    <style type="text/css">
    .preloader {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      z-index: 9999;
      background-color: #fff;
    }
    .preloader .loading {
      position: absolute;
      left: 50%;
      top: 50%;
      transform: translate(-50%,-50%);
      font: 14px arial;
    }
    </style>
	<script>
    $(document).ready(function(){
      $(".preloader").fadeOut();
    })
    </script>
<table width='100%' border='0'>
	<tr>
		<td width='12%'>&nbsp;</td>
		<td colspan='3'><u><b>Filter :<br /><br /></b></u></td>
	</tr>
	<tr>
		<td width='12%'>&nbsp;</td>
		<td width='20%'>
		<form method='GET' action='index.php'>
			<b>Periode</b>
		</td>
		<td width='52%'>
		<?php
			$y = date('Y');
			$m = date('m');
			$d = date('d');
			echo "<input type='date' class='form-control' name='periode' value= '$y-$m-01'>";
		?>
		</td>
		<td>
		</td>
		<td></td></tr>
		<tr>
		<td width='12%'>&nbsp;</td>
		<td width='20%'>
			<select name="kategori" class="form-control" id="kategori" >
				<option value="">---Pilih Filter---</option>
				<option value="jenis_pekerjaan_cari">Jenis Pekerjaan</option>
				<option value="mesin_cari">Mesin</option>
				<option value="teknisi_cari">Teknisi</option>
			</select>
		</td>
		<td width='52%'>
			<select name="pilih" class="form-control" id="pilih">
						  <option value="">-------------------------------</option>
			</select>
			<select name="jenis_pekerjaan_cari" class="form-control" id="jenis_pekerjaan_cari" style='display:none;'>
						  <option value="">---Pilih Jenis Pekerjaan---</option>
						  <?php
						   // jalankan query
						   $result = $bdd->query('SELECT * FROM mpekerjaan');
						  
						   // tampilkan data
						   while($row = $result->fetch()) {
								echo "<option value='$row[1]'>$row[1]</option>";
						  }
						  ?>
						  
			</select>
			<select name="mesin_cari" class="form-control" id="mesin_cari" style='display:none;'>
						  <option value="">---Pilih Mesin---</option>
						  <?php
						   // jalankan query
						   $mesin = $bdd->query('SELECT * FROM tmesin');
						  
						   // tampilkan data
						   while($row = $mesin->fetch()) {
								echo "<option value='$row[1]'>$row[1]</option>";
						  }
						  ?>
						  
			</select>
			<select name="teknisi_cari" class="form-control" id="teknisi_cari" style='display:none;'>
						  <option value="">---Pilih Teknisi---</option>
						  <?php
						   // jalankan query
						   $mesin = $bdd->query('select * from user where (divisi="MAINTENANCE" AND id_field=3 and active = 1) OR (active = 2) order by fullname asc;');
						  
						   // tampilkan data
						   while($row = $mesin->fetch()) {
								echo "<option value='$row[2]'>$row[1]</option>";
						  }
						  ?>
						  
			</select>
		</td>
		<td>
			&nbsp;<button type='submit' class='btn btn-danger'>Show</button>&nbsp;
			</form>
			<?php 
				echo "<a href='export/excel.php?periode=$date'>";
			?>
				<button class="btn btn-success" type="button">Cetak</button>
			</a>
			
		</td></tr>
</table>
<hr />
<br />
<?php
if($_GET[kategori]== NULL){
	$sql = "SELECT id, title, start, end, color, mesin, teknisi, isi_tugas, datetgs, namaMesin, title_only, kode_tugas, est_day, est_hour, est_min, series
			FROM tpenjadwalan p left join tmesin m on p.mesin=m.namaMesin order by id asc";
}else{
	$sql = "SELECT id, title, start, end, color, mesin, teknisi, isi_tugas, datetgs, namaMesin, title_only, kode_tugas, est_day, est_hour, est_min, series
			FROM tpenjadwalan p left join tmesin m on p.mesin=m.namaMesin";
	if($_GET[kategori]=="jenis_pekerjaan_cari"){
		$sql .= " where title_only = '$_GET[jenis_pekerjaan_cari]'";
	}
	if($_GET[kategori]=="mesin_cari"){
		$sql .= " where mesin = '$_GET[mesin_cari]'";
	}
	if($_GET[kategori]=="teknisi_cari"){
		$sql .= " where teknisi = '$_GET[teknisi_cari]'";
	}
		$sql .= "order by id asc";
}
$req = $bdd->prepare($sql);
$req->execute();
$events = $req->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
	<!-- FullCalendar -->
	<link href='css/fullcalendar.css' rel='stylesheet' />
    <!-- Custom CSS -->
    <style>
    body {
        padding-top: 20px;
        /* Required padding for .navbar-fixed-top. Remove if using .navbar-static-top. Change if height of navigation changes. */
    }
	#calendar {
		max-width: 800px;
	}
	.col-centered{
		float: none;
		margin: 0 auto;
	}
    </style>

</head>
<body>
    <!-- Page Content -->
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div id="calendar" class="col-centered">
                </div>
            </div>
        </div>
		<div class="preloader">
      <div class="loading">
        <img src="poi.gif" width="80">
        <p>Harap Tunggu</p>
      </div>
    </div>
        <!-- /.row -->
		
		<!-- Modal -->
		<div class="modal fade" id="ModalAdd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
			<div class="modal-content">
			<form class="form-horizontal" method="POST" action="addEvent.php">
			
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Tambah Jadwal</h4>
			  </div>
			  <div class="modal-body">
				
				 <div class="form-group">
					<label for="title" class="col-sm-2 control-label">Pekerjaan</label>
					<div class="col-sm-10">
					  <select name="title" class="form-control" id="title" required >
						  <option value="">---Pilih Jenis Pekerjaan---</option>
						  <?php
						   // jalankan query
						   $result = $bdd->query('SELECT * FROM mpekerjaan');
						  
						   // tampilkan data
						   while($row = $result->fetch()) {
								echo "<option value='$row[1]'>$row[1]</option>";
						  }
						  ?>
						  
						</select>
					</div>
				  </div>
				  <div class="form-group">
					<label for="title" class="col-sm-2 control-label">Mesin</label>
					<div class="col-sm-10">
					  <select name="mesin" class="form-control" id="mesin" required >
						  <option value="">---Pilih Mesin---</option>
						  <?php
						   // jalankan query
						   $mesin = $bdd->query('SELECT * FROM tmesin');
						  
						   // tampilkan data
						   while($row = $mesin->fetch()) {
								echo "<option value='$row[1]'>$row[1]</option>";
						  }
						  ?>
						  
						</select>
					</div>
				  </div>
				  <div class="form-group">
					<label for="title" class="col-sm-2 control-label">Teknisi</label>
					<div class="col-sm-10">
					  <select name="teknisi" class="form-control" id="teknisi" required >
						  <option value="">---Pilih Teknisi---</option>
						  <?php
						   // jalankan query
						   $mesin = $bdd->query('select * from user where (divisi="MAINTENANCE" AND id_field=3 and active = 1) OR (active = 2) order by fullname asc;');
						  
						   // tampilkan data
						   while($row = $mesin->fetch()) {
								echo "<option value='$row[2]'>$row[1]</option>";
						  }
						  ?>
						  
						</select>
					</div>
				  </div>
				  <div class="form-group">
					<label for="start" class="col-sm-2 control-label">Deskripsi</label>
					<div class="col-sm-10">
						<input type='text' class='form-control' name='isi_tgs' required id="isi_tgs" placeholder = 'Masukan deskripsi pekerjaan'>
					</div>
				  </div>
				  <div class="form-group" style='display:none;'>
					<label for="color" class="col-sm-2 control-label" >Warna</label>
					<div class="col-sm-10">
					<input type='text' name="color" class="form-control" id="color" required value="#FFD700" readonly='readonly' >
						</select>
					</div>
				  </div>
				  <div class='form-group'>
					<label for="color" class="col-sm-2 control-label" >Estimasi </label>
					<div class="col-sm-2">
							<label class='control-label'>Hari</label> <input type='number' name='est_day' id='est_day' class='form-control'>
					</div>
					<div class="col-sm-2">
						<label class='control-label'>Jam</label> <input type='number' name='est_hour' id='est_hour' class='form-control'>
					</div>
					<div class="col-sm-2">
						<label class='control-label'>Menit</label> <input type='number' name='est_minute' id='est_minute' class='form-control'>
					</div>
				</div>
				  <div class="form-group">
					<label for="start" class="col-sm-2 control-label">Tanggal</label>
					<div class="col-sm-10">
					  <input type="text" name="start" class="form-control" id="start" readonly>
					</div>
				  </div>
				<!--  <div class="form-group">
					<label for="end" class="col-sm-2 control-label">End date</label>
					<div class="col-sm-10"> -->
					  <input type="text" name="end" class="form-control" id="end" readonly style='display:none;'>
				<!--	</div>
				  </div>-->
				
			  </div>
			  <div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-primary">Save changes</button>
			  </div>
			</form>
			</div>
		  </div>
		</div>
		
		<!-- Modal -->
		<div class="modal fade" id="ModalEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
			<div class="modal-content">
			<form class="form-horizontal" method="POST" action="editEventTitle.php">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Edit Pekerjaan</h4>
			  </div>
			  <div class="modal-body">
				
				  <div class="form-group">
					<label for="title" class="col-sm-2 control-label">Pekerjaan</label>
					<div class="col-sm-10">
					  <select name="title" class="form-control" id="title">
						  <option value="">---Pilih Jenis Pekerjaan---</option>
						  <?php
						   // jalankan query
						   $result = $bdd->query('SELECT * FROM mpekerjaan');
						  
						   // tampilkan data
						   while($row = $result->fetch()) {
								echo "<option value='$row[1]'>$row[1]</option>";
						  }
						  ?>
						  
						</select>
					</div>
				  </div>
				  <div class="form-group">
					<label for="title" class="col-sm-2 control-label">Mesin</label>
					<div class="col-sm-10">
					  <select name="mesin" class="form-control" id="mesin">
						  <option value="">---Pilih Mesin---</option>
						  <?php
						   // jalankan query
						   $mesin = $bdd->query('SELECT * FROM tmesin');
						  
						   // tampilkan data
						   while($row = $mesin->fetch()) {
								echo "<option value='$row[1]'>$row[1]</option>";
						  }
						  ?>
						  
						</select>
					</div>
				  </div>
				  <div class="form-group">
					<label for="title" class="col-sm-2 control-label">Teknisi</label>
					<div class="col-sm-10">
					  <select name="teknisi" class="form-control" id="teknisi">
						  <option value="">---Pilih Teknisi---</option>
						  <?php
						   // jalankan query
						   $mesin = $bdd->query('select * from user where (divisi="MAINTENANCE" AND id_field=3 and active = 1) OR (active = 2) order by fullname asc;');
						  
						   // tampilkan data
						   while($row = $mesin->fetch()) {
								echo "<option value='$row[2]'>$row[1]</option>";
						  }
						  ?>
						  
						</select>
					</div>
				  </div>
				  <div class="form-group">
					<label for="start" class="col-sm-2 control-label">Deskripsi</label>
					<div class="col-sm-10">
						 <input type='text' class='form-control' name='isi_tgs' required id="isi_tgs">
					</div>
				  </div>
				  <div class="form-group" style='display:none;'>
					<label for="color" class="col-sm-2 control-label">Warna</label>
					<div class="col-sm-10">
					  <select name="color" class="form-control" id="color">
						  <option value="">---Pilih Warna---</option>
						  <option style="color:#0071c5;" value="#0071c5">&#9724; Dark blue</option>				  
						  <option style="color:#FFD700;" value="#FFD700">&#9724; Yellow</option>
						  
						</select>
					</div>
				  </div>
				  <div class='form-group'>
					<label for="color" class="col-sm-2 control-label" >Estimasi</label>
					<div class="col-sm-2">
							<label class='control-label'>Hari</label> <input type='number' name='est_day' id='est_day' class='form-control'>
					</div>
					<div class="col-sm-2">
						<label class='control-label'>Jam</label> <input type='number' name='est_hour' id='est_hour' class='form-control'>
					</div>
					<div class="col-sm-2">
						<label class='control-label'>Menit</label> <input type='number' name='est_minute' id='est_minute' class='form-control'>
					</div>
				</div>
				    <div class="form-group"> 
						<div class="col-sm-offset-2 col-sm-10">
						  <div class="checkbox">
							<label class="text-danger"><input type="checkbox"  name="delete" id="delete"> Hapus Pekerjaan</label>
						  </div>
						</div>
					</div>
				  
				  <input type="hidden" name="id" class="form-control" id="id">
				  <input type="hidden" name="kode_tugas" class="form-control" id="kode_tugas">
				  <input type="hidden" name="datetgs" class="form-control" id="datetgs">
			  </div>
			  <div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-primary" id='submit'>Save changes</button>
			  </div>
			</form>
			</div>
		  </div>
		</div>
		<br />
		<table width='30%'>
			<tr><td bgcolor='#FFD700' width='30%'>&nbsp;</td><td> : <b>PLAN</b></td></tr>
			<tr><td bgcolor='#81b214' width='30%'>&nbsp;</td><td> : <b>IN PROGRESS</b></td></tr>
			<tr><td bgcolor='#ec0101' width='30%'>&nbsp;</td><td> : <b>FINISH</b></td></tr>
			<tr><td bgcolor='#0071c5' width='30%'>&nbsp;</td><td> : <b>DIKERJAKAN</b></td></tr>
		</table>
		

    </div>
    <!-- /.container -->

    <!-- jQuery Version 1.11.1 -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
	
	<!-- FullCalendar -->
	<script src='js/moment.min.js'></script>
	<script src='js/fullcalendar.min.js'></script>
	<?php
	$now = date('Y-m-d');
	if($_GET[periode]==NULL){
		$date = date('Y-m-d');
	}else{
		$date = $_GET[periode];
	}
	
	$dep	 = $bdd->query("select * from user where username='$_SESSION[username]' ");
	$dp		 = $dep->fetch();
	$ds		 = $bdd->query("select * from mdocumentseries where divisi='$dp[divisi]' and dokumen like 'MTC%'");
	$series	 = $ds->fetch();
	?>
	<script>

	$(document).ready(function() {
		
		$('#calendar').fullCalendar({
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,basicWeek,basicDay'
			},
			defaultDate: '<?php echo $date; ?>',
			editable: true,
			eventLimit: true, // allow "more" link when too many events
			selectable: true,
			selectHelper: true,
			select: function(start, end) {
				
				$('#ModalAdd #start').val(moment(start).format('YYYY-MM-DD HH:mm:ss'));
				$('#ModalAdd #end').val(moment(end).format('YYYY-MM-DD HH:mm:ss'));
				$('#ModalAdd').modal('show');
			},
			eventRender: function(event, element) {
				element.bind('click', function() { // menampilkan data edit di form
				console.log("series "+event.series);
				console.log("series db "+event.series_db)
				if( ((event.datetgs > "<?php echo $now; ?>") && (event.color == "#FFD700") && (event.series == event.series_db))){
					$('#ModalEdit #id').val(event.id);
					$('#ModalEdit #kode_tugas').val(event.kode_tugas);
					
					$('#ModalEdit #title').val(event.title_only);
					$('#ModalEdit #title').prop( "disabled", false );//dissable dan enable
					$('#ModalEdit #mesin').val(event.mesin);
					$('#ModalEdit #mesin').prop( "disabled", false );
					$('#ModalEdit #teknisi').val(event.teknisi);
					$('#ModalEdit #teknisi').prop( "disabled", false );
					$('#ModalEdit #isi_tgs').val(event.isi_tgs);
					$('#ModalEdit #isi_tgs').prop( "disabled", false );
					$('#ModalEdit #color').val(event.color);
					$('#ModalEdit #color').prop( "disabled", false );
					$('#ModalEdit #est_day').val(event.est_day);
					$('#ModalEdit #est_day').prop( "disabled", false );
					$('#ModalEdit #est_hour').val(event.est_hour);
					$('#ModalEdit #est_hour').prop( "disabled", false );
					$('#ModalEdit #est_minute').val(event.est_minute)
					$('#ModalEdit #est_minute').prop( "disabled", false );;
					$('#ModalEdit #datetgs').val(event.datetgs);
					$('#ModalEdit #datetgs').prop( "disabled", false );
					$('#ModalEdit #delete').prop( "disabled", false );
					$('#ModalEdit #submit').prop( "disabled", false );
					$('#ModalEdit').modal('show');
					}
				else {
					$('#ModalEdit #id').val(event.id);
					$('#ModalEdit #kode_tugas').val(event.kode_tugas);
					
					$('#ModalEdit #title').val(event.title_only);
					$('#ModalEdit #title').prop( "disabled", true );//dissable dan enable
					$('#ModalEdit #mesin').val(event.mesin);
					$('#ModalEdit #mesin').prop( "disabled", true );
					$('#ModalEdit #teknisi').val(event.teknisi);
					$('#ModalEdit #teknisi').prop( "disabled", true );
					$('#ModalEdit #isi_tgs').val(event.isi_tgs);
					$('#ModalEdit #isi_tgs').prop( "disabled", true );
					$('#ModalEdit #color').val(event.color);
					$('#ModalEdit #color').prop( "disabled", true );
					$('#ModalEdit #est_day').val(event.est_day);
					$('#ModalEdit #est_day').prop( "disabled", true );
					$('#ModalEdit #est_hour').val(event.est_hour);
					$('#ModalEdit #est_hour').prop( "disabled", true );
					$('#ModalEdit #est_minute').val(event.est_minute)
					$('#ModalEdit #est_minute').prop( "disabled", true );;
					$('#ModalEdit #datetgs').val(event.datetgs);
					$('#ModalEdit #datetgs').prop( "disabled", true );
					$('#ModalEdit #delete').prop( "disabled", true );
					$('#ModalEdit #submit').prop( "disabled", true );
					$('#ModalEdit').modal('show');
				}					
				});
				//var s = document.getElementById("datetgs").val();
				/* if( s == '2020-10-29'){
					document.getElementById("datetgs").disabled = true;
				} */
			},
			eventDrop: function(event, delta, revertFunc) { 

				edit(event);

			},
			eventResize: function(event,dayDelta,minuteDelta,revertFunc) { 

				edit(event);

			},
			events: [
			<?php foreach($events as $event): 
			
				$start = explode(" ", $event['start']);
				$end = explode(" ", $event['end']);
				if($start[1] == '00:00:00'){
					$start = $start[0];
				}else{
					$start = $event['start'];
				}
				if($end[1] == '00:00:00'){
					$end = $end[0];
				}else{
					$end = $event['end'];
				}
			?>
				{
					//mengambil data untuk edit
					id			: '<?php echo $event['id']; 		?>',
					kode_tugas	: '<?php echo $event['kode_tugas']; ?>',
					title		: '<?php echo $event['title']; 		?>',
					mesin		: '<?php echo $event['mesin']; 		?>',
					teknisi		: '<?php echo $event['teknisi']; 	?>',
					isi_tgs		: '<?php echo $event['isi_tugas']; 	?>',
					start		: '<?php echo $start; 				?>',
					end			: '<?php echo $end; 				?>',
					color		: '<?php echo $event['color']; 		?>',
					title_only	: '<?php echo $event['title_only']; ?>',
					est_day		: '<?php echo $event['est_day']; 	?>',
					est_hour	: '<?php echo $event['est_hour']; 	?>',
					est_minute	: '<?php echo $event['est_min']; 	?>',
					datetgs		: '<?php echo $event['datetgs']; 	?>',
					series		: '<?php echo $event['series']; 	?>',
					series_db	: '<?php echo $series['series'];?>'
				},
			<?php endforeach; ?>
			]
		});
		
		function edit(event){
			start = event.start.format('YYYY-MM-DD HH:mm:ss');
			if(event.end){
				end = event.end.format('YYYY-MM-DD HH:mm:ss');
			}else{
				end = start;
			}
			
			id =  event.id;
			
			Event = [];
			Event[0] = id;
			Event[1] = start;
			Event[2] = end;
			
			$.ajax({
			 url: 'editEventDate.php',
			 type: "POST",
			 data: {Event:Event},
			 success: function(rep) {
					if(rep == 'OK'){
						alert('Pekerjaan berhasil disimpan');
					}else{
						alert('Tidak dapat disimpan. Silahkan Coba lagi.'); 
					}
				}
			});
		}
		
	});

</script>
<script type='text/javascript'>
$(window).load(function(){
$("#kategori").change(function() {
			console.log($("#kategori option:selected").val());
			
			if ($(kategori).val() == 'jenis_pekerjaan_cari') {
				$('#jenis_pekerjaan_cari').show();
				$('#mesin_cari').hide();	
				$('#teknisi_cari').hide();
				$('#pilih').hide();
			}	
			else if ($(kategori).val() == 'mesin_cari') {
				$('#jenis_pekerjaan_cari').hide();
				$('#mesin_cari').show();	
				$('#teknisi_cari').hide();	
				$('#pilih').hide();
			}	
			else if ($(kategori).val() == 'teknisi_cari') {
				$('#jenis_pekerjaan_cari').hide();
				$('#mesin_cari').hide();	
				$('#teknisi_cari').show();
				$('#pilih').hide();
			}			
			else {
				$('#jenis_pekerjaan_cari').hide();
				$('#mesin_cari').hide();	
				$('#teknisi_cari').hide();
				$('#pilih').show();
			}
		});
});
</script>
</body>

</html>
