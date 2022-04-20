<?php
//error_reporting(1);
session_start();
include('../../../../config/koneksi.php');

// Check connection
$p      =$_GET['p'];  
$act    =$_GET['act'];
if ($p=='masterapproval' AND $act=='inputapproval')
{
    $date = date('Y-m-d H:i:s');
    $query = mysqli_query($conn, "INSERT INTO mapproval (type, description)  values ('$_POST[type]', '$_POST[description]') ");

    if($query)
    {
        echo "<script>alert('Save Success.');
        window.location='../../../page.php?p=masterapproval';</script>";
    }
    else
    {
        $error = mysqli_error($conn);
        echo $error;
        // echo "<script>alert('Save Failed.$error');
        // window.location='../../../page.php?p=masterapproval';</script>";

        
    }
}

if ($p=='masterapproval' AND $act=='updateapproval')
{
    $date = date('Y-m-d H:i:s');
    $query = mysqli_query($conn, "UPDATE  mapproval set type = '$_POST[type]', description = '$_POST[description]'   WHERE idApproval = $_POST[id] ");
    if($query)
    {
        echo "<script>alert('Update Success.');
        window.location='../../../page.php?p=masterapproval';</script>";
    }
    else
    {
        // echo "<script>alert('Update Failed.');
        // window.location='../../../page.php?p=masterapproval';</script>";
        $error = mysqli_error($conn);
        echo $error;
    }
}

if ($p=='masterapproval' AND $act=='deleteapproval')
{

    $query = mysqli_query($conn, "DELETE FROM  mapproval WHERE idApproval = $_GET[id] ");
    if($query)
    {
        echo "<script>alert('Delete Success.');
        window.location='../../../page.php?p=masterapproval';</script>";
    }
    else
    {
        // echo "<script>alert('DELETE Failed.');
        // window.location='../../../page.php?p=masterapproval';</script>";
        $error = mysqli_error($conn);
        echo $error;
    }
}

if ($p=='masterapproval' AND $act=='getdata')
{
    header("Content-Type:application/json");
    $search = $_POST['id'];
    $approval              = mysqli_query($conn, "SELECT * FROM mapproval WHERE idApproval='$search'");

    $result = array();
    $i=0;
    while ($data = mysqli_fetch_assoc($approval)) {
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



if ($p=='masterapproval' AND $act=='inputuser')
{
    $date = date('Y-m-d H:i:s');
    $query = mysqli_query($conn, "INSERT INTO tuserapproval (idApproval, idUser) values ('$_POST[idapproval]', '$_POST[namauser]')");
    if($query)
    {
        echo "<script>alert('Save Success.');
        window.location='../../../page.php?p=masterapproval';</script>";
    }
    else
    {
        echo "<script>alert('Save Failed.');
        window.location='../../../page.php?p=masterapproval';</script>";
    }
}

if ($p=='masterapproval' AND $act=='updateuser')
{
    $date = date('Y-m-d H:i:s');
    $query = mysqli_query($conn, "UPDATE tuserapproval set idApproval='$_POST[idapproval]', idUser='$_POST[namauser]' WHERE idUserApproval=$_POST[id]");
    if($query)
    {
        echo "<script>alert('Save Success.');
        window.location='../../../page.php?p=masterapproval';</script>";
    }
    else
    {
        echo "<script>alert('Save Failed.');
        window.location='../../../page.php?p=masterapproval';</script>";
        
    }
}

if ($p=='masterapproval' AND $act=='deleteuser')
{
    $query = mysqli_query($conn, "DELETE FROM tuserapproval WHERE idUserApproval=$_GET[id]");
    if($query)
    {
        echo "<script>alert('Save Success.');
        window.location='../../../page.php?p=masterapproval';</script>";
    }
    else
    {
        echo "<script>alert('Save Failed.');
        window.location='../../../page.php?p=masterapproval';</script>";
    }  
}
if ($p=='masterapproval' AND $act=='getdatauser')
{
    header("Content-Type:application/json");
    $search = $_POST['id'];
    $approval              = mysqli_query($conn, "SELECT * FROM tuserapproval WHERE idUserApproval='$search'");

    $result = array();
    $i=0;
    while ($data = mysqli_fetch_assoc($approval)) {
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