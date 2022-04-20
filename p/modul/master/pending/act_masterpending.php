<?php
//error_reporting(1);
session_start();
include('../../../../config/koneksi.php');

// Check connection
$p	    =$_GET['p'];  
$act	=$_GET['act'];
if ($p=='masterpending' AND $act=='inputuser')
{
    $date = date('Y-m-d H:i:s');
    $query = mysqli_query($conn, "INSERT INTO mpending (User, createdBy, createdDate) 
									values ('$_POST[namauser]', '$_SESSION[username]', NOW()) ");

    if($query)
    {
        echo "<script>alert('Save Success.');
        window.location='../../../page.php?p=masterpending';</script>";
    }
    else
    {
        $error = mysqli_error($conn);
        echo $error;
        // echo "<script>alert('Save Failed.$error');
        // window.location='../../../page.php?p=mastershift';</script>";

        
    }
}


if ($p=='masterpending' AND $act=='deletepending')
{

    $query = mysqli_query($conn, "DELETE FROM  mpending WHERE idPending = $_GET[id] ");
    if($query)
    {
        echo "<script>alert('Delete Success.');
        window.location='../../../page.php?p=masterpending';</script>";
    }
    else
    {
        // echo "<script>alert('DELETE Failed.');
        // window.location='../../../page.php?p=mastershift';</script>";
        $error = mysqli_error($conn);
        echo $error;
    }
}
mysqli_close($conn);
?>