<?php
include ('../config/koneksi.php');

$query = mysqli_query($conn,"select * from tproblems");

while($data = mysqli_fetch_array($query)){
print $data;
}
?>
