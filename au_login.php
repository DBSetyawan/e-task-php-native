<?php
error_reporting(0);
session_start();
include('../config/koneksi.php');

/*$servername = "192.168.88.99";
$username = "maria";
$password = "maria123";
$db = "db_emtc_tes";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $db);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
echo "Connected successfully";
mysqli_close($conn);
*/

//jika session username belum dibuat, atau session username kosong
if (!isset($_SESSION['username']) || empty($_SESSION['username'])) {
	//redirect ke halaman login
}

$username = $_POST['username'];
$password = $_POST['password'];

// query untuk mendapatkan record dari username
$query = "SELECT * FROM user WHERE username = '$username'";
$hasil = mysqli_query($conn, $query);
$data = mysqli_fetch_array($hasil);
//$pass = md5("$data[password]");
// cek kesesuaian password
//if (md5($password, $pass))

$pass = password_hash("$data[password]", PASSWORD_DEFAULT);
// cek kesesuaian password
if (password_verify($password, $pass))
{
    // menyimpan username dan level ke dalam session
    $_SESSION['username'] = $data['username'];
    $_SESSION['level'] = $data['level'];
	$_SESSION['divisi'] = $data['divisi'];
	if (isset($_SESSION['level']))
	{
	  
	  if ($_SESSION['level'] == "admin")
	   { 
		session_start();
		$_SESSION['username']    = $username;
	        $_SESSION['password']    = $password;
		$username = $_SESSION['username'];
		
		header('location:page.php?p=dashboard');
	   }
	   else if($_SESSION['level'] == "superadmin"){
		   session_start();
			$_SESSION['username']    = $username;
			$_SESSION['password']    = $password;
			$username = $_SESSION['username'];
		    header('location:page.php?p=dashboard');
	   }
	   else {	
		   header('location:page.php?p=dashboard');
		}	
		
	}
	elseif (!isset($_SESSION['level']))
	{
	echo "<script>alert('The username or password you entered is incorrect.(level)'); window.location = 'index.php'</script>";
	  
	}
}
else {
	echo "<script>alert('The username or password you entered is incorrect.'); window.location = 'index.php'</script>";
	
}
?>
