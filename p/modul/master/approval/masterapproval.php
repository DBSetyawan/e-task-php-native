<?php
//error_reporting(1);
session_start(); 
$m = date('m');$d = date('d');$y = date('Y');
$aksi="modul/master/approval/act_masterapproval.php";
?>
<div class='container-fluid'>
			<div class='block-header'>
                <div class='row'>
                    <div class='col-lg-5 col-md-8 col-sm-12'>                        
                        <h2><a href='javascript:void(0);' class='btn btn-xs btn-link btn-toggle-fullwidth'><i class='fa fa-arrow-left'></i></a> Master Approval</h2>
                        <ul class='breadcrumb'>
                            <li class='breadcrumb-item'><a href='?p=dashboard'><i class='icon-home'></i></a></li>                            
                            <li class='breadcrumb-item'>Master</li>
                            <li class='breadcrumb-item active'>Master Approval</li>
                        </ul>
                    </div>         
                </div>
            </div>
            <div class='row clearfix'>
				<div class="col-lg-12 col-md-12">
                    <div class="card">
                        <div class="body project_report">
						<button type='button' class='btn btn-primary' data-toggle='modal' data-target='#addnote'><i class='icon-plus'></i> New Approval</button><br><br>
                            <div class="table-responsive">
                                <table class="table table-hover js-basic-example dataTable table-custom m-b-0">
                                    <thead>
                                        <tr>                  
											<th>No.</th>
                                            <th>Type Approval</th>
                                            <th>Description</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php
									$r2 = mysqli_query($conn, "SELECT * FROM mapproval");
									while($r = mysqli_fetch_array($r2)){
									$i=1;
									?>
                                        <tr>
											<td><?php echo $r[idApproval]; ?></td>
                                            <td><?php echo $r[type]; ?></td>
                                            <td><?php echo $r[description]; ?></td>
                                            <td class="project-actions">
                                                <?php echo "
												<a href='#edit_modal' title='Klik for updating' data-toggle='modal' data-id='$r[idApproval]' class='btn btn-sm btn-outline-success'  ><i class='icon-pencil'></i></a>";
                                                ?>
											<a href='<?php echo "$aksi?p=masterapproval&act=deleteapproval&id=$r[idApproval]";?>' class='btn btn-sm btn-outline-danger' onclick="return confirm('Are you sure to delete this data?');"><i class='icon-trash'></i></a>
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

                <div class="col-lg-12 col-md-12">
                    <div class="card">
                        <div class="body project_report">
						<button type='button' class='btn btn-primary' data-toggle='modal' data-target='#addnote2'><i class='icon-plus'></i> New User Approval</button><br><br>
                            <div class="table-responsive">
                                <table class="table table-hover js-basic-example dataTable table-custom m-b-0">
                                    <thead>
                                        <tr>                  
											<th>No.</th>
                                            <th>User Name</th>
                                            <th>Type Approval</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php
                                    $r2 = mysqli_query($conn, "SELECT ua.* , a.* , u.* FROM tuserapproval ua left join mapproval a on a.idApproval = ua.idApproval 
                                                                                            left join user u on u.iduser = ua.idUser");
									while($r = mysqli_fetch_array($r2)){
									$i=1;
									?>
                                        <tr>
											<td><?php echo $r[idUserApproval]; ?></td>
                                             <td><?php echo $r[fullname]; ?></td>
											<td><?php echo $r[type]; ?></td>
                                            <td class="project-actions">
                                                <?php echo "
												<a href='#edit_modal2' title='Klik for updating' data-toggle='modal' data-id='$r[idUserApproval]' class='btn btn-sm btn-outline-success'  ><i class='icon-pencil'></i></a>";
                                                ?>
											<a href='<?php echo "$aksi?p=masterapproval&act=deleteuser&id=$r[idUserApproval]";?>' class='btn btn-sm btn-outline-danger' onclick="return confirm('Are you sure to delete this data?');"><i class='icon-trash'></i></a>
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
<div class='modal animated fadeIn' id='addnote' tabindex='-1' role='dialog'>
	<div class='modal-dialog' role='document'>
        <div class='modal-content'>
            <div class='modal-header'>
                <h4 class='title' id='defaultModalLabel'>Add Unit</h4>
				<small>Add Unit*</small>
            </div>
            <div class='modal-body'>
                <div class='comment-form'>
                    <form id='basic-form' class='row clearfix' method='POST' action='$aksi?p=masterapproval&act=inputapproval'>
                       <div class='col-sm-6'>
                            <div class='form-group'>
							<label>Type :</label><br>
                                <input name='type' class ='from-control' type='text'>
                            </div>
                        </div>
                        <div class='col-sm-6'>
                            <div class='form-group'>
							<label>Deskripsi :</label><br>
                                <textarea name='description' class ='from-control' ></textarea>
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

<div class='modal animated fadeIn' id='addnote2' tabindex='-1' role='dialog'>
	<div class='modal-dialog' role='document'>
        <div class='modal-content'>
            <div class='modal-header'>
                <h4 class='title' id='defaultModalLabel'>Add Unit</h4>
				<small>Add Unit*</small>
            </div>
            <div class='modal-body'>
                <div class='comment-form'>
                    <form id='basic-form' class='row clearfix' method='POST' action='$aksi?p=masterapproval&act=inputuser'>
                       <div class='col-sm-6'>
                            <div class='form-group'>
                            <label>Pegawai :</label><br>
                                <select name='namauser' class = 'form-control'>
                                    <option selected disabled>--select user---</option>
                                    ";
                                    $query = mysqli_query($conn, "SELECT * FROM `user`");
                                    while($data = mysqli_fetch_assoc($query))
                                    {
                                        echo"<option value='$data[iduser]'>$data[fullname]</option>";
                                    }
                                    echo"
                                </select>
                            </div>
                        </div>
                        <div class='col-sm-6'>
                            <div class='form-group'>
                            <label>Shift :</label><br>
                                <select name='idapproval' class = 'form-control'>
                                    <option selected disabled>--select user---</option>
                                    ";
                                    $query = mysqli_query($conn, "SELECT * FROM mApproval ");
                                    while($data = mysqli_fetch_assoc($query))
                                    {
                                        echo"<option value='$data[idApproval]'>$data[type]</option>";
                                    }
                                    echo"
                                </select>
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
</div>";
		
echo "
<div class='modal animated fadeIn' id='edit_modal' tabindex='-1' role='dialog'>
    <div class='modal-dialog' role='document'>
    <form method='POST' action='$aksi?p=masterapproval&act=updateapproval'>
        <div class='modal-content'>
            <div class='modal-header'>
                <h4 class='title' id='defaultModalLabel'>Edit Approval</h4>
				
            </div>
            <div class='modal-body'>
                <div class='comment-form'>
                <input name='id' id='idapproval' class='form-control' readonly='true'>
                    <div class='form-group'>
                        <label>Nama</label>
                        <input name='type' id='type' class='form-control'>
                    </div>
                    <div class='col-sm-6'>
                        <div class='form-group'>
						<label>Deskripsi :</label><br>
                            <textarea name='description' id= 'description' class ='from-control' ></textarea>
                        </div>
                    </div>
                    
                    
                </div>
            </div>
            <div class='modal-footer'>
                <button type='submit' class='btn btn-warning'>Update</button>
                <button type='button' class='btn btn-outline-secondary' data-dismiss='modal'>CLOSE</button>
            </div>   
        </div>
        </form>
    </div>
</div>

<div class='modal animated fadeIn' id='edit_modal2' tabindex='-1' role='dialog'>
    <div class='modal-dialog' role='document'>
    <form method='POST' action='$aksi?p=masterapproval&act=updateuser'>
        <div class='modal-content'>
            <div class='modal-header'>
                <h4 class='title' id='defaultModalLabel'>Edit User Approval</h4>
				
            </div>
            <div class='modal-body'>
                <div class='comment-form'>
                <input name='id' id='iduserapproval' class='form-control' readonly='true'>
                    <div class='form-group'>
                        <label>Pegawai</label>
                        <select name='namauser' id='iduser' class='form-control' >
                        ";
                        $query = mysqli_query($conn, "SELECT * FROM `user` WHERE divisi = 'MAINTENANCE' ");
                        while($data = mysqli_fetch_assoc($query))
                        {
                            echo"<option value='$data[iduser]'>$data[fullname]</option>";
                        }
                        echo"
                        </select>
                    </div>
                    <div class='form-group'>
                        <label>Shift</label>
                        <select name='idapproval' id='approval' class='form-control' >
                        ";
                        $query = mysqli_query($conn, "SELECT * FROM mApproval ");
                        while($data = mysqli_fetch_assoc($query))
                        {
                            echo"<option value='$data[idApproval]'>$data[type]</option>";
                        }
                        echo"
                        </select>
                    </div>
                    
                </div>
                <div class='modal-footer'>
                    <button type='submit' class='btn btn-warning'>Update</button>
                    <button type='button' class='btn btn-outline-secondary' data-dismiss='modal'>CLOSE</button>
                </div>   
            </div>
        </div>
        </form>
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
                url : 'modul/master/approval/act_masterapproval.php?p=masterapproval&act=getdata',
                data :  'id='+ idx,
                success : function(data){
                    $("#idapproval").val(data[0].idApproval);
                    $("#type").val(data[0].type);
                    $("#description").val(data[0].description);
                }
            });
         });


         $('#edit_modal2').on('show.bs.modal', function (e) {
            var idx = $(e.relatedTarget).data('id');
            //menggunakan fungsi ajax untuk pengambilan data
            $.ajax({
                type : 'post',
                url : 'modul/master/approval/act_masterapproval.php?p=masterapproval&act=getdatauser',
                data :  'id='+ idx,
                success : function(data){
                    $("#iduserapproval").val(data[0].idUserApproval);
                    $("#iduser").val(data[0].idUser);
                    $("#approval").val(data[0].idApproval);
                }
            });
         });
    });
  </script>
  
