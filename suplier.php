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
   $Query = "SELECT * FROM data_suplier WHERE id_suplier LIKE '%$Name%' OR nama LIKE '%$Name%' OR alamat LIKE '%$Name%' OR no_hp LIKE '%$Name%'  LIMIT 2";
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
   <li onclick='fillpel("<?php echo $Result['nama']; ?>")'>
   <a>
   <!-- Assigning searched result in "Search box" in "search.php" file. -->
   ID  <?php echo $Result['id_suplier']; ?>  Nama  <?php echo $Result['nama']; ?> Alamat <?php echo $Result['alamat']; ?> No HP <?php echo $Result['no_hp']; ?>
   </li></a>
   <!-- Below php code is just for closing parenthesis. Don't be confused. -->
   <?php
}}
?>
</ul>