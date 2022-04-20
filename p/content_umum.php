<?php
if ($_GET['p']=='dashboardmonitor'){
    include "modul/dashboardmonitor.php";
}
if ($_GET['p']=='dashboard'){
    include "modul/dashboard.php";
}
if ($_GET['p']=='new-post'){
    include "modul/actlog/lpost.php";
}
if ($_GET['p']=='users'){
    include "modul/master/users/user.php";
}
if ($_GET['p']=='profile'){
    include "modul/master/users/profile.php";
}
if ($_GET['p']=='categories'){
    include "modul/master/category/category.php";
}
if ($_GET['p']=='division'){
    include "modul/master/division/division.php";
}
if ($_GET['p']=='machines'){
    include "modul/master/machine/machine.php";
}
if ($_GET['p']=='machinesunit'){
    include "modul/master/machineunit/machineunit.php";
}

if ($_GET['p']=='job'){
    include "modul/master/job/job.php";
}
if ($_GET['p']=='report'){
    include "modul/report/report.php";
}
if ($_GET['p']=='input-problem'){
    include "modul/911/add-problem.php";
}
if ($_GET['p']=='assign'){
    include "modul/911/911post.php";
}
if ($_GET['p']=='todolist'){
    include "modul/911/todolist.php";
}

if ($_GET['p']=='finished'){
    include "modul/911/finished.php";
}
if ($_GET['p']=='sparepart'){
    include "modul/911/sparepart/listsparepart.php";
}
if ($_GET['p']=='mastershift'){
    include "modul/master/shift/mastershift.php";
}
if ($_GET['p']=='masterapproval'){
    include "modul/master/approval/masterapproval.php";
}
?>