<?php
ob_start ("ob_gzhandler");
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
			include('add-problem.php');
			break;
case "problem-list":
?>
<div class='block-header'>
                <div class='row'>
                    <div class='col-lg-5 col-md-8 col-sm-12'>                        
                        <h2><a href='javascript:void(0);' class='btn btn-xs btn-link btn-toggle-fullwidth'><i class='fa fa-arrow-left'></i></a> Problems List</h2>
                        <ul class='breadcrumb'>
                            <li class='breadcrumb-item'><a href='?p=dashboard'><i class='icon-home'></i></a></li>                            
                            <li class='breadcrumb-item'>Log Book</li>
                            <li class='breadcrumb-item active'>New Problem</li>
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
							<br>";
							if($_SESSION['level']=='superadmin' || $_SESSION['level']=='admin'){
								if($_GET[all]=='y'){
									echo"<a href='?p=new-post&act=problem-list' title='Show Division' class='btn btn-sm btn-primary'>Show Division</a><br><br>";
								}
								else{
									echo"<a href='?p=new-post&act=problem-list&all=y' title='Show All' class='btn btn-sm btn-success'>Show All</a><br><br>";
								}
							}
							else{}
							echo"
                            <div class='table-responsive'>
                                <table class='table table-hover js-basic-example dataTable table-custom'>
                                    <thead>
                                        <tr>
                                            <th width='1%'></th>
											<th align='center'>PROBLEMS</th>
                                            <th width='10%'>TIME</th>
                                        </tr>
                                    </thead>
                                    <tbody>";
									$no=1;
								if($_SESSION['level']=='superadmin' || $_SESSION['level']=='admin'){
									if($_GET[all]=='y'){
										if($_GET[t]=='1'){
											$ro = mysql_query("SELECT a.*,mc.category_name,b.status,c.pic_handling FROM `tproblems` a 
															left join tlaporan b on a.idprob=b.no_pelaporan 
															LEFT JOIN mcategories mc ON a.idcat=mc.idcat 
															left join tassign c on a.idprob=c.no_pelaporan
															where a.idcat='$_GET[id]' AND AND b.status IS NULL order by a.idprob desc");
										}else{
											$ro = mysql_query("SELECT a.*,mc.category_name,b.status,c.pic_handling FROM `tproblems` a 
															left join tlaporan b on a.idprob=b.no_pelaporan 
															LEFT JOIN mcategories mc ON a.idcat=mc.idcat 
															left join tassign c on a.idprob=c.no_pelaporan
															WHERE b.status IS NULL
															order by a.idprob desc");
										}
									}
									else{
										if($_GET[t]=='1'){
											$ro = mysql_query("SELECT a.*,mc.category_name,b.status,c.pic_handling FROM `tproblems` a 
															left join tlaporan b on a.idprob=b.no_pelaporan 
															LEFT JOIN mcategories mc ON a.idcat=mc.idcat 
															left join tassign c on a.idprob=c.no_pelaporan
															where a.idcat='$_GET[id]' and a.divisi_problem='$_SESSION[divisi]' AND b.status IS NULL
															order by a.idprob desc");
										}else{
											$ro = mysql_query("SELECT a.*,mc.category_name,b.status,c.pic_handling FROM `tproblems` a 
															left join tlaporan b on a.idprob=b.no_pelaporan 
															LEFT JOIN mcategories mc ON a.idcat=mc.idcat 
															left join tassign c on a.idprob=c.no_pelaporan
															where a.divisi_problem='$_SESSION[divisi]' AND b.status IS NULL
															order by a.idprob desc");
										}
									}
								}else{
									if($_GET[t]=='1'){
										$ro = mysql_query("SELECT a.*,mc.category_name,b.status,c.pic_handling FROM `tproblems` a 
															left join tlaporan b on a.idprob=b.no_pelaporan 
															LEFT JOIN mcategories mc ON a.idcat=mc.idcat 
															left join tassign c on a.idprob=c.no_pelaporan
															where a.idcat='$_GET[id]' AND a.divisi_problem='$_SESSION[divisi]' AND b.status IS NULL
															order by a.idprob desc");
									}else{
										$ro = mysql_query("SELECT a.*,mc.category_name,b.status,c.pic_handling FROM `tproblems` a 
															left join tlaporan b on a.idprob=b.no_pelaporan 
															LEFT JOIN mcategories mc ON a.idcat=mc.idcat 
															left join tassign c on a.idprob=c.no_pelaporan
															where a.divisi_problem='$_SESSION[divisi]' AND b.status IS NULL
															order by a.idprob desc");
									}
								}
									while($r = mysql_fetch_array($ro)){
										$h = mysql_query("select *from tlampiran where idprob = '$r[idprob]'");
										$i = mysql_num_rows($h);
									echo "
                                        <tr>
											<td><input type='hidden' value='$no'></td>
                                            <td><a href='?p=new-post&act=problem-detail&id=$r[idprob]'><h6><b>$r[judulprob]";
											
											if($r[status]=="O"){
												echo "<span class='badge badge-primary'> OPEN </span>";
											}
											else if ($r[status]=="A"){
												echo "<span class='badge badge-danger'> ASSIGN TO $r[pic_handling] </span>";
											}
											else if ($r[status]=="IN"){
												echo "<span class='badge badge-danger'> IN PROGRESS <i class='fas fa-spinner fa-pulse'></i> </span>";
											}
											else if ($r[status]=="F"){
												echo "<span class='badge badge-success'> FINISHED BY $r[pic_handling]</span>";
											}
											
											if($r[status_del]==""){}
											else {
												echo "<font color='#f68c1f'> [ DELETE !! ] &nbsp;<i class='fas fa-spinner fa-pulse'></i></font>";
											}
											echo"</b></h6></a>
												<div class='col-4'>
														<font color='red'>
														<div>
															<i>
															<i class='fa fa-user'></i> $r[created_by] 
																&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
																&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
															<i class='fa fa-tag'></i> $r[category_name]
																&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
																&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
															if($i > 0){
																echo "<i class='icon-paper-clip'></i> $i";
															}else{}
															echo"
															</i>
														</div>
														</font>                       
												</div>
											</td>
                                            <td>".tgl_indo($r[dateprob])."<br>$r[timeprob]</td>
                                        </tr>";
										$no++;
									}
										
                              echo"      </tbody>
                                </table>
                            </div>
							
                        </div>
						</div></div>
						<div class='col-lg-12'>
                    <div class='card'>
						<div class='body'>
							<div class='table-responsive'>
                                <table class='table table-hover js-basic-example dataTable table-custom'>
                                    <thead>
                                        <tr>
                                            <th width='1%'></th>
											<th align='center'>PROBLEMS</th>
                                            <th width='10%'>TIME</th>
                                        </tr>
                                    </thead>
                                    <tbody>";
									$no=1;
								if($_GET[all]=='y'){
									if($_GET[t]=='1'){
										$ro = mysql_query("SELECT a.*,mc.category_name,b.status,c.pic_handling FROM `tproblems` a 
															left join tlaporan b on a.idprob=b.no_pelaporan 
															LEFT JOIN mcategories mc ON a.idcat=mc.idcat 
															left join tassign c on a.idprob=c.no_pelaporan
													   where a.idcat='$_GET[id]' and b.status IS NOT NULL order by a.idprob desc");
									}else{
										$ro = mysql_query("SELECT a.*,mc.category_name,b.status,c.pic_handling FROM `tproblems` a 
															left join tlaporan b on a.idprob=b.no_pelaporan 
															LEFT JOIN mcategories mc ON a.idcat=mc.idcat 
															left join tassign c on a.idprob=c.no_pelaporan
															WHERE b.status IS NOT NULL
															order by a.idprob desc");
									}
								}else{
									if($_GET[t]=='1'){
										$ro = mysql_query("SELECT a.*,mc.category_name,b.status,c.pic_handling FROM `tproblems` a 
															left join tlaporan b on a.idprob=b.no_pelaporan 
															LEFT JOIN mcategories mc ON a.idcat=mc.idcat 
															left join tassign c on a.idprob=c.no_pelaporan
													   where a.idcat='$_GET[id]', a.divisi_problem='$_SESSION[divisi]' and b.status IS NOT NULL order by a.idprob desc");
									}else{
										$ro = mysql_query("SELECT a.*,mc.category_name,b.status,c.pic_handling FROM `tproblems` a 
															left join tlaporan b on a.idprob=b.no_pelaporan 
															LEFT JOIN mcategories mc ON a.idcat=mc.idcat 
															left join tassign c on a.idprob=c.no_pelaporan
															where a.divisi_problem='$_SESSION[divisi]' and b.status IS NOT NULL
															order by a.idprob desc");
									}
								}
								
									while($r = mysql_fetch_array($ro)){
										$h = mysql_query("select *from tlampiran where idprob = '$r[idprob]'");
										$i = mysql_num_rows($h);
									echo "
                                        <tr>
											<td><input type='hidden' value='$no'></td>
                                            <td><a href='?p=new-post&act=problem-detail&id=$r[idprob]'><h6><b>$r[judulprob]";
											if($r[status]=="O"){
												echo "<span class='badge badge-primary'> OPEN </span>";
											}
											else if ($r[status]=="A"){
												echo "<span class='badge badge-danger'> ASSIGN TO $r[pic_handling] </span>";
											}
											else if ($r[status]=="IN"){
												echo "<span class='badge badge-danger'> IN PROGRESS <i class='fas fa-spinner fa-pulse'></i> </span>";
											}
											else if ($r[status]=="F"){
												echo "<span class='badge badge-success'> FINISHED BY $r[pic_handling]</span>";
											}
											else if($r[status]=="C"){
												echo "<span class='badge badge-default'> CLOSE </span>";
											}
											
											if($r[status_del]==""){}
											else {
												echo "<font color='#f68c1f'> [ DELETE !! ] &nbsp;<i class='fas fa-spinner fa-pulse'></i></font>";
											}
											echo"</b></h6></a>
												<div class='col-4'>
														<font color='red'>
														<div>
															<i>
															<i class='fa fa-user'></i> $r[created_by] 
																&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
																&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
															<i class='fa fa-tag'></i> $r[category_name]
																&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
																&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
															if($i > 0){
																echo "<i class='icon-paper-clip'></i> $i";
															}else{}
															echo"
															</i>
														</div>
														</font>                       
												</div>
											</td>
                                            <td>".tgl_indo($r[dateprob])."<br>$r[timeprob]</td>
                                        </tr>";
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
break;

case "problem-detail":
$date = date('Y-m-d');
	date_default_timezone_set('Asia/Jakarta');
$time = date('H:i:s');
$r = showProblemDetail($_GET[id]);
foreach ($r as $u);
	echo "<div class='container-fluid'>
			<div class='block-header'>
                <div class='row'>
                    <div class='col-lg-5 col-md-8 col-sm-12'>                        
                        <h2><a href='javascript:void(0);' class='btn btn-xs btn-link btn-toggle-fullwidth'><i class='fa fa-arrow-left'></i></a> Problem Details</h2>
                        <ul class='breadcrumb'>
                            <li class='breadcrumb-item'><a href='?p=dashboard'><i class='icon-home'></i></a></li>                            
                            <li class='breadcrumb-item'>Log Book</li>
                            <li class='breadcrumb-item active'>New Problem</li>
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
								$w = mysql_query("select *from tproblemnote where idprob = '$_GET[id]' order by idnote asc");
								while($h = mysql_fetch_array($w)){
									$lu = mysql_fetch_array(mysql_query("select *from user where username = '$h[created_by]'"));
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
							if($_SESSION[level]=='user')
							{
								$n = mysql_query("select *from tproblemnote where idprob = '$_GET[id]'");
								$not = mysql_num_rows($n);
								if($u[created_by]==$_SESSION[username]){
									echo "<tr><td colspan='2' align='right'><br>";
									$p = mysql_query("select *from tproblems where idprob = '$_GET[id]'");
									$nt = mysql_fetch_array($p);
									if($nt[status_del]=='Delete'){
										echo "<h6><font color='red'><u>ASK TO DELETE !!</u></font></h6>";
									}
									else{
										$c = mysql_query("select no_pelaporan, status from tlaporan where no_pelaporan = '$_GET[id]'");
										$cek = mysql_fetch_array($c);
										if($cek[no_pelaporan]==''){
										?>
											<a href='<?php echo "$aksi?p=new-post&act=911&id=$_GET[id]";?>' title='Send To IT' onclick="return confirm('Are you sure?')"><button type='button' class='btn btn-warning'><i class='fas fa-bullhorn'></i> <b>911</b></button></a>&nbsp;
										<?php 
										echo"<a href='?p=new-post&act=edit-problem&id=$_GET[id]' title='Edit'><button type='button' class='btn btn-success'><i class='icon-note'></i></button></a>&nbsp;";
										echo"
											<a href='#smallModal2' data-toggle='modal' data-target='#smallModal2' title='Ask to Delete'><button type='button' class='btn btn-danger'>Ask to Delete <i class='icon-trash'></i></button></a>";
										}else if($cek[status]=='F')	{
											echo "
													<a href='$aksi?p=new-post&act=close&id=$_GET[id]'>
													<button type='button' class='btn btn-success'>CLOSE <i class='icon-check'></i></button></a>";
										}
										else if($cek[status]=='C'){
											echo "<h6><font color='red'><u>SEND TO 911</u></font></h6>";
										}
										else{
											echo "<h6><font color='red'><u>SEND TO 911</u></font></h6>";
											if($not <=0){
												
											}
											else{
												echo"<a href='?p=new-post&act=edit-problem&id=$_GET[id]' title='Edit'><button type='button' class='btn btn-success'><i class='icon-note'></i></button></a>&nbsp;";
											}
										echo"
											<a href='#smallModal2' data-toggle='modal' data-target='#smallModal2' title='Ask to Delete'><button type='button' class='btn btn-danger'>Ask to Delete <i class='icon-trash'></i></button></a>";
										
										}
										
											echo"</td></tr>";
									}
								}
								
							}
							else if($_SESSION[level]=='admin'){
								echo "<tr><td colspan='2' align='right'><br>";
								$p = mysql_query("select *from tproblems where idprob = '$_GET[id]'");
									$nt = mysql_fetch_array($p);
									if($nt[status_del]=='Delete'){
										echo "<h6><font color='red'><u>ASK TO DELETE !!</u></font></h6>";
										echo"<a href='#smallModal' data-toggle='modal' data-target='#smallModal' title='Delete'><button type='button' class='btn btn-danger'><i class='icon-trash'></i></button></a>
											</td></tr>";
									}else{
										$c = mysql_query("select no_pelaporan, status from tlaporan where no_pelaporan = '$_GET[id]'");
										$cek = mysql_fetch_array($c);
										if($cek[no_pelaporan]==''){
									?>
										<a href='<?php echo "$aksi?p=new-post&act=911&id=$_GET[id]";?>' title='Send To IT' onclick="return confirm('Are you sure?')"><button type='button' class='btn btn-warning'><i class='fas fa-bullhorn'></i> <b>911</b></button></a>&nbsp;
									<?php	
										echo"<a href='?p=new-post&act=edit-problem&id=$_GET[id]' title='Edit'><button type='button' class='btn btn-success'><i class='icon-note'></i></button></a>
											<a href='#smallModal' data-toggle='modal' data-target='#smallModal' title='Delete'><button type='button' class='btn btn-danger'><i class='icon-trash'></i></button></a>
											</td></tr>";
										}else if($cek[status]=='F')	{
											echo "
													<a href='$aksi?p=new-post&act=close&id=$_GET[id]'>
													<button type='button' class='btn btn-success'>CLOSE <i class='icon-check'></i></button></a>";
										}
										else if($cek[status]=='C'){
											echo "<h6><font color='red'><u>SEND TO 911</u></font></h6>";
										}
										else{
											echo "<h6><font color='red'><u>SEND TO 911</u></font></h6>";
											if($not <=0){
											echo"<a href='?p=new-post&act=edit-problem&id=$_GET[id]' title='Edit'><button type='button' class='btn btn-success'><i class='icon-note'></i></button></a>&nbsp;
											<a href='#smallModal' data-toggle='modal' data-target='#smallModal' title='Delete'><button type='button' class='btn btn-danger'><i class='icon-trash'></i></button></a>";
											}
											else{}
										}
									}
							}
							else if($_SESSION[level]=='superadmin'){
								echo "<tr><td colspan='2' align='right'><br>";
								$p = mysql_query("select *from tproblems where idprob = '$_GET[id]'");
									$nt = mysql_fetch_array($p);
									if($nt[status_del]=='Delete'){
										echo "<h6><font color='red'><u>ASK TO DELETE !!</u></font></h6>";
										echo"<a href='#smallModal' data-toggle='modal' data-target='#smallModal' title='Delete'><button type='button' class='btn btn-danger'><i class='icon-trash'></i></button></a>
											</td></tr>";
									}else{
										$c = mysql_query("select no_pelaporan, status from tlaporan where no_pelaporan = '$_GET[id]'");
										$cek = mysql_fetch_array($c);
										if($cek[no_pelaporan]==''){
									?>
										<a href='<?php echo "$aksi?p=new-post&act=911&id=$_GET[id]";?>' title='Send To IT' onclick="return confirm('Are you sure?')"><button type='button' class='btn btn-warning'><i class='fas fa-bullhorn'></i> <b>911</b></button></a>&nbsp;
									<?php	
										echo"<a href='?p=new-post&act=edit-problem&id=$_GET[id]' title='Edit'><button type='button' class='btn btn-success'><i class='icon-note'></i></button></a>
											<a href='#smallModal' data-toggle='modal' data-target='#smallModal' title='Delete'><button type='button' class='btn btn-danger'><i class='icon-trash'></i></button></a>
											</td></tr>";
										}else if($cek[status]=='F')	{
											echo "
													<a href='$aksi?p=new-post&act=close&id=$_GET[id]'>
													<button type='button' class='btn btn-success'>CLOSE <i class='icon-check'></i></button></a>";
										}
										else if($cek[status]=='C'){
											echo "<h6><font color='red'><u>SEND TO 911</u></font></h6>";
										}
										else{
											echo "<h6><font color='red'><u>SEND TO 911</u></font></h6>";
											if($not <=0){
											echo"<a href='?p=new-post&act=edit-problem&id=$_GET[id]' title='Edit'><button type='button' class='btn btn-success'><i class='icon-note'></i></button></a>&nbsp;
											<a href='#smallModal' data-toggle='modal' data-target='#smallModal' title='Delete'><button type='button' class='btn btn-danger'><i class='icon-trash'></i></button></a>";
											}
											else{}
										}
									}
							}
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
							$t = mysql_query("select *from tdoc where idprob = '$u[idprob]' ");
							while($p = mysql_fetch_array($t)){
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

<div class='modal fade' id='smallModal2' tabindex='-1' role='dialog'>
    <div class='modal-dialog modal-sm' role='document'>
        <div class='modal-content'>
            <div class='modal-header'>
                <h4 class='title' id='smallModalLabel'>Are You Sure?</h4>
            </div>
            <div class='modal-body'> Anda akan mengirim permintaan ke Administrator untuk menghapus dokumen ini. </div>
			<input type='hidden' name='id' value='$_GET[id]'>
			<input type='hidden' name='status_del' value='Delete'>
									
            <div class='modal-footer'>
                <a href='$aksi?p=new-post&act=delete&id=$_GET[id]&st=Delete'><button type='button' class='btn btn-danger'>DELETE</button></a>
                <button type='button' class='btn btn-default' data-dismiss='modal'>CANCEL</button>
            </div>
        </div>
    </div>
</div>

<div class='modal fade' id='smallModal' tabindex='-1' role='dialog'>
    <div class='modal-dialog modal-sm' role='document'>
        <div class='modal-content'>
            <div class='modal-header'>
                <h4 class='title' id='smallModalLabel'>Are you sure?</h4>
            </div>
            <div class='modal-body'> You will delete this post. </div>
			<input type='hidden' name='id' value='$_GET[id]'>
			<input type='hidden' name='status_del' value='Delete'>
									
            <div class='modal-footer'>
                <a href='$aksi?p=new-post&act=delete-problem&id=$_GET[id]'><button type='button' class='btn btn-danger'>DELETE</button></a>
                <button type='button' class='btn btn-default' data-dismiss='modal'>CANCEL</button>
            </div>
        </div>
    </div>
</div>

	<div class='modal animated fadeIn' id='editnote' tabindex='-1' role='dialog'>
    <div class='modal-dialog' role='document'>
        <div class='modal-content'>
            <div class='modal-header'>
                <h4 class='title' id='defaultModalLabel'>Edit Note</h4>
				<small>Share your solution*</small>
            </div>
            <div class='modal-body'>
                <div class='comment-form'>
                    <div class='hasil-data'></div>
                </div>      
            </div>
            
        </div>
    </div>
</div>

";
break;
case "edit-problem":
$q = mysql_fetch_array(mysql_query("select *from tproblems where idprob = '$_GET[id]'"));
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
											<form method='POST' action='$aksi?p=new-post&act=up-doc&id=$_GET[id]'  >
												<table>
													<tr><td><input type='number' name='j' value='$_GET[j]' class='form-control' placeholder='0'>
													<input type='hidden' name='id' value='$_GET[id]' class='form-control' >
													</td>
														<td align='right'><button type='submit' class='btn btn-info'><i class='icon-plus'></i><i/button></td>
													</tr>
												</table>
											</form>
											</td></tr>
											<tr><td></td><td align='right'></td></tr><tr><td></td><td align='right'></td></tr><tr><td></td><td align='right'></td></tr>
											<tr><td></td><td align='right'></td></tr><tr><td></td><td align='right'></td></tr><tr><td></td><td align='right'></td></tr>
											
											<form method='POST' action='$aksi?p=new-post&act=update&j=$_GET[j]&id=$_GET[id]' enctype='multipart/form-data'>";
											$v = mysql_query("select *from tdoc where idprob = '$_GET[id]' ");
											$i=1;
											$a = mysql_num_rows($v);
											while($g = mysql_fetch_array($v)){
												echo "<tr><td width='6%' align='right'><a href='$aksi?p=new-post&act=deldoc&iddoc=$g[iddoc]&id=$_GET[id]'><i class='icon-close'></i></a>&nbsp&nbsp;</td><td>
														<input type='hidden' name='iddoc[$i]' value='$g[iddoc]'>
														<input type='text' name='nodoc[$i]' class='form-control' value='$g[nodoc]' readonly='readonly'></td></tr>";
											$i++;
											}
											$j=$_GET[j];
											for($i=$a+1;$i<=$a+$j;$i++){
												echo "<tr><td width='6%' align='right'></td>
												<td><input type='text' name='nodoc[$i]' class='form-control' placeholder='Document $i'></td>
												</tr>";
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
						<input type='hidden' name='kodeprob' value='$_GET[id]'>
						<input type='hidden' name='date' value='$date'><input type='hidden' name='time' value='$time'>
						<input type='hidden' name='u_by' value='$_SESSION[username]'>";
			echo"
                <div class='col-lg-8 col-md-8 col-sm-8'>
                    <div class='card'>
                        <div class='body'>
                            <div class='row clearfix'>                               
                                <div class='col-sm-12'>
									<div class='form-group'>
									<label>Title:</label>
										<input type='text' class='form-control' name='judul' placeholder='Enter Problem Title'  value='$q[judulprob]' required/>
									</div>
									<div class='form-group'>
									<label>Category:</label>
										<select class='form-control show-tick' name='idcat' required>
											<option>---Select Category---</option>";
											$cat = showCategory();
											foreach($cat as $c){
												if($c[idcat]==$q[idcat]){
													echo "<option value='$c[idcat]' selected>$c[category_name]</option>";
												}
												else{
													echo "<option value='$c[idcat]'>$c[category_name]</option>";
												}
											}
									echo "
										</select>
									</div>
									<label>Description:</label>
                                    <textarea class='summernote' name='des' required>
                                        $q[deskripsi]
                                    </textarea>
									<div class='form-group'>
									<label>Attachment:</label>
										<input type='file' name='fupload[]' class='form-control' multiple='multiple'>
									</div>
									<div class='form-group'>";
									$u = showLampiran($_GET[id]);
									$no=1;
									foreach ($u as $tt){
										echo "
											&nbsp;$tt[lampiran]&nbsp;
												<a href='$aksi?p=new-post&act=dellampiran&id_lampiran=$tt[id_lampiran]&id=$_GET[id]&nm=$tt[lampiran]'><i class='icon-close'></i></a>&nbsp&nbsp;
											<br>";
										$no++;
									}
									echo "
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
                url : 'modul/actlog/detail2.php',
                data :  'idx='+ idx,
                success : function(data){
                $('.hasil-data').html(data);//menampilkan data ke dalam modal
                }
            });
         });
    });
  </script>