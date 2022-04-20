<?php
error_reporting(0);
session_start(); 

include('../../../../../config/koneksi.php');
$m = date(m);$d = date(d);$y = date(Y);
$aksi="modul/master/users/act_user.php";
$dated = date('Y-m-d');
$sql = mysqli_query($conn,"SELECT * FROM user WHERE username = '$_SESSION[username]'");
        $r = mysqli_fetch_array($sql);
			echo "
		<div class='container-fluid'>
			<div class='block-header'>
                <div class='row'>
                    <div class='col-lg-5 col-md-8 col-sm-12'>                        
                        <h2><a href='javascript:void(0);' class='btn btn-xs btn-link btn-toggle-fullwidth'><i class='fa fa-arrow-left'></i></a> My Profile</h2>
                        <ul class='breadcrumb'>
                            <li class='breadcrumb-item'><a href='?p=dashboard'><i class='icon-home'></i></a></li>                            
                            <li class='breadcrumb-item'>Profile</li>
                        </ul>
                    </div>         
                </div>
            </div>
			<div class='row clearfix'>
			<div class='col-lg-8 col-md-3'>
			<div class='card'>
                        <div class='header'>
                            <h2>Account</h2>
						</div>
                        <div class='panel panel-inverse' data-sortable-id='form-validation-2'>
            <div class='body project_report'>
			<form method='POST' action='$aksi?p=profile&act=update' class='form-horizontal' data-parsley-validate='true' name='demo-form'>
			<input type='hidden' name='id' value='$r[iduser]'>
								<div class='form-group row m-b-15'>
									<label class='col-md-4 col-sm-4 col-form-label' for='fullname'>FullName*</label>
									<div class='col-md-8 col-sm-8'>
										<input class='form-control' type='text' name='fullname' data-parsley-required='true' value='$r[fullname]'/>
									</div>
								</div>
								<div class='form-group row m-b-15'>
									<label class='col-md-4 col-sm-4 col-form-label' for='website'>Username*</label>
									<div class='col-md-8 col-sm-8'>
										<input class='form-control' type='text' name='username' value='$r[username]' readonly='readonly'/>
									</div>
								</div>
								<div class='form-group row m-b-15'>
									<label class='col-md-4 col-sm-4 col-form-label' for='message'>Old Password*</label>
									<div class='col-md-8 col-sm-8'>
										<input class='form-control' type='password' name='password_o' />
									</div>
								</div>
								<div class='form-group row m-b-15'>
									<label class='col-md-4 col-sm-4 col-form-label' for='message'>New Password*</label>
									<div class='col-md-8 col-sm-8'>
										<input class='form-control' type='password' name='password_n' />
									</div>
								</div>
								<div class='form-group row m-b-15'>
									<label class='col-md-4 col-sm-4 col-form-label' for='message'>Confirm Password*</label>
									<div class='col-md-8 col-sm-8'>
										<input class='form-control' type='password' name='password_c' />
									</div>
								</div>
								<input class='form-control' type='hidden' name='level' value='$r[level]'/>
                            
											<div class='modal-footer'>
											<button type='submit' class='btn btn-yellow'><i class='fa fa-save'></i> Update</button>
											</div>
									</form>
									</div>
                    </div>
                    </div>
				</div>
				<div class='col-lg-4 col-md-3'>
			<div class='card'>
                        <div class='header'>
                            <h2>Photo Profile</h2>
						</div>
                        <div class='panel panel-inverse' data-sortable-id='form-validation-2'>
							<div class='body project_report'>
								<form method='POST' action='$aksi?p=profile&act=uphoto&id=$r[iduser]' enctype='multipart/form-data'>
									<input type='hidden' name='id' value='$r[iduser]'>
									<input type='hidden' name='nm' value='$r[photo]'>
										<div class='form-group row m-b-15'>
											<div class='col-md-12 col-sm-12'>";
											if($r[photo]==''){
												echo "<img width='50%' src='modul/master/users/photo/no_image.jpg' alt='' />";
											}
											else{
												echo "<img width='50%' src='modul/master/users/photo/$r[photo]' alt='' />";
											}
												
											echo"</div>
										</div>
										<div class='form-group row m-b-15'>
											<div class='col-md-12 col-sm-12'>
												<input class='form-control' type='file' name='photo' />
											</div>
										</div>
										<div class='modal-footer'>
											<button type='submit' class='btn btn-yellow'><i class='fa fa-save'></i> Update</button>
										</div>
								</form>
							</div>
						</div>
                    </div>
				</div>
                
			";
			?>
			