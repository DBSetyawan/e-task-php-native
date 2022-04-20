<?php
//error_reporting(1);
session_start(); 
$m = date('m');$d = date('d');$y = date('Y');
$aksi="modul/master/shift/act_mastershift.php";
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
						<button type='button' class='btn btn-primary' data-toggle='modal' data-target='#addnote'><i class='icon-plus'></i> New Shift</button><br><br>
                            <div class="table-responsive">
                                <table class="table table-hover js-basic-example dataTable table-custom m-b-0">
                                    <thead>
                                        <tr>                  
											<th>No.</th>
                                            <th>Shit Name</th>
                                            <th>Mulai</th>
                                            <th>Berakhir</th>
											<th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php
									$r2 = mysqli_query($conn, "SELECT * FROM mshift");
									while($r = mysqli_fetch_array($r2)){
									$i=1;
									?>
                                        <tr>
											<td><?php echo $r[idShift]; ?></td>
                                            <td><?php echo $r[namaShift]; ?></td>
                                            <td><?php echo $r[jamMulaiShift]; ?></td>
                                            <td><?php echo $r[jamAkhirShift]; ?></td>
											<td><?php echo $r[Status]; ?></td>
                                            <td class="project-actions">
                                                <?php echo "
												<a href='#edit_modal' title='Klik for updating' data-toggle='modal' data-id='$r[idShift]' class='btn btn-sm btn-outline-success'  ><i class='icon-pencil'></i></a>";
                                                ?>
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
						<button type='button' class='btn btn-primary' data-toggle='modal' data-target='#addnote2'><i class='icon-plus'></i> New User Shift</button><br><br>
                            <div class="table-responsive">
                                <table class="table table-hover js-basic-example dataTable table-custom m-b-0">
                                    <thead>
                                        <tr>                  
											<th>No.</th>
                                            <th>User Name</th>
                                            <th>Shift Name</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php
                                    $r2 = mysqli_query($conn, "SELECT us.* , s.* , u.* FROM tusershift us left join mshift s on s.idShift = us.idShift 
                                                                                            left join user u on u.iduser = us.idUser");
									while($r = mysqli_fetch_array($r2)){
									$i=1;
									?>
                                        <tr>
											<td><?php echo $r[idUserShift]; ?></td>
                                             <td><?php echo $r[fullname]; ?></td>
											<td><?php echo $r[namaShift]; ?></td>
                                            <td class="project-actions">
                                                <?php echo "
												<a href='#edit_modal2' title='Klik for updating' data-toggle='modal' data-id='$r[idUserShift]' class='btn btn-sm btn-outline-success'  ><i class='icon-pencil'></i></a>";
                                                ?>
											<a href='<?php echo "$aksi?p=mastershift&act=deleteuser&id=$r[idUserShift]";?>' class='btn btn-sm btn-outline-danger' onclick="return confirm('Are you sure to delete this data?');"><i class='icon-trash'></i></a>
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
                    <form id='basic-form' class='row clearfix' method='POST' action='$aksi?p=mastershift&act=inputshift'>
                       <div class='col-sm-6'>
                            <div class='form-group'>
							<label>Shft :</label><br>
                                <input name='namashift' class ='from-control' type='text'>
                            </div>
                        </div>
						<div class='col-sm-6'>
                            <div class='form-group'>
							<label>Mulai :</label><br>
                                <input name='mulai1' class ='from-control' type='number' min='0' max='23' placeholder='23'>
                                <input name='mulai2' class ='from-control' type='number' min='0' max='59' placeholder='00'>
                            </div>
                        </div>
                        <div class='col-sm-6'>
                            <div class='form-group'>
							<label>Berakhir :</label><br>
                            <input name='akhir1' class ='from-control' type='number' min='0' max='23' placeholder='23'>
                            <input name='akhir2' class ='from-control' type='number' min='0' max='59' placeholder='00'>
                            </div>
                        </div>
						<div class='col-sm-6'>
                            <div class='form-group'>
							<label>Status :</label><br>
                            <input name='status' type='radio'  value='Aktif'> Aktif &nbsp;&nbsp;&nbsp;
                            <input name='status' type='radio'  value='Non Aktif'> Non Aktif
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
                    <form id='basic-form' class='row clearfix' method='POST' action='$aksi?p=mastershift&act=inputuser'>
                       <div class='col-sm-6'>
                            <div class='form-group'>
                            <label>Pegawai :</label><br>
                                <select name='namauser' class = 'form-control'>
                                    <option selected disabled>--select user---</option>
                                    ";
                                    $query = mysqli_query($conn, "SELECT * FROM `user` WHERE divisi = 'MAINTENANCE' ");
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
                                <select name='namashift' class = 'form-control'>
                                    <option selected disabled>--select user---</option>
                                    ";
                                    $query = mysqli_query($conn, "SELECT * FROM mshift ");
                                    while($data = mysqli_fetch_assoc($query))
                                    {
                                        echo"<option value='$data[idShift]'>$data[namaShift]</option>";
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
    <form method='POST' action='$aksi?p=mastershift&act=updateshift'>
        <div class='modal-content'>
            <div class='modal-header'>
                <h4 class='title' id='defaultModalLabel'>Edit Shift</h4>
				
            </div>
            <div class='modal-body'>
                <div class='comment-form'>
                <input name='id' id='idshift' class='form-control' readonly='true'>
                    <div class='form-group'>
                        <label>Nama</label>
                        <input name='namashift' id='namashift' class='form-control'>
                    </div>
                    
                    <div class='form-group'>
                        <label>Mulai</label>
                        <div class='col-sm-6'>
                            <input name='mulai1' id='mulai1' class='form-control' type = 'number'>
                            <input name='mulai2' id='mulai2' class='form-control' type = 'number'>
                        </div>
                    </div>
                    
                    <div class='form-group'>
                        <label>Akhir</label>
                        <div class='col-sm-6'>
                            <input name='akhir1' id='akhir1' class='form-control' type = 'number'>
                            <input name='akhir2' id='akhir2' class='form-control' type = 'number'>
                        </div>
                    </div>
                    <div class='col-sm-6'>
                            <div class='form-group'>
							<label>Status :</label><br>
                            <input name='status' type='radio'  id='status' value='Aktif'> Aktif &nbsp;&nbsp;&nbsp;
                            <input name='status' type='radio' id='status' value='Non Aktif'> Non Aktif
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
    <form method='POST' action='$aksi?p=mastershift&act=updateuser'>
        <div class='modal-content'>
            <div class='modal-header'>
                <h4 class='title' id='defaultModalLabel'>Edit User Shift</h4>
				
            </div>
            <div class='modal-body'>
                <div class='comment-form'>
                <input name='id' id='idusershift' class='form-control' readonly='true'>
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
                        <select name='namashift' id='shift' class='form-control' >
                        ";
                        $query = mysqli_query($conn, "SELECT * FROM mshift ");
                        while($data = mysqli_fetch_assoc($query))
                        {
                            echo"<option value='$data[idShift]'>$data[namaShift]</option>";
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
                url : 'modul/master/shift/act_mastershift.php?p=mastershift&act=getdata',
                data :  'id='+ idx,
                success : function(data){
                    $("#idshift").val(data[0].idShift);
                    $("#namashift").val(data[0].namaShift);
                    $("#mulai1").val(data[0].jamMulaiShift.slice(0,2));
                    $("#mulai2").val(data[0].jamMulaiShift.slice(3,6));
                    $("#akhir1").val(data[0].jamAkhirShift.slice(0,2));
                    $("#akhir2").val(data[0].jamAkhirShift.slice(3,6));
					$("status").val(data[0].status.checked);
                }
            });
         });


         $('#edit_modal2').on('show.bs.modal', function (e) {
            var idx = $(e.relatedTarget).data('id');
            //menggunakan fungsi ajax untuk pengambilan data
            $.ajax({
                type : 'post',
                url : 'modul/master/shift/act_mastershift.php?p=mastershift&act=getdatauser',
                data :  'id='+ idx,
                success : function(data){
                    $("#idusershift").val(data[0].idUserShift);
                    $("#iduser").val(data[0].idUser);
                    $("#shift").val(data[0].idShift);
                }
            });
         });
    });
  </script>
  <script>
  document.querySelectorAll('input[type=number]')
  .forEach(e => e.oninput = () => {
    // Always 2 digits
    if (e.value.length >= 2) e.value = e.value.slice(0, 2);
    // 0 on the left (doesn't work on FF)
    if (e.value.length === 1) e.value = '0' + e.value;
    // Avoiding letters on FF
    if (!e.value) e.value = '00';
  });
  </script>
