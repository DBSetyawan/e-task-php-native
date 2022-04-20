<?php
error_reporting(0);
session_start(); 
$m = date(m);$d = date(d);$y = date(Y);
$aksi="modul/master/job/act_job.php";
?>
<div class='container-fluid'>
			<div class='block-header'>
                <div class='row'>
                    <div class='col-lg-5 col-md-8 col-sm-12'>                        
                        <h2><a href='javascript:void(0);' class='btn btn-xs btn-link btn-toggle-fullwidth'><i class='fa fa-arrow-left'></i></a> Master job</h2>
                        <ul class='breadcrumb'>
                            <li class='breadcrumb-item'><a href='?p=dashboard'><i class='icon-home'></i></a></li>                            
                            <li class='breadcrumb-item'>Master</li>
                            <li class='breadcrumb-item active'>Master job</li>
                        </ul>
                    </div>         
                </div>
            </div>
            <div class='row clearfix'>
				<div class="col-lg-12 col-md-12">
                    <div class="card">
                        <div class="body project_report">
						<button type='button' class='btn btn-primary' data-toggle='modal' data-target='#addnote'><i class='icon-plus'></i> New job</button><br><br>
                            <div class="table-responsive">
                                <table class="table table-hover js-basic-example dataTable table-custom m-b-0">
                                    <thead>
                                        <tr>                                            
                                            <th>No.</th>
                                            <th>job Name</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php
									$t = mysqli_query($conn, "select *from tprepress");
									while($r = mysqli_fetch_array($t)){
									?>
                                        <tr>
											<td width='7%'><?php echo $r[idPrepress]; ?></td>
                                            <td class="project-title">
                                                <h6><?php echo $r[namaPrepress]; ?></h6>
                                            </td>
											<td class="project-actions" width='10%'>
                                                <?php echo "
												<a href='#edit_modal' title='Klik for updating' data-toggle='modal' data-id='$r[idPrepress]' class='btn btn-sm btn-outline-success'  ><i class='icon-pencil'></i></a>";
                                                ?>
											<a href='<?php echo "$aksi?p=job&act=delete&id=$r[idPrepress]";?>' class='btn btn-sm btn-outline-danger' onclick="return confirm('Are you sure to delete this data?');"><i class='icon-trash'></i></a>
                                            </td>
                                        </tr>
										<?php
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
		<div class='modal animated fadeIn' id='addnote' tabindex='-1' role='dialog'>
		<div class='modal-dialog' role='document'>
        <div class='modal-content'>
            <div class='modal-header'>
                <h4 class='title' id='defaultModalLabel'>Add job</h4>
				<small>Add New job*</small>
            </div>
            <div class='modal-body'>
                <div class='comment-form'>
                    <form id='basic-form' class='row clearfix' method='POST' action='$aksi?p=job&act=input'>
                        <div class='col-sm-12'>
						<div class='form-group'>
							<label>Code*</label>
                                <input type='text' class='form-control' name='idPrepress' placeholder='Enter code job' required>
                            </div>
                            <div class='form-group'>
							<label>job Name*</label>
                                <input type='text' class='form-control' name='pre_nm' placeholder='Enter job Name' required>
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
                <h4 class='title' id='defaultModalLabel'>Edit job</h4>
				<small>Edit jobs*</small>
            </div>
            <div class='modal-body'>
                <div class='comment-form'>
                   <div class='hasil-data'></div>
    </div>
</div>
		";
?>
<script src="modul/master/users/jquery-3.1.1.min.js"></script>
  <script type="text/javascript">
    $(document).ready(function(){
        $('#edit_modal').on('show.bs.modal', function (e) {
            var idx = $(e.relatedTarget).data('id');
            //menggunakan fungsi ajax untuk pengambilan data
            $.ajax({
                type : 'post',
                url : 'modul/master/job/detail.php',
                data :  'idx='+ idx,
                success : function(data){
                $('.hasil-data').html(data);//menampilkan data ke dalam modal
                }
            });
         });
    });
  </script>
