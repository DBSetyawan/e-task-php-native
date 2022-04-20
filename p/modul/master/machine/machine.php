<?php
error_reporting(0);
session_start(); 
$m = date(m);$d = date(d);$y = date(Y);
$aksi="modul/master/machine/act_machine.php";
?>
<div class='container-fluid'>
			<div class='block-header'>
                <div class='row'>
                    <div class='col-lg-5 col-md-8 col-sm-12'>                        
                        <h2><a href='javascript:void(0);' class='btn btn-xs btn-link btn-toggle-fullwidth'><i class='fa fa-arrow-left'></i></a> Master machine</h2>
                        <ul class='breadcrumb'>
                            <li class='breadcrumb-item'><a href='?p=dashboard'><i class='icon-home'></i></a></li>                            
                            <li class='breadcrumb-item'>Master</li>
                            <li class='breadcrumb-item active'>Master machine</li>
                        </ul>
                    </div>         
                </div>
            </div>
            <div class='row clearfix'>
				<div class="col-lg-12 col-md-12">
                    <div class="card">
                        <div class="body project_report">
						<button type='button' class='btn btn-primary' data-toggle='modal' data-target='#addnote'><i class='icon-plus'></i> New machine</button><br><br>
                            <div class="table-responsive">
                                <table class="table table-hover js-basic-example dataTable table-custom m-b-0">
                                    <thead>
                                        <tr>                                            
                                            <th>No.</th>
                                            <th>machine Name</th>
                                            <th>machine Category</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php
									$t = mysqli_query($conn, "select *from tmesin");
									while($r = mysqli_fetch_array($t)){
									?>
                                        <tr>
											<td width='7%'><?php echo "MSN".$r[idMesin]; ?></td>
                                            <td class="project-title">
                                                <h6><?php echo $r[namaMesin]; ?></h6>
                                            </td>
                                            <td class="project-title">
                                                <h6><?php echo $r[kategori]; ?></h6>
                                            </td>
											<td class="project-actions" width='10%'>
                                                <?php echo "
												<a href='#edit_modal' title='Klik for updating' data-toggle='modal' data-id='$r[idMesin]' class='btn btn-sm btn-outline-success'  ><i class='icon-pencil'></i></a>";
                                                ?>
											<a href='<?php echo "$aksi?p=machines&act=delete&id=$r[idMesin]";?>' class='btn btn-sm btn-outline-danger' onclick="return confirm('Are you sure to delete this data?');"><i class='icon-trash'></i></a>
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
                <h4 class='title' id='defaultModalLabel'>Add machine</h4>
				<small>Add New Machine*</small>
            </div>
            <div class='modal-body'>
                <div class='comment-form'>
                    <form id='basic-form' class='row clearfix' method='POST' action='$aksi?p=machines&act=input'>
                        <div class='col-sm-12'>
                            <div class='form-group'>
							<label>machine Name*</label>
                                <input type='text' class='form-control' name='mesin_nm' placeholder='Enter machine Name' required>
                            </div>
                            <div class='form-group'>
							<label>machine Category*</label>
                                <input type='text' class='form-control' name='mesin_cat' placeholder='Enter machine Category (ex. : MTC / UMUM / PGA)' required>
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
                <h4 class='title' id='defaultModalLabel'>Edit machine</h4>
				<small>Edit machines*</small>
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
                url : 'modul/master/machine/detail.php',
                data :  'idx='+ idx,
                success : function(data){
                $('.hasil-data').html(data);//menampilkan data ke dalam modal
                }
            });
         });
    });
  </script>
