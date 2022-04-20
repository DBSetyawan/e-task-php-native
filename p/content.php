<?php
if ($_GET['p']=='dashboardmonitor'){
    include "modul/dashboard_umum.php";
}
if ($_GET['p']=='dashboard'){
    include "modul/dashboard.php";
}
if ($_GET['p']=='dashboard-internal'){
    include "modul/dashboard-internal.php";
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
if ($_GET['p']=='masterpending'){
    include "modul/master/pending/pending.php";
}
if ($_GET['p']=='machines'){
    include "modul/master/machine/machine.php";
}
if ($_GET['p']=='machinesunit'){
    include "modul/master/machineunit/machineunit.php";
}
if ($_GET['p']=='checkdata'){
    include "modul/master/checkdata/checkdata.php";
}
if ($_GET['p']=='job'){
    include "modul/master/job/job.php";
}
if ($_GET['p']=='report'){
    include "modul/report/report.php";
}
if ($_GET['p']=='report-langkahkerja'){
    include "modul/report/report_langkahkerja.php";
}
if ($_GET['p']=='report-masalah'){
    include "modul/report/report_masalah.php";
}
if ($_GET['p']=='report-masalahfil'){
    include "modul/report/report_prob.php";
}
if ($_GET['p']=='report-reqsparepart'){
    include "modul/report/report_sparepart.php";
}
if ($_GET['p']=='input-problem'){
    include "modul/911/add-problem.php";
}
if ($_GET['p']=='input-problem-in'){
    include "modul/911/add-problem-IN.php";
}
if ($_GET['p']=='edit-problem'){
    include "modul/911/edit-problem.php";
}
if ($_GET['p']=='assign'){
    include "modul/911/911post.php";
}
if ($_GET['p']=='todolist'){
    include "modul/911/todolistd.php";
}
if ($_GET['p']=='pendingproblem'){
    include "modul/911/pendingproblem.php";
}
if ($_GET['p']=='finished'){
    include "modul/911/finishedd.php";
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
if ($_GET['p']=='msparepart'){
    include "modul/master/sparepart/sparepart.php";
}
if ($_GET['p']=='input-est-time'){
    include "modul/911/belum_estimasi.php";
}
//PENJADWALAN
if ($_GET['p']=='planning'){
    include "modul/penjadwalan/jadwal.php";
}
if ($_GET['p']=='report-jadwalmtc'){
	include "modul/report/report_jadwalmtc.php";
}

//ADJUSMENT

if ($_GET['p']=='adjustmentin'){
    include "modul/adjustment/adjustmentin.php";
}
if ($_GET['p']=='listadjustmentout'){
    include "modul/adjustment/listadjustmentout.php";
}
if ($_GET['p']=='act-adj'){
    include "modul/adjustment/act_adj.php";
}
if ($_GET['p']=='adjustmentout'){
    include "modul/adjustment/adjustmentout.php";
}
if ($_GET['p']=='searchadjustmentout'){
    include "modul/adjustment/searchadjustmentout.php";
}

if ($_GET['p']=='printadjustmentout'){
    include "modul/adjustment/print.php";
}

if ($_GET['p']=='reportadjustmentout'){
    include "modul/adjustment/reportadjustmentout.php";
}
?>