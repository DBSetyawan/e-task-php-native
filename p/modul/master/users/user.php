<?php
error_reporting(0);
session_start(); 
$m = date(m);$d = date(d);$y = date(Y);
$aksi="modul/master/users/act_user.php";
?>
<div class='container-fluid'>
			<div class='block-header'>
                <div class='row'>
                    <div class='col-lg-5 col-md-8 col-sm-12'>                        
                        <h2><a href='javascript:void(0);' class='btn btn-xs btn-link btn-toggle-fullwidth'><i class='fa fa-arrow-left'></i></a> Master User</h2>
                        <ul class='breadcrumb'>
                            <li class='breadcrumb-item'><a href='?p=dashboard'><i class='icon-home'></i></a></li>                            
                            <li class='breadcrumb-item'>Master</li>
                            <li class='breadcrumb-item active'>Master User</li>
                        </ul>
                    </div>         
                </div>
            </div>
            <div class='row clearfix'>
				<div class="col-lg-12 col-md-12">
                    <div class="card">
                        <div class="body project_report">
						<button type='button' class='btn btn-primary' data-toggle='modal' data-target='#addnote'><i class='icon-plus'></i> New User</button><br><br>
                            <div class="table-responsive">
                                <table class="table table-hover js-basic-example dataTable table-custom m-b-0">
                                    <thead>
                                        <tr>                  
											<th>No.</th>
                                            <th>Full Name</th>
                                            <th>Username</th>
                                            <th>Department</th>
                                            <th>Field</th>
											<th>Photo</th>
                                            <th>Level</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php
							$l = mysqli_fetch_array(mysqli_query($conn,"select *from user where username = '$_SESSION[username]'"));
							if($l[divisi]=='PREPRESS' || $l[divisi]=='PPIC'){
								$r2 = mysqli_query($conn, "SELECT * FROM user u left join tdepartment d on u.id_dep=d.id_dep
											left join tfield f on u.id_field=f.id_field where u.divisi IN ('PREPRESS','PPIC') order by iduser desc");
							}
							else if($l[divisi]=='EDP'){
								$r2 = mysqli_query($conn, "SELECT * FROM user u left join tdepartment d on u.id_dep=d.id_dep
											left join tfield f on u.id_field=f.id_field order by iduser desc");
							}
							else{
									$r2 = mysqli_query($conn, "SELECT * FROM user u left join tdepartment d on u.id_dep=d.id_dep
											left join tfield f on u.id_field=f.id_field order by iduser desc");
							}
								while($r = mysqli_fetch_array($r2)){
									$i=1;
									?>
                                        <tr>
											<td><?php echo "USR".$r[iduser]; ?></td>
                                            <td class="project-title">
                                                <h6><?php echo $r[fullname]; ?></h6>
                                            </td>
                                            <td><?php echo $r[username]; ?></td>
											<td><?php echo $r[nama_dep]; ?></td>
                                            <td><?php echo $r[nama_field]; ?></td>
                                            <td><img src="modul/master/users/photo/no_image.jpg" data-toggle="tooltip" data-placement="top" title="Team Lead" alt="Avatar" class="width35 rounded"></td>
                                            <td>
											<?php
											if($r[level]=='admin'){
												echo "<span class='badge badge-danger'>";
											}else{
												echo "<span class='badge badge-info'>";
											}
											?><?php echo $r[level]; ?></span></td>
                                            <td class="project-actions">
                                                <?php echo "
												<a href='#edit_modal' title='Klik for updating' data-toggle='modal' data-id='$r[iduser]' class='btn btn-sm btn-outline-success'  ><i class='icon-pencil'></i></a>";
                                                ?>
											<a href='<?php echo "$aksi?p=users&act=delete&id=$r[iduser]";?>' class='btn btn-sm btn-outline-danger' onclick="return confirm('Are you sure to delete this data?');"><i class='icon-trash'></i></a>
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
                <h4 class='title' id='defaultModalLabel'>Add User</h4>
				<small>Add New User*</small>
            </div>
            <div class='modal-body'>
                <div class='comment-form'>
                    <form id='basic-form' class='row clearfix' method='POST' action='$aksi?p=users&act=input'>
                        <div class='col-sm-12'>
                            <div class='form-group'>
							<label>Fullname*</label>
                                <input type='text' class='form-control' name='fullname' placeholder='Enter Fullname' required>
                            </div>
                        </div>
						<div class='col-sm-6'>
                            <div class='form-group'>
							<label>Username</label>
                                <input type='text' class='form-control' name='username2' placeholder='Enter Username' required>
                            </div>
                        </div>
						<div class='col-sm-6'>
                            <div class='form-group'>
							<label>Password</label>
                                <input type='text' class='form-control' name='password' placeholder='Enter Password' required>
                            </div>
                        </div>
						<div class='col-sm-12'>
                            <div class='form-group'>
							<label>Email*</label>
                                <input type='email' class='form-control' name='email' placeholder='Enter Email' required>
                            </div>
                        </div>
						<div class='col-sm-6'>
                            <div class='form-group'>
							<label>Department</label><br>
                                <select name='department' class='form-control'>
                                        <option>--Select Department--</option>";
										$t = mysqli_query($conn,"select *from tdepartment order by id_dep desc");
										while($row = mysqli_fetch_array($t)){
											echo "<option value='$row[id_dep]'>$row[nama_dep]</option>";
										}
                                    echo "</select>
                            </div>
                        </div>
						<div class='col-sm-6'>
                            <div class='form-group'>
							<label>Field</label><br>
                                <select name='field' class='form-control'>
                                        <option>--Select Field--</option>";
										$t2 = mysqli_query($conn,"select *from tfield order by id_field desc");
										while($r2 = mysqli_fetch_array($t2)){
											echo "<option value='$r2[id_field]'>$r2[nama_field]</option>";
										}
                                    echo "</select>
                            </div>
                        </div>
						<div class='col-sm-6'>
                            <div class='form-group'>
							<label>Level</label><br>
								<label class='fancy-radio custom-color-green'><input name='level' value='superadmin' type='radio'><span><i></i>Super Admin</span></label>
                                <label class='fancy-radio custom-color-green'><input name='level' value='admin' type='radio'><span><i></i>Admin</span></label>
                                <label class='fancy-radio custom-color-green'><input name='level' value='user' type='radio'><span><i></i>User</span></label>
								<label class='fancy-radio custom-color-green'><input name='level' value='user_sparepart' type='radio'><span><i></i>User Sparepart</span></label>
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
        <div class='modal-content'>
            <div class='modal-header'>
                <h4 class='title' id='defaultModalLabel'>Edit User</h4>
				<small>Edit User*</small>
            </div>
            <div class='modal-body'>
                <div class='comment-form'>
                   <div class='hasil-data'></div>
			
		</div>
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
                url : 'modul/master/users/detail.php',
                data :  'idx='+ idx,
                success : function(data){
                $('.hasil-data').html(data);//menampilkan data ke dalam modal
                }
            });
         });
    });
  </script>
