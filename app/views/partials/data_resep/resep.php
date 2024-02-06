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
    <div  class="p-2 mb-2">
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
                        if(!empty($_GET['backlink'])){
                        $backlink=$_GET['backlink'];
                        }else{
                        $backlink="";
                        }
                        if(!empty($_GET['precord'])){
                        $ciphertext = $_GET['precord'];
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
                        $sqlcek2 = mysqli_query($koneksi,"select * from data_resep WHERE id_data_resep='$original_plaintext'");
                        $rowspa = mysqli_num_rows($sqlcek2);
                        if ($rowspa <> 0) {
                        $rowd= mysqli_fetch_assoc($sqlcek2); 
                        $id_daftar=$rowd['id_daftar'];
                        $id_obat=$rowd['id_obat'];
                        $nama_obat=$rowd['nama_obat'];
                        $aturan_minum=$rowd['aturan_minum'];
                        $keterangan=$rowd['keterangan'];
                        $jumlahedite=$rowd['jumlah'];
                        $tebus_resep=$rowd['tebus_resep'];
                        $ket_setok=$rowd['ket_setok'];
                        $bagian=$rowd['bagian'];
                        $divisi=$ket_setok;
                        }else{
                        ?>
                        <script language="JavaScript">
                            alert('Dilarang Akses URL Tidak Valid');
                            document.location='<?php print_link("pendaftaran_poli"); ?>';
                        </script>
                        <?php } 
                        if(!empty($_GET['action'])){
                        $action=$_GET['action'];
                        $backlink=$_GET['backlink'];
                        if($action=="HAPUS"){
                        if($tebus_resep==""){
                        $sqlobat = mysqli_query($koneksi,"select * from setok_barang WHERE id_barang='$id_obat'");
                        $rowsobat = mysqli_num_rows($sqlobat);
                        if ($rowsobat <> 0) {
                        $rowob= mysqli_fetch_assoc($sqlobat); 
                        $jumsetok=$rowob['jumlah'];
                        $kode=$rowob['kode_barang'];
                        }
                        $sqldat = mysqli_query($koneksi,"select * FROM data_setok WHERE kode_barang='$kode' and divisi='$divisi' and bagian='$bagian'");
                        $rodats = mysqli_num_rows($sqldat);
                        if ($rodats <> 0) {
                        $rods= mysqli_fetch_assoc($sqldat); 
                        $datjumlah=$rods['jumlah'];
                        $iddats=$rods['id'];
                        } 
                        if($divisi=="GUDANG"){
                        $totalset=$jumlahedite + $jumsetok;
                        mysqli_query($koneksi, " UPDATE `setok_barang` SET `jumlah`='$totalset' WHERE id_barang='$id_obat'");
                        mysqli_query($koneksi, "DELETE FROM data_resep WHERE id_data_resep='$original_plaintext'");     
                        }else{
                        $totalset=$jumlahedite + $datjumlah;
                        mysqli_query($koneksi, " UPDATE `data_setok` SET `jumlah`='$totalset' WHERE id='$iddats'");
                        mysqli_query($koneksi, "DELETE FROM data_resep WHERE id_data_resep='$original_plaintext'");     
                        }
                        }else{
                        $sqldata = mysqli_query($koneksi,"select * FROM data_resep WHERE id_data_resep='$original_plaintext'");
                        $rodatsa = mysqli_num_rows($sqldata);
                        if ($rodatsa <> 0) {
                        $rodsa= mysqli_fetch_assoc($sqldata); 
                        $idresep=$rodsa['id_resep_obat'];
                        }
                        $ceki=0;
                        $sqlcek4 = mysqli_query($koneksi,"select * FROM data_resep WHERE id_resep_obat='$idresep'");
                        while ($row4=mysqli_fetch_array($sqlcek4)){
                        $ceki++;
                        }
                        if($ceki=="1"){
                        mysqli_query($koneksi, "DELETE FROM resep_obat WHERE  id_resep_obat='$idresep'");        
                        }                     
                        mysqli_query($koneksi, "DELETE FROM data_resep WHERE id_data_resep='$original_plaintext'"); 
                        }
                        ?>
                        <script language="JavaScript">
                            alert('Data Berhasil Di Hapus!!');
                            <?php 
                            if(!empty($_GET['dari'])){
                            $dari=$_GET['dari'];
                            ?>
                            document.location='<?php print_link("$dari/resep?precord=$backlink"); ?>';
                            <?php }else{?>
                            document.location='<?php print_link("rekam_medis/resep?precord=$backlink"); ?>';
                            <?php }?>
                        </script>
                        <?php
                        }
                        }
                        $sqlcek1 = mysqli_query($koneksi,"select * from pendaftaran_poli WHERE id_pendaftaran_poli='$id_daftar'");
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
                        }
                        $sqlcek3 = mysqli_query($koneksi,"select * from data_dokter WHERE id_user='$id_user'");
                        while ($row3=mysqli_fetch_array($sqlcek3)){
                        $nama_dokter=$row3['nama_dokter'];
                        $nama_poli=$row3['specialist'];
                        }
                        $sqlcek4 = mysqli_query($koneksi,"select * from data_poli WHERE id_poli='$nama_poli'");
                        while ($row4=mysqli_fetch_array($sqlcek4)){
                        $namapoli=$row4['nama_poli'];
                        }
                        }else{
                        if(isset($_POST['prosesresep'])){
                        if(isset($_POST['dari'])){
                        $dari=$_POST['dari'];
                        }else{
                        $dari="";
                        }
                        $postid=$_POST['prosesresep'];  
                        if($dari=="igd"){
                        $sql = mysqli_query($koneksi,"select * from igd WHERE id_igd='$postid'");
                        while ($row=mysqli_fetch_array($sql)){
                        $no_rekam_medis=$row['no_rekam_medis'];
                        $alamat=$row['alamat'];
                        $nama_pasien=$row['nama_pasien'];
                        $idtransaksi=$row['id_transaksi'];
                        $tanggal=$row['tanggal_masuk'];
                        // $nama_poli=$row['nama_poli'];
                        $nama_poli="IGD";
                        $tanggal_lahir=$row['tanggal_lahir'];
                        $phone=$row['no_hp'];
                        $dokter=$row['dokter'];
                        $pembayaran=$row['pembayaran'];  
                        $pasien=$row['pasien'];
                        $idtransaksi=$row['id_transaksi'];
                        }   
                        $sqlcek3 = mysqli_query($koneksi,"select * from data_dokter WHERE id_dokter='$dokter'");
                        while ($row3=mysqli_fetch_array($sqlcek3)){
                        $nama_dokter=$row3['nama_dokter'];
                        } 
                        }else if($dari=="rawat_inap"){
                        $sql = mysqli_query($koneksi,"select * from rawat_inap WHERE id='$postid'");
                        while ($row=mysqli_fetch_array($sql)){
                        $no_rekam_medis=$row['no_rekam_medis'];
                        $alamat=$row['alamat'];
                        $nama_pasien=$row['nama_pasien'];
                        $pasien=$row['pasien'];
                        $tanggal=$row['tanggal_masuk'];
                        // $nama_poli=$row['nama_poli'];
                        $nama_poli=$row['poli'];
                        $tanggal_lahir=$row['tanggal_lahir'];
                        $phone=$row['no_hp'];
                        $dokter=$row['dokter_rawat_inap'];
                        $pembayaran=$row['pembayaran'];
                        $idtransaksi=$row['id_transaksi'];
                        }   
                        $sqlcek3 = mysqli_query($koneksi,"select * from data_dokter WHERE id_dokter='$dokter'");
                        while ($row3=mysqli_fetch_array($sqlcek3)){
                        $nama_dokter=$row3['nama_dokter'];
                        } 
                        $sqlcek31 = mysqli_query($koneksi,"select * from data_poli WHERE id_poli='$poli'");
                        while ($row31=mysqli_fetch_array($sqlcek31)){
                        $nama_poli=$row31['nama_poli'];
                        } 
                        }else if($dari=="ranap_anak"){
                        $sql = mysqli_query($koneksi,"select * from ranap_anak WHERE id='$postid'");
                        while ($row=mysqli_fetch_array($sql)){
                        $no_rekam_medis=$row['no_rekam_medis'];
                        $alamat=$row['alamat'];
                        $nama_pasien=$row['nama_pasien'];
                        $pasien=$row['pasien'];
                        $tanggal=$row['tanggal_masuk'];
                        // $nama_poli=$row['nama_poli'];
                        $nama_poli=$row['poli'];
                        $tanggal_lahir=$row['tanggal_lahir'];
                        $phone=$row['no_hp'];
                        $dokter=$row['dokter_ranap_anak'];
                        $pembayaran=$row['pembayaran'];
                        $idtransaksi=$row['id_transaksi'];
                        }   
                        $sqlcek3 = mysqli_query($koneksi,"select * from data_dokter WHERE id_dokter='$dokter'");
                        while ($row3=mysqli_fetch_array($sqlcek3)){
                        $nama_dokter=$row3['nama_dokter'];
                        } 
                        $sqlcek31 = mysqli_query($koneksi,"select * from data_poli WHERE id_poli='$poli'");
                        while ($row31=mysqli_fetch_array($sqlcek31)){
                        $nama_poli=$row31['nama_poli'];
                        } 
                        }else if($dari=="ranap_bersalin"){
                        $sql = mysqli_query($koneksi,"select * from ranap_bersalin WHERE id='$postid'");
                        while ($row=mysqli_fetch_array($sql)){
                        $no_rekam_medis=$row['no_rekam_medis'];
                        $alamat=$row['alamat'];
                        $nama_pasien=$row['nama_pasien'];
                        $pasien=$row['pasien'];
                        $tanggal=$row['tanggal_masuk'];
                        // $nama_poli=$row['nama_poli'];
                        $nama_poli=$row['poli'];
                        $tanggal_lahir=$row['tanggal_lahir'];
                        $phone=$row['no_hp'];
                        $dokter=$row['dokter_ranap_bersalin'];
                        $pembayaran=$row['pembayaran'];
                        $idtransaksi=$row['id_transaksi'];
                        }   
                        $sqlcek3 = mysqli_query($koneksi,"select * from data_dokter WHERE id_dokter='$dokter'");
                        while ($row3=mysqli_fetch_array($sqlcek3)){
                        $nama_dokter=$row3['nama_dokter'];
                        } 
                        $sqlcek31 = mysqli_query($koneksi,"select * from data_poli WHERE id_poli='$poli'");
                        while ($row31=mysqli_fetch_array($sqlcek31)){
                        $nama_poli=$row31['nama_poli'];
                        } 
                        }else if($dari=="ranap_perina"){
                        $sql = mysqli_query($koneksi,"select * from ranap_perina WHERE id='$postid'");
                        while ($row=mysqli_fetch_array($sql)){
                        $no_rekam_medis=$row['no_rekam_medis'];
                        $alamat=$row['alamat'];
                        $nama_pasien=$row['nama_pasien'];
                        $pasien=$row['pasien'];
                        $tanggal=$row['tanggal_masuk'];
                        // $nama_poli=$row['nama_poli'];
                        $nama_poli=$row['poli'];
                        $tanggal_lahir=$row['tanggal_lahir'];
                        $phone=$row['no_hp'];
                        $dokter=$row['dokter_ranap_perina'];
                        $pembayaran=$row['pembayaran'];
                        $idtransaksi=$row['id_transaksi'];
                        }   
                        $sqlcek3 = mysqli_query($koneksi,"select * from data_dokter WHERE id_dokter='$dokter'");
                        while ($row3=mysqli_fetch_array($sqlcek3)){
                        $nama_dokter=$row3['nama_dokter'];
                        } 
                        $sqlcek31 = mysqli_query($koneksi,"select * from data_poli WHERE id_poli='$poli'");
                        while ($row31=mysqli_fetch_array($sqlcek31)){
                        $nama_poli=$row31['nama_poli'];
                        } 
                        }else{
                        $sql = mysqli_query($koneksi,"select * from pendaftaran_poli WHERE id_pendaftaran_poli='$postid'");
                        while ($row=mysqli_fetch_array($sql)){
                        $no_rekam_medis=$row['no_rekam_medis'];
                        $alamat=$row['alamat'];
                        $nama_pasien=$row['nama_pasien'];
                        $tanggal=$row['tanggal'];
                        $nama_poli=$row['nama_poli'];
                        $tanggal_lahir=$row['tanggal_lahir'];
                        $phone=$row['no_hp'];
                        $pasien=$row['pasien'];
                        $pembayaran=$row['pembayaran'];
                        $idtransaksi=$row['id_transaksi'];
                        }   
                        $sqlcek3 = mysqli_query($koneksi,"select * from data_poli WHERE id_poli='$nama_poli'");
                        while ($row3=mysqli_fetch_array($sqlcek3)){
                        $nama_dokter=$row3['nama_poli'];
                        }            
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
                        $querypb1 = mysqli_query($koneksi, "select * from resep_obat WHERE id_daftar='$postid' and no_rekam_medis='$no_rekam_medis' and setatus='' and tebus_resep='' and resep='0'")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                        $rowspb1 = mysqli_num_rows($querypb1);
                        if ($rowspb1 <> 0) {
                        $datapb1 = mysqli_fetch_assoc($querypb1);
                        $tanggal=$datapb1['tanggal'];
                        $id_resep_obat=$datapb1['id_resep_obat'];
                        }
                        $queryp = mysqli_query($koneksi, "select * from penjualan WHERE id_jual='$postid' and id_pelanggan='$no_rekam_medis' and resep='0'")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                        $rowsp = mysqli_num_rows($queryp);
                        if ($rowsp <> 0) {
                        $datap = mysqli_fetch_assoc($queryp);
                        $id_penjualan=$datap['id_penjualan'];
                        }else{
                        mysqli_query($koneksi,"INSERT INTO `penjualan` (`id_jual`,`no_hp`,`id_pelanggan`, `tanggal`, `nama_pelanggan`, `alamat`) VALUES ('$postid','$phone','$no_rekam_medis', '$tanggal', '$nama_pasien', '$alamat')"); 
                        $querypb = mysqli_query($koneksi, "select * from penjualan WHERE id_jual='$postid'")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                        $rowspb = mysqli_num_rows($querypb);
                        if ($rowspb <> 0) {
                        $datapb = mysqli_fetch_assoc($querypb);
                        $id_penjualan=$datapb['id_penjualan'];
                        }
                        } 
                        $jumtotbeli="0";
                        $jumtotjual="0";
                        $jumqty="0";
                        $sqlcek2 = mysqli_query($koneksi,"select * from data_resep WHERE id_daftar='$postid' and no_rekam_medis='$no_rekam_medis' and setatus='' and tebus_resep='' and resep='0'");
                        $rowspa = mysqli_num_rows($sqlcek2);
                        if ($rowspa <> 0) {
                        while ($rowi=mysqli_fetch_array($sqlcek2)){
                        $idst=$rowi['id_obat'];
                        $qtys=$rowi['jumlah'];
                        $idsd=$rowi['id_data_resep'];
                        $iddsetok=$rowi['id_data_setok'];
                        $divisi=$rowi['ket_setok'];
                        $bagian=$rowi['bagian'];
                        $sqlcek4 = mysqli_query($koneksi,"select * from setok_barang WHERE id_barang='$idst'");
                        while ($row4=mysqli_fetch_array($sqlcek4)){
                        $nama_obat=$row4['nama_barang'];
                        $kode_obat=$row4['kode_barang'];
                        $satuan=$row4['satuan'];
                        $jumlah=$row4['jumlah'];
                        $harga_beli=$row4['harga_beli'];
                        $harga_jual=$row4['harga_jual'];
                        $isi_nama="$nama_obat ($satuan)";
                        }            
                        $stoks=$jumlah - $qtys; 
                        $totharga=$harga_jual * $qtys;
                        mysqli_query($koneksi,"INSERT INTO `data_penjualan` (`divisi`,`bagian`,`id_data_setok`,`id_transaksi`,`id_penjualan`,`no_hp`,`kode_barang`,`nama_poli`,`id_pelanggan`, `tanggal`, `nama_pelanggan`, `alamat`, `nama_barang`, `jumlah`, `harga`, `total_harga`, `total_bayar`) VALUES ('$divisi','$bagian','$iddsetok','$idtransaksi','$id_penjualan','$phone','$kode_obat','$nama_poli','$no_rekam_medis', '$tanggal', '$nama_pasien', '$alamat', '$nama_obat', '$qtys', '$harga_jual', '$totharga', '$totharga')"); 
                        $totbeli=$harga_beli * $qtys;
                        $jumtotbeli=$jumtotbeli + $totbeli;
                        $jumtotjual=$jumtotjual + $totharga;
                        //////////////////////////////////////////
                        mysqli_query($koneksi,"UPDATE data_resep SET kode_barang='$kode_obat' WHERE id_data_resep='$idsd'");
                        $jumqty=$jumqty + $qtys;    
                        }
                        $jumtotdiskon="";
                        $no_invoice="INVPNJ$id_penjualan";
                        mysqli_query($koneksi,"UPDATE penjualan SET setatus='Register', resep='1',no_invoice='$no_invoice', total_jumlah='$jumqty',total_harga_beli='$jumtotbeli',total_harga_jual='$jumtotjual',total_diskon='$jumtotdiskon' WHERE id_penjualan='$id_penjualan'"); 
                        $querydtr = mysqli_query($koneksi, "SELECT max(resep) as nomor from data_resep WHERE id_daftar='$postid' and no_rekam_medis='$no_rekam_medis' and tebus_resep=''")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                        $rowsdtr = mysqli_num_rows($querydtr);
                        if ($rowsdtr <> 0) {
                        $datadtr       = mysqli_fetch_assoc($querydtr);
                        $noresep = $datadtr['nomor'] + 1;
                        }else{
                        $noresep=1;  
                        }
                        mysqli_query($koneksi,"UPDATE data_resep SET setatus='Register', resep='$noresep' WHERE id_resep_obat='$id_resep_obat' and tebus_resep=''");
                        mysqli_query($koneksi,"UPDATE resep_obat SET setatus='Register', resep='$noresep' WHERE id_resep_obat='$id_resep_obat'");
                        $queryb = mysqli_query($koneksi, "select * from pelanggan WHERE id_pelanggan='$no_rekam_medis'")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                        // ambil jumlah baris data hasil query
                        $rowsb = mysqli_num_rows($queryb);
                        // cek hasil query
                        // jika "no_antrian" sudah ada
                        if ($rowsb <> 0) {}else{
                        mysqli_query($koneksi,"INSERT INTO `pelanggan` (`id_pelanggan`, `nama_pelanggan`, `alamat`, `phone`) VALUES ('$no_rekam_medis', '$nama_pasien', '$alamat',  '$phone')");    
                        }   
                        ////////////////////////////////////////////////////////////////////////////////////////
                        $iddaftar=$postid;
                        /*
                        $ress1 = mysqli_query($koneksi, "SELECT * FROM resep_obat WHERE id_daftar='$iddaftar'"); 
                        while ($rowss1=mysqli_fetch_array($ress1)){
                        $id_resep_obat = $rowss1['id_resep_obat'];
                        }  
                        */  
                        $rowid   = 1;
                        $resulti = mysqli_query($koneksi, "SELECT * FROM data_resep WHERE id_resep_obat='$id_resep_obat'"); 
                        while ($row=mysqli_fetch_array($resulti)){
                        $id_data_resep = $row['id_data_resep'];
                        $nambar = $row['nama_obat'];
                        $idobat = $row['id_obat'];
                        $ketsetok = $row['ket_setok'];
                        $aturan = $row['aturan_minum'];
                        $jumres = $row['jumlah'];
                        $idtrx = $row['id_transaksi'];
                        $tgldat = $row['tanggal'];
                        $minum  = "($aturan)";
                        if($rowid=="1"){
                        mysqli_query($koneksi, "UPDATE data_rekam_medis SET resep_obat='$nambar $minum' WHERE id_daftar='$iddaftar' and no_rekam_medis='$no_rekam_medis'");
                        }else{
                        $resultii = mysqli_query($koneksi, "SELECT * FROM data_rekam_medis WHERE id_daftar='$iddaftar' and no_rekam_medis='$no_rekam_medis'"); 
                        while ($rowi=mysqli_fetch_array($resultii)){
                        $resp = $rowi['resep_obat'];
                        $koma     = "<br/>";
                        $isiresep = "$resp$koma$nambar $minum";
                        mysqli_query($koneksi, "UPDATE data_rekam_medis SET resep_obat='$isiresep' WHERE id_daftar='$iddaftar' and no_rekam_medis='$no_rekam_medis'"); 
                        }  
                        }
                        if($ketsetok=="GUDANG"){
                        $divisi="FARMASI";
                        $bagian="FARMASI";
                        $sqlcek4 = mysqli_query($koneksi,"select * from setok_barang WHERE id_barang='$idobat'");
                        while ($row4=mysqli_fetch_array($sqlcek4)){
                        $kodeb=$row4['kode_barang'];
                        $nama_obat=$row4['nama_barang'];
                        $satuan=$row4['satuan'];
                        $idobatluar=$row4['id_barang'];
                        $jumlah=$row4['jumlah'];
                        $harga_jual=$row4['harga_jual'];
                        $cate =$row4['category_barang'];
                        $isi_nama="$nama_obat ($satuan)";
                        }
                        mysqli_query($koneksi,"INSERT INTO `permintaan_barang_resep`(`id_data_resep`, `id_transaksi`, `tanggal`, `kode_barang`, `nama_barang`, `category_barang`, `jumlah`, `divisi`, `bagian`, `setatus`, `keterangan`) VALUES ('$id_data_resep','$idtrx','$tgldat','$kodeb','$nama_obat','$cate','$jumres','$divisi','$bagian','Register','Untuk Resep INV$idtrx')");   
                        }
                        $rowid = $rowid + 1;
                        }
                        $ceresep = mysqli_query($koneksi, "SELECT * FROM data_rekam_medis WHERE id_daftar='$iddaftar' and no_rekam_medis='$no_rekam_medis'"); 
                        $roresep = mysqli_num_rows($ceresep);
                        if ($roresep <> 0) {
                        $datres      = mysqli_fetch_assoc($ceresep);
                        $ketresep    = $datres['resep_obat'];
                        $kettindakan = $datres['tindakan'];
                        }else{
                        $ketresep    = "";
                        $kettindakan = "";
                        }
                        /////////////////////////////////////////////////////////////////////////////////////   
                        $cekpen  = mysqli_query($koneksi, "SELECT * FROM penjualan WHERE id_jual='$iddaftar' and id_pelanggan='$no_rekam_medis'"); 
                        $rowspen = mysqli_num_rows($cekpen);
                        if ($rowspen <> 0) {
                        $dato         = mysqli_fetch_assoc($cekpen);
                        $id_penjualan = $dato['id_penjualan'];
                        mysqli_query($koneksi,"UPDATE data_penjualan SET id_jual='$iddaftar' WHERE id_penjualan='$id_penjualan' ");
                        //////////////////////////////////////////////
                        $qujumtin = mysqli_query($koneksi, "SELECT SUM(total_harga) AS tot from data_penjualan WHERE id_penjualan='$id_penjualan'")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                        $jumtin = mysqli_fetch_assoc($qujumtin); 
                        $totresep = $jumtin['tot'];
                        $quetrx= mysqli_query($koneksi, "select * from transaksi WHERE no_rekam_medis='$no_rekam_medis' and setatus_tagihan='Register'")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                        // ambil jumlah baris data hasil query
                        $rotrx = mysqli_num_rows($quetrx);
                        if ($rotrx <> 0) {
                        $dattrx      = mysqli_fetch_assoc($quetrx);
                        $idtrx       = $dattrx['id'];  
                        $tottagawal  = $dattrx['total_tagihan'];
                        $tottagakhir = $tottagawal + $totresep;
                        mysqli_query($koneksi, "UPDATE transaksi SET total_tagihan='$tottagakhir' WHERE id='$idtrx'"); 
                        } 
                        if($dari=="igd"){
                        $resepdari="IGD";
                        }else if($dari=="rawat_inap"){
                        $resepdari="RAWAT INAP";
                        }else if($dari=="ranap_anak"){
                        $resepdari="RANAP ANAK";
                        }else if($dari=="ranap_bersalin"){
                        $resepdari="RANAP BERSALIN";
                        }else if($dari=="ranap_perina"){
                        $resepdari="RANAP PERINA";
                        }else{
                        $resepdari="POLI"; 
                        }
                        mysqli_query($koneksi,"INSERT INTO `data_tagihan_pasien` (`id_transaksi`,`id_data`,`nama_tagihan`,`tanggal`,`no_rekam_medis`,`total_tagihan`,`setatus`,`pasien`,`keterangan`) VALUES (' $idtrx','$id_penjualan','Resep Obat','$tanggal','$no_rekam_medis','$totresep','Register','$resepdari','$ketresep')");  
                        }
                        if($dari=="pendaftaran_poli"){
                        //  mysqli_query($koneksi, "UPDATE pendaftaran_poli SET setatus='Closed' WHERE id_pendaftaran_poli='$iddaftar'");
                        //  mysqli_query($koneksi,"UPDATE data_rm SET setatus='Closed' WHERE id_daftar='$iddaftar' and no_rekam_medis='$no_rekam_medis'");
                        ?>
                        <?php if(USER_ROLE==3){
                        $key="dermawangroup";
                        $plaintext = "$postid";
                        $ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
                        $iv = openssl_random_pseudo_bytes($ivlen);
                        $ciphertext_raw = openssl_encrypt($plaintext, $cipher, $key, $options=OPENSSL_RAW_DATA, $iv);
                        $hmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary=true);
                        $ciphertext = base64_encode( $iv.$hmac.$ciphertext_raw );       
                        ?> 
                        <script language="JavaScript">
                            alert('Resep Obat Berhasil Di Simpan!!');
                            document.location='<?php print_link("pendaftaran_poli/dokter?precord=$ciphertext&datrm=$no_rekam_medis"); ?>';
                        </script>
                        <?php }else{?>
                        <script language="JavaScript">
                            alert('Resep Obat Berhasil Di Simpan!!');
                            document.location='<?php print_link("pendaftaran_poli"); ?>';
                        </script>
                        <?php }?>
                        <?php 
                        }else{
                        ?>
                        <script language="JavaScript">
                            alert('Resep Obat Berhasil Di Simpan!!');
                            document.location='<?php print_link("$dari"); ?>';
                        </script>
                        <?php       
                        }
                        }else{
                        ?>
                        <script language="JavaScript">
                            alert('Dilarang Akses !!');
                            <?php if($dari==""){?>
                            document.location='<?php print_link("pendaftaran_poli"); ?>';
                            <?php }else{?>
                            document.location='<?php print_link("$dari"); ?>';
                            <?php }?>
                        </script>
                        <?php  
                        }  
                        ?>
                        <script language="JavaScript">
                            alert('Dilarang Akses !!');
                            document.location='<?php print_link("pendaftaran_poli"); ?>';
                        </script>
                        <?php   
                        }else{
                        ?>
                        <script language="JavaScript">
                            alert('Dilarang Akses !!');
                            document.location='<?php print_link(""); ?>';
                        </script>
                        <?php 
                        }
                        }?>
                    </div>
                </div><h4 class="record-title">Edite Data Resep</h4>
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
            <div class="col-md-7 comp-grid">
                <div class=""> <div id="page-report-body" class="table-responsive p-2">
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
                                <tr>
                                    <th align="left"> Tanggal Lahir</th>
                                    <td >
                                        <?php echo $tanggal_lahir; ?> 
                                    </td>
                                </tr> 
                                <tr>
                                    <th align="left"> Dokter Pemeriksa: </th>
                                    <td >
                                        <?php echo $nama_dokter; ?> 
                                    </td>
                                </tr>        
                            </table>
                        </td>
                        <td >  
                            <table >
                                <tr>
                                    <th align="left">&nbsp;&nbsp;Umur: </th>
                                    <td >
                                        <?php echo $umur; ?> 
                                    </td>
                                </tr> 
                                <tr>
                                    <th align="left"> &nbsp;&nbsp;Tinggi: </th>
                                    <td >
                                        <?php echo $tinggi; ?> 
                                    </td>
                                </tr>
                                <tr >
                                    <th align="left">&nbsp;&nbsp;Berat Badan: </th>
                                    <td >
                                        <?php echo $berat_badan; ?> 
                                    </td>
                                </tr>
                                <tr >
                                    <th align="left">&nbsp;&nbsp;Tensi: </th>
                                    <td >
                                        <?php echo $tensi; ?> 
                                    </td>
                                </tr>
                                <tr >
                                    <th align="left">&nbsp;&nbsp;Suhu Badan: </th>
                                    <td >
                                        <?php echo $suhu_badan; ?> 
                                    </td>
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
            <form id="data_resep-resep-form" role="form" novalidate enctype="multipart/form-data" class="form page-form form-horizontal needs-validation" action="<?php print_link("data_resep/resep?csrf_token=$csrf_token") ?>" method="post"><input type="hidden" name="racikan" value="<?php echo $tebus_resep;?>"/><input type="hidden" name="backlink" value="<?php echo $ciphertext;?>"/>
                <div><input type="hidden" name="precord" value="<?php echo $original_plaintext;?>"/>
                    <div class="form-group ">
                        <div class="row">
                            <div class="col-sm-4">
                                <label class="control-label" for="nama_obat">Nama Obat <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-sm-8">
                                <div class="">
                                    <select required=""  id="ctrl-nama_obat" name="nama_obat"  placeholder="Select a value ..."    class="custom-select" >
                                        <option value="">Select a value ...</option>
                                        <?php
                                        $sql = mysqli_query($koneksi,"select * from setok_barang where category_barang='1'");
                                        while ($row=mysqli_fetch_array($sql)){
                                        $id_barang=$row['id_barang'];
                                        $nama_obat=$row['nama_barang'];
                                        $satuan=$row['satuan'];
                                        $jumlah=$row['jumlah'];
                                        if($id_barang==$id_obat){
                                        $pilih="selected";
                                        }else{
                                        $pilih="";
                                        }
                                        if($jumlah<2){
                                        echo"<option value=\"Luar$id_barang\" title=\"Setok Habis\" $pilih>$nama_obat ($satuan >Habis> Tebus Di Luar)</option>";
                                        }else{
                                        echo"<option value=\"$id_barang\" title=\"Setok sisa $jumlah\" $pilih>$nama_obat ($satuan sisa $jumlah)</option>";
                                        }  
                                        }
                                        ?>                        
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="row">
                            <div class="col-sm-4">
                                <label class="control-label" for="jumlah">Jumlah <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-sm-8">
                                <div class="">
                                    <input id="ctrl-jumlah"  value="<?php  echo $this->set_field_value('jumlah',"$jumlahedite"); ?>" type="text" placeholder="Enter Jumlah"  required="" name="jumlah"  class="form-control " />
                                    </div>
                                </div>
                            </div>
                        </div>       
                        <div class="form-group ">
                            <div class="row">
                                <div class="col-sm-4">
                                    <label class="control-label" for="aturan_minum">Aturan Minum <span class="text-danger">*</span></label>
                                </div>
                                <div class="col-sm-8">
                                    <div class="">
                                        <input id="ctrl-aturan_minum"  value="<?php  echo $this->set_field_value('aturan_minum',"$aturan_minum"); ?>" type="text" placeholder="Enter Aturan Minum"  required="" name="aturan_minum"  class="form-control " />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php 
                            if($keterangan==""){
                            ?>
                            <input type="hidden" name="keterangan" value=""/>
                            <?php
                            }else{
                            ?>
                            <div class="form-group ">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <label class="control-label" for="keterangan">Keterangan Racikan <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-sm-8">
                                        <div class="input-group">
                                            <textarea placeholder="Enter Keterangan" id="ctrl-keterangan" required="" name="keterangan" class="form-control"><?php echo $keterangan;?></textarea>     
                                        </div>
                                    </div>
                                </div>
                            </div>                
                            <?php }?>              
                        </div>
                        <div class="form-group form-submit-btn-holder text-center mt-3">
                            <div class="form-ajax-status"></div>
                            <button class="btn btn-primary" type="submit" onclick="setTimeout(function(){ window.location.reload();}, 2000);">
                                Submit
                                <i class="fa fa-send"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</section>
