<?php
require('config.php');
$usrnam  = "".USER_NAME;
$id_user = "".USER_ID;
$dbhost  = "".DB_HOST;
$dbuser  = "".DB_USERNAME;
$dbpass  = "".DB_PASSWORD;
$dbname  = "".DB_NAME;
$koneksi = new mysqli($dbhost, $dbuser,$dbpass, $dbname);
$idtrace = "$id_user$usrnam";

/*
$tahun = "2018";
$bulan = "12";
$tanggal = "29";
$format = $tahun.'-'.$bulan.'-'.$tanggal;
$seminggu = abs(6*86400);
$awal = strtotime($format);
$akhir = strtotime($format)+$seminggu;
for($i=$awal; $i <=$akhir;$i+=86400)
{
$date = date('Y-m-d', $i);
$sql = $db->query("select * from invoice where tgl_invoice='$date' AND  year(tgl_invoice)='$tahun'");
$row = $sql->fetch_array();
echo $row['tgl_invoice'];
echo "<br/>";
}



SELECT YEARWEEK(tanggal) AS tahun_minggu,COUNT(*) AS jumlah_mingguan
FROM tbl_data
WHERE YEARWEEK(tanggal)=YEARWEEK(NOW())
GROUP BY YEARWEEK(tanggal);


*/


//$stmt = $db->query("SELECT CURRENT_DATE + INTERVAL '1 WEEK' FROM nama_table");

//$Query = "SELECT  DISTINCT no_request FROM data_permintaan_barang";
$Query = "SELECT  DISTINCT no_request FROM data_permintaan_barang";

$ExecQuery = MySQLi_query($koneksi, $Query);
 while ($Result = MySQLi_fetch_array($ExecQuery)) {
	    $no_request=$Result['no_request'];
		echo $no_request;
 }
//SELECT  DISTINCT tanggal AS value  FROM transaksi
?>