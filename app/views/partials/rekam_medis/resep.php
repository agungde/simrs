<?php
$comp_model = new SharedController;
$page_element_id = "add-page-" . random_str();
$current_page = $this->set_current_page_link();
$csrf_token = Csrf::$token;
$show_header = $this->show_header;
$view_title = $this->view_title;
$redirect_to = $this->redirect_to;
?>
<section class="page" id="<?php echo $page_element_id; ?>" data-page-type="add"  data-display-type="" data-page-url="<?php print_link($current_page); ?>">
    <?php
    if( $show_header == true ){
    ?>
    <div  class="bg-white p-1 mb-1">
        <div class="container">
            <div class="row ">
                <div class="col ">
                    <div class=""><div>
                        <?php
                        $id_user = "".USER_ID;
                        $dbhost  = "".DB_HOST;
                        $dbuser  = "".DB_USERNAME;
                        $dbpass  = "".DB_PASSWORD;
                        $dbname  = "".DB_NAME;
                        //$koneksi=open_connection();
                        $koneksi = new mysqli($dbhost, $dbuser,$dbpass, $dbname);
                        if(!empty($_GET['precord'])){
                        $ciphertext = $_GET['precord'];
                        $backlink=$ciphertext;
                        $ciphertext=str_replace(' ', '+', $ciphertext);
                        $resep=$ciphertext;
                        $key="dermawangroup";
                        $c = base64_decode($ciphertext);
                        $ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
                        $iv = substr($c, 0, $ivlen);
                        $hmac = substr($c, $ivlen, $sha2len=32);
                        $ciphertext_raw = substr($c, $ivlen+$sha2len);
                        $original_plaintext = openssl_decrypt($ciphertext_raw, $cipher, $key, $options=OPENSSL_RAW_DATA, $iv);
                        $calcmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary=true);
                        if (hash_equals($hmac, $calcmac))// timing attack safe comparison
                        {
                        // echo $original_plaintext."\n";
                        }
                        $sqlcek2 = mysqli_query($koneksi,"select * from pendaftaran_poli WHERE id_pendaftaran_poli='$original_plaintext'");
                        $rowspa = mysqli_num_rows($sqlcek2);
                        if ($rowspa <> 0) {
                        }else{
                        ?>
                        <script language="JavaScript">
                            alert('Dilarang Akses URL Tidak Valid');
                            document.location='<?php print_link("pendaftaran_poli"); ?>';
                        </script>
                        <?php } 
                        $sqlcek1 = mysqli_query($koneksi,"select * from pendaftaran_poli WHERE id_pendaftaran_poli='$original_plaintext'");
                        $rows1 = mysqli_num_rows($sqlcek1);
                        if ($rows1 <> 0) {
                        $row= mysqli_fetch_assoc($sqlcek1); 
                        $no_rekam_medis=$row['no_rekam_medis'];
                        $nama_pasien=$row['nama_pasien'];
                        $alamat=$row['alamat'];
                        $no_hp=$row['no_hp'];
                        $tanggal_lahir=$row['tanggal_lahir'];
                        $jenis_kelamin=$row['jenis_kelamin'];
                        $email=$row['email'];
                        $umur=$row['umur'];
                        $tinggi=$row['tinggi'];
                        $berat_badan=$row['berat_badan'];
                        $tensi=$row['tensi'];
                        $suhu_badan=$row['suhu_badan'];
                        $tanggal=$row['tanggal'];
                        $keluhan=$row['keluhan'];
                        $id_dokter=$row['dokter'];
                        $idtrx=$row['id_transaksi'];
                        }
                        $sqlcek3 = mysqli_query($koneksi,"select * from data_dokter WHERE id_dokter='$id_dokter'");
                        while ($row3=mysqli_fetch_array($sqlcek3)){
                        $nama_dokter=$row3['nama_dokter'];
                        $nama_poli=$row3['specialist'];
                        }
                        $sqlcek4 = mysqli_query($koneksi,"select * from data_poli WHERE id_poli='$nama_poli'");
                        while ($row4=mysqli_fetch_array($sqlcek4)){
                        $namapoli=$row4['nama_poli'];
                        }
                        }else{
                        ///////////////////////Simpan///////////////////////
                        if(isset($_POST['prosesresep'])){
                        $iddaftar=$_POST['prosesresep'];
                        }
                        ////////////////////////////////////ADD///////////////////
                        if(isset($_POST['addresep'])){
                        $precodback = $_POST['precodback'];
                        $uname  = $_POST['name'];
                        $idpoli = $_POST['precod'];
                        $aturan = $_POST['aturan'];
                        $aturan1 = $_POST['aturan1'];
                        $aturan2 = $_POST['aturan2'];
                        $qty    = $_POST['qty'];
                        $keterangan =$_POST['keterangan'];
                        $modelresep=$_POST['addresep'];
                        $sql = mysqli_query($koneksi,"select * from pendaftaran_poli WHERE id_pendaftaran_poli='$idpoli'");
                        while ($row=mysqli_fetch_array($sql)){
                        $no_rekam_medis=$row['no_rekam_medis'];
                        $alamat=$row['alamat'];
                        $nama_pasien=$row['nama_pasien'];
                        $tanggal=$row['tanggal'];
                        $nama_poli=$row['nama_poli'];
                        $tanggal_lahir=$row['tanggal_lahir'];
                        $phone=$row['no_hp'];
                        $dokter=$row['dokter'];
                        $pembayaran=$row['pembayaran'];
                        $idtrx=$row['id_transaksi'];
                        }   
                        $sqlcek3 = mysqli_query($koneksi,"select * from data_dokter WHERE id_dokter='$dokter'");
                        while ($row3=mysqli_fetch_array($sqlcek3)){
                        $nama_dokter=$row3['nama_dokter'];
                        }            
                        $thn  = substr($tanggal_lahir, 0, 4);
                        $taun = date("Y");
                        $umur = $taun - $thn;
                        $umur = substr($umur, 0, 2);
                        function hitung_umur($thn){
                        $birthDate = new DateTime($thn);
                        $today = new DateTime("today");
                        if ($birthDate > $today) { 
                        exit("0 tahun 0 bulan 0 hari");
                        }
                        $y = $today->diff($birthDate)->y;
                        $m = $today->diff($birthDate)->m;
                        $d = $today->diff($birthDate)->d;
                        return $y."Tahun ".$m."Bulan ".$d."Hari";
                        }
                        $umurnya=hitung_umur("$tanggal_lahir"); 
                        if($modelresep=="racikan"){
                        $queryrc = mysqli_query($koneksi, "SELECT max(racikan) as nomor from data_resep WHERE id_transaksi='$idtrx' and no_rekam_medis='$no_rekam_medis'")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                        $rowsrc = mysqli_num_rows($queryrc);
                        if ($rowsrc <> 0) {
                        $datarc = mysqli_fetch_assoc($queryrc);
                        $noracikan = $datarc['nomor'] + 1;
                        }
                        else {
                        // "no_antrian" = 1
                        $noracikan = 1;
                        }
                        }else{
                        $noracikan="0";
                        }  
                        $jumtotbeli="0";
                        $jumtotjual="0";
                        $jumqty="0";  
                        if(!empty($uname)){
                        for($a = 0; $a < count($uname); $a++){
                        if(!empty($uname[$a])){
                        $unames  = $uname[$a];
                        if($modelresep=="racikan"){
                        $kali="X";
                        $at=$aturan;
                        $at1=$aturan1;
                        $at2=$aturan2;
                        $aturans = "$at$kali$at1 $at2"; 
                        }else{
                        $kali="X";
                        $at=$aturan[$a];
                        $at1=$aturan1[$a];
                        $at2=$aturan2[$a];
                        $aturans = "$at$kali$at1 $at2";  
                        }
                        $qtys    = $qty[$a];
                        $cekluardat  = substr($unames, 0, 4);
                        $bacaluar=strlen("$unames");
                        $idluar  = substr($unames, 4, $bacaluar);
                        if($cekluardat=="Luar"){
                        $query1 = mysqli_query($koneksi, "select * from resep_obat WHERE tebus_resep='Luar' and no_rekam_medis='$no_rekam_medis' and id_daftar='$idpoli' and resep='0'")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                        $rows1 = mysqli_num_rows($query1);
                        if ($rows1 <> 0) {
                        $data1 = mysqli_fetch_assoc($query1);
                        $idresepobat=$data1['id_resep_obat'];
                        }else{
                        mysqli_query($koneksi,"INSERT INTO `resep_obat` (`pasien`,`pembayaran`,`tebus_resep`,`id_daftar`,`no_rekam_medis`, `tanggal`, `nama_poli`, `nama_pasien`, `alamat`, `tanggal_lahir`, `umur`, `nama_dokter`) VALUES ('POLI','Luar','Luar','$idpoli','$no_rekam_medis', '$tanggal', '$nama_poli', '$nama_pasien', '$alamat', '$tanggal_lahir', '$umurnya', '$nama_dokter')");  
                        } 
                        $query2 = mysqli_query($koneksi, "select * from resep_obat WHERE tebus_resep='Luar' and id_daftar='$idpoli' and no_rekam_medis='$no_rekam_medis' and resep='0'")  or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                        $rows2 = mysqli_num_rows($query2);
                        if ($rows2 <> 0) {
                        $data2 = mysqli_fetch_assoc($query2);
                        $idresepobat=$data2['id_resep_obat'];
                        }else{}     
                        $sqlcek4 = mysqli_query($koneksi,"select * from setok_barang WHERE id_barang='$idluar'");
                        while ($row4=mysqli_fetch_array($sqlcek4)){
                        $nama_obat=$row4['nama_barang'];
                        $satuan=$row4['satuan'];
                        $idobatluar=$row4['id_barang'];
                        $jumlah=$row4['jumlah'];
                        $harga_jual=$row4['harga_jual'];
                        $isi_nama="$nama_obat ($satuan)";
                        }         
                        mysqli_query($koneksi,"INSERT INTO `data_resep` (`id_transaksi`,`id_daftar`,`keterangan`,`racikan`,`tebus_resep`,`id_resep_obat`,`id_obat`, `no_rekam_medis`, `tanggal`, `nama_poli`, `nama_pasien`, `alamat`, `tanggal_lahir`, `umur`, `nama_dokter`, `nama_obat`, `aturan_minum`, `jumlah`) VALUES ('$idtrx','$idpoli','$keterangan','$noracikan','Luar','$idresepobat','$idobatluar', '$no_rekam_medis', '$tanggal', '$nama_poli', '$nama_pasien', '$alamat', '$tanggal_lahir', '$umurnya', '$nama_dokter', '$isi_nama', '$aturans', '$qtys')");  
                        }else{     
                        $reseptebusluar="";
                        $iddsetok=0;
                        /////////////////////////////////////////////////////////////////////////                       
                        $sqlcek4 = mysqli_query($koneksi,"select * from setok_barang WHERE id_barang='$unames'");
                        while ($row4=mysqli_fetch_array($sqlcek4)){
                        $nama_obat=$row4['nama_barang'];
                        $kode_obat=$row4['kode_barang'];
                        $satuan=$row4['satuan'];
                        $jumlah=$row4['jumlah'];
                        $harga_beli=$row4['harga_beli'];
                        $harga_jual=$row4['harga_jual'];
                        $isi_nama="$nama_obat ($satuan)";
                        } 
                        $divisi = "FARMASI";
                        $bag    = "FARMASI";  
                        $qudat = mysqli_query($koneksi, "SELECT * from data_setok WHERE kode_barang='$kode_obat' and divisi='$divisi' and bagian='$bag' and jumlah >0")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                        $rodtpab = mysqli_num_rows($qudat);
                        if ($rodtpab <> 0) {
                        $cdt= mysqli_fetch_assoc($qudat);
                        $jumdatsetok=$cdt['jumlah'];
                        $iddsetok=$cdt['id'];
                        }else{
                        $jumdatsetok="";     
                        }
                        if($jumdatsetok==""){
                        if($jumlah > $qtys or $jumlah==$qtys){
                        $stoks=$jumlah - $qtys;          
                        mysqli_query($koneksi,"UPDATE setok_barang SET jumlah='$stoks' WHERE id_barang='$unames'");
                        $ket_setok="GUDANG";
                        $bag    = "GUDANG"; 
                        }else{
                        $reseptebusluar="Ya"; 
                        }
                        }else{
                        if($jumdatsetok > $qtys or $jumdatsetok == $qtys ){
                        $stoks=$jumdatsetok - $qtys;
                        mysqli_query($koneksi,"UPDATE data_setok SET jumlah='$stoks' WHERE kode_barang='$kode_obat' and divisi='$divisi' and bagian='$bag'"); 
                        $ket_setok="FARMASI";
                        // $bag    = "FARMASI";
                        }else{
                        if($jumlah > $qtys or $jumlah==$qtys){
                        $stoks=$jumlah - $qtys;          
                        mysqli_query($koneksi,"UPDATE setok_barang SET jumlah='$stoks' WHERE id_barang='$unames'"); 
                        $ket_setok="GUDANG";
                        $bag    = "GUDANG"; 
                        }else{
                        $reseptebusluar="Ya"; 
                        }                        
                        }  
                        }
                        if($reseptebusluar=="") {     
                        /////////////////////////////////////////penjualan///////////////////////
                        $query = mysqli_query($koneksi, "select * from resep_obat WHERE id_daftar='$idpoli' and no_rekam_medis='$no_rekam_medis' and tebus_resep='' and resep='0' ORDER BY `id_resep_obat` DESC")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                        $rows = mysqli_num_rows($query);
                        if ($rows <> 0) {
                        $data = mysqli_fetch_assoc($query);
                        $idresepobat=$data['id_resep_obat'];
                        }else{
                        mysqli_query($koneksi,"INSERT INTO `resep_obat` (`pasien`,`id_daftar`,`no_rekam_medis`, `tanggal`, `nama_poli`, `nama_pasien`, `alamat`, `tanggal_lahir`, `umur`, `nama_dokter`) VALUES ('POLI','$idpoli','$no_rekam_medis', '$tanggal', '$nama_poli', '$nama_pasien', '$alamat', '$tanggal_lahir', '$umurnya', '$nama_dokter')");    
                        $queryr = mysqli_query($koneksi, "select * from resep_obat WHERE id_daftar='$idpoli' and no_rekam_medis='$no_rekam_medis' ORDER BY `id_resep_obat` DESC")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                        $rowsr = mysqli_num_rows($queryr);
                        if ($rowsr <> 0) {
                        $datar = mysqli_fetch_assoc($queryr);
                        $idresepobat=$datar['id_resep_obat'];
                        }  
                        } 
                        $queryp = mysqli_query($koneksi, "select * from penjualan WHERE id_jual='$idpoli' and id_pelanggan='$no_rekam_medis' and resep='0'")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                        $rowsp = mysqli_num_rows($queryp);
                        if ($rowsp <> 0) {
                        $datap = mysqli_fetch_assoc($queryp);
                        $id_penjualan=$datap['id_penjualan'];
                        }else{
                        mysqli_query($koneksi,"INSERT INTO `penjualan` (`trx`,`id_jual`,`no_hp`,`id_pelanggan`, `tanggal`, `nama_pelanggan`, `alamat`) VALUES ('Clinik','$idpoli','$phone','$no_rekam_medis', '$tanggal', '$nama_pasien', '$alamat')"); 
                        $querypb = mysqli_query($koneksi, "select * from penjualan WHERE id_jual='$idpoli' and id_pelanggan='$no_rekam_medis'")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                        $rowspb = mysqli_num_rows($querypb);
                        if ($rowspb <> 0) {
                        $datapb = mysqli_fetch_assoc($querypb);
                        $id_penjualan=$datapb['id_penjualan'];
                        }
                        }                      
                        mysqli_query($koneksi,"INSERT INTO `data_resep` (`id_data_setok`,`bagian`,`ket_setok`,`id_transaksi`,`id_daftar`,`keterangan`,`racikan`,`id_resep_obat`,`id_obat`, `no_rekam_medis`, `tanggal`, `nama_poli`, `nama_pasien`, `alamat`, `tanggal_lahir`, `umur`, `nama_dokter`, `nama_obat`, `aturan_minum`, `jumlah`) VALUES ('$iddsetok','$bag','$ket_setok','$idtrx','$idpoli','$keterangan','$noracikan','$idresepobat','$unames', '$no_rekam_medis', '$tanggal', '$nama_poli', '$nama_pasien', '$alamat', '$tanggal_lahir', '$umurnya', '$nama_dokter', '$isi_nama', '$aturans', '$qtys')"); 
                        $totharga=$harga_jual * $qtys;
                        /*
                        mysqli_query($koneksi,"INSERT INTO `data_penjualan` (`id_penjualan`,`no_hp`,`kode_barang`,`nama_poli`,`id_pelanggan`, `tanggal`, `nama_pelanggan`, `alamat`, `nama_barang`, `jumlah`, `harga`, `total_harga`, `total_bayar`) VALUES ('$id_penjualan','$phone','$kode_obat','$nama_poli','$no_rekam_medis', '$tanggal', '$nama_pasien', '$alamat', '$nama_obat', '$qtys', '$harga_jual', '$totharga', '$totharga')"); 
                        */
                        $totbeli=$harga_beli * $qtys;
                        $jumtotbeli=$jumtotbeli + $totbeli;
                        $jumtotjual=$jumtotjual + $totharga;
                        //////////////////////////////////////////
                        $jumqty=$jumqty + $qtys;
                        }else{
                        $query1 = mysqli_query($koneksi, "select * from resep_obat WHERE tebus_resep='Luar' and no_rekam_medis='$no_rekam_medis' and id_daftar='$idpoli' and resep='0'")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                        $rows1 = mysqli_num_rows($query1);
                        if ($rows1 <> 0) {
                        $data1 = mysqli_fetch_assoc($query1);
                        $idresepobat=$data1['id_resep_obat'];
                        }else{
                        /////////////////////////////////////////luar///////////////////
                        mysqli_query($koneksi,"INSERT INTO `resep_obat` (`pasien`,`pembayaran`,`tebus_resep`,`id_daftar`,`no_rekam_medis`, `tanggal`, `nama_poli`, `nama_pasien`, `alamat`, `tanggal_lahir`, `umur`, `nama_dokter`) VALUES ('POLI','Luar','Luar','$idpoli','$no_rekam_medis', '$tanggal', '$nama_poli', '$nama_pasien', '$alamat', '$tanggal_lahir', '$umurnya', '$nama_dokter')");  
                        } 
                        $query2 = mysqli_query($koneksi, "select * from resep_obat WHERE tebus_resep='Luar' and id_daftar='$idpoli' and no_rekam_medis='$no_rekam_medis' and resep='0'")  or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                        $rows2 = mysqli_num_rows($query2);
                        if ($rows2 <> 0) {
                        $data2 = mysqli_fetch_assoc($query2);
                        $idresepobat=$data2['id_resep_obat'];
                        }else{}     
                        $sqlcek4 = mysqli_query($koneksi,"select * from setok_barang WHERE id_barang='$idluar'");
                        while ($row4=mysqli_fetch_array($sqlcek4)){
                        $nama_obat=$row4['nama_barang'];
                        $satuan=$row4['satuan'];
                        $idobatluar=$row4['id_barang'];
                        $jumlah=$row4['jumlah'];
                        $harga_jual=$row4['harga_jual'];
                        $isi_nama="$nama_obat ($satuan)";
                        }         
                        mysqli_query($koneksi,"INSERT INTO `data_resep` (`id_transaksi`,`id_daftar`,`keterangan`,`racikan`,`tebus_resep`,`id_resep_obat`,`id_obat`, `no_rekam_medis`, `tanggal`, `nama_poli`, `nama_pasien`, `alamat`, `tanggal_lahir`, `umur`, `nama_dokter`, `nama_obat`, `aturan_minum`, `jumlah`) VALUES ('$idtrx','$idpoli','$keterangan','$noracikan','Luar','$idresepobat','$idobatluar', '$no_rekam_medis', '$tanggal', '$nama_poli', '$nama_pasien', '$alamat', '$tanggal_lahir', '$umurnya', '$nama_dokter', '$isi_nama', '$aturans', '$qtys')");    
                        ///////////////////////////////////end////////////////////////
                        }              
                        ////////////////////////////////////////////////end//////////////////////////////
                        }
                        //////////////////////////////////////////
                        }
                        }
                        } 
                        /*
                        $querydtr = mysqli_query($koneksi, "SELECT max(resep) as nomor from data_resep WHERE id_daftar='$idpoli' and tebus_resep='Luar'")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                        $rowsdtr = mysqli_num_rows($querydtr);
                        if ($rowsdtr <> 0) {
                        $datadtr       = mysqli_fetch_assoc($querydtr);
                        $noresep = $datadtr['nomor'] + 1;
                        }else{
                        $noresep=1;  
                        }
                        mysqli_query($koneksi,"UPDATE data_resep SET setatus='Register', resep='$noresep' WHERE id_resep_obat='$id_resep_obat' and tebus_resep='Luar'");
                        */
                        ?>
                        <script language="JavaScript">
                            <?php if($modelresep=="racikan"){ ?>
                            document.location='<?php print_link("rekam_medis/resep?precord=$precodback&pesanresep=racikan"); ?>';
                            <?php }else{?>
                            document.location='<?php print_link("rekam_medis/resep?precord=$precodback&pesanresep=racikan"); ?>';
                            <?php }?>
                        </script>
                        <?php
                        }else{
                        ?>
                        <script language="JavaScript">
                            alert('Dilarang Akses Add Langsung');
                            document.location='<?php print_link(""); ?>';
                        </script>
                        <?php 
                        }
                        }
                        ?>
                        </div></div><h4 class="record-title">Add New Resep Obat  <?php
                    if(!empty($_GET['racikan'])){ echo "Racikan";}?></h4>
                </div>
            </div>
        </div>
    </div>
    <?php
    }
    ?>
    <div  class="">
        <div class="container">
            <div class="row ">
                <div class="col-md-10 comp-grid">
                    <div class=""> <div id="page-report-body" class="table-responsive">
                        <table class=" bg-white">
                            <tr><td>
                                <table >
                                    <tr >
                                        <th align="left"> Tanggal: </th>
                                        <td >
                                            <?php echo $tanggal; ?> 
                                        </td>
                                    </tr>
                                    <tr >
                                        <th align="left"> No Rekam Medis: </th>
                                        <td >
                                            <?php echo $no_rekam_medis; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th align="left"> Nama Pasien: </th>
                                        <td >
                                            <?php echo $nama_pasien; ?> 
                                        </td>
                                    </tr>
                                    <tr>
                                        <th align="left"> Alamat: </th>
                                        <td >
                                            <?php echo $alamat; ?> 
                                        </td>
                                    </tr>
                                </tr>        
                            </table>
                        </td>
                        <td >  
                            <table >
                                <tr>
                                    <th align="left"> Tanggal Lahir</th>
                                    <td >
                                        <?php echo $tanggal_lahir; ?> 
                                    </td>
                                </tr> 
                                <tr>
                                    <th align="left">&nbsp;&nbsp;Umur: </th>
                                    <td >
                                        <?php echo $umur; ?> 
                                    </td>
                                </tr>   
                                <tr>
                                    <th align="left"> Dokter Pemeriksa: </th>
                                    <td >
                                        <?php echo $nama_dokter; ?> 
                                    </tr>       
                                    <tr >
                                        <th align="left">&nbsp;&nbsp;Specialist: </th>
                                        <td >
                                            <?php echo $namapoli; ?> 
                                        </td>
                                    </tr>        
                                </table>         
                            </td>  
                        </tr>
                    </table>   
                </div>
            </div>
            <?php $this :: display_page_errors(); ?>
            <div  class="bg-light p-3 animated fadeIn page-content">
                <style>
                    /* Style the tab */
                    .tab {
                    overflow: hidden;
                    /* border: 1px solid #ccf;*/
                    background-color: #f1f1f1;
                    border-radius: 8px;
                    font-weight: bold;
                    }
                    /* Style the buttons inside the tab */
                    .tab button {
                    background-color: inherit;
                    float: left;
                    border: none;
                    outline: none;
                    cursor: pointer;
                    border-radius: 8px;
                    font-weight: bold;
                    padding: 8px 10px;
                    transition: 0.3s;
                    font-size: 17px;
                    }
                    /* Change background color of buttons on hover */
                    .tab button:hover {
                    background-color: #1E90FF;
                    color: white; 
                    border-radius: 8px;
                    font-weight: bold;
                    }
                    /* Create an active/current tablink class */
                    .tab button.active {
                    background-color: green;
                    color: white;
                    border-radius: 8px;
                    font-weight: bold;
                    }
                    /* Style the tab content */
                    .tabcontent {
                    display: none;
                    padding: 6px 12px;
                    border: 1px solid #ccc;
                    border-top: none;
                    }
                    .dropdown a.dropdown-item:hover {
                    cursor: pointer;
                    background-color: #F5F5DC;
                    }
                </style>
                <?php
                $reseosave="";
                $nonracikshow="";
                $racikshow="";
                $itung=1;
                $Queryd = "SELECT * FROM data_resep where id_transaksi='$idtrx' and resep='0'";
                $ExecQueryd = MySQLi_query($koneksi, $Queryd);
                $rowsd = mysqli_num_rows($ExecQueryd);
                if ($rowsd <> 0) {
                while ($rowd=mysqli_fetch_array($ExecQueryd)){
                $racikanke= $rowd['racikan'];
                $namobar= $rowd['nama_obat'];
                $atminum= $rowd['aturan_minum'];
                $nonjum=$rowd['jumlah'];
                $nonjum=$rowd['jumlah'];
                if($racikanke=="0"){
            $nonrac="Nama Obat $namobar Jumlah  $nonjum Aturan Minum $atminum</br>";
            $nonracikshow="$nonracikshow$nonrac";
            $racikanresep="";
            }else{
            if($itung==$racikanke){
            $racikanresep="Ya";
            }else{
            $racikanresep="Ya";
            $itung=$itung + 1;
            }
            }
            }
            }else{
            $racikanresep="";
            }
            $queryc1 = mysqli_query($koneksi, "SELECT COUNT(*) AS rl from data_resep WHERE id_transaksi='$idtrx' and racikan='0' and tebus_resep='' and resep='0'")
            or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
            $rowsc1 = mysqli_num_rows($queryc1);
            if ($rowsc1 <> 0) {
            $datnum1=mysqli_fetch_assoc($queryc1);
            $itungdl=$datnum1['rl'];
            }else{
            $itungdl="0";
            }
            $queryc1r = mysqli_query($koneksi, "SELECT COUNT(*) AS rlr from data_resep WHERE id_transaksi='$idtrx' and racikan='0' and tebus_resep='Luar' and resep='0'")
            or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
            $rowsc1r = mysqli_num_rows($queryc1r);
            if ($rowsc1r <> 0) {
            $datnum1r=mysqli_fetch_assoc($queryc1r);
            $itunglr=$datnum1r['rlr'];
            }else{
            $itunglr="0";
            }
            if($itunglr=="0"){ }else{
            $reseosave="Ya";
        echo "<b>Resep Obat Tebus Luar</b></br>";
        ?>
        <table class="table-bordered" ><tr><td>Nama Obat</td><td>Jumlah</td><td>Aturan</td><td>Action</td></tr>
            <?php
            $Querrslr = "SELECT * FROM data_resep where id_transaksi='$idtrx' and racikan='0' and tebus_resep='Luar' and resep='0'";
            $ExecQuerrslr = MySQLi_query($koneksi, $Querrslr);
            while ($ronlr=mysqli_fetch_array($ExecQuerrslr)){
            $namobarl= $ronlr['nama_obat'];
            $iddatal= $ronlr['id_data_resep'];
            $atminuml= $ronlr['aturan_minum'];
            $nonjuml=$ronlr['jumlah'];
            $keterl=$ronlr['keterangan'];
            ?>
            <tr><td> <?php echo $namobarl;?></td><td>&nbsp;&nbsp; <?php echo $nonjuml;?></td><td>&nbsp;&nbsp; <?php echo $atminuml;?></td><td>
                <div class="dropdown" >
                    <button data-toggle="dropdown" class="dropdown-toggle btn btn-primary btn-sm">
                        <i class="fa fa-bars"></i> 
                    </button>
                    <ul class="dropdown-menu">
                        <?php $key="dermawangroup";
                        $plaintext = "$iddatal";
                        $ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
                        $iv = openssl_random_pseudo_bytes($ivlen);
                        $ciphertext_raw = openssl_encrypt($plaintext, $cipher, $key, $options=OPENSSL_RAW_DATA, $iv);
                        $hmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary=true);
                        $ciphertextdt = base64_encode( $iv.$hmac.$ciphertext_raw );
                        ?>
                        <a  class="dropdown-item record-delete-btn" href="<?php print_link("data_resep/resep?precord=$ciphertextdt&pasien=POLI&action=HAPUS&backlink=$ciphertext"); ?>" data-prompt-msg="Anda Yakin Mau Hapus Obat <?php echo $namobar;?>?" data-display-style="modal">
                            <i class="fa fa-times"></i> Hapus Resep
                        </a>     
                    </ul>
                </div>
            </td></tr>
            <?php
            }
        echo "</table>";
        }
        if($itungdl=="0"){ }else{  
        $reseosave="Ya";
    echo "<b>Resep Obat</b></br>";
    ?>
    <table class="table-bordered" ><tr><td>Nama Obat</td><td>Jumlah</td><td>Aturan</td><td>Action</td></tr>
        <?php
        $Querrsdl = "SELECT * FROM data_resep where id_transaksi='$idtrx' and racikan='0' and tebus_resep='' and resep='0'";
        $ExecQuerrsdl = MySQLi_query($koneksi, $Querrsdl);
        while ($ron=mysqli_fetch_array($ExecQuerrsdl)){
        $namobar= $ron['nama_obat'];
        $iddata= $ron['id_data_resep'];
        $atminum= $ron['aturan_minum'];
        $nonjum=$ron['jumlah'];
        $keter=$ron['keterangan'];
        ?>
        <tr><td> <?php echo $namobar;?></td><td>&nbsp;&nbsp; <?php echo $nonjum;?></td><td>&nbsp;&nbsp; <?php echo $atminum;?></td><td>
            <div class="dropdown" >
                <button data-toggle="dropdown" class="dropdown-toggle btn btn-primary btn-sm">
                    <i class="fa fa-bars"></i> 
                </button>
                <ul class="dropdown-menu">
                    <?php $key="dermawangroup";
                    $plaintext = "$iddata";
                    $ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
                    $iv = openssl_random_pseudo_bytes($ivlen);
                    $ciphertext_raw = openssl_encrypt($plaintext, $cipher, $key, $options=OPENSSL_RAW_DATA, $iv);
                    $hmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary=true);
                    $ciphertextdt = base64_encode( $iv.$hmac.$ciphertext_raw );
                    ?>
                    <a  class="dropdown-item record-delete-btn" href="<?php print_link("data_resep/resep?precord=$ciphertextdt&pasien=POLI&action=HAPUS&backlink=$ciphertext"); ?>" data-prompt-msg="Anda Yakin Mau Hapus Obat <?php echo $namobar;?>?" data-display-style="modal">
                        <i class="fa fa-times"></i> Hapus Resep
                    </a>   
                </ul>
            </div>
        </td></tr>
        <?php
        }
    echo "</table>";
    }
    //////////////////////////////////
    if($racikanresep=="Ya"){
    for ($x = 1; $x <= $itung; $x++) {
    $Quercek = "SELECT * FROM data_resep where id_transaksi='$idtrx' and racikan='$x' and resep='0'";
    $ExecQuercek = MySQLi_query($koneksi, $Quercek);
    while ($datcek=mysqli_fetch_array($ExecQuercek)){
    $cekluarracik= $datcek['tebus_resep'];
    }
    if($cekluarracik==""){
    $luarshow="";
    }else{
    $luarshow="Tebus Luar";
    }
    $Quer = "SELECT * FROM data_resep where id_transaksi='$idtrx' and racikan='$x' and resep='0'";
    $ExecQuer = MySQLi_query($koneksi, $Quer);
echo "<b>Racikan Ke $x $luarshow</b></br>";
?>
<table class="table-bordered" ><tr><td>Nama Obat</td><td>Jumlah</td><td>Action</td></tr>
    <?php
    while ($rorac=mysqli_fetch_array($ExecQuer)){
    $iddata= $rorac['id_data_resep'];
    $namobar= $rorac['nama_obat'];
    $atminum= $rorac['aturan_minum'];
    $nonjum=$rorac['jumlah'];
    $keter=$rorac['keterangan'];
    ?>
    <tr><td> <?php echo $namobar;?></td><td>&nbsp;&nbsp; <?php echo $nonjum;?></td><td>
        <div class="dropdown" >
            <button data-toggle="dropdown" class="dropdown-toggle btn btn-primary btn-sm">
                <i class="fa fa-bars"></i> 
            </button>
            <ul class="dropdown-menu">
                <?php $key="dermawangroup";
                $plaintext = "$iddata";
                $ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
                $iv = openssl_random_pseudo_bytes($ivlen);
                $ciphertext_raw = openssl_encrypt($plaintext, $cipher, $key, $options=OPENSSL_RAW_DATA, $iv);
                $hmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary=true);
                $ciphertextdt = base64_encode( $iv.$hmac.$ciphertext_raw );
                ?>
                <a  class="dropdown-item record-delete-btn" href="<?php print_link("data_resep/resep?precord=$ciphertextdt&pasien=POLI&action=HAPUS&backlink=$ciphertext"); ?>" data-prompt-msg="Anda Yakin Mau Hapus Obat <?php echo $namobar;?>?" data-display-style="modal">
                    <i class="fa fa-times"></i> Hapus Resep
                </a>        
            </ul>
        </div>               
    </td></tr>
    <?php       
    }
echo "<tr><td>Aturan Minum : </br>$atminum</td>  <td>Keterangan : </br>$keter</td> <td></td></tr></table>";
}
$reseosave="Ya";
}
if($reseosave=="Ya"){
?>
<div class="form-group form-submit-btn-holder text-center mt-3">
    <div class="form-ajax-status"></div>
    <button class="btn btn-primary" type="button" onclick="prosesresep();">
        Simpan Resep
        <i class="fa fa-send"></i>
    </button>
</div>
<form name="proses" id="proses" method="post" action="<?php print_link("data_resep/resep?csrf_token=$csrf_token") ?>">
    <input type="hidden" name="prosesresep" value="<?php echo $original_plaintext;?>"/>
        <input type="hidden" name="dari" value="pendaftaran_poli"/>
    </form>                                                   
    <script>
        function prosesresep() {
        var result = confirm("Anda Yakin Senua Resep Sudah Benar?");
        if (result == true) {
        //document.getElementById('autobtn').click();
        document.getElementById("proses").submit();
        return true;
        }
        else {
        return false;
        }
        }
    </script>                                                 
    <?php }?>
    <div class="tab">
        <button class="tablinks" onclick="openResep(event, 'non')" id="nonracik">Resep Non Racikan</button>
        <button class="tablinks" onclick="openResep(event, 'racik')" id="racikan"> Resep Racikan</button>
        <button class="tablinks" onclick="openResep(event, 'alke')" id="alkes"> Resep ALKES</button>
    </div>
    <div id="non" class="tabcontent">
        <h3>Non Racikan</h3>
        <form action="<?php  print_link("rekam_medis/resep?csrf_token=$csrf_token");?>" method="POST">
            <div class="form-group ">
                <div class="row">
                    <div class="col-sm-4">
                        <label class="control-label" for="tanggal_resep">Tanggal Resep<span class="text-danger">*</span></label>
                    </div>
                    <div class="col-sm-8">
                        <div class="input-group">
                            <input id="ctrl-tanggal_resep" class="form-control datepicker  datepicker" required="" value="<?php  echo $this->set_field_value('tanggal_resep',datetime_now()); ?>" type="datetime"  name="tanggal_resep" placeholder="Enter Tanggal Resep" data-enable-time="true" data-min-date="" data-max-date="" data-date-format="Y-m-d H:i:S" data-alt-format="F j, Y - H:i" data-inline="false" data-no-calendar="false" data-mode="single" /> 
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <table  id="dynamicTable" class="table-striped table-sm text-left">  
                    <input type="hidden" name="addresep" value="nonracik"/>
                    <input type="hidden" name="keterangan" value=""/>
                    <input type="hidden" name="precod" value="<?php echo $original_plaintext;?>"/>
                        <input type="hidden" name="precodback" value="<?php echo $backlink;?>"/>
                            <?php
                            if(!empty($_GET['datrem'])){
                            $datrem=$_GET['datrem'];
                            echo "  <input type=\"hidden\" name=\"datrem\" value=\"$datrem\"/>";
                            }
                            ?>
                            <tr>
                                <th width="30%"style="background-color: #228b22; color:#fff;">Nama Obat</th>
                                <th width="4%" style="background-color: #228b22; color:#fff;">Jumlah</th>
                                <th style="background-color: #228b22; color:#fff;">Aturan Pakai</th>
                                <th style="background-color: #228b22; color:#fff;">Action</th>
                            </tr>
                            <tr>  
                                <td>
                                    <select required="" data-endpoint="<?php print_link('api/json/resep_obat_name_option_list') ?>" id="ctrl-name" name="name[]"  placeholder="Select a value ..."    class="selectize-ajax" >
                                        <option value="">Select a value ...</option>
                                    </select>
                                </td>  
                                <td><input type="text" required="" name="qty[]" placeholder="QTY" class="form-control" /></td> 
                                <td><table>
                                    <tr>
                                        <td width="18%">
                                            <input type="text" required="" name="aturan[]" placeholder=".." class="form-control"  /> 
                                        </td><td>X</td>
                                        <td width="18%">
                                            <input type="text" required="" name="aturan1[]" placeholder=".." class="form-control"  /> 
                                        </td>  
                                        <td width="62%">
                                            <select required=""  id="ctrl-aturan_minum" name="aturan2[]"  placeholder="Select a value ..."    class="custom-select" >
                                                <option value="">Select a value ...</option>
                                                <?php 
                                                $aturan_minum_options = $comp_model -> data_resep_aturan_minum_option_list();
                                                if(!empty($aturan_minum_options)){
                                                foreach($aturan_minum_options as $option){
                                                $value = (!empty($option['value']) ? $option['value'] : null);
                                                $label = (!empty($option['label']) ? $option['label'] : $value);
                                                $selected = $this->set_field_selected('aturan_minum',$value, "");
                                                ?>
                                                <option <?php echo $selected; ?> value="<?php echo $value; ?>">
                                                    <?php echo $label; ?>
                                                </option>
                                                <?php
                                                }
                                                }
                                                ?>
                                            </select>                                           
                                        </td>
                                    </tr>
                                </table></td>  
                                <td></td>  
                            </tr>  
                            <tr>  
                                <td>
                                    <select data-endpoint="<?php print_link('api/json/resep_obat_name_option_list') ?>" id="ctrl-name" name="name[]"  placeholder="Select a value ..."    class="selectize-ajax" >
                                        <option value="">Select a value ...</option>
                                    </select>
                                </td>  
                                <td><input type="text"  name="qty[]" placeholder="QTY" class="form-control" /></td> 
                                <td><table>
                                    <tr>
                                        <td width="18%">
                                            <input type="text"  name="aturan[]" placeholder=".." class="form-control"  /> 
                                        </td><td>X</td>
                                        <td width="18%">
                                            <input type="text"  name="aturan1[]" placeholder=".." class="form-control"  /> 
                                        </td>  
                                        <td width="62%">
                                            <select  id="ctrl-aturan_minum" name="aturan2[]"  placeholder="Select a value ..."    class="custom-select" >
                                                <option value="">Select a value ...</option>
                                                <?php 
                                                $aturan_minum_options = $comp_model -> data_resep_aturan_minum_option_list();
                                                if(!empty($aturan_minum_options)){
                                                foreach($aturan_minum_options as $option){
                                                $value = (!empty($option['value']) ? $option['value'] : null);
                                                $label = (!empty($option['label']) ? $option['label'] : $value);
                                                $selected = $this->set_field_selected('aturan_minum',$value, "");
                                                ?>
                                                <option <?php echo $selected; ?> value="<?php echo $value; ?>">
                                                    <?php echo $label; ?>
                                                </option>
                                                <?php
                                                }
                                                }
                                                ?>
                                            </select> 
                                        </td>
                                    </tr>
                                </table></td>  
                                <td></td>  
                            </tr>
                            <tr>  
                                <td>
                                    <select  data-endpoint="<?php print_link('api/json/resep_obat_name_option_list') ?>" id="ctrl-name" name="name[]"  placeholder="Select a value ..."    class="selectize-ajax" >
                                        <option value="">Select a value ...</option>
                                    </select>
                                </td>  
                                <td><input type="text"  name="qty[]" placeholder="QTY" class="form-control" /></td> 
                                <td><table>
                                    <tr>
                                        <td width="18%">
                                            <input type="text" name="aturan[]" placeholder=".." class="form-control"  /> 
                                        </td><td>X</td>
                                        <td width="18%">
                                            <input type="text" name="aturan1[]" placeholder=".." class="form-control"  /> 
                                        </td>  
                                        <td width="62%">
                                            <select  id="ctrl-aturan_minum" name="aturan2[]"  placeholder="Select a value ..."    class="custom-select" >
                                                <option value="">Select a value ...</option>
                                                <?php 
                                                $aturan_minum_options = $comp_model -> data_resep_aturan_minum_option_list();
                                                if(!empty($aturan_minum_options)){
                                                foreach($aturan_minum_options as $option){
                                                $value = (!empty($option['value']) ? $option['value'] : null);
                                                $label = (!empty($option['label']) ? $option['label'] : $value);
                                                $selected = $this->set_field_selected('aturan_minum',$value, "");
                                                ?>
                                                <option <?php echo $selected; ?> value="<?php echo $value; ?>">
                                                    <?php echo $label; ?>
                                                </option>
                                                <?php
                                                }
                                                }
                                                ?>
                                            </select>
                                        </td>
                                    </tr>
                                </table></td>  
                                <td></td>  
                            </tr>                           
                            <tr>  
                                <td>
                                    <select data-endpoint="<?php print_link('api/json/resep_obat_name_option_list') ?>" id="ctrl-name" name="name[]"  placeholder="Select a value ..."    class="selectize-ajax" >
                                        <option value="">Select a value ...</option>
                                    </select>
                                </td>  
                                <td><input type="text" name="qty[]" placeholder="QTY" class="form-control" /></td> 
                                <td><table>
                                    <tr>
                                        <td width="18%">
                                            <input type="text" name="aturan[]" placeholder=".." class="form-control"  /> 
                                        </td><td>X</td>
                                        <td width="18%">
                                            <input type="text" name="aturan1[]" placeholder=".." class="form-control"  /> 
                                        </td>  
                                        <td width="62%">
                                            <select id="ctrl-aturan_minum" name="aturan2[]"  placeholder="Select a value ..."    class="custom-select" >
                                                <option value="">Select a value ...</option>
                                                <?php 
                                                $aturan_minum_options = $comp_model -> data_resep_aturan_minum_option_list();
                                                if(!empty($aturan_minum_options)){
                                                foreach($aturan_minum_options as $option){
                                                $value = (!empty($option['value']) ? $option['value'] : null);
                                                $label = (!empty($option['label']) ? $option['label'] : $value);
                                                $selected = $this->set_field_selected('aturan_minum',$value, "");
                                                ?>
                                                <option <?php echo $selected; ?> value="<?php echo $value; ?>">
                                                    <?php echo $label; ?>
                                                </option>
                                                <?php
                                                }
                                                }
                                                ?>
                                            </select>
                                        </td>
                                    </tr>
                                </table></td>  
                                <td><button type="button" name="add" id="add" class="btn btn-success"><i class="fa fa-plus"></i></button></td>  
                            </tr>                            
                        </table> 
                        <div class="form-group form-submit-btn-holder text-center mt-3">
                            <div class="form-ajax-status"></div>
                            <button class="btn btn-primary" type="submit">
                                Add Resep Non Racik
                                <i class="fa fa-send"></i>
                            </button>
                        </div>
                    </form>
                    <script type="text/javascript">
                        var i = 0;
                        $("#add").click(function(){
                        ++i;
                        $("#dynamicTable").append('<tr><td><?php
                            echo "<select name=\"name[]\" class=\"form-control\" required=\"\">";
                                echo "<option value=\"\">Pilih Nama Obat</option>";
                                $sql11 = mysqli_query($koneksi,"select * from setok_barang where category_barang='1'");
                                while ($row11=mysqli_fetch_array($sql11)){
                                $id_obat11=$row11['id_barang'];
                                $nama_obat11=$row11['nama_barang'];
                                $satuan11=$row11['satuan'];
                                $jumlahs=$row11['jumlah'];
                                if($jumlahs<2){
                                echo"<option value=\"Luar$id_obat11\" title=\"Setok Habis\">$nama_obat11 ($satuan11 >Habis> Tebus Di Luar)</option>";   
                                }else{
                                echo"<option value=\"$id_obat11\" title=\"Setok sisa $jumlah\">$nama_obat11 ($satuan11  setok $jumlahs)</option>";
                                }         
                                }
                                //  echo "<option value=\"airport1\">Airport1</option>";
                                //echo " <option value=\"airport2\">Airport2</option>";
                            echo " </select>";
                            ?></td><td><input type="text" required=\"\" name="qty[]" placeholder="QTY" class="form-control" /></td><td><table><tr><td width="18%"><input type="text" required="" name="aturan[]" placeholder=".." class="form-control"  /></td><td>X</td><td width="18%"><input type="text" required="" name="aturan1[]" placeholder=".." class="form-control"  /></td><td width="62%"><select name="aturan2[]" class="form-control" required=""><option value="">Pilih...</option><option value="Sesudah Makan">Sesudah Makan</option><?php
                            $queryc = mysqli_query($koneksi, "SELECT  DISTINCT aturan_pakai AS value,aturan_pakai AS label FROM aturan_pakai ORDER BY id ASC")
                            or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                            $rowsc = mysqli_num_rows($queryc);
                            // cek hasil query
                            // jika "no_antrian" sudah ada
                            if ($rowsc <> 0) {
                            // ambil data hasil query
                            // $datac = mysqli_fetch_assoc($queryc);
                            //  $namb = $datac['nama_bank'];
                            while ($row = mysqli_fetch_assoc($queryc)) {
                            $isisel=$row['value'];  
                            $labsel=$row['label'];
                            echo"<option value=\"$isisel\">$labsel</option>";
                            }
                            }
                        ?></select></td></tr></table></td><td><button type="button" class="btn btn-danger remove-tr"><i class=\"fa fa-close \"></i></button></td></tr>');
                        // $("#dynamicTable").append('<tr><td><input type="text" name="name[]" placeholder="Enter Nama Obat" class="form-control" /></td><td><input type="text" name="type[]" placeholder="Enter Type Obat" class="form-control" /></td><td><input type="text" name="aturan[]" placeholder="Enter Aturan Minum" class="form-control" /></td><td><input type="text" name="aqty[]" placeholder="Enter Jumlah" class="form-control" /></td><td><button type="button" class="btn btn-danger remove-tr">Remove</button></td></tr>');
                        });
                        $(document).on('click', '.remove-tr', function(){  
                        $(this).parents('tr').remove();
                        });  
                    </script>
                </div>
                <div id="racik" class="tabcontent">
                    <h3>Racikan</h3>
                    <form action="<?php  print_link("rekam_medis/resep?csrf_token=$csrf_token");?>" method="POST">
                        <div class="form-group ">
                            <div class="row">
                                <div class="col-sm-4">
                                    <label class="control-label" for="tanggal_resep">Tanggal Resep<span class="text-danger">*</span></label>
                                </div>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <input id="ctrl-tanggal_resep" class="form-control datepicker  datepicker" required="" value="<?php  echo $this->set_field_value('tanggal_resep',datetime_now()); ?>" type="datetime"  name="tanggal_resep" placeholder="Enter Tanggal Resep" data-enable-time="true" data-min-date="" data-max-date="" data-date-format="Y-m-d H:i:S" data-alt-format="F j, Y - H:i" data-inline="false" data-no-calendar="false" data-mode="single" /> 
                                            <div class="input-group-append">
                                                <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <table id="dynamicTableRacik" class="table-striped table-sm text-left">  
                                <input type="hidden" name="addresep" value="racikan"/>
                                <input type="hidden" name="precod" value="<?php echo $original_plaintext;?>"/>
                                    <input type="hidden" name="precodback" value="<?php echo $backlink;?>"/>
                                        <input type="hidden" name="keterangan" value=""/>
                                        <?php
                                        if(!empty($_GET['datrem'])){
                                        $datrem=$_GET['datrem'];
                                        echo "  <input type=\"hidden\" name=\"datrem\" value=\"$datrem\"/>";
                                        }
                                        ?>
                                        <tr>
                                            <th style="background-color: #228b22; color:#fff;">Nama Obat</th>
                                            <th width="4%" style="background-color: #228b22; color:#fff;">Jumlah</th>
                                            <th style="background-color: #228b22; color:#fff;">Action</th>
                                        </tr>
                                        <tr>  
                                            <td>
                                                <select required="" data-endpoint="<?php print_link('api/json/resep_obat_name_option_list') ?>" id="ctrl-name" name="name[]"  placeholder="Select a value ..."    class="selectize-ajax" >
                                                    <option value="">Select a value ...</option>
                                                </select>
                                            </td>  
                                            <td><input type="text" required="" name="qty[]" placeholder="QTY" class="form-control" /></td>  
                                            <td></td>  
                                        </tr> 
                                        <tr>  
                                            <td>
                                                <select data-endpoint="<?php print_link('api/json/resep_obat_name_option_list') ?>" id="ctrl-name" name="name[]"  placeholder="Select a value ..."    class="selectize-ajax" >
                                                    <option value="">Select a value ...</option>
                                                </select>
                                            </td>  
                                            <td><input type="text" name="qty[]" placeholder="QTY" class="form-control" /></td>  
                                            <td></td>  
                                        </tr> 
                                        <tr>  
                                            <td>
                                                <select  data-endpoint="<?php print_link('api/json/resep_obat_name_option_list') ?>" id="ctrl-name" name="name[]"  placeholder="Select a value ..."    class="selectize-ajax" >
                                                    <option value="">Select a value ...</option>
                                                </select>
                                            </td>  
                                            <td><input type="text" name="qty[]" placeholder="QTY" class="form-control" /></td>  
                                            <td></td>  
                                        </tr> 
                                        <tr>  
                                            <td>
                                                <select data-endpoint="<?php print_link('api/json/resep_obat_name_option_list') ?>" id="ctrl-name" name="name[]"  placeholder="Select a value ..."    class="selectize-ajax" >
                                                    <option value="">Select a value ...</option>
                                                </select>
                                            </td>  
                                            <td><input type="text" name="qty[]" placeholder="QTY" class="form-control" /></td>  
                                            <td><button type="button" name="add" id="addr" class="btn btn-success"><i class="fa fa-plus"></i></button></td>  
                                        </tr>                                         
                                    </table> 
                                    <div class="form-group ">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <label class="control-label" for="aturan">Aturan Pakai<span class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-sm-8">
                                                <div class="input-group">
                                                    <table>
                                                        <tr>
                                                            <td width="18%">
                                                                <input type="text" required="" name="aturan[]" placeholder=".." class="form-control"  /> 
                                                            </td><td>X</td>
                                                            <td width="18%">
                                                                <input type="text" required="" name="aturan1[]" placeholder=".." class="form-control"  /> 
                                                            </td>  
                                                            <td width="62%">
                                                                <select required=""  id="ctrl-aturan_minum" name="aturan2[]"  placeholder="Select a value ..."    class="custom-select" >
                                                                    <option value="">Select a value ...</option>
                                                                    <?php 
                                                                    $aturan_minum_options = $comp_model -> data_resep_aturan_minum_option_list();
                                                                    if(!empty($aturan_minum_options)){
                                                                    foreach($aturan_minum_options as $option){
                                                                    $value = (!empty($option['value']) ? $option['value'] : null);
                                                                    $label = (!empty($option['label']) ? $option['label'] : $value);
                                                                    $selected = $this->set_field_selected('aturan_minum',$value, "");
                                                                    ?>
                                                                    <option <?php echo $selected; ?> value="<?php echo $value; ?>">
                                                                        <?php echo $label; ?>
                                                                    </option>
                                                                    <?php
                                                                    }
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <label class="control-label" for="keterangan">Keterangan Racikan <span class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-sm-8">
                                                <div class="input-group">
                                                    <textarea placeholder="Enter Keterangan" id="ctrl-keterangan" required="" name="keterangan" class="form-control"></textarea>     
                                                </div>
                                            </div>
                                        </div>
                                    </div>       
                                    <div class="form-group form-submit-btn-holder text-center mt-3">
                                        <div class="form-ajax-status"></div>
                                        <button class="btn btn-primary" type="submit">
                                            Add Resep Racikan
                                            <i class="fa fa-send"></i>
                                        </button>
                                    </div>
                                </form>
                                <script type="text/javascript">
                                    var i = 0;
                                    $("#addr").click(function(){
                                    ++i;
                                    $("#dynamicTableRacik").append('<tr><td><?php
                                        echo "<select name=\"name[]\" class=\"form-control\" required=\"\">";
                                            echo "<option value=\"\">Pilih Nama Obat</option>";
                                            $sql11 = mysqli_query($koneksi,"select * from setok_barang where category_barang='1'");
                                            while ($row11=mysqli_fetch_array($sql11)){
                                            $id_obat11=$row11['id_barang'];
                                            $nama_obat11=$row11['nama_barang'];
                                            $satuan11=$row11['satuan'];
                                            $jumlahs=$row11['jumlah'];
                                            if($jumlahs<2){
                                            echo"<option value=\"Luar$id_obat11\" title=\"Setok Habis\">$nama_obat11 ($satuan11 >Habis> Tebus Di Luar)</option>";   
                                            }else{
                                            echo"<option value=\"$id_obat11\" title=\"Setok sisa $jumlah\">$nama_obat11 ($satuan11  setok $jumlahs)</option>";
                                            }         
                                            }
                                            //  echo "<option value=\"airport1\">Airport1</option>";
                                            //echo " <option value=\"airport2\">Airport2</option>";
                                        echo " </select>";
                                    ?></td><td><input type="text" required=\"\" name="qty[]" placeholder="QTY" class="form-control" /></td><td><button type="button" class="btn btn-danger remove-tr"><i class=\"fa fa-close \"></i></button></td></tr>');
                                    // $("#dynamicTable").append('<tr><td><input type="text" name="name[]" placeholder="Enter Nama Obat" class="form-control" /></td><td><input type="text" name="type[]" placeholder="Enter Type Obat" class="form-control" /></td><td><input type="text" name="aturan[]" placeholder="Enter Aturan Minum" class="form-control" /></td><td><input type="text" name="aqty[]" placeholder="Enter Jumlah" class="form-control" /></td><td><button type="button" class="btn btn-danger remove-tr">Remove</button></td></tr>');
                                    });
                                    $(document).on('click', '.remove-tr', function(){  
                                    $(this).parents('tr').remove();
                                    });  
                                </script>
                            </div>
                            <div id="alke" class="tabcontent">
                                <h3>Alkes</h3>
                                <form action="<?php  print_link("rekam_medis/resep?csrf_token=$csrf_token");?>" method="POST">
                                    <div class="form-group ">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <label class="control-label" for="tanggal_resep">Tanggal Resep<span class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-sm-8">
                                                <div class="input-group">
                                                    <input id="ctrl-tanggal_resep" class="form-control datepicker  datepicker" required="" value="<?php  echo $this->set_field_value('tanggal_resep',datetime_now()); ?>" type="datetime"  name="tanggal_resep" placeholder="Enter Tanggal Resep" data-enable-time="true" data-min-date="" data-max-date="" data-date-format="Y-m-d H:i:S" data-alt-format="F j, Y - H:i" data-inline="false" data-no-calendar="false" data-mode="single" /> 
                                                        <div class="input-group-append">
                                                            <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <table id="dynamicTableAlkes" class="table-striped table-sm text-left">  
                                            <input type="hidden" name="addresep" value="alkes"/>
                                            <input type="hidden" name="precod" value="<?php echo $original_plaintext;?>"/>
                                                <input type="hidden" name="precodback" value="<?php echo $backlink;?>"/>
                                                    <input type="hidden" name="keterangan" value=""/>
                                                    <?php
                                                    if(!empty($_GET['datrem'])){
                                                    $datrem=$_GET['datrem'];
                                                    echo "  <input type=\"hidden\" name=\"datrem\" value=\"$datrem\"/>";
                                                    }
                                                    ?>
                                                    <tr>
                                                        <th style="background-color: #228b22; color:#fff;">Nama Obat</th>
                                                        <th width="4%" style="background-color: #228b22; color:#fff;">Jumlah</th>
                                                        <th style="background-color: #228b22; color:#fff;">Action</th>
                                                    </tr>
                                                    <tr>  
                                                        <td>
                                                            <select required="" data-endpoint="<?php print_link('api/json/data_resep_nama_obat_option_list') ?>" id="ctrl-nama_obat" name="name[]"  placeholder="Select a value ..."    class="selectize-ajax" >
                                                                <option value="">Select a value ...</option>
                                                            </select>       
                                                        </td>  
                                                        <td><input type="text"required=""  name="qty[]" placeholder="QTY" class="form-control" /></td>  
                                                        <td></td>  
                                                    </tr>  
                                                    <tr>  
                                                        <td>
                                                            <select  data-endpoint="<?php print_link('api/json/data_resep_nama_obat_option_list') ?>" id="ctrl-nama_obat" name="name[]"  placeholder="Select a value ..."    class="selectize-ajax" >
                                                                <option value="">Select a value ...</option>
                                                            </select>       
                                                        </td>  
                                                        <td><input type="text"name="qty[]" placeholder="QTY" class="form-control" /></td>  
                                                        <td></td>  
                                                    </tr> 
                                                    <tr>  
                                                        <td>
                                                            <select data-endpoint="<?php print_link('api/json/data_resep_nama_obat_option_list') ?>" id="ctrl-nama_obat" name="name[]"  placeholder="Select a value ..."    class="selectize-ajax" >
                                                                <option value="">Select a value ...</option>
                                                            </select>       
                                                        </td>  
                                                        <td><input type="text" name="qty[]" placeholder="QTY" class="form-control" /></td>  
                                                        <td></td>  
                                                    </tr> 
                                                    <tr>  
                                                        <td>
                                                            <select  data-endpoint="<?php print_link('api/json/data_resep_nama_obat_option_list') ?>" id="ctrl-nama_obat" name="name[]"  placeholder="Select a value ..."    class="selectize-ajax" >
                                                                <option value="">Select a value ...</option>
                                                            </select>       
                                                        </td>  
                                                        <td><input type="text"  name="qty[]" placeholder="QTY" class="form-control" /></td>  
                                                        <td><button type="button" name="add" id="addra" class="btn btn-success"><i class="fa fa-plus"></i></button></td>  
                                                    </tr>                                                     
                                                </table>
                                                <input type="hidden" name="aturan" value=""/>
                                                <input type="hidden" name="aturan1" value=""/>
                                                <input type="hidden" name="aturan2" value=""/>
                                                <div class="form-group form-submit-btn-holder text-center mt-3">
                                                    <div class="form-ajax-status"></div>
                                                    <button class="btn btn-primary" type="submit">
                                                        Add Resep Alkes
                                                        <i class="fa fa-send"></i>
                                                    </button>
                                                </div>
                                            </form>
                                            <script type="text/javascript">
                                                var i = 0;
                                                $("#addra").click(function(){
                                                ++i;
                                                $("#dynamicTableAlkes").append('<tr><td><?php
                                                    echo "<select name=\"name[]\" class=\"form-control\" required=\"\">";
                                                        echo "<option value=\"\">Pilih Nama Obat</option>";
                                                        $sql11 = mysqli_query($koneksi,"select * from setok_barang where category_barang='1'");
                                                        while ($row11=mysqli_fetch_array($sql11)){
                                                        $id_obat11=$row11['id_barang'];
                                                        $nama_obat11=$row11['nama_barang'];
                                                        $satuan11=$row11['satuan'];
                                                        $jumlahs=$row11['jumlah'];
                                                        if($jumlahs<2){
                                                        echo"<option value=\"Luar$id_obat11\" title=\"Setok Habis\">$nama_obat11 ($satuan11 >Habis> Tebus Di Luar)</option>";   
                                                        }else{
                                                        echo"<option value=\"$id_obat11\" title=\"Setok sisa $jumlah\">$nama_obat11 ($satuan11  setok $jumlahs)</option>";
                                                        }         
                                                        }
                                                        //  echo "<option value=\"airport1\">Airport1</option>";
                                                        //echo " <option value=\"airport2\">Airport2</option>";
                                                    echo " </select>";
                                                ?></td><td><input type="text" required=\"\" name="qty[]" placeholder="QTY" class="form-control" /></td><td><button type="button" class="btn btn-danger remove-tr"><i class=\"fa fa-close \"></i></button></td></tr>');
                                                // $("#dynamicTable").append('<tr><td><input type="text" name="name[]" placeholder="Enter Nama Obat" class="form-control" /></td><td><input type="text" name="type[]" placeholder="Enter Type Obat" class="form-control" /></td><td><input type="text" name="aturan[]" placeholder="Enter Aturan Minum" class="form-control" /></td><td><input type="text" name="aqty[]" placeholder="Enter Jumlah" class="form-control" /></td><td><button type="button" class="btn btn-danger remove-tr">Remove</button></td></tr>');
                                                });
                                                $(document).on('click', '.remove-tr', function(){  
                                                $(this).parents('tr').remove();
                                                });  
                                            </script>
                                        </div>
                                        <script>
                                            $(document).ready(function(){ 
                                            });
                                            function openResep(evt, cityName) {
                                            var i, tabcontent, tablinks;
                                            tabcontent = document.getElementsByClassName("tabcontent");
                                            for (i = 0; i < tabcontent.length; i++) {
                                            tabcontent[i].style.display = "none";
                                            }
                                            tablinks = document.getElementsByClassName("tablinks");
                                            for (i = 0; i < tablinks.length; i++) {
                                            tablinks[i].className = tablinks[i].className.replace(" active", "");
                                            }
                                            document.getElementById(cityName).style.display = "block";
                                            evt.currentTarget.className += " active";
                                            }
                                            document.getElementById("nonracik").click();
                                        </script>
                                    </div>
                                    <div class=""><div>
                                        <?php if(USER_ROLE==3){?>
                                        <iframe src="<?php print_link("datarekam.php?csrf_token=$csrf_token&precord=$backlink") ?>" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                                        <?php }?>    
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
