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

//Getting value of "search" variable from "script.js".
if (isset($_POST['nama_barang'])) {
	$Name = $_POST['nama_barang'];
	$div = $_POST['divisi'];
	$bag = $_POST['bagian'];
//Search box value assigning to $Name variable.
 
//Search query.
   $Query = "SELECT * FROM data_setok WHERE jumlah >0 and divisi='$div' and bagian='$bag' and kode_barang LIKE '%$Name%' OR nama_barang LIKE '%$Name%'  LIMIT 2";

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
	
       ?>
   <!-- Creating unordered list items.
        Calling javascript function named as "fill" found in "script.js" file.
        By passing fetched result as parameter. -->
   <li onclick='fill("<?php echo $Result['nama_barang']; ?>");idfill("<?php echo $Result['id']; ?>");kodefill("<?php echo $Result['kode_barang']; ?>");catefill("<?php echo $Result['category_barang']; ?>");'>
   <a>
   <!-- Assigning searched result in "Search box" in "search.php" file. -->
   Kode  <?php echo $Result['kode_barang']; ?> | Nama  <?php echo $Result['nama_barang']; ?>
   </li></a>
   <!-- Below php code is just for closing parenthesis. Don't be confused. -->
   <?php
	
}
  }else{
	  
	  echo" <li> Data Tidak Di Temukan </li>";
	  
  }
}
?>
</ul>