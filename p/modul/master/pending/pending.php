<?php
//error_reporting(1);
session_start(); 
$m = date('m');$d = date('d');$y = date('Y');
$aksi="modul/master/pending/act_masterpending.php";
?>
<div class='container-fluid'>
			<div class='block-header'>
                <div class='row'>
                    <div class='col-lg-5 col-md-8 col-sm-12'>                        
                        <h2><a href='javascript:void(0);' class='btn btn-xs btn-link btn-toggle-fullwidth'><i class='fa fa-arrow-left'></i></a> Master Pending</h2>
                        <ul class='breadcrumb'>
                            <li class='breadcrumb-item'><a href='?p=dashboard'><i class='icon-home'></i></a></li>                            
                            <li class='breadcrumb-item'>Master</li>
                            <li class='breadcrumb-item active'>Master Pending</li>
                        </ul>
                    </div>         
                </div>
            </div>
            <div class='row clearfix'>
				

                <div class="col-lg-12 col-md-12">
                    <div class="card">
                        <div class="body project_report">
						<button type='button' class='btn btn-primary' data-toggle='modal' data-target='#addnote2'><i class='icon-plus'></i> New User Pending</button><br><br>
                            <div class="table-responsive">
                                <table class="table table-hover js-basic-example dataTable table-custom m-b-0">
                                    <thead>
                                        <tr>                  
											<th>No.</th>
                                            <th>User</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php
                                    $r2 = mysqli_query($conn, "SELECT *from mpending m left join user u on m.User=u.username order by idPending DESC");
									while($r = mysqli_fetch_array($r2)){
									$i=1;
									?>
                                        <tr>
											<td>PDG-<?php echo $r[idPending]; ?></td>
                                             <td><?php echo $r[fullname]; ?></td>
                                            <td class="project-actions">
											<a href='<?php echo "$aksi?p=masterpending&act=deletepending&id=$r[idPending]";?>' class='btn btn-sm btn-outline-danger' onclick="return confirm('Are you sure to delete this data?');"><i class='icon-trash'></i></a>
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

<div class='modal animated fadeIn' id='addnote2' tabindex='-1' role='dialog'>
	<div class='modal-dialog' role='document'>
        <div class='modal-content'>
            <div class='modal-header'>
                <h4 class='title' id='defaultModalLabel'>Add User Pending</h4>
				<small>Add User*</small>
            </div>
            <div class='modal-body'>
                <div class='comment-form'>
                    <form id='basic-form' class='row clearfix' method='POST' action='$aksi?p=masterpending&act=inputuser'>
                       <div class='col-sm-6'>
                            <div class='form-group'>
                            <label>Pegawai :</label><br>
                                <select name='namauser' class = 'form-control'>
                                    <option selected disabled>--select user---</option>
                                    ";
                                    $query = mysqli_query($conn, "SELECT * FROM `user` ");
                                    while($data = mysqli_fetch_assoc($query))
                                    {
                                        echo"<option value='$data[username]'>$data[fullname]</option>";
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
?>
<script src="modul/master/users/jquery-3.1.1.min.js"></script>
