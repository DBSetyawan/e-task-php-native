 <?php
error_reporting(0);
/* ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL); */
session_start(); 
$m = date(m);$d = date(d);$y = date(Y);
$aksi="modul/911/sparepart/aksi_sparepart.php";
$dated = date('Y-m-d');

$sim_servername = "192.168.88.5";
$sim_username = "root";
$sim_password = "19K23O15P";
$sim_db = "kristest";
$sim_conn = mysqli_connect($sim_servername, $sim_username, $sim_password, $sim_db);
 ?>
 <div class="container-fluid">

			<?php
switch($_GET[act]){
default:
			$query= mysqli_query($conn, "SELECT * FROM tmesin order by namaMesin ASC");
			
			$number=1;
			$rows= mysqli_num_rows($query);
			//$btnmesin='';
			$opsimesin='';
			while($tmesin = mysqli_fetch_array($query)) 
			{
				$namamesin = str_replace(' ', '', $tmesin['namaMesin']);
				$opsimesin.="<option value='$tmesin[namaMesin]'>$tmesin[namaMesin]</option>";
			}
			/*while($tmesin = mysqli_fetch_array($query)) {
				$namamesin = str_replace(' ', '', $tmesin['namaMesin']);
				//var_dump($namamesin);
				if ($number%5==0) {
					$btnmesin.="</tr><tr>";	
				}
				if ($number==1) {
					$btnmesin.="<tr>";
				}
				$onclick='$("input:checkbox[id='.$namamesin.']").prop("checked", true);$("#'.$namamesin.'c").hide();$("#'.$namamesin.'u").show();';
				$onclick2='$("input:checkbox[id='.$namamesin.']").prop("checked", false);$("#'.$namamesin.'c").show();$("#'.$namamesin.'u").hide();';
				$btnmesin.="<td><button type='button' class='btn btn-block btn-primary m-t-20' id='".$namamesin."c' onclick='$onclick' >$tmesin[namaMesin]</button><button type='button' class='btn btn-block btn-danger m-t-20' id='".$namamesin."u' style='display:none;' onclick='$onclick2' >$tmesin[namaMesin]</button></td>";
				if ($number==$rows) {
					$btnmesin.="</tr>";
				}
				$number++;
			}*/
			/*<table border='0'>
								<tr>
										$btnmesin

									</tr>
								</table>*/

			/**
			 * *listing semuamesin dan jumlah sparepart berdasarkan tanggal
			 */
			$datasparepart= "
			SELECT mesin, count(idReq)jumlah, min(date(appDate))mulai, max(date(appDate))sampai from ( SELECT t.idReq, t.idProb, p.status_problem, t.nama_teknisi, t.mesin, t.kode_sparepart,
			t.unit, ta.nama_sparepart, t.qty, t.satuan, t.createdDate, ta.info, ta.createdBy as appBy, ta.createdDate as appDate
			FROM tsparepart t left join tsparepart_action ta ON t.idReq=ta.idReq LEFT JOIN tproblems p ON t.idProb = p.idProb
			where ta.createdBy IS NOT NULL AND ta.createdDate IS NOT NULL AND (t.kode_sparepart LIKE '%MTC.%' OR ta.nama_sparepart LIKE '%MTC.%' ) and p.status_problem = 'CLOSED' and t.idProb not in (SELECT TaskCode from tadjustoutmaterial )) a
						group by mesin
						  order by 1;";
						  //echo $datasparepart;
			$tablemesin= "<table>
								<thead>
									<tr>
										<th style='text-align:center;'>Mesin</th>
										<th style='text-align:center;'>Jumlah Request</th>
										<th style='text-align:center;'>Tanggal</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>";
			
			$dat =mysqli_query($conn, $datasparepart);
			while ($datamesin = mysqli_fetch_array($dat)) {
				$tablemesin .="<tr>
					<td style='text-align:center;'>$datamesin[mesin]</td>
					<td style='text-align:center;'>$datamesin[jumlah]</td>
					<td style='text-align:center;'>$datamesin[mulai] s/d $datamesin[sampai]</td>
					<td><a href='page.php?p=listadjustmentout&tglprove1=$datamesin[mulai]&tglprove2=$datamesin[sampai]&mesin=$datamesin[mesin]' class='btn btn-success'>select</a></td>
				</tr>"; 
			}
			$tablemesin .="
			
			</tbody>
							</table>";

			/**
			 * TODO: pembuaatan tombol select dan disselect
			 */

			$disselect="$('input:checkbox').prop('checked',false);";
			$select="$('input:checkbox').prop('checked',true);";
			echo"


			<div class='block-header'>
                <div class='row'>
                    <div class='col-lg-5 col-md-8 col-sm-12'>                        
                        <h2><a href='javascript:void(0);' class='btn btn-xs btn-link btn-toggle-fullwidth'><i class='fa fa-arrow-left'></i></a> Daftar Permintaan Sparepart</h2>
                        <ul class='breadcrumb'>
                            <li class='breadcrumb-item'><a href='?p=dashboard'><i class='icon-home'></i></a></li>                            
                            <li class='breadcrumb-item active'>Sparepart</li>
                        </ul>
                    </div>         
                </div>
            </div>
			
				<div class='col-lg-12 col-md-12'>
                    <div class='card'>
                        <div class='body'>
							<form method='POST' action='?p=adjustmentout'>
								<table border='0' width='100%'>
									<tr>
										<td><button type='submit' class='btn btn-block btn-success m-t-20'>Buat Adjustment Out</button>
											
										</td>
										
										<td align='right' width='81%'><h4><font color='red'><u>Daftar Material Adjustment Out</u></font></h4></td>
									</tr>
									
								</table>
							
								<br>
								
									<div class='col-lg-4'>
									
									<div id='msn'>
									<select class='form-control' id='selectmesin' name='selectmesin' >
									<option disabled selected value=''>--pilih mesin--</option>
									$opsimesin</select>
									</div>
									<div id='tgl1'>
									<input class='form-control' type='date' id='dateprove1'  name='dateprove1' >
									</div>
									<div id='tgl2'>
									<input class='form-control' type='date' id='dateprove2' name='dateprove2' >
									</div>
									<button class='btn btn-success' id='search' type='button' >Search</button>
									<button class='btn btn-primary' onclick=$select type='button'>Select All</button>
									<button class='btn btn-warning' onclick=$disselect type='button'>Diselect</button>
									<button class='btn btn-secondary' data-toggle='collapse' href='#collapseMesin' role='button'type='button' >Show List</button>
									
									</div>
								
								<div class='collapse' id='collapseMesin'>
  									<div class='card card-body'>
										$tablemesin
									</div>
								</div>
								<br>
								<br>
								<table border = '0' width= '50%' >
									<tr>
										<td bgcolor='lightblue' style='font-size:large;text-align:center;' >$_GET[mesin]</td>
										<td bgcolor='lightgreen' style='font-size:large;text-align:center;'>$_GET[tglprove1]</td>
										<td bgcolor='lightgreen' style='font-size:large;text-align:center;''>S/D</td>
										<td bgcolor='lightgreen' style='font-size:large;text-align:center;'>$_GET[tglprove2]</td>
									</tr>
								</table>
                           <div class='row'>
						    <div class='col-lg-12 col-md-12'>

							<div class='table-responsive'>
                                <table class='table table-hover js-custom-example dataTable table-custom m-b-0'>
                                    <thead>
                                        <tr>
											<th align='center' width='10%'>No.</th>
											<th align='center' width='10%'>KODE</th>
											<th align='left' width='15%'>TANGGAL APP.</th>
											<th align='left' width='15%'>TEKNISI</th>
											<th align='left' width='15%'>MESIN</th>
											<th align='left' width='15%'>KODE SPAREPART</th>
											<th width='10%'>SPAREPART</th>
                                            <th align='center'>JUMLAH</th>
											<th align='center'>SATUAN</th>
											<th align='center'>MESIN</th>
                                            <th >UNIT MESIN</th>
                                        </tr>
                                    </thead>
                                    <tbody>";
                                    $hasil='';
                                    $sim_code='';
									$sim_materialcode=array();
									$sim_skuunit=array();
									$sim_smallestunit=array();
									$urut=0;
                                    if (isset($_GET['mesin'])&&isset($_GET['tglprove1'])) 
									{
                                    	$cari = "SELECT t.idReq, t.idProb, p.status_problem, t.nama_teknisi, t.mesin, t.kode_sparepart, t.unit, ta.nama_sparepart,
												 t.qty, t.satuan, t.createdDate, ta.owner, ta.info, ta.createdBy 
												 as appBy, ta.createdDate as appDate, ou.idReq as reqid  FROM tsparepart t 
												 	left join tsparepart_action ta ON t.idReq=ta.idReq 
													 LEFT JOIN tproblems p ON t.idProb = p.idProb 
													 left join tadjustoutmaterial ou on t.idReq = ou.idReq
													 where ta.createdBy IS NOT NULL AND ta.createdDate IS NOT NULL AND (t.kode_sparepart LIKE '%MTC.%' OR ta.nama_sparepart 
													 LIKE '%MTC.%' ) and p.status_problem = 'CLOSED' and t.mesin = '$_GET[mesin]' 
													 and (Date(ta.createdDate) between  '$_GET[tglprove1]' and '$_GET[tglprove2]') and ou.idreq IS NULL and (ta.owner is  NULL or ta.owner='MTC') order by t.idprob asc ;" ;
									
										//echo $cari;
										$hasil  = mysqli_query($conn,$cari);
										$no=1;
											
										$detect_query="Select code,smallestunit,skuunit	 from mastermaterial ";
										$sim_code=mysqli_query($sim_conn,$detect_query);
										while($sim_material=mysqli_fetch_array($sim_code))
										{
											array_push($sim_materialcode, $sim_material['code']);
											array_push($sim_skuunit, $sim_material['skuunit']);
											array_push($sim_smallestunit, $sim_material['smallestunit']);
										}
									}
									
									while($r = mysqli_fetch_array($hasil)){
									
									//$usernya = mysqli_fetch_array(mysqli_query($conn, "select * from user where username='$r[handling]'"));
									/*if ($r[mesin] == 'CD-6 1') {
										$sid="cd6-1";
									}
									else
									{
										$sid="umum";
									}*/
									$namamesin = str_replace(' ', '', $r['mesin']);
									$sparepartnya='';
									$satuannya='';
									$checkboxnya='';
									if(in_array($r['nama_sparepart'],$sim_materialcode))
									{
										//$sparepartnya="<td align='center' bgcolor='lightgreen'>$r[nama_sparepart]<input value='$r[nama_sparepart]' name='name[]' style='visibility:hidden'></td>";
										$key=array_search($r['nama_sparepart'],$sim_materialcode);
										if($sim_skuunit[$key]==strtoupper($r['satuan'])||$sim_smallestunit[$key]==strtoupper($r['satuan']))
										{
											//$satuannya="<td align='center' bgcolor='lightgreen'>".strtoupper($r['satuan'])."</td>";
											//$checkboxnya ="";
											echo "
											<tr>
											<td align='center'><input type='checkbox' name='adj[]' value='$r[idReq]' id='$namamesin'></td>
												<td><h6><b>$r[idProb] <input value='$r[idReq]' name='req[]' style='visibility:hidden'></b></h6></td>
												<td>$r[appDate]</td>
												<td>$r[nama_teknisi]</td>
												<td>$r[mesin]</td>
												<td>$r[kode_sparepart]</td>
												<td align='center' bgcolor='lightgreen'>$r[nama_sparepart]<input value='$r[nama_sparepart]' name='name[]' style='visibility:hidden'></td>
												<td align='center'>$r[qty]<input value='$r[qty]' name='qty[]' style='visibility:hidden'></td>
												<td align='center' bgcolor='lightgreen'>".strtoupper($r['satuan'])."</td>
												<td>$r[mesin]</td>
												<td>$r[unit]<input value='$r[unit]' name='unit[]' style='visibility:hidden'></td>
												
											</tr>";
										}
										else
										{
											//$satuannya="<td align='center' bgcolor='#ba2222'>".strtoupper($r['satuan'])."</td>";
											//$checkboxnya = "<td align='center'></td>";
											echo "
											<tr>
												<td align='center'></td>
												<td><h6><b>$r[idProb] <input value='$r[idReq]'  style='visibility:hidden'></b></h6></td>
												<td>$r[appDate]</td>
												<td>$r[nama_teknisi]</td>
												<td>$r[mesin]</td>
												<td>$r[kode_sparepart]</td>
												<td align='center' bgcolor='lightgreen'>$r[nama_sparepart]<input value='$r[nama_sparepart]'  style='visibility:hidden'></td>
												<td align='center'>$r[qty]<input value='$r[qty]'  style='visibility:hidden'></td>
												<td align='center' bgcolor='orange'>".strtoupper($r['satuan'])."</td>
												<td>$r[mesin]</td>
												<td>$r[unit]<input value='$r[unit]' style='visibility:hidden'></td>
												
											</tr>";
										}
									}
									else
									{
										$sparepartnya="";
										$satuannya="";
										$checkboxnya = "";

										echo "
                                        <tr>
											<td align='center'></td>
											<td><h6><b>$r[idProb] <input value='$r[idReq]'  style='visibility:hidden'></b></h6></td>
											<td>$r[appDate]</td>
											<td>$r[nama_teknisi]</td>
											<td>$r[mesin]</td>
											<td>$r[kode_sparepart]</td>
											<td align='center' bgcolor='orange'>$r[nama_sparepart]<input value='$r[nama_sparepart]'  style='visibility:hidden'></td>
                                            <td align='center'>$r[qty]<input value='$r[qty]'  style='visibility:hidden'></td>
											<td align='center' bgcolor='orange'>".strtoupper($r['satuan'])."</td>
                                            <td>$r[mesin]</td>
											<td>$r[unit]<input value='$r[unit]'  style='visibility:hidden'></td>
											
                                        </tr>";
									}
									/* echo "
                                        <tr>
											$checkboxnya
											<td><h6><b>$r[idProb] <input value='$r[idReq]' name='req[]' style='visibility:hidden'></b></h6></td>
											<td>$r[appDate]</td>
											<td>$r[nama_teknisi]</td>
											<td>$r[mesin]</td>
											<td>$r[kode_sparepart]</td>
											$sparepartnya
                                            <td align='center'>$r[qty]<input value='$r[qty]' name='qty[]' style='visibility:hidden'></td>
											$satuannya
                                            <td>$r[mesin]</td>
											<td>$r[unit]<input value='$r[unit]' name='unit[]' style='visibility:hidden'></td>
											
                                        </tr>"; */
										$no++;
										$urut++;
									}
										
                              echo"      </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
					<div class='row'>
						<div class='container'>
							<div class='col-lg-12'>
								<button class='btn btn-primary' onclick=$select type='button'>Select All</button>
								<button class='btn btn-warning' onclick=$disselect type='button'>Diselect</button>
								<button type='submit' class='btn  btn-success '>Buat Adjustment Out</button>
							</div>
						</div>
					</div>

					</form>
					</div>
					 </div></div>
					
							";
	break;
	case "permintaan":

		echo "
		<div class='block-header'>
                <div class='row'>
                    <div class='col-lg-5 col-md-8 col-sm-12'>                        
                        <h2><a href='javascript:void(0);' class='btn btn-xs btn-link btn-toggle-fullwidth'><i class='fa fa-arrow-left'></i></a> Formulir Permintaan Sparepart</h2>
                        <ul class='breadcrumb'>
                            <li class='breadcrumb-item'><a href='?p=dashboard'><i class='icon-home'></i></a></li>
							 <li class='breadcrumb-item'><a href='?p=sparepart'>List Sparepart</a></li>
                            <li class='breadcrumb-item active'>Formulir Sparepart</li>
                        </ul>
                    </div>         
                </div>
            </div>
		
		
		<div class='col-lg-12 col-md-12'>
                    <div class='card'>
                        <div class='body'>
							<form method='POST' action='$aksi?p=sparepart&act=permintaan'>
								
                           <div class='row'>
						    <div class='col-lg-12 col-md-12'>
							<div class='table-responsive'>
                                <table class='table table-striped table-hover dataTable'>
                                    <thead>
                                        <tr>
											<th align='center' width='10%'>No.</th>
											<th align='left' width='15%'>KODE SP</th>
											<th width='10%'>NAMA SP</th>
                                            <th align='center'>JUMLAH</th>
											<th align='center'>SATUAN</th>
                                        </tr>
                                    </thead>
                                    <tbody>";
									
									$jumlah = count($_POST[req]);
									if($jumlah >0){
									$no=1;
									for($i=0; $i<$jumlah; $i++)  
									{
										$idreq = $_POST[req][$i];
										$cari = "SELECT t.idReq, t.idProb, t.nama_teknisi, t.mesin, t.unit, t.kode_sparepart, 
											 ta.nama_sparepart, t.qty, t.satuan, t.createdDate, ta.info, ta.createdBy as appBy, ta.createdDate as appDate 
											 FROM tsparepart t left join tsparepart_action ta ON t.idReq=ta.idReq
											 where t.idReq = '$idreq'" ;
									
										$hasil  = mysqli_query($conn,$cari);
									
										
									
										$r = mysqli_fetch_array($hasil);
										echo "
											<tr>
												<td align='center' width='1%'>$no.</td>
												<td width='25%'>
												<input type='hidden' name='idProb[]' class='form-control' value='$r[idProb]'>
												<input type='hidden' name='idReq[]' class='form-control' value='$r[idReq]'>
												<input type='hidden' name='nama_pelapor[]' class='form-control' value='$r[nama_teknisi]'>
												<input type='text' name='kode_sparepart[]' class='form-control' value='$r[kode_sparepart]'></td>
												<td width='40%'><input type='text' name='nama_sparepart[]' class='form-control' autofocus></td>
												<td width='15%' align='center'><input type='number' name='qty_ya[]' class='form-control' value='$r[qty]' min=1></td>
												<td align='center'><input type='text' name='satuan_ya[]' class='form-control' value='".strtoupper($r[satuan])."'></td>
											</tr>";
											$no++;
									}
									}else{
										echo "<tr><td colspan='5' align='center'><font color='red'>Tidak ada permintaan yang dipilih.</font></td></tr>";
									}
										
                              echo"      </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
					<table border='0' width='100%'>
									<tr>
										<td width='81%'></td>
										<td align='right' >";
										if($jumlah >0){
											echo"<a href='?p=sparepart'>
												<button type='button' class='btn btn-block btn-default m-t-20'>Kembali</button></a>
												<button type='submit' class='btn btn-block btn-success m-t-20'>Disetujui</button></td>";
										}else{
											echo"<a href='?p=sparepart'>
												<button type='button' class='btn btn-block btn-default m-t-20'>Kembali</button></a>
												<button type='submit' class='btn btn-block btn-success m-t-20' disabled=''>Disetujui</button></td>";
										}
										echo"
									</tr>
								</table><br />
					</form>
					</div>
					 </div></div>
					 
					 <div class='col-lg-12 col-md-12'>
                    <div class='card'>
                        <div class='body'>
							<form method='POST' action='$aksi?p=sparepart&act=permintaan'>
								<table border='0' width='100%'>
									<tr>
										<td><h6><font color='red'><u>Permintaan Sparepart</u></font></h6></td>
										<td align='right' width='81%'><h4><font color='red'><u></u></font></h4></td>
									</tr>
								</table><br />
                           <div class='row'>
						    <div class='col-lg-12 col-md-12'>
							<div class='table-responsive'>
                                <table class='table table-striped table-hover dataTable'>
                                    <thead>
                                        <tr>
											<th align='center' width='10%' style='display:none'>No.</th>
											<th align='center' width='10%'>KODE</th>
											<th align='left' width='15%'>TANGGAL REQ.</th>
											<th align='left' width='15%'>TEKNISI</th>
											<th align='left' width='15%'>KODE SP</th>
											<th width='10%'>NAMA SP</th>
                                            <th align='center'>JUMLAH</th>
											<th align='center'>SATUAN</th>
											<th align='center'>MESIN</th>
                                            <th width='10%'>UNIT MESIN</th>
                                        </tr>
                                    </thead>
                                    <tbody>";
									
									$jumlah = count($_POST[req]);
									$no=1;
									for($i=0; $i<$jumlah; $i++)  
									{
										$idreq = $_POST[req][$i];
										$cari = "SELECT t.idReq, t.idProb, t.nama_teknisi, t.mesin, t.unit, t.kode_sparepart, t.mesin, t.unit,
											 ta.nama_sparepart, t.qty, t.satuan, t.createdDate,ta.owner, ta.info, ta.createdBy as appBy, ta.createdDate as appDate 
											 FROM tsparepart t left join tsparepart_action ta ON t.idReq=ta.idReq
											 where t.idReq = '$idreq'" ;
									
										$hasil  = mysqli_query($conn,$cari);
									
										
									
										$r = mysqli_fetch_array($hasil);
										echo "
											<tr>
												<td style='display:none' align='center'>$no</td>
											<td><h6><b>$r[idProb]</b></h6></td>
											<td>$r[createdDate]</td>
											<td>$r[nama_teknisi]</td>
											<td>$r[kode_sparepart]</td>
											<td>$r[nama_sparepart]</td>
                                            <td align='center'>$r[qty]</td>
											<td align='center'>".strtoupper($r[satuan])."</td>
                                            <td>$r[mesin]</td>
											<td>$r[unit]</td>
											</tr>";
											$no++;
									}
										
                              echo"      </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
					</form>
					</div>
					 </div></div>
							";
	break;
}
?>
