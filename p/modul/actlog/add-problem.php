<?php
 error_reporting(0);
session_start(); 
$m = date(m);$d = date(d);$y = date(Y);
$aksi="modul/actlog/act_log.php";
$dated = date('Y-m-d');

echo"
<div class='block-header'>
                <div class='row'>
                    <div class='col-lg-5 col-md-8 col-sm-12'>                        
                        <h2><a href='javascript:void(0);' class='btn btn-xs btn-link btn-toggle-fullwidth'><i class='fa fa-arrow-left'></i></a> Add New Problem</h2>
                        <ul class='breadcrumb'>
                            <li class='breadcrumb-item'><a href='?p=dashboard'><i class='icon-home'></i></a></li>                            
                            <li class='breadcrumb-item'>Log Book</li>
                            <li class='breadcrumb-item active'>New Problem</li>
                        </ul>
                    </div>         
                </div>
            </div>
            <div class='row clearfix'>
				<div class='col-lg-4 col-md-4 col-sm-4'>
                    <div class='card'>
                        <div class='body'>
                            <div class='row clearfix'>                               
                                <div class='col-sm-12'>";
										$dated = date('Y-m-d');
										$t = mysql_fetch_array(mysql_query("select max(idprob) as no , dateprob from tproblems where dateprob='$dated' "));
										$noUrut = (int) substr($t[no], 13, 3);
										$noUrut++;
										$char = "LBK-$y$m$d-";
										$newID = $char . sprintf("%03s", $noUrut);
                                    
									echo "<table border='0' width='100%'>
										<p align='right'><font color=red><b>$newID</b></font></p>";    
										$date = date('Y-m-d');
											date_default_timezone_set('Asia/Jakarta');
											$time = date('H:i:s');
										echo "<tr><td>Log Date: </td><td><input type='text' class='form-control' value='".tgl_indo($date)."' readonly=readonly>
											<input type='hidden' name='date' value='$date'><input type='hidden' name='time' value='$time'></td>";
										echo "	
											</tr>
						
											<tr><td colspan='2'></td></tr><tr><td colspan='2'></td></tr><tr><td colspan='2'></td></tr>
											<tr><td colspan='2'></td></tr><tr><td colspan='2'></td></tr><tr><td colspan='2'></td></tr><tr><td colspan='2'></td></tr>
											<tr><td>Related Document: </td><td>
											<form method='POST' action='$aksi?p=new-post&act=doc'  >
												<table>
													<tr><td><input type='number' name='j' value='$_GET[j]' class='form-control' placeholder='0'></td>
														<td align='right'><button type='submit' class='btn btn-info'><i class='icon-plus'></i><i/button></td>
													</tr>
												</table>
											</form>
											</td></tr>
											<tr><td></td><td align='right'></td></tr><tr><td></td><td align='right'></td></tr><tr><td></td><td align='right'></td></tr>
											<tr><td></td><td align='right'></td></tr><tr><td></td><td align='right'></td></tr><tr><td></td><td align='right'></td></tr>
											
											<form method='POST' action='$aksi?p=new-post&act=input&j=$_GET[j]' enctype='multipart/form-data'>";
											$j=$_GET[j];
											for($i=1;$i<=$j;$i++){
												echo "<tr><td width='5%' align='right'></td><td><input type='text' name='nodoc[$i]' class='form-control' placeholder='Document $i'></td></tr>";
											}
											echo"</table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>";
			$dated = date('Y-m-d');
						$t = mysql_fetch_array(mysql_query("select max(idprob) as no , dateprob from tproblems where dateprob='$dated' "));
										$noUrut = (int) substr($t[no], 13, 3);
										$noUrut++;
										$char = "LBK-$y$m$d-";
										$newID = $char . sprintf("%03s", $noUrut);
						echo "
						<input type='hidden' name='kodeprob' value='$newID'>
						<input type='hidden' name='date' value='$date'><input type='hidden' name='time' value='$time'>
						<input type='hidden' name='c_at' value='$date'><input type='hidden' name='c_by' value='$_SESSION[username]'>
						<input type='hidden' name='u_by' value='$_SESSION[username]'>";
			echo"
                <div class='col-lg-8 col-md-8 col-sm-8'>
                    <div class='card'>
                        <div class='body'>
                            <div class='row clearfix'>                               
                                <div class='col-sm-12'>
									<div class='form-group'>
									<label>Title:</label>
										<input type='text' class='form-control' name='judul' placeholder='Enter Problem Title'  required/>
									</div>
									<div class='form-group'>
									<label>Category:</label>
										<select class='form-control show-tick' name='idcat' required>
											<option>---Select Category---</option>";
												$cat = showCategory();
												foreach($cat as $c){
													echo "<option value='$c[idcat]'>$c[category_name]</option>";
												}
											echo "
										</select>
									</div>
									<div class='form-group'>
										<input type='radio' name='privat' value = 'Private'> Private &nbsp;&nbsp;
										<input type='radio' name='privat' value = 'Public'> Public
									</div>
									<label>Description:</label>
                                    <textarea class='summernote' name='des' required>
                                        
                                    </textarea>
									<div class='form-group'>
									<label>Attachment:</label>
										<input type='file' name='fupload[]' class='form-control' multiple='multiple'>
									</div>
                                </div>
                                <div class='col-sm-12'>
                                    <div class='mt-4'>
                                        <button type='submit' class='btn btn-block btn-primary m-t-20'>Post</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
				</form>
            </div>
        </div>
    </div>
    
</div>";
?>


