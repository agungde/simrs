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
if (isset($_POST['beli'])) {
	$beli="True";
}else{
	$beli="";
}
//Getting value of "search" variable from "script.js".
if (isset($_POST['search'])) {
	$Name = $_POST['search'];
//Search box value assigning to $Name variable.
if (isset($_POST['cate'])) {
	$cate=$_POST['cate'];
	
	  $queryc = mysqli_query($koneksi, "SELECT * FROM `setok_barang` WHERE `category_barang`='$cate'")
                                  or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
  $rowsc = mysqli_num_rows($queryc);
  if ($rowsc <> 0) {
   // $datac = mysqli_fetch_assoc($queryc);
   // $idcate=$datac['category_barang'];
	//$Query ="SELECT * FROM `setok_barang` WHERE `category_barang`=$idcate and `nama_barang` LIKE '%$Name%' OR `kode_barang` LIKE '%$Name%' ";
	$Query = "SELECT * FROM setok_barang WHERE nama_barang LIKE '%$Name%' OR kode_barang LIKE '%$Name%' and category_barang='$cate' LIMIT 2";

  }else{
     $Query = "SELECT * FROM setok_barang WHERE category_barang='$cate'";

  }



}else{   
//Search query.
   $Query = "SELECT * FROM setok_barang WHERE kode_barang LIKE '%$Name%' OR nama_barang LIKE '%$Name%'  LIMIT 2";
}
//Query execution
   $ExecQuery = MySQLi_query($koneksi, $Query);
//Creating unordered list to display result.
   echo '
<ul>
   ';
    $rows = mysqli_num_rows($ExecQuery);
  if ($rows <> 0) {
   //Fetching result from database.
   while ($Result = MySQLi_fetch_array($ExecQuery)) {
	    $cekcate=$Result['category_barang'];
		if($beli==""){
			?>
			   <li onclick='fill("<?php echo $Result['nama_barang']; ?>")'>
   <a>
   <!-- Assigning searched result in "Search box" in "search.php" file. -->
   Kode  <?php echo $Result['kode_barang']; ?> | Nama  <?php echo $Result['nama_barang']; ?> | Harga <?php echo number_format($Result['harga_jual'],0,",","."); ?> 
   </li></a>
			<?php
		}else{
		//////////////////////Filter////////////////////////////// /* | Setok <?php echo $Result['jumlah']; 
	    if($cekcate=="$cate"){
       ?>
   <!-- Creating unordered list items.
        Calling javascript function named as "fill" found in "script.js" file.
        By passing fetched result as parameter. -->
   <li onclick='fill("<?php echo $Result['nama_barang']; ?>")'>
   <a>
   <!-- Assigning searched result in "Search box" in "search.php" file. -->
   Kode  <?php echo $Result['kode_barang']; ?> | Nama  <?php echo $Result['nama_barang']; ?> | Harga <?php echo number_format($Result['harga_jual'],0,",","."); ?> | Setok <?php echo $Result['jumlah']; ?>
   </li></a>
   <!-- Below php code is just for closing parenthesis. Don't be confused. -->
   <?php
		}
   ///////////////////////////////////////////////
		}
}
  }else{
	  if($beli==""){
	  echo" <li> Data Tidak Di Temukan </li>";
	  }else{
		  echo" <li> Data Tidak Di Temukan!!</li>";
		  echo" <li> Silahkan Pilih Menu Add Pembelian + Add Data Barang </li>";
	  }
  }
}
?>
</ul>