<?php
error_reporting(0);
session_start(); 
$m = date(m);$d = date(d);$y = date(Y);
$aksi="modul/master/checkdata/act_checkdata.php";
switch($_GET[act]){
default:
        echo"
            <div class='block-header'>
                <div class='row'>
                    <div class='col-lg-5 col-md-8 col-sm-12'>                        
                        <h2><a href='javascript:void(0);' class='btn btn-xs btn-link btn-toggle-fullwidth'><i class='fa fa-arrow-left'></i></a> Revisi Laporan</h2>
                        <ul class='breadcrumb'>
                            <li class='breadcrumb-item'><a href='?p=dashboard'><i class='icon-home'></i></a></li>                            
                            <li class='breadcrumb-item active'>Revisi</li>
                        </ul>
                    </div>         
                </div>
            </div>
                <div class='col-lg-12 col-md-12'>
                    <div class='card'>
                        <div class='body'>
                           <div class='row'>
                            <div class='col-lg-12 col-md-12'>
                            <u><h6>Revisi Status</h6></u><br />
                            <form method='post' action='?p=checkdata&act=tampil'>
                                <table border='0' width='100%'>
                                <tr><td width='15%'>Kode Masalah</td><td>
                                        <input type='text' class='form-control' name='kode_masalah' />
                                    </td><td>&nbsp;</td><td width='15%'>&nbsp;</td><td>&nbsp;</td></tr>
                                </table><br /><br />
                                <p align='right'>";
                                ?>
                                <button class="btn btn-danger" type="submit"><b><i class='fa fa-print'></i>&nbsp; &nbsp; TAMPILKAN</button>
                                <?php
                                echo"
                            </form>
                            
                        </div>
                    </div></div>
                            ";
    break;
break;
case "tampil" :
?>
<div class='container-fluid'>
			<div class='block-header'>
                <div class='row'>
                    <div class='col-lg-5 col-md-8 col-sm-12'>                        
                        <h2><a href='javascript:void(0);' class='btn btn-xs btn-link btn-toggle-fullwidth'><i class='fa fa-arrow-left'></i></a> Check Data</h2>
                        
                    </div>         
                </div>
            </div>
			<div class='row clearfix'>
				<div class="col-lg-12 col-md-12">
                    <div class="card">
                        <div class="body project_report">
						<p>Tabel Problems</p>
						<div class="table-responsive">
                                <table class="table table-hover js-basic-example dataTable table-custom m-b-0">
                                    <thead>
                                        <tr>                                            
                                            <th>ID Prob.</th>
											<th>Status Problem</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php
									$t = mysqli_query($conn, "SELECT * FROM tproblems WHERE idprob='$_POST[kode_masalah]' order by idprob");
									$i=1;
									while($r = mysqli_fetch_array($t)){
									?>
                                        <tr>
											<td width='7%'><?php echo $r[idprob]; ?></td>
                                            <td>
                                                <h6><?php echo $r[status_problem]; ?></h6>
                                            </td>
											<td class="project-actions" width='10%'>
                                                <?php echo "
												<a href='#edit_modal' title='Klik for updating' data-toggle='modal' data-id='$r[idprob]' class='btn btn-sm btn-outline-success'  ><i class='icon-pencil'></i></a>";
                                                ?>
											<a href='<?php echo "$aksi?p=checkdata&act=delete_prob&id=$r[idprob]";?>' class='btn btn-sm btn-outline-danger' onclick="return confirm('Are you sure to delete this data?');"><i class='icon-trash'></i></a>
                                            </td>
                                        </tr>
										<?php
										$i++;
									}
										?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
			</div>
            <div class='row clearfix'>
				<div class="col-lg-12 col-md-12">
                    <div class="card">
                        <div class="body project_report">
						<p>Tabel Handling</p>
						<button type='button' class='btn btn-primary' data-toggle='modal' data-target='#addhand'><i class='icon-plus'></i> Tambah Data</button><br><br>
                            <div class="table-responsive">
                                <table class="table table-hover js-basic-example dataTable table-custom m-b-0">
                                    <thead>
                                        <tr>              
                                            <th>ID Prob</th>
                                            <th>Status Problem</th>
											<th>Handling</th>
											<th>Date Handling</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php
									$t = mysqli_query($conn, "SELECT * FROM thandling where idprob='$_POST[kode_masalah]' AND idProb IS NOT NULL");
									$i=1;
									while($r = mysqli_fetch_array($t)){
									?>
                                        <tr>
                                            <td class="project-title">
                                                <h6><?php echo $r[idProb]; ?></h6>
                                            </td>
                                            <td><?php echo $r[statusProblem]; ?></td>
											<td><?php echo $r[handling]; ?></td>
											<td><?php echo $r[dateAction]; ?></td>
											<td class="project-actions" width='10%'>
                                                <?php echo "
												<a href='#edit_modal_hand' title='Klik for updating' data-toggle='modal' data-id='$r[idHandling]' class='btn btn-sm btn-outline-success'  ><i class='icon-pencil'></i></a>";
                                                ?>
											<a href='<?php echo "$aksi?p=checkdata&act=delete_hand&id=$r[idHandling]";?>' class='btn btn-sm btn-outline-danger' onclick="return confirm('Are you sure to delete this data?');"><i class='icon-trash'></i></a>
                                            </td>
                                        </tr>
										<?php
										$i++;
									}
										?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
			</div>
		<?php
		echo "
		<div class='modal animated fadeIn' id='addhand' tabindex='-1' role='dialog'>
		<div class='modal-dialog' role='document'>
        <div class='modal-content'>
            <div class='modal-header'>
                <h4 class='title' id='defaultModalLabel'>Tambah Handling</h4>
            </div>
            <div class='modal-body'>
                <div class='comment-form'>
                    <form id='basic-form' class='row clearfix' method='POST' action='$aksi?p=checkdata&act=inputhandling'>
                        <div class='col-sm-12'>
                            <div class='form-group'>
							<label>ID Prob</label>
                                <input type='text' class='form-control' name='idprob' required>
                            </div>
                        </div>
						<div class='col-sm-12'>
                            <div class='form-group'>
							<label>Status Problem</label>
                                <select class='form-control show-tick' name='status_prob' required>
											<option selected disabled>---Select Status---</option>
											<option value='OPEN'>OPEN</option>
											<option value='ASSIGN'>ASSIGN</option>
											<option value='IN PROGRESS'>IN PROGRESS</option>
											<option value='MENUNGGU SPAREPART'>MENUNGGU SPAREPART</option>
											<option value='FINISH'>FINISH</option>
											<option value='APPROVED'>APPROVED</option>
											<option value='CLOSED'>CLOSED</option>
										</select>
                            </div>
                        </div>
						<div class='col-sm-12'>
                            <div class='form-group'>
							<label>Handling</label>
                                <input type='text' class='form-control' name='handling'  required>
                            </div>
                        </div>
						<div class='col-sm-12'>
                            <div class='form-group'>
							<label>Date Handling</label>
                                <input type='text' class='form-control' name='date_handling' required>
                            </div>
                        </div>
                </div>      
            </div>
            <div class='modal-footer'>
                <button type='submit' class='btn btn-primary'>Add</button>
                <button type='button' class='btn btn-outline-secondary' data-dismiss='modal'>Close</button>
            </div>                               
            </form>
        </div>
    </div>
</div>";
		
echo "
<div class='modal animated fadeIn' id='edit_modal' tabindex='-1' role='dialog'>
	<div class='modal-dialog' role='document'>
        <div class='modal-content'>
            <div class='modal-header'>
                <h4 class='title' id='defaultModalLabel'>Edit Status Problem</h4>
            </div>
            <div class='modal-body'>
                <div class='comment-form'>
                   <div class='hasil-data-prob'></div>
    </div>
</div></div></div></div>
		";
echo "
<div class='modal animated fadeIn' id='edit_modal_hand' tabindex='-1' role='dialog'>
	<div class='modal-dialog' role='document'>
        <div class='modal-content'>
            <div class='modal-header'>
                <h4 class='title' id='defaultModalLabel'>Edit Handling</h4>
            </div>
            <div class='modal-body'>
                <div class='comment-form'>
                   <div class='hasil-data'></div>
    </div>
</div>
		";
break;
}
?>
<script src="modul/master/users/jquery-3.1.1.min.js"></script>
  <script type="text/javascript">
    $(document).ready(function(){
        $('#edit_modal').on('show.bs.modal', function (e) {
            var idx = $(e.relatedTarget).data('id');
            //menggunakan fungsi ajax untuk pengambilan data
            $.ajax({
                type : 'post',
                url : 'modul/master/checkdata/detail.php',
                data :  'idx='+ idx,
                success : function(data){
                $('.hasil-data-prob').html(data);//menampilkan data ke dalam modal
                }
            });
         });
    });
  </script>
  <script src="modul/master/users/jquery-3.1.1.min.js"></script>
  <script type="text/javascript">
    $(document).ready(function(){
        $('#edit_modal_hand').on('show.bs.modal', function (e) {
            var idx = $(e.relatedTarget).data('id');
            //menggunakan fungsi ajax untuk pengambilan data
            $.ajax({
                type : 'post',
                url : 'modul/master/checkdata/detail_handling.php',
                data :  'idx='+ idx,
                success : function(data){
                $('.hasil-data').html(data);//menampilkan data ke dalam modal
                }
            });
         });
    });
  </script>
