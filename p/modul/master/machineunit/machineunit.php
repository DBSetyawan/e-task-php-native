<?php
error_reporting(0);
session_start(); 
$m = date(m);$d = date(d);$y = date(Y);
$aksi="modul/master/machineunit/act_machineunit.php";
?>
<div class='container-fluid'>
			<div class='block-header'>
                <div class='row'>
                    <div class='col-lg-5 col-md-8 col-sm-12'>                        
                        <h2><a href='javascript:void(0);' class='btn btn-xs btn-link btn-toggle-fullwidth'><i class='fa fa-arrow-left'></i></a> Master Machine Unit</h2>
                        <ul class='breadcrumb'>
                            <li class='breadcrumb-item'><a href='?p=dashboard'><i class='icon-home'></i></a></li>                            
                            <li class='breadcrumb-item'>Master</li>
                            <li class='breadcrumb-item active'>Master Machine Unit</li>
                        </ul>
                    </div>         
                </div>
            </div>
            <div class='row clearfix'>
				<div class="col-lg-12 col-md-12">
                    <div class="card">
                        <div class="body project_report">
						<button type='button' class='btn btn-primary' data-toggle='modal' data-target='#addnote'><i class='icon-plus'></i> New Machine Unit</button><br><br>
                            <div class="table-responsive">
                                <table class="table table-hover js-basic-example dataTable table-custom m-b-0">
                                    <thead>
                                        <tr>                  
											<th>No.</th>
                                            <th>Unit Name</th>
                                            <th>Machines</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php
									$r2 = mysqli_query($conn, "SELECT * FROM tmesinunit u left join tmesin m on u.idMesin=m.idMesin order by idUnit Desc");
									while($r = mysqli_fetch_array($r2)){
									$i=1;
									?>
                                        <tr>
											<td><?php echo "UM".$r[idUnit]; ?></td>
                                             <td><?php echo $r[namaUnit]; ?></td>
											<td><?php echo $r[namaMesin]; ?></td>
                                            <td class="project-actions">
                                                <?php echo "
												<a href='#edit_modal' title='Klik for updating' data-toggle='modal' data-id='$r[idUnit]' class='btn btn-sm btn-outline-success'  ><i class='icon-pencil'></i></a>";
                                                ?>
											<a href='<?php echo "$aksi?p=machinesunit&act=delete&id=$r[idUnit]";?>' class='btn btn-sm btn-outline-danger' onclick="return confirm('Are you sure to delete this data?');"><i class='icon-trash'></i></a>
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
                    <form id='basic-form' class='row clearfix' method='POST' action='$aksi?p=machinesunit&act=input'>
                       <div class='col-sm-6'>
                            <div class='form-group'>
							<label>Machine *</label><br>
                                <select name='mesin' class='form-control'>
                                        <option>--Select Machine--</option>";
										$t = mysqli_query($conn,"select *from tmesin order by idMesin desc");
										while($row = mysqli_fetch_array($t)){
											echo "<option value='$row[idMesin]'>$row[namaMesin]</option>";
										}
                                    echo "</select>
                            </div>
                        </div>
						<div class='col-sm-6'>
                            <div class='form-group'>
							<label>Unit Name</label>
                                <input type='text' class='form-control' name='unit_mesin' placeholder='Enter Unit Name' required>
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
                <h4 class='title' id='defaultModalLabel'>Edit Unit</h4>
				<small>Edit Unit*</small>
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
                url : 'modul/master/machineunit/detail.php',
                data :  'idx='+ idx,
                success : function(data){
                $('.hasil-data').html(data);//menampilkan data ke dalam modal
                }
            });
         });
    });
  </script>
