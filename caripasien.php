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
   $Query = "SELECT * FROM data_pasien WHERE no_rekam_medis LIKE '%$Name%' or  nama_pasien LIKE '%$Name%' LIMIT 2";
//Query execution
   $ExecQuery = MySQLi_query($koneksi, $Query);
//Creating unordered list to display result.
   echo '
<ul>
   ';
   //Fetching result from database.
   while ($Result = MySQLi_fetch_array($ExecQuery)) {
	   $idpasien=$Result['id_pasien'];
$key="dermawangroup";
$plaintext = "$idpasien";
$ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
$iv = openssl_random_pseudo_bytes($ivlen);
$ciphertext_raw = openssl_encrypt($plaintext, $cipher, $key, $options=OPENSSL_RAW_DATA, $iv);
$hmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary=true);
$ciphertext = base64_encode( $iv.$hmac.$ciphertext_raw );
       ?>
   <!-- Creating unordered list items.
        Calling javascript function named as "fill" found in "script.js" file.
        By passing fetched result as parameter. -->
   <li onclick='fill("<?php echo $ciphertext; ?>")'>
   <a>
   <!-- Assigning searched result in "Search box" in "search.php" file. -->
   <?php echo $Result['no_rekam_medis']; ?> | Nama: <?php echo $Result['nama_pasien']; ?> | Alamat: <?php echo $Result['alamat']; ?> | TGL Lahir: <?php echo $Result['tanggal_lahir']; ?>
   </li></a>
   <!-- Below php code is just for closing parenthesis. Don't be confused. -->
   <?php
}}
?>
</ul>