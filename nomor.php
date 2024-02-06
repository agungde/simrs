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
  $query = mysqli_query($koneksi, "select * from data_barang_temp limit 0,10") or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
  // ambil jumlah baris data hasil query
  $rows = mysqli_num_rows($query);
  if ($rows <> 0) {
      while ($row=mysqli_fetch_array($query)){
 $harga=$row['harga_beli'];
 $harga=str_replace(',','',$harga);
 $hargalen=strlen($harga);
 $cekharga  = substr($harga, 2, $hargalen);
 $num = "$cekharga";
$int = (int)$num;
echo "Tes >$int<</br>";
 echo "Tes >$hargalen<</br>";
	  }
  }
?>