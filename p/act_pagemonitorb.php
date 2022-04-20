<?php
error_reporting(0);
session_start(); 
include('../config/koneksi.php');
include('../config/fungsi_indotgl.php');
 // Ambil Aksi
 $act = $_GET['aksi'];
 if ($act=='data') {
 	$prob = "SELECT * FROM tproblems p
			left join mcategories c on p.idcat = c.idcat
			left join tmesin m on p.id_mesin = m.idMesin
			left join tmesinunit n on p.id_unit_mesin = n.idUnit
			left join tassign ta on p.idprob = ta.no_pelaporan
			left join user u on u.username = ta.pic_handling
			where p.status_problem NOT IN ('CLOSED')";
			if($_GET[show]=='pribadi'){
				$prob .= " AND p.created_by = '$_SESSION[username]' ";
			}else{}
			
			$prob .= "group by p.idprob
			order by p.idcat asc";
		$ptampil = mysqli_query($conn,$prob);
		$no = 1;
		while ($data = mysqli_fetch_assoc($ptampil))
		{
			echo "
			<tr>
				";
				if($data[category_name] == 'Kritis'){
					echo"
						<td bgcolor='red'><font color='white'>$no</font></td>
						<td bgcolor='red'><font color='white'><b>$data[category_name]</b></font></td>
						<td bgcolor='red'><a href='?p=todolist&act=problem-detail&id=$data[idprob]&s=report'><font color='white'><b>$data[idprob]</b></font></a></td>
						<td bgcolor='red'><font color='white'>$data[namapelapor]</font></td>
						<td bgcolor='red'><font color='white'>$data[namaMesin]</font></td>
						<td bgcolor='red'><font color='white'>$data[namaUnit]</font></td>
						<td bgcolor='red'><font color='white'>$data[fullname]</font></td>";
				}
				else if($data[category_name] == 'Penting'){
					echo"	
						<td bgcolor='yellow'>$no</font></td>
						<td bgcolor='yellow'><b>$data[category_name]</b></td>
						<td bgcolor='yellow'><a href='?p=todolist&act=problem-detail&id=$data[idprob]&s=report'><b>$data[idprob]</b></a></td>
						<td bgcolor='yellow'>$data[namapelapor]</td>
						<td bgcolor='yellow'>$data[namaMesin]</td>
						<td bgcolor='yellow'>$data[namaUnit]</td>
						<td bgcolor='yellow'>$data[fullname]</td>";
				}
				else{
					echo"
						<td>$no</td>
						<td><b>$data[category_name]</b></font></td>
						<td><a href='?p=todolist&act=problem-detail&id=$data[idprob]&s=report'><b>$data[idprob]</b></a></td>
						<td>$data[namapelapor]</td>
						<td>$data[namaMesin]</td>
						<td>$data[namaUnit]</td>
						<td>$data[fullname]</td>";
				}
				echo"
				
				";
			if($h[divisi]=='PRODUKSI'){
				if($data[status_problem] == 'APPROVED'){
					echo "<td>APPROVED </td>";
					if($data[created_by] == $_SESSION[username]){
						echo "<td><a href='modul/911/aksi_911.php?p=close&act=close&id=$data[idprob]' title='Klik for closing problem' class='btn btn-sm btn-danger'>CLOSE</a></td>";
					}else{
						echo "<td>&nbsp;</td>";
					}
				}else{
					echo "<td><font color='blue'><b>$data[status_problem]</b></font></td>
						  <td>&nbsp;</td>";
				}
			}
			else{
				echo "<td><font color='blue'><b>$data[status_problem]</b></font></td><td>&nbsp;</td>";
				
			}
			echo"</tr>";
			$no++;
		}
									
 }
 if ($act=="open") {
 	$p = mysqli_num_rows(mysqli_query($conn,"select *from tproblems p
													where status_problem ='OPEN'"));

													echo $p;
 }
 if ($act=="inprogress") {
 	$p = mysqli_num_rows(mysqli_query($conn,"select *from tproblems p
													where status_problem ='IN PROGRESS'"));

													echo $p;
 }
 if ($act=="assign") {
 	$p = mysqli_num_rows(mysqli_query($conn,"select *from tproblems p
													where status_problem ='ASSIGN'"));

													echo $p;
 }

 if ($act=="sparepart") {
 	$p = mysqli_num_rows(mysqli_query($conn,"select *from tproblems p
													where status_problem ='MENUNGGU SPAREPART'"));

													echo $p;
 }
 if ($act=="finish") {
 	$p = mysqli_num_rows(mysqli_query($conn,"select *from tproblems p
													where status_problem ='FINISH'"));

													echo $p;
 }
 if ($act=="approved") {
 	$p = mysqli_num_rows(mysqli_query($conn,"select *from tproblems p
													where status_problem ='APPROVED'"));

													echo $p;
 }
 mysqli_close($conn);
?>