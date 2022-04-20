
<?php
/* ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL); */

include "../../../config/koneksi.php";
/* $date1 = $_GET['awal'];
$date2 = $_GET['akhir'];
$datapps=$_post['select']; */
$date= $_POST['date'];

asort($date);

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Print AdjustmentOut</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <style>
        .body{
            max-width: 500px;
        }
        .head.border {
            border: thin;
            border-style: solid;
        }
        .head.title{
            text-align: center ;
            margin-top: 20px;
            margin-right: 20px;
            margin-left: 10px;
        }
        .table-header{
            /* border: 1px solid #999; */
            border: 0px;
            width: 100%;
            
        }
        .table-header.outfit{
            padding-bottom: 10px;
        }
        .table-header.left{
            text-align: left;
            width: 30%;
        }
        .table-header.right{
            text-align: left;
            width: 50%;
        }
        .table-header.center{
            text-align: left;
            width: 20%;
        }
        .col-3{
            width: 300px;
        }
        .col-4
        {   
            width: 400px;
        }
        .container{
            
            display: grid;
            grid-template-columns: auto auto auto auto;
            grid-gap: 10px;
            align-items: center;
        }
        .container-head{
            display: grid;
            grid-template-columns: auto auto auto auto ;
            grid-gap: 10px;
            
        }
        .span2{
            grid-column: 1 / span 2;
            
        }
        .span2b{
            grid-column: 3 / span 4;
            
        }
        .span4{
            grid-column: 1 / span 4;
        }
        .container-head > div {
            padding: 10px;
        }
        .item1{
            border-style: solid;
            width: 200px;
        }
        .address{
            text-align: center;
        }
        .address > p {
            margin: 0px;
            font-size: 6pt;
        }
        .image-logo{
            text-align: center;
        }
        .image-logo > img{
            width: 100px;
        }
        .date-doc{
            margin-left: 10px;
        }
        .body-border{
            border: thin;
            border-style: solid;
        }
        .paragraph{
            font-size: 8pt;
        }
        
        .table-body{
            margin-left: 2px;
            border: 1pt;
            border-style: solid;
            border-spacing: 0pt;
        }
        .table-body > thead > tr > th {
            border: thin;
            border-style: solid;
        }
        .table-body > tbody > tr > td {
            border: thin;
            border-style: solid;
        }
        .table-pps > tbody > tr > th{
            text-align: center;
        }
        .table-ttd > thead > tr > th{
            text-align: center;
        }
        .table-ttd > tbody > tr > td{
            text-align: center;
        }
    </style>
</head>
<body>
    <div class='head border'>
        <div class="container-head">
            <div class="span2">
                <div class='head title'>
                    <b>MEMO</b>
                </div>
            </div>
            <div class="span2b">
                <div class="image-logo">
                    <img src="../../../assets/images/logo34.png" >
                </div>
                <div class="address">
                    <p>Jl. Rungkut Industri III/19, Surabaya 60293</p>
                    <p>Telp. (031)8438096, 8432182</p>
                    <p>Fax. 62.31.8432186</p>
                </div>
            </div>

        </div>
        
        <div class="container">
                <table class='table-header ' border=1 width=100%>
                    <tbody>
                        <tr>
                            <td class='table-header left paragraph'>To</td>
                            <td class='table-header center paragraph'>:</td>
                            <td class='table-header right paragraph'>Accounting</td>
                        </tr>
                        <tr>
                            <td class='table-header left paragraph'>From</td>
                            <td class='table-header center paragraph'>:</td>
                            <td class='table-header right paragraph'>Adm MTC</td>
                        </tr>
                        <tr>
                            <td class='table-header left paragraph' >Perihal</td>
                            <td class='table-header center paragraph' >:</td>
                            <td class='table-header right paragraph' >Pemakaian Sparepart</td>
                        </tr>
                    </tbody>
                </table>
            <div >
                <div class="date-doc paragraph">
                    <p align='right'><?php 
                        echo date_format(date_create($date[0]), "d M Y")." &nbsp; s/d &nbsp; ".date_format(date_create($date[count($date) - 1]), "d M Y");?></p>
                </div>
            </div>
        </div>
              
    </div>
    <div class="body-border">
        <div class="container">
            <div class="span4 paragraph">
                <p>Mohon bantuan untuk dikeluarkan dari stock pada gudang MTC untuk barang dengan rincian sebagai berikut :</p>
            </div>
            <div class="span4 paragraph">
                <table class="table-body"  width="99%">
                    <thead >
                        <tr >
                            <th style="text-align: center;">No</th>
                            <th width='20%'>Kode</th>
                            <th width='30%'>Nama Barang</th>
                            <th width='9%'>Purpose</th>
                            <th>Qty</th>
                            <th>Satuan</th>
                            <th width='14%'>No TSK</th>
                            <th width='13%'>No PPS</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        
                        if (isset($_POST['select'])) {
                            $select= $_POST['select'];
                           
                        for ($i=0; $i < count($_POST['select']) ; $i++) { 
                            
                            
                        
                        /* $query = mysqli_query($conn, "SELECT * FROM tadjustoutmaterial t 
                                                        left join tsparepart_action sa on sa.idreq = t.idreq 
                                                        left join tsparepart sp on sp.idreq = t.idreq
                                                         where t.DateAdjOut BETWEEN '$date1' AND '$date2' "); */

                        $query = mysqli_query($conn, "SELECT * FROM tadjustoutmaterial t 
                                                        left join tsparepart_action sa on sa.idreq = t.idreq 
                                                        left join tsparepart sp on sp.idreq = t.idreq
                                                         where t.DocNo='$select[$i]'");
                        $no = 1;
                        
                        while($result = mysqli_fetch_array($query))
                        {
                        
                        ?>
                        <tr>
                            <td style="text-align: center;"><?php echo $no;?></td>
                            <td><?php echo $result['MaterialCode'];?></td>
                            <td><?php echo $result['kode_sparepart'];?></td>
                            <td><?php echo $result['mesin'];?></td>
                            <td style="text-align: center;"><?php echo $result['Qty'];?></td>
                            <td style="text-align: center;"><?php echo strtoupper($result['Satuan']); ?></td>
                            <td><?php echo $result['TaskCode'];?></td>
                            <td><?php echo $result['DocNo'];?></td>
                        </tr>
                        <?php
                        $no++;
                        }
                    }
                }
                        ?> 
                    </tbody>
                </table>
            </div>
            <div class="span2 paragraph" style="margin-left: 20px;">
                <table class="table-pps">
                    <thead>
                        <?php
                        /* $query = mysqli_query($conn, "SELECT distinct t.DocNo, sp.mesin FROM tadjustoutmaterial t 
                                                        left join tsparepart_action sa on sa.idreq = t.idreq 
                                                        left join tsparepart sp on sp.idreq = t.idreq
                                                         where t.DateAdjOut BETWEEN '$date1' AND '$date2' "); */
                    

                    if (isset($_POST['select'])) 
                    {
                        $select= $_POST['select'];
                        for ($i=0; $i < count($_POST['select']) ; $i++) {
                                                                                                                                                                   
                        
                                                         /* $query = mysqli_query($conn, "SELECT distinct t.DocNo, sp.mesin FROM tadjustoutmaterial t 
                                                        left join tsparepart_action sa on sa.idreq = t.idreq 
                                                        left join tsparepart sp on sp.idreq = t.idreq
                                                         where t.DocNo = '$select[$i]' "); */
                        $date1=$date[0];
                        $date2=$date[count($date) - 1];

                                                         $query = mysqli_query($conn, "SELECT distinct t.DocNo, sp.mesin  FROM tadjustoutmaterial t 
                                                        left join tsparepart_action sa on sa.idreq = t.idreq 
                                                        left join tsparepart sp on sp.idreq = t.idreq
                                                         where t.DateAdjOut BETWEEN '$date1' AND '$date2' AND DocNo='$select[$i]' ");
                        
                        while($res= mysqli_fetch_array($query))
                        {

                            ?>
                        <tr>
                            <th><?php echo $res['mesin'];?></th>
                            <th><?php echo $res['DocNo'];?></th>
                        </tr>
                     <?php
                        }
                    }
                    }
                    
                     ?>   
                        
                    </tbody>
                </table>
                <br /><br /><br />
                <table class="table-ttd" width="100%" align='center'>
                    <thead>
                        <tr>
                            <th colspan="3" >Diajukan,</th>
                            <th colspan="3" >Diketahui,</th>
                            <th  colspan="5" >Disetujui,</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            <td ><br><br><br><br><br>(............................)</td>
                            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            <td ><br><br><br><br><br>(............................)</td>
                            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            <td ><br><br><br><br><br>(............................)</td>
                            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            
                        </tr>
                    </tbody>
                </table>
            <br>
            <br>
            <p style="font-size: 8pt;">QF.KOP-PG-7.4-001 REV : 00</p>
			<p style="font-size: 6pt;" align='right'>Memo ini di buat otomatis oleh sistem pada <?php ini_set('date.timezone', 'Asia/Jakarta');
			echo date('d M Y  H:m:s') ?></p>
            </div>   
            
        </div>

    </div>
</body>
<script>
    /* $(document).ready(function() {
        window.print();
    }); */
    <?php
        if (isset($_POST['select'])) {
            ?>window.print();<?php        
        }
        else {
            ?>
            window.alert("harus pilih pps");
            window.open("/etask_ga/p/page.php?p=searchadjustmentout", "_self");<?php
        }
    ?>
    
</script>
</html>