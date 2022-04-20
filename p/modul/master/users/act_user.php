<?php
error_reporting(0);
session_start();
include('../../../../config/koneksi.php');


$p	=$_GET[p];  $act	=$_GET[act];

if ($p=='users' AND $act=='input'){
	$w = mysqli_query($conn, "SELECT * FROM tdepartment where id_dep='$_POST[department]';");
	$r = mysqli_fetch_array($w);
	mysqli_query($conn, "INSERT INTO user VALUES(NULL,'$_POST[fullname]','$_POST[username2]','$_POST[password]','$_POST[department]','$_POST[field]',NULL,'$_POST[level]','$r[nama_dep]',1,'$_POST[email]' )");
	$link = "<script>alert('Save Success.');
	window.location='../../../page.php?p=users';</script>";
	echo $link;
}
if ($p=='users' AND $act=='update'){
	$w = mysqli_query($conn, "SELECT * FROM tdepartment where id_dep='$_POST[department]';");
	$r = mysqli_fetch_array($w);
	mysqli_query($conn, "UPDATE user SET fullname = '$_POST[fullname]', id_dep = ' $_POST[department]', id_field = '$_POST[field]', divisi = '$r[nama_dep]', level = '$_POST[level]', email = '$_POST[email]'
				WHERE iduser  = '$_POST[id]'");
	$link = "<script>alert('Update Success.');
	window.location='../../../page.php?p=users';</script>";
	echo $link;
}
if ($p=='users' AND $act=='delete'){
	mysqli_query($conn, "DELETE FROM user WHERE iduser = '$_GET[id]'");
	$link = "<script>alert('Delete Success.');
	window.location='../../../page.php?p=users';</script>";
	echo $link;
}
if ($p=='profile' AND $act=='update'){
	$d = mysqli_query($conn, "select *from user where username='$_POST[username]'");
	$y = mysqli_fetch_array($d);
	
	if($y[level]=='admin' || $y[level]=='superadmin'){
		
		if($_POST[password_o]==''){
			mysqli_query($conn, "UPDATE user SET 
								 fullname  	= '$_POST[fullname]'
								 WHERE iduser  = '$_POST[id]'");
			$link = "<script>
					alert('Successfully to update profile, $_POST[fullname]');
					window.location='../../../page.php?p=profile';</script>";
			echo $link;
		}
	else{
	if($_POST[password_o]==$y[password]){
		if($_POST[password_n]!='' AND $_POST[password_c]!=''){
			if($_POST[password_n]==$_POST[password_c]){
				mysqli_query($conn, "UPDATE user SET 
								 fullname  	= '$_POST[fullname]',
								 username	= '$_POST[username]',
								 password	= '$_POST[password_n]',
								 level		= '$_POST[level]'
								 WHERE iduser  = '$_POST[id]'");
				$link = "<script>
					alert('Successfully to update profile, $_POST[fullname]');
					window.location='../../../page.php?p=profile';</script>";
				echo $link;
			}
			else{
				$link = "<script>
					alert('New Password and Confirm Password not match !!')
					window.location='../../../page.php?p=profile';</script>";
					echo $link;
			}
		}
		else{
			$link = "<script>
					alert('New Password and Confirm Password not fill !!')
					window.location='../../../page.php?p=profile';</script>";
					echo $link;
		}
	}else{
		$link = "<script>
					alert('Old Password not match !!')
					window.location='../../../page.php?p=profile';</script>";
					echo $link;
	}
}
		
	}else if($y[level]=='user'){
		
	if($_POST[password_o]==''){
	mysqli_query($conn, "UPDATE user SET 
								 fullname  	= '$_POST[fullname]',
								 username	= '$_POST[username]',
								 level		= '$_POST[level]'
								 WHERE iduser  = '$_POST[id]'");
	$link = "<script>
					alert('Successfully to update profile, $_POST[fullname]');
					window.location='../../../page.php?p=profile';</script>";
			echo $link;
}
else{
	
	if($_POST[password_o]==$y[password]){
		if($_POST[password_n]!='' AND $_POST[password_c]!=''){
			if($_POST[password_n]==$_POST[password_c]){
				mysqli_query($conn, "UPDATE user SET 
								 fullname  	= '$_POST[fullname]',
								 username	= '$_POST[username]',
								 password	= '$_POST[password_n]',
								 level		= '$_POST[level]'
								 WHERE iduser  = '$_POST[id]'");
				$link = "<script>
					alert('Successfully to update profile, $_POST[fullname]');
					window.location='../../../page.php?p=profile';</script>";
				echo $link;
			}
			else{
				$link = "<script>
					alert('New Password and Confirm Password not match !!')
					window.location='../../../page.php?p=profile';</script>";
					echo $link;
			}
		}
		else{
				$link = "<script>
					alert('New Password and Confirm Password not fill !!')
					window.location='../../../page.php?p=profile';</script>";
					echo $link;
			}
		}else{
				$link = "<script>
					alert('Old Password not match !!')
					window.location='../../../page.php?p=profile';</script>";
					echo $link;
			}
		}

	}
}
if ($p=='profile' AND $act=='uphoto'){
	
	$tipe_file      = $_FILES['photo']['type'];
	$nama_file      = $_FILES['photo']['name'];
	
		 unlink("photo/".$_POST['photo']);
		 mysqli_query($conn, "UPDATE user SET photo = '$nama_file'
                             WHERE iduser   = '$_GET[id]'");
		move_uploaded_file($_FILES['photo']['tmp_name'], "photo/".$_FILES['photo']['name']);
		$link = "<script>alert('Success !!');
					window.location='../../../page.php?p=profile';</script>";
					echo $link;
	
}
mysqli_close($conn);
?>
