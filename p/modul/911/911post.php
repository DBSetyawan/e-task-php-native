<?php
error_reporting(0);
session_start(); 
$m = date(m);$d = date(d);$y = date(Y);
$aksi="modul/actlog/act_log.php";
$dated = date('Y-m-d');
 ?>
 <div class="container-fluid">
<?php
switch($_GET[act]){
default:
		
?>
<div class='block-header'>
                <div class='row'>
                    <div class='col-lg-5 col-md-8 col-sm-12'>                        
                        <h2><a href='javascript:void(0);' class='btn btn-xs btn-link btn-toggle-fullwidth'><i class='fa fa-arrow-left'></i></a> Assign List</h2>
                        <ul class='breadcrumb'>
                            <li class='breadcrumb-item'><a href='?p=dashboard'><i class='icon-home'></i></a></li>                            
                            <li class='breadcrumb-item'>911</li>
                            <li class='breadcrumb-item active'>Assign List</li>
                        </ul>
                    </div>         
                </div>
            </div>
	<div class="col-lg-12">
                    <div class="card">
                        <div class="body">
						<?php
						$kategori = "<b>$_GET[category]</b>";
						echo "
							<h6 align='right'>$kategori</h6>
                            <div class='table-responsive'>
                                <table class='table dataTable js-exportable' >
                                    <thead>
                                        <tr>
											<th width='1%' style='display:none;'>#</th>
                                            <th width='1%'>MASALAH</th>
											<th width='10%'>DESKRIPSI</th>
                                            <th width='5%'>MESIN</th>
											<th width='10%'>STATUS</th>
											<th width='20%'>NAMA PELAPOR</th>
                                        </tr>
                                    </thead>
                                    <tbody>";
									$no=1;
								$l = mysqli_fetch_array(mysqli_query($conn,"select *from user where username = '$_SESSION[username]'"));
								$date = date('Y-m-d');
								if($_SESSION[divisi]=='GA'){
                                    $ro = mysqli_query($conn,"SELECT a.*,mc.category_name, mc.idcat as iddc, tm.namaMesin FROM `tproblems` a
                                                            LEFT JOIN mcategories mc ON a.idcat=mc.idcat
                                                            LEFT JOIN tmesin tm ON a.id_mesin = tm.idMesin
                                                            where status_problem not in ('CLOSED','FINISH','APPROVED')
                                                            and a.idprob like 'PGA%'
                                                            order by mc.idcat asc;");
                                }else{
                                    $ro = mysqli_query($conn,"SELECT a.*,mc.category_name, mc.idcat as iddc, tm.namaMesin FROM `tproblems` a
                                                            LEFT JOIN mcategories mc ON a.idcat=mc.idcat
                                                            LEFT JOIN tmesin tm ON a.id_mesin = tm.idMesin
                                                            where status_problem not in ('CLOSED','FINISH','APPROVED')
                                                            and a.idprob like 'TSK%'
                                                            order by mc.idcat asc;");
                                }
									while($r = mysqli_fetch_array($ro)){
										$h = mysqli_query($conn,"select *from tlampiran where idprob = '$r[idprob]'");
										$i = mysqli_num_rows($h);
										if($r[category_name]=='Kritis'){
											echo"<tr bgcolor='red'>";
											$color = 'white';
										}
										else if($r[category_name]=='Penting'){
											echo"<tr bgcolor='yellow'>";
											$color = 'black';
										}
										else{
											echo"<tr>";
											$color = 'black';
										}
									echo "
                                        
											<td style='display:none;'>$r[iddc]</td>
											<td><a href='?p=todolist&act=problem-detail&id=$r[idprob]'><b><font color='$color'>$r[idprob]</font></b></a></td>
                                            <td><font color='$color'>$r[deskripsi]</font></td>
											<td><font color='$color'>$r[namaMesin]</font></td>
											<td>";
											if($r[status_problem]=='ASSIGN'){
												echo "<a href='?p=todolist&act=problem-detail&id=$r[idprob]'><button type='button' class='btn btn-danger btn-sm' >$r[status_problem]</button></td>";
											}else{
												echo "<a href='?p=todolist&act=problem-detail&id=$r[idprob]'><button type='button' class='btn btn-success btn-sm' >$r[status_problem]</button></td>";
											}
										echo"
                                            <td><font color='$color'>$r[namapelapor]</font></td></tr>";
										$no++;
									}
										
                              echo"      </tbody>
                                </table>
                            </div>";
							?>
                        </div>
                    </div>
    </div>
<?php
echo"
<div class='modal fade' id='editnote'>
	<div class='modal-dialog'>
		<div class='modal-content'>
			<div class='modal-header'>
				<h4 class='modal-title'>ASSIGN TO EDP-TEAM</h4>
				<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
			</div>
			<div class='modal-body'>
			<p>
			<div class='hasil-data'></div>
			</p>
			</div>
		</div>
	</div>
</div>

<div class='modal fade' id='reassign'>
	<div class='modal-dialog'>
		<div class='modal-content'>
			<div class='modal-header'>
				<h4 class='modal-title'>RE-ASSIGN TO EDP-TEAM</h4>
				<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
			</div>
			<div class='modal-body'>
			<p>
			<div class='hasil-data2'></div>
			</p>
			</div>
		</div>
	</div>
</div>
";
?>

  <?php
break;

case "problem-detail":
$date = date('Y-m-d');
	date_default_timezone_set('Asia/Jakarta');
$time = date('H:i:s');
foreach ($r as $u);
	echo "<div class='container-fluid'>
			<div class='block-header'>
                <div class='row'>
                    <div class='col-lg-5 col-md-8 col-sm-12'>                        
                        <h2><a href='javascript:void(0);' class='btn btn-xs btn-link btn-toggle-fullwidth'><i class='fa fa-arrow-left'></i></a> Problem Details</h2>
                        <ul class='breadcrumb'>
                            <li class='breadcrumb-item'><a href='?p=dashboard'><i class='icon-home'></i></a></li>                            
                            <li class='breadcrumb-item'>911</li>
                            <li class='breadcrumb-item active'>Problem Detail</li>
                        </ul>
                    </div>         
                </div>
            </div>
            <div class='row clearfix'>
                <div class='col-lg-8 col-md-12 left-box'>
                    <div class='card single_post'>
                        <div class='body'>
                            <h3 align='center'><b>$u[judulprob]</b></h3><hr>
                            <p>$u[deskripsi]</p>
                        <br>
                            <button type='button' class='btn btn-primary btn-block' data-toggle='modal' data-target='#addnote'>Add New Notes</button>
                        </div>
                    </div>
                    <div class='card'>
                            <div class='header'>
                                <h2><b>Notes</b></h2>
                            </div><hr>
                            <div class='body'>
                                <ul class='comment-reply list-unstyled'>";
								$w = mysqli_query($conn,"select *from tproblemnote where idprob = '$_GET[id]' order by idnote asc");
								while($h = mysqli_fetch_array($w)){
									$lu = mysqli_fetch_array(mysqli_query($conn,"select *from user where username = '$h[created_by]'"));
                                    echo"<li class='row clearfix'>
                                        <div class='icon-box col-md-2 col-4'>";
										if($lu[photo]==''){
											echo "<img class='img-fluid img-thumbnail' src='modul/master/users/photo/no_image.jpg' alt='Awesome Image'>";
										}
										else{
											echo "<img class='img-fluid img-thumbnail' src='modul/master/users/photo/$lu[photo]' alt='Awesome Image'>";
										}
										echo"</div>
                                        <div class='text-box col-md-10 col-8 p-l-0 p-r0'>
										<table width='100%'>
                                            <tr><td><h5 class='m-b-0'>$lu[fullname] </h5></td><td align='right'>";
									if($h[created_by]==$_SESSION[username]){
										echo"
											<a href='' data-toggle='modal' data-target='#editnote' data-id='$h[idnote]'><i class='icon-note'></i></a> &nbsp;
											<a href='$aksi?p=new-post&act=delete-note&id=$_GET[id]&idnote=$h[idnote]' title='Delete' ><i class='icon-trash'></i></a>";
											
										}
										echo"</td></tr></table>
                                            <p>$h[note]</p>
											<br>
                                            <ul class='list-inline'>
                                                <li>
												<table width='100%'>
												<tr><td width='100%'>
													<a href='javascript:void(0);'>".tgl_indo($h[datenote])." - $h[timenote]</a></td>
													<td width='50%'><font color='grey'><i>$h[edited]</i></font></td></tr>
												</table>
												</li>
                                            </ul>
                                        </div>
                                    </li><hr>";
								}
                               echo" </ul>                                        
                            </div>
                        </div>
                </div>
                <div class='col-lg-4 col-md-12 right-box'>
                    <div class='card'>
                        <div class='body widget'>
                            <h6><font color='red'><b>$u[idprob]</b></font></h6>
							<table width='100%'>
							<tr><td>Created By : </td><td>$u[created_by]</td></tr>
							<tr><td>Created At : </td><td>".tgl_indo($u[dateprob])."</td></tr>
							<tr><td>&nbsp;</td><td>$u[timeprob]</td></tr>";
							
							echo "
							</table>
                        </div>
                    </div>
					<div class='card'>
                        <div class='header'>
                            <h2><b>Related Documents</b></h2>
                        </div>
                        <div class='body widget'>
                            <ul class='list-unstyled categories-clouds m-b-0'>";
							$t = mysqli_query($conn,"select *from tdoc where idprob = '$u[idprob]' ");
							while($p = mysqli_fetch_array($t)){
                            echo "    <b><li><a href='javascript:void(0);'>$p[nodoc]</a></li></b>";
							}
							echo"
                            </ul>
                        </div>
                    </div>
                    
                    <div class='card'>
                        <div class='header'>
                            <h2><b>Attachment</b></h2>
                                               
                            <div class='input-group'>
							<table class='table-hover dataTable'>";
							$u = showLampiran($_GET[id]);
							$no=1;
							foreach ($u as $tt){
								echo "
								<tr><td><a href='modul/actlog/download.php?lampiran=$tt[lampiran]' target='_blank'>$tt[lampiran]</a></td></tr>
								";
								$no++;
							}
							echo "
							</table>
                            </div>
                        </div>
                    </div>
					
					<div class='card'>
                        <div class='header'>
                            <h2><b>Problem List</b></h2>
                        </div>
                        <div class='body widget newsletter'>                        
                            <div class='input-group'>
                            <div class='table-responsive'>
                                <table>
                                    <tbody>";
									$t = showProblemLimit();
									foreach($t as $r){
									echo "
                                        <tr>
                                            <td><a href='?p=new-post&act=problem-detail&id=$r[idprob]'><h6><b>$r[judulprob]</b></h6></a>
												<font color='red'><i><i class='fa fa-user'></i> $r[created_by] 
												&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
														<i class='fa fa-tag'></i> $r[category_name]</div> </i></font>                       
											</td>
                                        </tr>
										<tr><td>&nbsp;</td></tr>";
									}
										
                              echo"      </tbody>
                                </table>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
		
<div class='modal animated fadeIn' id='addnote' tabindex='-1' role='dialog'>
    <div class='modal-dialog' role='document'>
        <div class='modal-content'>
            <div class='modal-header'>
                <h4 class='title' id='defaultModalLabel'>Add Note</h4>
				<small>Share your solution*</small>
            </div>
            <div class='modal-body'>
                <div class='comment-form'>
                    <form class='row clearfix' method='POST' action='$aksi?p=new-post&act=problem-note&id=$_GET[id]'>
                        <div class='col-sm-6'>
                            <div class='form-group'>
                                <input type='hidden' class='form-control' name='c_by' value = '$_SESSION[username]' readonly='readonly'>
								<input type='hidden' class='form-control' name='dt_note' value = '$date' readonly='readonly'>
								<input type='hidden' class='form-control' name='tm_note' value = '$time' readonly='readonly'>
                            </div>
                        </div>
                        <div class='col-sm-12'>
                            <div class='form-group'>
                                <textarea class='summernote' name='note' ></textarea>
                            </div>
                        </div> 
                </div>      
            </div>
            <div class='modal-footer'>
                <button type='submit' class='btn btn-primary'>Add</button>
                <button type='button' class='btn btn-outline-secondary' data-dismiss='modal'>CLOSE</button>
            </div>                               
                    </form>
        </div>
    </div>
</div>
";
break;
}
?>
</div>
<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
  <script type="text/javascript">
    $(document).ready(function(){
        $('#editnote').on('show.bs.modal', function (e) {
            var idx = $(e.relatedTarget).data('id');
            //menggunakan fungsi ajax untuk pengambilan data
            $.ajax({
                type : 'post',
                url : 'modul/911/assign_modal.php',
                data :  'idx='+ idx,
                success : function(data){
                $('.hasil-data').html(data);//menampilkan data ke dalam modal
                }
            });
         });
		 
		 $('#reassign').on('show.bs.modal', function (e) {
            var idx = $(e.relatedTarget).data('id');
            //menggunakan fungsi ajax untuk pengambilan data
            $.ajax({
                type : 'post',
                url : 'modul/911/reassign_modal.php',
                data :  'idx='+ idx,
                success : function(data){
                $('.hasil-data2').html(data);//menampilkan data ke dalam modal
                }
            });
         });
    });
  </script>