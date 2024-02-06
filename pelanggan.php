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
if (isset($_POST['search'])) {
//Search box value assigning to $Name variable.
   $Name = $_POST['search'];
//Search query.
   $Query = "SELECT * FROM pelanggan WHERE id_pelanggan LIKE '%$Name%' OR nama_pelanggan LIKE '%$Name%' OR alamat LIKE '%$Name%' OR phone LIKE '%$Name%'  LIMIT 2";
//Query execution
   $ExecQuery = MySQLi_query($koneksi, $Query);
//Creating unordered list to display result.
   echo '
<ul>
   ';
   //Fetching result from database.
   while ($Result = MySQLi_fetch_array($ExecQuery)) {
       ?>
   <!-- Creating unordered list items.
        Calling javascript function named as "fill" found in "script.js" file.
        By passing fetched result as parameter. -->
   <li onclick='fillpel("<?php echo $Result['nama_pelanggan']; ?>")'>
   <a>
   <!-- Assigning searched result in "Search box" in "search.php" file. -->
   ID  <?php echo $Result['id_pelanggan']; ?>  Nama  <?php echo $Result['nama_pelanggan']; ?> Alamat <?php echo $Result['alamat']; ?> No HP <?php echo $Result['phone']; ?>
   </li></a>
   <!-- Below php code is just for closing parenthesis. Don't be confused. -->
   <?php
}}
?>
</ul>