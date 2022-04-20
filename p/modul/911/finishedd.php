<?php
$date = date('Y-m-d');
$month = date('m');
error_reporting(0);
session_start();
?>
<div class="block-header">
                <div class="row">
                    <div class="col-lg-6 col-md-8 col-sm-12">
                        <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a> Finish List Problems</h2>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html"><i class="icon-home"></i></a></li>                            
                            <li class="breadcrumb-item active">Finished</li>
                        </ul>
                    </div>      
                </div>
            </div>

            <div class="row clearfix">
			<div class="col-lg-12 col-md-12">
			<div class="card">
			<?php
			if($_SESSION[divisi]=='GA'){
				$prob = mysqli_query($conn, "SELECT * FROM tproblems p
					left join mcategories c on p.idcat = c.idcat
					left join tmesin m on p.id_mesin = m.idMesin
					left join tmesinunit n on p.id_unit_mesin = n.idUnit
					left join tassign ta on p.idprob = ta.no_pelaporan
					left join user u on u.username = ta.pic_handling
					where p.status_problem IN ('FINISH', 'APPROVED')
					and p.idprob like 'PGA%'
					and ta.created_date IN
						(select max(created_date) from tassign group by no_pelaporan)
					group by p.idprob
					order by p.idcat asc");
			}else{
				$prob = mysqli_query($conn, "SELECT * FROM tproblems p
					left join mcategories c on p.idcat = c.idcat
					left join tmesin m on p.id_mesin = m.idMesin
					left join tmesinunit n on p.id_unit_mesin = n.idUnit
					left join tassign ta on p.idprob = ta.no_pelaporan
					left join user u on u.username = ta.pic_handling
					where p.status_problem IN ('FINISH', 'APPROVED')
					and p.idprob like 'TSK%'
					and ta.created_date IN
						(select max(created_date) from tassign group by no_pelaporan)
					group by p.idprob
					order by p.idcat asc");
											
			}							
			?>
                        <div class="body">                           
                            <ul class="right_chat list-unstyled">
							<div class='row'>
						    <div class='col-lg-12 col-md-12'>
							<div class='table-responsive'>
								<table class='table table-striped table-hover dataTable js-exportable'>
                                    <thead>
                                        <tr>
                                            <th align='center' style='display:none;'>PRIORITAS</th>
											<th align='center'>MASALAH</th>
											<th align='center'>DESKRIPSI</th>
											<th align='center'>MESIN</th>
											<th width='10%'>TEKNISI</th>
											<th width='10%'>STATUS</th>
											<?php
											$c = mysqli_query($conn, "select *from user where username='$_SESSION[username]'");
											$h = mysqli_fetch_array($c);
											
											if($h[divisi]=='PRODUKSI'){
												echo"<th width='10%'>ACTION</th>";
											}else{
												echo"<th width='10%'>#</th>";
											}
											?>
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php
									
										$no = 1;
										while ($data = mysqli_fetch_assoc($prob))
										{
											$hbb = mysqli_fetch_array(mysqli_query($conn, "select *from thandling where idProb = '$data[idprob]' AND statusProblem = 'FINISH'"));
											echo "
											<tr>
												";
												if($data[category_name] == 'Kritis'){
													echo"
														<td bgcolor='red' style='display:none;'><font color='white'>$data[category_name]</font></td>
														<td bgcolor='red'><a href='?p=todolist&act=problem-detail&id=$data[idprob]&s=app&tek=$hbb[handling]'><font color='white'><b>$data[idprob]</b></font></a></td>
														<td bgcolor='red'><font color='white'>$data[deskripsi]</font></td>
														<td bgcolor='red'><font color='white'>$data[namaMesin]</font></td>
														<td bgcolor='red'><font color='white'>$data[fullname]</font></td>";
												}
												else if($data[category_name] == 'Penting'){
														echo"
														<td bgcolor='yellow' style='display:none;'>$data[category_name]</td>
														<td bgcolor='yellow'><a href='?p=todolist&act=problem-detail&id=$data[idprob]&s=app&tek=$hbb[handling]'><b>$data[idprob]</b></a></td>
														<td bgcolor='yellow'>$data[deskripsi]</td>
														<td bgcolor='yellow'>$data[namaMesin]</td>
														<td bgcolor='yellow'>$data[fullname]</td>";
												}
												else{
													echo"
														<td style='display:none;'>$data[category_name]</td>
														<td><a href='?p=todolist&act=problem-detail&id=$data[idprob]&s=app&tek=$hbb[handling]'><b>$data[idprob]</b></a></td>
														<td>$data[deskripsi]</td>
														<td>$data[namaMesin]</td>
														<td>$data[fullname]</td>";
												}
												echo"
												
												";
												/* if($data[status_problem] == 'FINISH'){
													$h = mysqli_fetch_array(mysqli_query($conn, "select *from thandling where idProb = '$data[idprob]' AND statusProblem = 'FINISH'"));
													echo "<td>FINISHED by $h[handling]</td>";
													echo "<td><a href='?p=todolist&act=problem-detail&id=$data[idprob]&s=app&tek=$h[handling]' title='Klik for closing problem' class='btn btn-sm btn-danger'>APPROVED</a></td>";
												}
												else if($data[status_problem] == 'APPROVED'){
													$h = mysqli_fetch_array(mysqli_query($conn, "select *from thandling where idProb = '$data[idprob]' AND statusProblem = 'APPROVED'"));
													echo "<td>$data[status_problem]</td>";
													echo "<td><a href='?p=todolist&act=problem-detail&id=$data[idprob]&s=disapp&tek=$h[handling]' title='Klik for closing problem' class='btn btn-sm btn-warning'>DISAPPROVED</a></td>";
												}
												else{ */
													echo "<td>$data[status_problem]</td>
														  <td>&nbsp;</td>";
												/* } */
											echo"</tr>";
											$no++;
										}
										
									?>
									</tbody>
								</table>
								</div>
								</div>
								</div>
                            </ul>
                        </div>
                    </div>
				</div>
				
				<div class="col-lg-7 col-md-8">
				
				</div>
                
				
            </div>            
            </div>

            