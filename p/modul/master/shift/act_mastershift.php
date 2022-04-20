<?php
//error_reporting(1);
session_start();
include('../../../../config/koneksi.php');

// Check connection
$p	    =$_GET['p'];  
$act	=$_GET['act'];
if ($p=='mastershift' AND $act=='inputshift')
{
    $date = date('Y-m-d H:i:s');
    $query = mysqli_query($conn, "INSERT INTO mshift (namaShift, createdBy, createdDate, jamMulaiShift, jamAkhirShift, Status)  values ('$_POST[namashift]', '$_SESSION[username]', '$date', '$_POST[mulai1]:$_POST[mulai2]', '$_POST[akhir1]:$_POST[akhir2]', '$_POST[status]') ");

    if($query)
    {
        echo "<script>alert('Save Success.');
        window.location='../../../page.php?p=mastershift';</script>";
    }
    else
    {
        $error = mysqli_error($conn);
        echo $error;
        // echo "<script>alert('Save Failed.$error');
        // window.location='../../../page.php?p=mastershift';</script>";

        
    }
}

if ($p=='mastershift' AND $act=='updateshift')
{
    $date = date('Y-m-d H:i:s');
    $query = mysqli_query($conn, "UPDATE  mshift set namaShift = '$_POST[namashift]', changedBy= '$_SESSION[username]', changedDate = '$date',  jamMulaiShift='$_POST[mulai1]:$_POST[mulai2]', jamAkhirShift='$_POST[akhir1]:$_POST[akhir2]', Status='$_POST[status]' WHERE idShift = $_POST[id] ");
    if($query)
    {
        echo "<script>alert('Update Success.');
        window.location='../../../page.php?p=mastershift';</script>";
    }
    else
    {
        // echo "<script>alert('Update Failed.');
        // window.location='../../../page.php?p=mastershift';</script>";
        $error = mysqli_error($conn);
        echo $error;
    }
}

if ($p=='mastershift' AND $act=='deleteshift')
{

    $query = mysqli_query($conn, "DELETE FROM  mshift WHERE idShift = $_GET[id] ");
    if($query)
    {
        echo "<script>alert('Delete Success.');
        window.location='../../../page.php?p=mastershift';</script>";
    }
    else
    {
        // echo "<script>alert('DELETE Failed.');
        // window.location='../../../page.php?p=mastershift';</script>";
        $error = mysqli_error($conn);
        echo $error;
    }
}

if ($p=='mastershift' AND $act=='getdata')
{
    header("Content-Type:application/json");
    $search = $_POST['id'];
    $shift 				= mysqli_query($conn, "SELECT * FROM mshift WHERE idShift='$search'");

    $result = array();
    $i=0;
    while ($data = mysqli_fetch_assoc($shift)) {
        // var_dump($data);die;
        $result[$i] = json_decode(json_encode($data));
        // array_push($result, (object) $data);
        $i++;
    }



    $json = json_encode($result);
    // var_dump($result);
    // var_dump($json);die;
    echo $json;

}



if ($p=='mastershift' AND $act=='inputuser')
{
    $date = date('Y-m-d H:i:s');
    $query = mysqli_query($conn, "INSERT INTO tusershift (idShift, idUser, createdBy, createdDate) values ('$_POST[namashift]', '$_POST[namauser]', '$_SESSION[username]', '$date')");
    if($query)
    {
        echo "<script>alert('Save Success.');
        window.location='../../../page.php?p=mastershift';</script>";
    }
    else
    {
        echo "<script>alert('Save Failed.');
        window.location='../../../page.php?p=mastershift';</script>";
    }
}

if ($p=='mastershift' AND $act=='updateuser')
{
    $date = date('Y-m-d H:i:s');
    $query = mysqli_query($conn, "UPDATE tusershift set idShift='$_POST[namashift]', idUser='$_POST[namauser]', changedBy='$_SESSION[username]', changedDate='$date' WHERE idUserShift=$_POST[id]");
    if($query)
    {
        echo "<script>alert('Save Success.');
        window.location='../../../page.php?p=mastershift';</script>";
    }
    else
    {
        echo "<script>alert('Save Failed.');
        window.location='../../../page.php?p=mastershift';</script>";
        
    }
}

if ($p=='mastershift' AND $act=='deleteuser')
{
    $query = mysqli_query($conn, "DELETE FROM tusershift WHERE idUserShift=$_GET[id]");
    if($query)
    {
        echo "<script>alert('Save Success.');
        window.location='../../../page.php?p=mastershift';</script>";
    }
    else
    {
        echo "<script>alert('Save Failed.');
        window.location='../../../page.php?p=mastershift';</script>";
    }  
}
if ($p=='mastershift' AND $act=='getdatauser')
{
    header("Content-Type:application/json");
    $search = $_POST['id'];
    $shift 				= mysqli_query($conn, "SELECT * FROM tusershift WHERE idUserShift='$search'");

    $result = array();
    $i=0;
    while ($data = mysqli_fetch_assoc($shift)) {
        // var_dump($data);die;
        $result[$i] = json_decode(json_encode($data));
        // array_push($result, (object) $data);
        $i++;
    }



    $json = json_encode($result);
    // var_dump($result);
    // var_dump($json);die;
    echo $json;

}
mysqli_close($conn);
?>