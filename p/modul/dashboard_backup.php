<div class="block-header">
                <div class="row">
                    <div class="col-lg-6 col-md-8 col-sm-12">
                        <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a> Dashboard</h2>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html"><i class="icon-home"></i></a></li>                            
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ul>
                    </div>      
                </div>
            </div>

            <div class="row clearfix">
			<div class="col-lg-7 col-md-3">
			<div class="card">
                        <div class="header">
                            <h2>Latest</h2>
                        </div>
                        <div class="body">                           
                            <ul class="right_chat list-unstyled">
							<?php
								$l = mysqli_fetch_array(mysqli_query($conn,"select *from user where username = '$_SESSION[username]'"));
								$date = date('Y-m-d');
							if($l[divisi]=='PREPRESS' || $l[divisi]=='PPIC'){
									
									$p = mysqli_query($conn,"SELECT * FROM `tproblems` a
															LEFT JOIN mcategories mc ON a.idcat=mc.idcat
															LEFT JOIN tassign t ON a.idProb=t.NO_PELAPORAN
															where a.created_by ='$_SESSION[username]' AND a.dateprob = '$date' AND a.divisi_problem IN ('PREPRESS','PPIC')");
								
							}else{
								
									$p = mysqli_query($conn,"SELECT * FROM `tproblems` a
															LEFT JOIN mcategories mc ON a.idcat=mc.idcat
															LEFT JOIN tassign t ON a.idProb=t.NO_PELAPORAN
															where a.created_by='$_SESSION[username]' AND a.dateprob = '$date'  AND a.divisi_problem NOT IN ('PREPRESS','PPIC')");
								
							}
								while($j = mysqli_fetch_array($p)){
							?>
                                <li class="online"><?php
								if($l[level]=='admin'){
									?>
                                    <a href="<?php echo "?p=todolist&act=problem-detail&id=$j[idprob]&i=as"; ?>">
									<?php
								}else if($l[level]=='superadmin'){
									?>
									<a href="<?php echo "?p=todolist&act=problem-detail&id=$j[idprob]"; ?>">
									<?php
								}
									?>
                                        <div class="media">
										<?php
										if($l[photo]==''){
												echo "<img class='media-object' alt='User Profile Picture' src='modul/master/users/photo/no_image.jpg'>";
										}
										else{
												echo "<img class='media-object' src='modul/master/users/photo/$l[photo]'>";
										}
										?>
                                            <div class="media-body">
                                                <span class="name"><?php echo "<a href='?p=todolist&act=problem-detail&id=$j[idprob]&s=report'><b>$j[idprob]</b></a><br /> <b>".$j[namapelapor]."</b><br>".substr($j[deskripsi], 0, 25)."..."; 
											if($j[status_problem] == 'ASSIGN'){
												$h = mysqli_fetch_array(mysqli_query($conn, "select *from tassign where NO_PELAPORAN = '$j[idprob]' "));
												echo "<span class='badge badge-primary'> ASSIGN TO $h[PIC_HANDLING] </span>";
											}else if($j[status_problem] == 'IN PROGRESS'){
												$h = mysqli_fetch_array(mysqli_query($conn, "select *from thandling where idProb = '$j[idprob]' AND statusProblem = 'IN PROGRESS'"));
												echo "<span class='badge badge-primary'> IN PROGRESS by $h[handling] </span>";
											}else if($j[status_problem] == 'FINISH'){
												$h = mysqli_fetch_array(mysqli_query($conn, "select *from thandling where idProb = '$j[idprob]' AND statusProblem = 'FINISH'"));
												echo "<span class='badge badge-primary'> FINISHED by $h[handling] </span>";
												echo "<a href='modul/911/aksi_911.php?p=close&act=close&id=$j[idprob]' title='Klik for closing problem' class='btn btn-sm btn-danger'>CLOSE</a>";
											}else if($j[status_problem] == 'CLOSED'){
												echo "<span class='badge badge-danger'> CLOSED </span>";
											}
											
												?> <small class="float-right"><?php echo "".tgl_indo($j[dateprob]); ?><br><?php echo "".$j[timeprob]; ?></small></span>
                                                <span class="message"></span>
                                                <span class="badge badge-outline status"></span>
                                            </div>
                                        </div>
                                    </a>                            
                                </li>
							<?php
								}
							?>
                            </ul>
                        </div>
                    </div>
				</div>
				<?php
				if($_SESSION[level]=='admin' || $_SESSION[level]=='superadmin'){
				?>
                <div class="col-lg-4 col-md-10">
                    <div class="card top_counter">
                        <div class="body">
							<div class="icon"><i class="fa fa-exclamation"></i> </div>
							<div class="content">
                                
						<?php
							$date = date('Y-m-d');
							$l = mysqli_fetch_array(mysqli_query($conn,"select *from user where username = '$_SESSION[username]'"));
							
							if($l[divisi]=='PREPRESS' || $l[divisi]=='PPIC'){
								if($_SESSION[level]=='superadmin'){
								?>
								<div class="text">All Problems Today</div>
                                <h1 class="number">
								<?php
								$p = mysqli_num_rows(mysqli_query($conn,"select *from tproblems p
																 where dateprob = '$date' AND divisi_problem IN ('PREPRESS','PPIC')"));
								echo $p;
								}else{
								?>
								<div class="text">Problems Today</div>
                                <h1 class="number">
								<?php
								$p = mysqli_num_rows(mysqli_query($conn,"select *from tproblems p left join user u on p.created_by=u.username
																 where dateprob = '$date'  AND divisi_problem IN ('PREPRESS','PPIC')"));
								echo $p;
								?>
																 </h1>
		                            </div>
									 <hr>
									<div class="text">Total Open Problems </div>
									<h1 class="number">
								<?php
									$p = mysqli_num_rows(mysqli_query($conn,"select *from tproblems p left join user u on p.created_by=u.username where p.status_problem='OPEN'
																 "));
									ECHO $p;
								}
							}
							else if($l[divisi]=='EDP'){
								if($_SESSION[level]=='superadmin'){
								?>
								<div class="text">All Problems Today</div>
                                <h1 class="number">
								<?php
								$p = mysqli_num_rows(mysqli_query($conn,"select *from tproblems p
																 where dateprob = '$date'"));
								echo $p;
								}else{
								?>
								<div class="text">Problems Today</div>
                                <h1 class="number">
								<?php
								$p = mysqli_num_rows(mysqli_query($conn,"select *from tproblems p left join user u on p.created_by=u.username
																 where dateprob = '$date' "));
								echo $p;
								}
							}
							else{
								if($_SESSION[level]=='superadmin'){
								?>
								<div class="text">All Problems Today</div>
                                <h1 class="number">
								<?php
								$p = mysqli_num_rows(mysqli_query($conn,"select *from tproblems p
																 where dateprob = '$date' AND divisi_problem NOT IN ('PREPRESS','PPIC')"));
								echo $p;
								}else{
								?>
								<div class="text">Problems Today</div>
                                <h1 class="number">
								<?php
								$p = mysqli_num_rows(mysqli_query($conn,"select *from tproblems p left join user u on p.created_by=u.username
																 where dateprob = '$date' AND divisi_problem NOT IN ('PREPRESS','PPIC')"));
								echo $p;
								}
								?>
								 </h1>
		                            </div>
									 <hr>
									<div class="text">Total Open Problems </div>
									<h1 class="number">
								<?php
									$q = mysqli_num_rows(mysqli_query($conn,"select *from tproblems p where p.status_problem='OPEN'
																 "));
									ECHO $q;
							}
								?>
								</h1>
                            </div>
                            <hr>
                            <div class="icon"><i class="fa fa-tasks"></i> </div>
                            <div class="content">
                               
								<?php
							if($l[divisi]=='PREPRESS' || $l[divisi]=='PPIC'){
								if($_SESSION[level]=='superadmin'){
								?>
									<div class="text">Total All Problems </div>
									<h1 class="number">
								<?php
									$p = mysqli_num_rows(mysqli_query($conn,"select *from tproblems p left join user u on p.created_by=u.username where divisi_problem IN ('PREPRESS','PPIC') "));
								}else{
								?>
									<div class="text">Total Problems </div>
									<h1 class="number">
								<?php
									$p = mysqli_num_rows(mysqli_query($conn,"select *from tproblems p left join user u on p.created_by=u.username  where divisi_problem IN ('PREPRESS','PPIC')
																 "));
																 ?>
																 </h1>
		                            </div>
									 <hr>
									<div class="icon"><i class="fa fa-tasks"></i> </div>
									<div class="content">
									<div class="text">Total Open Problems </div>
									<h1 class="number">
								<?php
									$q = mysqli_num_rows(mysqli_query($conn,"select *from tproblems p  where p.status_problem='OPEN'
																 "));
																 ECHO $q;
								}
							}
							else if($l[divisi]=='EDP'){
								if($_SESSION[level]=='superadmin'){
								?>
									<div class="text">Total All Problems </div>
									<h1 class="number">
								<?php
									$p = mysqli_num_rows(mysqli_query($conn,"select *from tproblems p left join user u on p.created_by=u.username "));
								}else{
								?>
									<div class="text">Total Problems </div>
									<h1 class="number">
								<?php
									$p = mysqli_num_rows(mysqli_query($conn,"select *from tproblems p left join user u on p.created_by=u.username
																 ")); 
									$q = mysqli_num_rows(mysqli_query($conn,"select *from tproblems p  where p.status_problem='OPEN'
																 "));
								}
							}
							else{
								if($_SESSION[level]=='superadmin'){
								?>
									<div class="text">Total All Problems </div>
									<h1 class="number">
								<?php
									$p = mysqli_num_rows(mysqli_query($conn,"select *from tproblems p left join user u on p.created_by=u.username  where divisi_problem NOT IN ('PREPRESS','PPIC')"));
									?>
									<div class="text">Total Open Problems </div>
									<h1 class="number">
								<?php
									$p = mysqli_num_rows(mysqli_query($conn,"select *from tproblems p left join user u on p.created_by=u.username where p.status_problem='OPEN'
																 "));
									$q = mysqli_num_rows(mysqli_query($conn,"select *from tproblems p  where p.status_problem='OPEN'
																 "));
								}else{
								?>
									<div class="text">Total Problems </div>
									<h1 class="number">
								<?php
									$p = mysqli_num_rows(mysqli_query($conn,"select *from tproblems p left join user u on p.created_by=u.username  where divisi_problem NOT IN ('PREPRESS','PPIC')
									 "));
									
									$q = mysqli_num_rows(mysqli_query($conn,"select *from tproblems p  where p.status_problem='OPEN'
																 "));
								}
							}
							
								echo $p;?>
								</h1>
		                            </div>
									<hr>
									<div class="icon"><i class="fa fa-tasks"></i> </div>
									<div class="content">
									<div class="text">Total Open Problems </div>
									<h1 class="number">
								<?
								echo $q;
				}else{}
								?>
								</h1>
                            </div>
							 <hr>


                        </div>
                    </div>
                </div>
				<div class="col-lg-7 col-md-8">
				
				</div>
                
				
            </div>            
            </div>

            