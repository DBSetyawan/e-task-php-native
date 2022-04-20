<?php
/* error_reporting(1);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL); */
session_start(); 
$m = date('m');$d = date('d');$y = date('Y');
$aksi="modul/master/sparepart/act_sparepart.php";
$kesesuaianunit=1;
switch($_GET[act]){
default:

echo "
<div class='container-fluid'>
			<div class='block-header'>
                <div class='row'>
                    <div class='col-lg-5 col-md-8 col-sm-12'>                        
                        <h2><a href='javascript:void(0);' class='btn btn-xs btn-link btn-toggle-fullwidth'><i class='fa fa-arrow-left'></i></a> Adjustment Out</h2>
                        <ul class='breadcrumb'>
                            <li class='breadcrumb-item'><a href='?p=dashboard'><i class='icon-home'></i></a></li>
							<li class='breadcrumb-item active'><a href='?p=listadjustmentout'>Daftar Material Adjustment Out</a></li>							
							<li class='breadcrumb-item active'>Adjustment Out</li>
                        </ul>
                    </div>         
                </div>
            </div>";
			?>
			<div class="col-lg-12 col-md-12">
			<div class="card">
			<?php
						$prob = "SELECT * FROM tproblems p
							left join mcategories c on p.idcat = c.idcat
							left join tmesin m on p.id_mesin = m.idMesin
							left join tmesinunit n on p.id_unit_mesin = n.idUnit
							left join tassign ta on p.idprob = ta.no_pelaporan
							left join user u on u.username = ta.pic_handling
							where p.status_problem NOT IN ('CLOSED')";
							if($_GET['show']=='pribadi'){
								$prob .= " AND p.created_by = '$_SESSION[username]' ";
							}else{}
							
							$prob .= "group by p.idprob, ta.PIC_HANDLING
							order by p.idcat asc";
						$ptampil = mysqli_query($conn,$prob);
										
						$c = mysqli_query($conn, "select *from user where username='$_SESSION[username]'");
						$h = mysqli_fetch_array($c);
			?>
                        <div class="body">
						<ul class="nav nav-tabs">
							<li><a href="#home" data-toggle="tab" >HEADER</a></li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<li><a href="#profile" data-toggle="tab">DETAIL</a></li>
						</ul>
							  
							<div class='row'>
						    <div class='col-lg-12 col-md-12'>
							<div class=''>
							<?php
							$y = date('Y');
							$m = date('m');
							$d = date('d');
							echo "
							<form method='POST' action='page.php?p=act-adj'>
							<div class='tab-content'>
							<div role='tabpanel' class='tab-pane active' id='home'>
							<h6 align='center'><u>Header</u></h6>
								<div class='form-group row m-b-15'>
									<label class='col-md-2 col-sm-2 col-form-label' for='website'>Series</label>
									<div class='col-md-2 col-sm-2'>
										<input type='text' class='form-control' name='series' readonly='readonly' value='PPS'/>
									</div>
								</div>
								<div class='form-group row m-b-15'>
									<label class='col-md-2 col-sm-2 col-form-label' for='website'>Doc No</label>
									<div class='col-md-4 col-sm-4'>
										<input type='text' class='form-control' name='docno' readonly='readonly' />
									</div>
								</div>
								<div class='form-group row m-b-15'>
									<label class='col-md-2 col-sm-2 col-form-label' for='website'>Doc Date</label>
									<div class='col-md-4 col-sm-4'>
										<input type='date' class='form-control' name='docdate' value='$y-$m-$d'/>
									</div>
								</div>
								<div class='form-group row m-b-15'>
									<label class='col-md-2 col-sm-2 col-form-label' for='website'>Transaction Type</label>
									<div class='col-md-6 col-sm-6'>
										<select class='form-control' name='trans_type' id='trans_type' required>
											<option disabled selected value=''>---Transaction Type---</option>";
											//koneksi ke simtest
											$servername_sim = "192.168.88.5";
											$username_sim = "root";
											$password_sim = "19K23O15P";
											$db_sim = "kristest";
											$sim = mysqli_connect($servername_sim, $username_sim, $password_sim, $db_sim);

											$tr = mysqli_query($sim, "SELECT * FROM mastertransactiontype m where Purpose = 'ADJUSTMENT OUT'");
											while($t = mysqli_fetch_array($tr)){
												echo"<option value='$t[Type]'>$t[Type] - $t[Description]</option>";
											}

											mysqli_close($sim);
										echo"
										</select>
									</div>
								</div>
								<div class='form-group row m-b-15'>
									<label class='col-md-2 col-sm-2 col-form-label' for='website'>Location</label>
									<div class='col-md-2 col-sm-2'>
										<input type='text' class='form-control' name='location' value='G19SP' readonly='readonly'/>
									</div>
								</div>
								<div class='form-group row m-b-15'>
									<label class='col-md-2 col-sm-2 col-form-label' for='website'>Information</label>
									<div class='col-md-10 col-sm-10'>
										<input type='text' class='form-control' name='information' />
									</div>
								</div>
							</div>
							
							<div role='tabpanel' class='tab-pane' id='profile'>
							<h6 align='center'><u>Detail</u></h6>";
							?>
							<div class="table-responsive">
                                <table class="table table-hover js-basic-example dataTable table-custom m-b-0" border='1'>
                                    <thead>
                                        <tr>                  
											<th>#</th>
											<th>Code</th>
                                            <th>Name</th>
                                            <th>Tag No</th>
                                            <th>Unit E-Task</th>
											<th>Unit SIM</th>
											<th>Qty</th>
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php
									
									/** 
									* TODO: data sumber dari listadjustmenout.php
									* * data material akan digabungkan bila memiliki kode material SIM yang sama 
									* * setelah material digabungkan akan ada pengecekan tagno, apabila jumlah material MTC lebih kecil dari tagno SIM maka semua qty di alokasikan pada tagno tsb
									* * apabila tagno lebihkecil dan jumlah tagno-nya lebih dari 1 maka qty barang MTC akan dipecah otomatis pada script ini
									
									* TODO: data yang dikirim: 
									* * materialcode
									* * etaskcode
									* * qty material
									* * tagno 
									* * material unit
									*/
																		
									$totalharga=0;
									/* print_r($_POST['adj']); */
									$jumlah = count($_POST['adj']);
									echo "<p align='right'>Jumlah Material yang di Adjustment Out = $jumlah</p>";
									$no=0;
									$r='';
									
									$data=array();
									$arraymaterial= array();
									for($i=0; $i<$jumlah; $i++)  
									{
										$urut =  $_POST['adj'][$i];
										
										$cari = "SELECT t.idReq, t.idProb, p.status_problem,
										t.nama_teknisi, t.mesin, t.kode_sparepart,
										 t.unit, ta.nama_sparepart, t.qty, t.satuan, t.createdDate, 
										 ta.info, ta.createdBy as appBy, ta.createdDate as appDate 
										 FROM tsparepart t left join tsparepart_action ta ON t.idReq=ta.idReq 
										 LEFT JOIN tproblems p ON t.idProb = p.idProb where ta.createdBy 
										 IS NOT NULL AND ta.createdDate IS NOT NULL AND 
										 (t.kode_sparepart LIKE '%MTC.%' OR ta.nama_sparepart LIKE '%MTC.%' ) 
										 and p.status_problem = 'CLOSED' and t.idReq='$urut' ;";
										$hasil  = mysqli_query($conn,$cari);
										$no++;
										$r = mysqli_fetch_array($hasil);
										//$datatmp = array('name'=>$r['kode_sparepart'],'qty'=>$_POST['qty'][$nourut],'code'=>$_POST['name'][$nourut],'unit'=>$r['satuan']);
										$datatmp = array('name'=>$r['kode_sparepart'],'qty'=>$r['qty'],'code'=>$r['nama_sparepart'],'unit'=>$r['satuan'],'idProb'=>$r['idProb'],'idReq'=>$r['idReq']);
										array_push($data, $datatmp);
										$kodeetask 		= $r['idProb'];
										$koderequest 	= $r['idReq'];
										$kodematerial 	= $r['nama_sparepart'];
										$qty			= $r['qty'];
										$unit			= $r['satuan'];
										echo"
										<input name='etask[]' value='$kodeetask' style='display:none;'>
										<input name='req[]' value='$koderequest' style='display:none;'>
										<input name='mat_awal[]' value='$kodematerial' style='display:none;'>
										<input name='qty_awal[]' value='$qty' style='display:none;'>
										<input name='unit_awal[]' value='$unit' style='display:none;'>";
									}
									$tdata=$data;
									sort($tdata);
									sort($data);
									

										for($k=0; $k<$jumlah; $k++)
									    {
									        for($j=$k+1; $j<$jumlah; $j++)
									        {
									            /* If duplicate found then increment count by 1 */
									            if ($tdata[$k]['code'] == $tdata[$j]['code']) 
									            {
									            	$tempcode= $tdata[$j]['code'];
													$tempqty = $tdata[$j]['qty'] + $tdata[$k]['qty'];
													$tdata[$k]['qty']=$tempqty;
													array_splice($tdata, $j, 1);
													
									            }
									            
									        }
									    }

										$data=$tdata;
										/*var_dump($tdata);
										echo "<br>";
										echo "<br>";
										var_dump($data);*/
										//print_r($data);
										//echo "<br>data :".count($data)."<br><br>";

										//proses pengecekan tagno dan pemecahan qty material

										$no=1;
										$batas = count($data);
										$missing = array();
									for ($l=0; $l < $batas; $l++) { 
										$nourut =  $_POST['adj'][$l];
										$materialcode=$data[$l]['code'];
										$kodeetask=$data[$l]['idProb'];
										$koderequest=$data[$l]['idReq'];
										$harga=0;
										$materialunit='';
										//$option = "<select name='tagno[]'>";
										//simtest
										$servername_sim = "192.168.88.5";
										$username_sim = "root";
										$password_sim = "19K23O15P";
										$db_sim = "kristest";
										$sim = mysqli_connect($servername_sim, $username_sim, $password_sim, $db_sim);
										//////////////


										$date = date("Y-m")."-01";
										$query = mysqli_query($sim, "SELECT stockbalance.* , mastermaterial.smallestunit FROM stockbalance 
											left join mastermaterial on mastermaterial.code = stockbalance.materialcode  
											where stockbalance.periode = '$date' and stockbalance.materialcode= '$materialcode' and stockbalance.QtyEnd >  0.0000 and stockbalance.location='G19SP' order by periode DESC ;");
										if (mysqli_num_rows($query) > 0 ) {
											
											$numb=0;
											$dataqty = $data[$l]['qty'];


												while($result = mysqli_fetch_array($query)){
													while ($dataqty > 0) {
													//jika qty barang masih diatas 0 maka akan di pecah lagi dengan tagno berbeda
													if ($result['QtyEnd'] > $dataqty){
														//jika qty lebih kecil daripada ketersediaan batch
														$option = "<select name='tagno[]' readonly>";
														$option.="<option value='$result[TagNo]' selected>$result[TagNo]</option>";
														$materialunit = $result['smallestunit'];

														/**
														 * *pengecekan kesesuaian material unit, antara sim dan etask
														 * *bila tidak sama ,maka mtc harus ubah terlebih dahulu 
														*/
														$bgcolor='';
														if (strtoupper($materialunit) != strtoupper($data[$l]['unit']) ) {
															$kesesuaianunit=0;
															$bgcolor="bgcolor='red'";
														}
														/////////////////////////////////////////////////////
														
														$harga=$result['Price'];
														$option.="</select>";
														?>
															<tr>
																<td <?php echo $bgcolor;?>><?php echo $no ; ?></td>
																<td width='20%' <?php echo $bgcolor;?>><?php echo $materialcode; echo "<input name='material[]' value='$materialcode'  style='visibility: hidden;''>";?> </td>
									                            <td width='35%' <?php echo $bgcolor;?>><?php echo $data[$l]["name"]; ?></td>
																<td width='15%' <?php echo $bgcolor;?>><?php echo $option; echo "qty : ".$result['QtyEnd'] ; ?></td>
									                            <td width='5%' <?php echo $bgcolor;?>><?php echo $data[$l]['unit'];?></td>
									                            <td width='5%' <?php echo $bgcolor;?>><?php echo $materialunit;echo"<input value='$materialunit' name='unit[]' style='visibility: hidden;'>"; ?></td>
									                            <td width='5%' <?php echo $bgcolor;?>><?php echo $dataqty; echo"<input value='$dataqty' name='qty[]' style='visibility: hidden;'>"?></td>
																
									                        </tr>
														<?php
														$dataqty=0;	
														$no++;
														break;
													}
													else
													{
														// jika qty lebih besar daripada ketersediann qty batch
														$option = "<select name='tagno[]' disable>";
														$option.="<option value='$result[TagNo]' selected>$result[TagNo]</option>";
														$materialunit = $result['smallestunit'];
														$harga=$result['Price'];
														
														/** 
														 * *pengecekan kesesuaian material unit, antara sim dan etask
														 * *bila tidak sama ,maka mtc harus ubah terlebih dahulu 
														 */
														$bgcolor='';
														if (strtoupper($materialunit) != strtoupper($data[$l]['unit']) ) {
															$kesesuaianunit=0;
															$bgcolor="bgcolor='red'";
														}


														$option.="</select>";
														?>
															<tr>
																<td <?php echo $bgcolor;?>><?php echo "$no "; ?> </td>
																<td width='20%' <?php echo $bgcolor;?>><?php echo $materialcode;echo "<input name='material[]' value='$materialcode'  style='visibility: hidden;''>"; ?></td>
									                            <td width='35%' <?php echo $bgcolor;?>><?php echo $data[$l]['name']; ?></td>
																<td width='15%' <?php echo $bgcolor;?>><?php echo $option; echo "qty : ".$result['QtyEnd'] ;?></td>
																<td width='5%' <?php echo $bgcolor;?>><?php echo $data[$l]['unit']; ?></td>
									                            <td width='5%' <?php echo $bgcolor;?>><?php echo $materialunit;  echo"<input value='$materialunit' name='unit[]' style='visibility: hidden;'>"; ?></td>
									                            <td width='5%' <?php echo $bgcolor;?>><?php echo $dataqty; echo"<input value='$dataqty' name='qty[]' style='visibility: hidden;'>"?></td>
																
									                        </tr>
														<?php
														$no++;
														$dataqty = $dataqty-$result['QtyEnd'];//pengurangan qty
														break;
													}/*endif*/
												}/*endwhile*/		
											}/*endwhile*/
										}/*endif*/
										else
										{
											array_push($missing, $data[$l]);
											if (mysqli_error($sim)!='') {
												echo ("error sim : ".mysqli_error($sim));
											}
											
										}

									}/*endfor*/
									//var_dump($missing);
										?>
                                    </tbody>
                                </table>
                                
                            </div>
                            <br>
                            <br>
                            <label>Daftar Material Tidak ada di dalam SIM</label>
                            <input type="text" id="missingpart" value="<?php echo count($missing);?>" style="display: none;">
                            <div class="table-responsive">
                                <table class="table table-hover js-basic-example dataTable table-custom m-b-0" border='1' id='edittable'>
                                    <thead>
                                        <tr>                  
											<th>#</th>
											<th>Code</th>
                                            <th>Name</th>
                                            <th>Tag No</th>
                                            <th>Unit E-Task</th>
											<th>Unit SIM</th>
											<th>Qty</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    	<?php
                                    	$num=0;
                                    	for ($i=0; $i < count($missing); $i++) { 
                                    		echo "<tr>
                                    				<td>$num</td>
                                    				<td>".$missing[$i]['code']."</td>
                                    				<td>".$missing[$i]['name']."</td>
                                    				<td></td>
                                    				<td></td>
                                    				<td></td>
                                    				<td></td>
                                    				</tr>";
                                    				$num++;
                                    	}
                                    	/*while ($missingpart = $missing) {
                                    		echo "<tr>
                                    				<td>$num</td>
                                    				<td>$missingpart[code]</td>
                                    				<td>$missingpart[name]</td>
                                    				<td></td>
                                    				<td></td>
                                    				</tr>";
                                    				$num++;
                                    	}*/
                                    	?>
                                    </tbody>
                                </table>
                            </div>
							<?php
							/*jika material unit sudah sesuai*/
							if ($kesesuaianunit==1 && count($missing)== 0) {
								$alert='';
								if(count($missing)> 0){
									$jml = count($missing);
									$alert='return confirm("Terdapat '.$jml.' item tidak ada dalam SIM, tetap lanjut?")';
								}
								echo"
								</div>
								
								<br />
								<p align='right'>
									<button type='submit' class='btn btn-primary' onclick='$alert'>Simpan</button>&nbsp;&nbsp;<button type='reset' class='btn btn-danger'>Cancel</button>
								</p>
								</form>
									";		
							}
								
								?>
								</div>
								</div>
								</div>
                        </div>
                    </div>
				</div>
			<?php
break;
case "edit-material" :
echo "
<div class='container-fluid'>
			<div class='block-header'>
                <div class='row'>
                    <div class='col-lg-5 col-md-8 col-sm-12'>                        
                        <h2><a href='javascript:void(0);' class='btn btn-xs btn-link btn-toggle-fullwidth'><i class='fa fa-arrow-left'></i></a> Master Sparepart</h2>
                        <ul class='breadcrumb'>
                            <li class='breadcrumb-item'><a href='?p=dashboard'><i class='icon-home'></i></a></li>                            
                            <li class='breadcrumb-item'>Master</li>
                            <li class='breadcrumb-item'>Master Sparepart</li>
							<li class='breadcrumb-item active'><a href='?p=msparepart'>Edit Sparepart</a></li>
                        </ul>
                    </div>         
                </div>
            </div>";
			?>
			<div class="col-lg-12 col-md-12">
			<div class="card">
			<?php
											$prob = "SELECT * FROM msparepart where idSp ='$_GET[id]'";
											$ptampil = mysqli_query($conn,$prob);
										
						$h = mysqli_fetch_array($ptampil);
			?>
                        <div class="body">
						<ul class="nav nav-tabs">
							<li><a href="#home" data-toggle="tab" >MATERIAL</a></li>&nbsp;&nbsp;&nbsp;
							<li><a href="#profile" data-toggle="tab">STOCK</a></li>&nbsp;&nbsp;&nbsp;
							<li><a href="#messages" data-toggle="tab">LOKASI</a></li>&nbsp;&nbsp;&nbsp;
							<li><a href="#plan" data-toggle="tab">RENCANA</a></li>
						</ul>
							  
							<div class='row'>
						    <div class='col-lg-12 col-md-12'>
							<div class=''>
							<?php
							echo "
							<form method='POST' action=''>
							<div class='tab-content'>
							<div role='tabpanel' class='tab-pane active' id='home'>
							<h6 align='center'><u>Material</u></h6>
								<div class='form-group row m-b-15'>
									<label class='col-md-2 col-sm-2 col-form-label' for='website'>Part Number</label>
									<div class='col-md-10 col-sm-10'>
										<input type='text' class='form-control' name='part_numb' autofocus value='$h[partNumber]' />
									</div>
								</div>
								<div class='form-group row m-b-15'>
									<label class='col-md-2 col-sm-2 col-form-label' for='website'>SIM Code*</label>
									<div class='col-md-6 col-sm-6'>
										<input type='text' class='form-control' name='sim_code' required value='$h[simCode]' />
									</div>
								</div>
								<div class='form-group row m-b-15'>
									<label class='col-md-2 col-sm-2 col-form-label' for='website'>Supplier Code</label>
									<div class='col-md-6 col-sm-6'>
										<input type='text' class='form-control' name='supp_code' value='$h[supplierCode]' />
									</div>
								</div>
								<div class='form-group row m-b-15'>
									<label class='col-md-2 col-sm-2 col-form-label' for='website'>SIM Name</label>
									<div class='col-md-10 col-sm-10'>
										<input type='text' class='form-control' name='sim_name' value='$h[simName]' />
									</div>
								</div>
								<div class='form-group row m-b-15'>
									<label class='col-md-2 col-sm-2 col-form-label' for='website'>Keterangan*</label>
									<div class='col-md-10 col-sm-10'>
										<input type='text' class='form-control' name='ket' required value='$h[keterangan]' />
									</div>
								</div>
							</div>
							
							<div role='tabpanel' class='tab-pane' id='profile'>
							<h6 align='center'><u>Stock</u></h6>
								<div class='form-group row m-b-15'>
									<label class='col-md-2 col-sm-2 col-form-label' for='website'>Satuan*</label>
									<div class='col-md-10 col-sm-10'>
										<input type='text' class='form-control' name='satuan' value='$h[satuan]' required />
									</div>
								</div>
								<div class='form-group row m-b-15'>
									<label class='col-md-2 col-sm-2 col-form-label' for='website'>Stock Awal*</label>
									<div class='col-md-10 col-sm-10'>
										<input type='number' min='0' class='form-control' name='st_awal' value='$h[stockAwal]' />
									</div>
								</div>
								<div class='form-group row m-b-15'>
									<label class='col-md-2 col-sm-2 col-form-label' for='website'>IN</label>
									<div class='col-md-10 col-sm-10'>
										<input type='number' min='0' class='form-control' name='in_st' value='$h[IN]' />
									</div>
								</div>
								<div class='form-group row m-b-15'>
									<label class='col-md-2 col-sm-2 col-form-label' for='website'>OUT</label>
									<div class='col-md-10 col-sm-10'>
										<input type='number' min='0' class='form-control' name='out_st' value='$h[OUT]' />
									</div>
								</div>
								<div class='form-group row m-b-15'>
									<label class='col-md-2 col-sm-2 col-form-label' for='website'>Stock Akhir</label>
									<div class='col-md-10 col-sm-10'>
										<input type='number' min='0' class='form-control' name='st_akhir' value='$h[stockAkhir]' autofocus />
									</div>
								</div>
							</div>
							
							 <div role='tabpanel' class='tab-pane' id='messages'>
							<h6 align='center'><u>Lokasi</u></h6>
								<div class='form-group row m-b-15'>
									<label class='col-md-2 col-sm-2 col-form-label' for='website'>Rak</label>
									<div class='col-md-10 col-sm-10'>
										<input type='text' class='form-control' name='rak' value='$h[rak]'  />
									</div>
								</div>
								<div class='form-group row m-b-15'>
									<label class='col-md-2 col-sm-2 col-form-label' for='website'>Level</label>
									<div class='col-md-10 col-sm-10'>
										<input type='text' class='form-control' name='level' value='$h[level]' />
									</div>
								</div>
								<div class='form-group row m-b-15'>
									<label class='col-md-2 col-sm-2 col-form-label' for='website'>Zona</label>
									<div class='col-md-10 col-sm-10'>
										<input type='text' class='form-control' name='zona' value='$h[zona]' />
									</div>
								</div>
								<div class='form-group row m-b-15'>
									<label class='col-md-2 col-sm-2 col-form-label' for='website'>Kotak</label>
									<div class='col-md-2 col-sm-2'>
										<input type='text' class='form-control' name='kotak' value='$h[kotak]' />
									</div>
								</div>
							</div>
							
							<div role='tabpanel' class='tab-pane' id='plan'>
							<h6 align='center'><u>Rencana Order</u></h6>
								<div class='form-group row m-b-15'>
									<label class='col-md-2 col-sm-2 col-form-label' for='website'>Minimum Stock</label>
									<div class='col-md-2 col-sm-2'>
										<input type='number' min='0' class='form-control' name='min_st' value='$h[minimumStock]' />
									</div>
								</div>
								<div class='form-group row m-b-15'>
									<label class='col-md-2 col-sm-2 col-form-label' for='website'>Re-Order Plan</label>
									<div class='col-md-4 col-sm-4'>
										<input type='number' min='1' class='form-control' name='reorder_plan' value='$h[reorderPlan]' />
									</div>
								</div>
								<div class='form-group row m-b-15'>
									<label class='col-md-2 col-sm-2 col-form-label' for='website'>Lead Time</label>
									<div class='col-md-4 col-sm-4'>
										<input type='number' min='1' class='form-control' name='lead_time' value='$h[leadTime]' />
									</div>
								</div>
							</div>
							<br />
							<p align='right'>
								<button type='submit' class='btn btn-primary'>Edit</button>&nbsp;&nbsp;<button type='reset' class='btn btn-danger'>Cancel</button>
							</p>
							</form>
								";
								
								
								?>
								</div>
								</div>
								</div>
                        </div>
                    </div>
				</div>
			<?php
break;
case "upload-material":
break;
case "update-material":
break;
case "stock-material":
break;
}
?>