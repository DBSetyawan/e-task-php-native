<?php
error_reporting(0);

//include('../../config/koneksi.php');
session_start();

$status_insert_adjouth=True;
$status_insert_adjoutd=True;
$status_insert_etask=True;


$user= $_SESSION['username'] ;
$servername_sim = "192.168.88.5";
$username_sim = "root";
$password_sim = "19K23O15P";
$db_sim = "kristest";
$sim = mysqli_connect($servername_sim, $username_sim, $password_sim, $db_sim);



//$date = date("Y-m")."-01";
$strtime = strtotime("$_POST[docdate]");
$date = date("ymd", $strtime);
$query = mysqli_query($sim, "SELECT DocNo from adjustouth where docno like '%PPS-$date%' order by DocNo DESC limit 1");
$data=mysqli_fetch_assoc($query);
//$date=date("ymd");
$kodelama=$data['DocNo'];
$noUrut = (int) substr($kodelama, 13, 4);
$noUrut++;
$char = "PPS-$date-";
$newID = $char . sprintf("%04s", $noUrut);



echo "Series $_POST[series]<br>";
echo "DocNo $newID<br>";
echo "Docdate $_POST[docdate]<br>";
echo "TransactionType $_POST[trans_type]<br>";
echo "Location $_POST[location]<br>";
echo "Information $_POST[information]<br>";

$per=date("Y-m-01");
echo "periode $per<br>";
$totaltagno=count($_POST[tagno]);
echo "$totaltagno";
$tg =$_POST[tagno][0];

echo "tagno : $tg";

$totalprice=0;
for ($i=0; $i < $totaltagno; $i++) { 
	$tg =$_POST[tagno][$i];
	$qty= $_POST[qty][$i];
	$material=$_POST[material][$i];
	

	$query = mysqli_query($sim, "SELECT stockbalance.* , mastermaterial.Name,mastermaterial.smallestunit FROM stockbalance left join mastermaterial on mastermaterial.code = stockbalance.materialcode where stockbalance.tagno = $tg and stockbalance.materialcode ='$material' and stockbalance.periode = '$per' and stockbalance.QtyEnd >  0.0000 ");
	$data2=mysqli_fetch_array($query);

	
	$price_item = $qty *  $data2[Price];
	
	$totalprice = $totalprice + $price_item;
}

echo "Grandtotal = $totalprice<br>";

$newformatgrandtotal = number_format($totalprice,4,'.');

//adjustout db_emtc


//adjustouth
$query_adjouth ="
INSERT INTO adjustouth
(
  DocNo
 ,Series
 ,TransactionType
 ,DocDate
 ,Location
 ,Information
 ,Status
 ,TotalCost
 ,IsApproved
 ,ApprovedBy
 ,ApprovedDate
 ,PrintCounter
 ,PrintedBy
 ,PrintedDate
 ,CreatedBy
 ,CreatedDate
 ,ChangedBy
 ,ChangedDate
)
VALUES
(
  '$newID' -- DocNo - VARCHAR(15) NOT NULL
 ,'PPS' -- Series - VARCHAR(3) NOT NULL
 ,'$_POST[trans_type]' -- TransactionType - VARCHAR(20) NOT NULL
 ,NOW() -- DocDate - DATE NOT NULL
 ,'G19SP' -- Location - VARCHAR(5) NOT NULL
 ,'$_POST[information]' -- Information - VARCHAR(255) NOT NULL
 ,'OPEN' -- Status - VARCHAR(20) NOT NULL
 ,$totalprice -- TotalCost - DECIMAL(18, 4) NOT NULL
 ,0 -- IsApproved - BIT(1) NOT NULL
 ,'' -- ApprovedBy - VARCHAR(16) NOT NULL
 ,NOW() -- ApprovedDate - DATETIME
 ,0 -- PrintCounter - INT(10) NOT NULL
 ,'' -- PrintedBy - VARCHAR(16)
 ,NOW() -- PrintedDate - DATETIME
 ,'$user' -- CreatedBy - VARCHAR(16) NOT NULL
 ,NOW() -- CreatedDate - DATETIME NOT NULL
 ,'$user' -- ChangedBy - VARCHAR(16) NOT NULL
 ,NOW() -- ChangedDate - DATETIME NOT NULL
);";

if(mysqli_query($sim, $query_adjouth))
{
	echo " <br> <br> insert header success <br>";
	for ($i=0; $i < $totaltagno; $i++) { 
		$tg =$_POST[tagno][$i];
		$qty= $_POST[qty][$i];
		$material=$_POST['material'][$i];
		$query_get="SELECT stockbalance.* , mastermaterial.Name,mastermaterial.smallestunit FROM stockbalance left join mastermaterial on mastermaterial.code = stockbalance.materialcode where stockbalance.tagno = $tg and stockbalance.materialcode ='$material' and stockbalance.periode = '$per' and stockbalance.QtyEnd >  0.0000 ";
		$query = mysqli_query($sim, $query_get);
		$data2=mysqli_fetch_array($query);
		//echo $query_get.'<br>';
		echo "<br> Code $data2[MaterialCode] <br>";
		echo "name $data2[Name] <br>";
		echo "tagno $data2[TagNo] <br>";
		echo "unit $data2[smallestunit] <br>";
		echo "qty $qty<br>";
		echo "price $data2[Price]<br>";
		$price_item = $qty *  $data2[Price];
		echo "total price = $price_item <br><br>";
		$totalprice = $totalprice + $price_item;
		$newformatpriceitem = number_format($price_item,4,'.');
		$unit=$_POST['unit'][$i];
		echo "unit :".$unit;
		$query_adjoutd="
		INSERT INTO adjustoutd
		(
		  DocNo
		 ,MaterialCode
		 ,TagNo
		 ,Zone
		 ,Bin
		 ,Unit
		 ,Qty
		 ,Cost
		)
		VALUES
		(
		  '$newID' -- DocNo - VARCHAR(15) NOT NULL
		 ,'$data2[MaterialCode]' -- MaterialCode - VARCHAR(20) NOT NULL
		 ,'$data2[TagNo]' -- TagNo - VARCHAR(10) NOT NULL
		 ,'' -- Zone - VARCHAR(10) NOT NULL
		 ,'' -- Bin - VARCHAR(10) NOT NULL
		 ,'$unit' -- Unit - VARCHAR(5) NOT NULL
		 ,$qty -- Qty - DECIMAL(18, 4) NOT NULL
		 ,$price_item -- Cost - DECIMAL(18, 4) NOT NULL
		);";

		if (mysqli_query($sim,$query_adjoutd)) {
			echo "maeterial $data2[MaterialCode] success";
		}
		else
		{
			echo "error insert detail material $data2[MaterialCode] ".mysqli_error($sim);
			echo "<br>$query_adjoutd<br>";
			$status_insert_adjoutd=False;
		}
	}
}
else
{
	echo "error insert header : ".mysqli_error($sim);
	$status_insert_adjouth=False;
}

// for ($i=0; $i < $totaltagno; $i++) { 
$jumlahreq= count($_POST['req']);
for ($i=0; $i < $jumlahreq; $i++) { 
	$materialcode=$_POST['mat_awal'][$i];
	$taskcode=$_POST['etask'][$i];
	$qty=$_POST['qty_awal'][$i];
	$satuan=$_POST['unit_awal'][$i];
	$idrequest=$_POST['req'][$i];
	$db_emtc="

	INSERT INTO tadjustoutmaterial
	(
	  DocNo
	 ,MaterialCode
	 ,TaskCode
	 ,Qty
	 ,DateAdjOut
	 ,AdjOutBy
	 ,Satuan
	 ,idReq
	)
	VALUES
	(
	  '$newID' -- DocNo - VARCHAR(255) NOT NULL
	 ,'$materialcode' -- MaterialCode - VARCHAR(255) NOT NULL
	 ,'$taskcode' -- TaskCode - VARCHAR(255) NOT NULL
	 ,'$qty' -- Qty - VARCHAR(45) NOT NULL
	 ,NOW() -- DateAdjOut - DATE
	 ,'$user' -- AdjOutBy - VARCHAR(45) NOT NULL
	 ,'$satuan' -- Satuan - VARCHAR(45) NOT NULL
	 ,$idrequest);";

	if (mysqli_query($conn,$db_emtc)) {
		echo "berhasil";
	}
	else
	{
		echo "gagal bikin PRS".mysqli_error($conn);
		$status_insert_etask = False;
	}
}


if ($status_insert_etask == True && $status_insert_adjouth == True && $status_insert_adjoutd == True) {
	echo "<script>alert('Data Inserted : $newID');window.location='page.php?p=listadjustmentout';</script>";
}

?>

