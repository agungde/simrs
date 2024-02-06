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
                    <h4 class="record-title">Add New Transaksi</h4>
                    <div class=""><div>
                        <?php
                        $usrnam  = "".USER_NAME;
                        $id_user = "".USER_ID;
                        $dbhost  = "".DB_HOST;
                        $dbuser  = "".DB_USERNAME;
                        $dbpass  = "".DB_PASSWORD;
                        $dbname  = "".DB_NAME;
                        $koneksi = new mysqli($dbhost, $dbuser,$dbpass, $dbname);
                        $idtrace = "$id_user$usrnam";
                        if(isset($_POST['precod'])){
                        $ciphertext = $_POST['precod'];
                        $deposit = $_POST['deposit'];
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
                        $queryb = mysqli_query($koneksi, "select * from transaksi WHERE id='$original_plaintext'")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                        // ambil jumlah baris data hasil query
                        $rowsb = mysqli_num_rows($queryb);
                        if ($rowsb <> 0) {
                        $row   = mysqli_fetch_assoc($queryb); 
                        $idtrx=$row['id'];
                        $pembayaran=$row['pembayaran'];
                        $total=$row['total_tagihan'];
                        $noinvoice=$row['no_invoice'];
                        $depositawal=$row['deposit'];
                        $depositakhir=$deposit + $depositawal;
                        $sisatag=$total - $depositakhir;
                        }else{
                        ?>
                        <script language="JavaScript">
                            alert('Dilarang Akses URL Tidak Valid');
                            document.location='<?php print_link(""); ?>';
                        </script>
                        <?php }  
                        $type_transaksi=$_POST['type_transaksi'];
                        $tanggaltrx    = $_POST['tanggal_transaksi'];
                        /*
                        $queryn = mysqli_query($koneksi, "SELECT * FROM `kas` where transaksi='2' ORDER BY `id` DESC")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                        $rowsn = mysqli_num_rows($queryn);
                        if ($rowsn <> 0) {
                        $datacekn= mysqli_fetch_assoc($queryn);
                        $saldoawaln = $datacekn['saldo_cash'];
                        }else{
                        $saldoawaln = "0";
                        }
                        */
                        $query = mysqli_query($koneksi, "SELECT * FROM `kas` ORDER BY `id` DESC")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                        $rows = mysqli_num_rows($query);
                        if ($rows <> 0) {
                        $datacek= mysqli_fetch_assoc($query);
                        $saldoawal = $datacek['saldo'];
                        $kasawal = $datacek['kas_awal'];
                        $saldoawaln = $datacek['saldo_cash'];
                        }else{
                        $saldoawal = "0";
                        $saldoawaln = "0";
                        $kasawal="0";   
                        }     
                        if($type_transaksi==2){
                        $saldocash=$saldoawaln + $deposit;
                        }else{
                        $saldocash="$saldoawaln";
                        }
                        $saldoahir = $saldoawal + $deposit;
                        $keterangan="Deposit No Invoice $noinvoice";
                        mysqli_query($koneksi, "INSERT INTO `kas`(`kas_awal`,`tanggal`, `debet`, `keterangan`, `saldo`, `kasir`, `setatus`, `transaksi`, `saldo_cash`) VALUES ('$kasawal','$tanggaltrx','$deposit','$keterangan','$saldoahir','$id_user','Register','$pembayaran','$saldocash')"); 
                        mysqli_query($koneksi,"UPDATE transaksi SET deposit='$depositakhir', sisa_tagihan='$sisatag'  WHERE id='$idtrx'");
                        ?>
                        <script language="JavaScript">
                            alert('Deposit Berhasil Di Input!!');
                            document.location='<?php print_link("transaksi"); ?>';
                        </script>
                        <?php 
                        }
                        if(isset($_POST['prosestrx'])){
                        $ciphertext = $_POST['prosestrx'];
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
                        $queryb = mysqli_query($koneksi, "select * from transaksi WHERE id='$original_plaintext'")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                        // ambil jumlah baris data hasil query
                        $rowsb = mysqli_num_rows($queryb);
                        if ($rowsb <> 0) {
                        $row   = mysqli_fetch_assoc($queryb); 
                        $idtrx=$row['id'];
                        $totaltagihan=$row['total_tagihan'];
                        $transaksi=$row['transaksi'];
                        $pembayaran=$row['pembayaran'];
                        $noinvoice=$row['no_invoice'];
                        }else{
                        ?>
                        <script language="JavaScript">
                            alert('Dilarang Akses URL Tidak Valid');
                            document.location='<?php print_link(""); ?>';
                        </script>
                        <?php }  
                        if($pembayaran==1){
                        $siatag=$totaltagihan;
                        }else{    
                        $siatag=$_POST['bayar'] - $_POST['kembalian'];
                        }
                        $tanggaltrx    = $_POST['tanggal_transaksi'];
                        $type_transaksi=$_POST['type_transaksi'];
                        ////////////////////////////////////////////////Cash//////////////////////////
                        $queryn = mysqli_query($koneksi, "SELECT * FROM `kas` where transaksi='2' ORDER BY `id` DESC")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                        $rowsn = mysqli_num_rows($queryn);
                        if ($rowsn <> 0) {
                        $datacekn= mysqli_fetch_assoc($queryn);
                        $saldoawaln = $datacekn['saldo_cash'];
                        $kasawal = $datacekn['kas_awal'];
                        }else{
                        $saldoawaln = "0";
                        }
                        if($type_transaksi==2){
                        $saldocash=$saldoawaln + $siatag;
                        }else{
                        $saldocash="0";
                        }
                        $query = mysqli_query($koneksi, "SELECT * FROM `kas` ORDER BY `id` DESC")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                        $rows = mysqli_num_rows($query);
                        if ($rows <> 0) {
                        $datacek= mysqli_fetch_assoc($query);
                        $saldoawal = $datacek['saldo'];
                        }else{
                        $saldoawal = "0";
                        }
                        $saldoahir = $saldoawal + $siatag;
                        $keterangan="Pembayaran Invoice $noinvoice";
                        mysqli_query($koneksi, "INSERT INTO `kas`(`kas_awal`,`tanggal`, `debet`, `keterangan`, `saldo`, `kasir`, `setatus`, `transaksi`, `saldo_cash`) VALUES ('$kasawal','$tanggaltrx','$siatag','$keterangan','$saldoahir','$id_user','Register','$pembayaran','$saldocash')"); 
                        if($pembayaran==1){ }else{    
                        mysqli_query($koneksi,"UPDATE transaksi SET bayar='".$_POST['bayar']."', kembalian='".$_POST['kembalian']."' WHERE id='$idtrx'");
                        }
                        mysqli_query($koneksi,"UPDATE data_tagihan_pasien SET setatus='Closed' WHERE id_transaksi='$idtrx'");
                        $queryi = mysqli_query($koneksi, "SELECT * FROM igd WHERE id_transaksi='$idtrx'")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                        $rowsi = mysqli_num_rows($queryi);
                        if ($rowsi <> 0) {
                        mysqli_query($koneksi,"UPDATE igd SET setatus='Closed', tanggal_keluar='".date("Y-m-d H:i:s")."' WHERE id_transaksi='$idtrx'");
                        }
                        ////////////////////////////////////////////////////////Ranap //////////////////////////                        
                        $queryin = mysqli_query($koneksi, "SELECT * FROM rawat_inap WHERE id_transaksi='$idtrx'")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                        $rowsin = mysqli_num_rows($queryin);
                        if ($rowsin <> 0) {
                        $rowdt   = mysqli_fetch_assoc($queryin); 
                        $id=$rowdt['id'];
                        $idkelas=$rowdt['kamar_kelas'];
                        $idnomor=$rowdt['no_kamar'];
                        $idnama=$rowdt['nama_kamar'];
                        $noranjang=strtolower($rowdt['no_ranjang']);
                        $noranjang=$ciphertext=str_replace(' ', '_', $noranjang);
                        // mysqli_query($koneksi,"UPDATE rawat_inap SET setatus='Closed' WHERE id='".$rowdt['id']."'");
                        $noranjang=strtolower($noranjang);
                        $qudtk = mysqli_query($koneksi, "select * from data_kamar WHERE kamar_kelas='$idkelas' and no_kamar ='$idnomor' and nama_kamar='$idnama'")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                        // ambil jumlah baris data hasil query
                        $rodtk = mysqli_num_rows($qudtk);
                        if ($rodtk <> 0) {
                        $rowdtk   = mysqli_fetch_assoc($qudtk); 
                        $iddtk=$rowdtk['id_data_kamar'];
                        $tisi=$rowdtk['terisi'];
                        $ksisa=$rowdtk['sisa'];
                        $jumsisa=$ksisa + 1;
                        $jumisi=$tisi - 1;
                        mysqli_query($koneksi,"UPDATE data_kamar SET terisi='$jumisi', sisa='$jumsisa' WHERE id_data_kamar='$iddtk'");
                        mysqli_query($koneksi,"UPDATE data_ranjang SET $noranjang='' WHERE id_data_kamar='$iddtk'");
                        }     
                        mysqli_query($koneksi,"UPDATE rawat_inap SET setatus='Closed', tanggal_keluar='".date("Y-m-d H:i:s")."' WHERE id_transaksi='$idtrx'");
                        }
                        ////////////////////////////////////////////////////////Ranap ANak//////////////////////////                          
                        $queryin = mysqli_query($koneksi, "SELECT * FROM ranap_anak WHERE id_transaksi='$idtrx'")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                        $rowsin = mysqli_num_rows($queryin);
                        if ($rowsin <> 0) {
                        $rowdt   = mysqli_fetch_assoc($queryin); 
                        $id=$rowdt['id'];
                        $idkelas=$rowdt['kamar_kelas'];
                        $idnomor=$rowdt['no_kamar'];
                        $idnama=$rowdt['nama_kamar'];
                        $noranjang=strtolower($rowdt['no_ranjang']);
                        $noranjang=$ciphertext=str_replace(' ', '_', $noranjang);
                        // mysqli_query($koneksi,"UPDATE rawat_inap SET setatus='Closed' WHERE id='".$rowdt['id']."'");
                        $noranjang=strtolower($noranjang);
                        $qudtk = mysqli_query($koneksi, "select * from data_kamar_anak WHERE kamar_kelas='$idkelas' and no_kamar ='$idnomor' and nama_kamar='$idnama'")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                        // ambil jumlah baris data hasil query
                        $rodtk = mysqli_num_rows($qudtk);
                        if ($rodtk <> 0) {
                        $rowdtk   = mysqli_fetch_assoc($qudtk); 
                        $iddtk=$rowdtk['id_data_kamar_anak'];
                        $tisi=$rowdtk['terisi'];
                        $ksisa=$rowdtk['sisa'];
                        $jumsisa=$ksisa + 1;
                        $jumisi=$tisi - 1;
                        mysqli_query($koneksi,"UPDATE data_kamar_anak SET terisi='$jumisi', sisa='$jumsisa' WHERE id_data_kamar_anak='$iddtk'");
                        mysqli_query($koneksi,"UPDATE data_ranjang_anak SET $noranjang='' WHERE id_data_kamar='$iddtk'");
                        }     
                        mysqli_query($koneksi,"UPDATE ranap_anak SET setatus='Closed', tanggal_keluar='".date("Y-m-d H:i:s")."' WHERE id_transaksi='$idtrx'");
                        }                        
                        ////////////////////////////////////////////////////////Ranap Bersalin//////////////////////////                          
                        $queryin = mysqli_query($koneksi, "SELECT * FROM ranap_bersalin WHERE id_transaksi='$idtrx'")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                        $rowsin = mysqli_num_rows($queryin);
                        if ($rowsin <> 0) {
                        $rowdt   = mysqli_fetch_assoc($queryin); 
                        $id=$rowdt['id'];
                        $idkelas=$rowdt['kamar_kelas'];
                        $idnomor=$rowdt['no_kamar'];
                        $idnama=$rowdt['nama_kamar'];
                        $noranjang=strtolower($rowdt['no_ranjang']);
                        $noranjang=$ciphertext=str_replace(' ', '_', $noranjang);
                        // mysqli_query($koneksi,"UPDATE rawat_inap SET setatus='Closed' WHERE id='".$rowdt['id']."'");
                        $noranjang=strtolower($noranjang);
                        $qudtk = mysqli_query($koneksi, "select * from data_kamar_bersalin WHERE kamar_kelas='$idkelas' and no_kamar ='$idnomor' and nama_kamar='$idnama'")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                        // ambil jumlah baris data hasil query
                        $rodtk = mysqli_num_rows($qudtk);
                        if ($rodtk <> 0) {
                        $rowdtk   = mysqli_fetch_assoc($qudtk); 
                        $iddtk=$rowdtk['id_data_kamar_bersalin'];
                        $tisi=$rowdtk['terisi'];
                        $ksisa=$rowdtk['sisa'];
                        $jumsisa=$ksisa + 1;
                        $jumisi=$tisi - 1;
                        mysqli_query($koneksi,"UPDATE data_kamar_bersalin SET terisi='$jumisi', sisa='$jumsisa' WHERE id_data_kamar_bersalin='$iddtk'");
                        mysqli_query($koneksi,"UPDATE data_ranjang_bersalin SET $noranjang='' WHERE id_data_kamar='$iddtk'");
                        }     
                        mysqli_query($koneksi,"UPDATE ranap_bersalin SET setatus='Closed', tanggal_keluar='".date("Y-m-d H:i:s")."' WHERE id_transaksi='$idtrx'");
                        } 
                        ////////////////////////////////////////////////////////Ranap Perina//////////////////////////                          
                        $queryin = mysqli_query($koneksi, "SELECT * FROM ranap_perina WHERE id_transaksi='$idtrx'")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                        $rowsin = mysqli_num_rows($queryin);
                        if ($rowsin <> 0) {
                        $rowdt   = mysqli_fetch_assoc($queryin); 
                        $id=$rowdt['id'];
                        $normdata=$rowdt['no_rekam_medis'];
                        $idkelas=$rowdt['kamar_kelas'];
                        $idnomor=$rowdt['no_kamar'];
                        $idnama=$rowdt['nama_kamar'];
                        $noranjang=strtolower($rowdt['no_ranjang']);
                        $noranjang=$ciphertext=str_replace(' ', '_', $noranjang);
                        // mysqli_query($koneksi,"UPDATE rawat_inap SET setatus='Closed' WHERE id='".$rowdt['id']."'");
                        $noranjang=strtolower($noranjang);
                        $qudtk = mysqli_query($koneksi, "select * from data_kamar_perina WHERE kamar_kelas='$idkelas' and no_kamar ='$idnomor' and nama_kamar='$idnama'")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                        // ambil jumlah baris data hasil query
                        $rodtk = mysqli_num_rows($qudtk);
                        if ($rodtk <> 0) {
                        $rowdtk   = mysqli_fetch_assoc($qudtk); 
                        $iddtk=$rowdtk['id_data_kamar_perina'];
                        $tisi=$rowdtk['terisi'];
                        $ksisa=$rowdtk['sisa'];
                        $jumsisa=$ksisa + 1;
                        $jumisi=$tisi - 1;
                        mysqli_query($koneksi,"UPDATE data_kamar_perina SET terisi='$jumisi', sisa='$jumsisa' WHERE id_data_kamar_perina='$iddtk'");
                        mysqli_query($koneksi,"UPDATE data_ranjang_perina SET $noranjang='' WHERE id_data_kamar='$iddtk'");
                        }     
                        mysqli_query($koneksi,"UPDATE ranap_perina SET setatus='Closed', tanggal_keluar='".date("Y-m-d H:i:s")."' WHERE id_transaksi='$idtrx'");
                        mysqli_query($koneksi,"UPDATE data_kelahiran SET setatus='Closed' WHERE no_rekam_medis='$normdata'");
                        } 
                        $queryr = mysqli_query($koneksi, "SELECT DISTINCT id_resep_obat AS idres from data_resep WHERE id_transaksi='$idtrx'")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                        // ambil jumlah baris data hasil query
                        $rowsr = mysqli_num_rows($queryr);
                        if ($rowsr <> 0) {
                        while ($datacekr=mysqli_fetch_array($queryr)){   
                        $idresep=$datacekr['idres'];
                        mysqli_query($koneksi,"UPDATE resep_obat SET pembayaran='Lunas' WHERE id_resep_obat='$idresep'");
                        }
                        }
                        mysqli_query($koneksi,"UPDATE transaksi SET setatus_tagihan='Closed' WHERE id='$idtrx'");
                        ?>
                        <script language="JavaScript">
                            alert('Transaksi Berhasil Di Proses!!');
                            document.location='<?php print_link("transaksi"); ?>';
                        </script>
                        <?php 
                        }  
                        ?>
                        <script language="JavaScript">
                            alert('Dilarang Akses');
                            document.location='<?php print_link(""); ?>';
                        </script> 
                    </div></div>
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
                    <?php $this :: display_page_errors(); ?>
                    <div  class="bg-light p-3 animated fadeIn page-content">
                        <form id="transaksi-add-form" role="form" novalidate enctype="multipart/form-data" class="form page-form form-horizontal needs-validation" action="<?php print_link("transaksi/add?csrf_token=$csrf_token") ?>" method="post">
                            <div>
                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label class="control-label" for="no_invoice">No Invoice <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="">
                                                <input id="ctrl-no_invoice"  value="<?php  echo $this->set_field_value('no_invoice',""); ?>" type="text" placeholder="Enter No Invoice"  required="" name="no_invoice"  class="form-control " />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <label class="control-label" for="tanggal">Tanggal <span class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-sm-8">
                                                <div class="input-group">
                                                    <input id="ctrl-tanggal" class="form-control datepicker  datepicker"  required="" value="<?php  echo $this->set_field_value('tanggal',""); ?>" type="datetime" name="tanggal" placeholder="Enter Tanggal" data-enable-time="false" data-min-date="" data-max-date="" data-date-format="Y-m-d" data-alt-format="F j, Y" data-inline="false" data-no-calendar="false" data-mode="single" />
                                                        <div class="input-group-append">
                                                            <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group ">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <label class="control-label" for="no_rekam_medis">No Rekam Medis <span class="text-danger">*</span></label>
                                                </div>
                                                <div class="col-sm-8">
                                                    <div class="">
                                                        <input id="ctrl-no_rekam_medis"  value="<?php  echo $this->set_field_value('no_rekam_medis',""); ?>" type="text" placeholder="Enter No Rekam Medis"  required="" name="no_rekam_medis"  class="form-control " />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group ">
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <label class="control-label" for="nama_pasien">Nama Pasien <span class="text-danger">*</span></label>
                                                    </div>
                                                    <div class="col-sm-8">
                                                        <div class="">
                                                            <input id="ctrl-nama_pasien"  value="<?php  echo $this->set_field_value('nama_pasien',""); ?>" type="text" placeholder="Enter Nama Pasien"  required="" name="nama_pasien"  class="form-control " />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group ">
                                                    <div class="row">
                                                        <div class="col-sm-4">
                                                            <label class="control-label" for="alamat">Alamat <span class="text-danger">*</span></label>
                                                        </div>
                                                        <div class="col-sm-8">
                                                            <div class="">
                                                                <input id="ctrl-alamat"  value="<?php  echo $this->set_field_value('alamat',""); ?>" type="text" placeholder="Enter Alamat"  required="" name="alamat"  class="form-control " />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group ">
                                                        <div class="row">
                                                            <div class="col-sm-4">
                                                                <label class="control-label" for="no_hp">No Hp <span class="text-danger">*</span></label>
                                                            </div>
                                                            <div class="col-sm-8">
                                                                <div class="">
                                                                    <input id="ctrl-no_hp"  value="<?php  echo $this->set_field_value('no_hp',""); ?>" type="text" placeholder="Enter No Hp"  required="" name="no_hp"  class="form-control " />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group ">
                                                            <div class="row">
                                                                <div class="col-sm-4">
                                                                    <label class="control-label" for="pasien">Pasien <span class="text-danger">*</span></label>
                                                                </div>
                                                                <div class="col-sm-8">
                                                                    <div class="">
                                                                        <input id="ctrl-pasien"  value="<?php  echo $this->set_field_value('pasien',""); ?>" type="text" placeholder="Enter Pasien"  required="" name="pasien"  class="form-control " />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group ">
                                                                <div class="row">
                                                                    <div class="col-sm-4">
                                                                        <label class="control-label" for="poli">Poli <span class="text-danger">*</span></label>
                                                                    </div>
                                                                    <div class="col-sm-8">
                                                                        <div class="">
                                                                            <input id="ctrl-poli"  value="<?php  echo $this->set_field_value('poli',""); ?>" type="text" placeholder="Enter Poli"  required="" name="poli"  class="form-control " />
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group ">
                                                                    <div class="row">
                                                                        <div class="col-sm-4">
                                                                            <label class="control-label" for="pembayaran">Pembayaran <span class="text-danger">*</span></label>
                                                                        </div>
                                                                        <div class="col-sm-8">
                                                                            <div class="">
                                                                                <input id="ctrl-pembayaran"  value="<?php  echo $this->set_field_value('pembayaran',""); ?>" type="number" placeholder="Enter Pembayaran" step="1"  required="" name="pembayaran"  class="form-control " />
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group ">
                                                                        <div class="row">
                                                                            <div class="col-sm-4">
                                                                                <label class="control-label" for="setatus_bpjs">Setatus Bpjs <span class="text-danger">*</span></label>
                                                                            </div>
                                                                            <div class="col-sm-8">
                                                                                <div class="">
                                                                                    <input id="ctrl-setatus_bpjs"  value="<?php  echo $this->set_field_value('setatus_bpjs',""); ?>" type="text" placeholder="Enter Setatus Bpjs"  required="" name="setatus_bpjs"  class="form-control " />
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group ">
                                                                            <div class="row">
                                                                                <div class="col-sm-4">
                                                                                    <label class="control-label" for="deposit">Deposit <span class="text-danger">*</span></label>
                                                                                </div>
                                                                                <div class="col-sm-8">
                                                                                    <div class="">
                                                                                        <input id="ctrl-deposit"  value="<?php  echo $this->set_field_value('deposit',""); ?>" type="number" placeholder="Enter Deposit" step="1"  required="" name="deposit"  class="form-control " />
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group ">
                                                                                <div class="row">
                                                                                    <div class="col-sm-4">
                                                                                        <label class="control-label" for="sisa_tagihan">Sisa Tagihan <span class="text-danger">*</span></label>
                                                                                    </div>
                                                                                    <div class="col-sm-8">
                                                                                        <div class="">
                                                                                            <input id="ctrl-sisa_tagihan"  value="<?php  echo $this->set_field_value('sisa_tagihan',""); ?>" type="number" placeholder="Enter Sisa Tagihan" step="1"  required="" name="sisa_tagihan"  class="form-control " />
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group ">
                                                                                    <div class="row">
                                                                                        <div class="col-sm-4">
                                                                                            <label class="control-label" for="bayar">Bayar <span class="text-danger">*</span></label>
                                                                                        </div>
                                                                                        <div class="col-sm-8">
                                                                                            <div class="">
                                                                                                <input id="ctrl-bayar"  value="<?php  echo $this->set_field_value('bayar',""); ?>" type="number" placeholder="Enter Bayar" step="1"  required="" name="bayar"  class="form-control " />
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="form-group ">
                                                                                        <div class="row">
                                                                                            <div class="col-sm-4">
                                                                                                <label class="control-label" for="kembalian">Kembalian <span class="text-danger">*</span></label>
                                                                                            </div>
                                                                                            <div class="col-sm-8">
                                                                                                <div class="">
                                                                                                    <input id="ctrl-kembalian"  value="<?php  echo $this->set_field_value('kembalian',""); ?>" type="number" placeholder="Enter Kembalian" step="1"  required="" name="kembalian"  class="form-control " />
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="form-group ">
                                                                                            <div class="row">
                                                                                                <div class="col-sm-4">
                                                                                                    <label class="control-label" for="setatus_tagihan">Setatus Tagihan <span class="text-danger">*</span></label>
                                                                                                </div>
                                                                                                <div class="col-sm-8">
                                                                                                    <div class="">
                                                                                                        <input id="ctrl-setatus_tagihan"  value="<?php  echo $this->set_field_value('setatus_tagihan',""); ?>" type="text" placeholder="Enter Setatus Tagihan"  required="" name="setatus_tagihan"  class="form-control " />
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="form-group ">
                                                                                                <div class="row">
                                                                                                    <div class="col-sm-4">
                                                                                                        <label class="control-label" for="transaksi">Transaksi <span class="text-danger">*</span></label>
                                                                                                    </div>
                                                                                                    <div class="col-sm-8">
                                                                                                        <div class="">
                                                                                                            <input id="ctrl-transaksi"  value="<?php  echo $this->set_field_value('transaksi',""); ?>" type="text" placeholder="Enter Transaksi"  required="" name="transaksi"  class="form-control " />
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="form-group ">
                                                                                                    <div class="row">
                                                                                                        <div class="col-sm-4">
                                                                                                            <label class="control-label" for="operator">Operator <span class="text-danger">*</span></label>
                                                                                                        </div>
                                                                                                        <div class="col-sm-8">
                                                                                                            <div class="">
                                                                                                                <input id="ctrl-operator"  value="<?php  echo $this->set_field_value('operator',""); ?>" type="number" placeholder="Enter Operator" step="1"  required="" name="operator"  class="form-control " />
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="form-group ">
                                                                                                        <div class="row">
                                                                                                            <div class="col-sm-4">
                                                                                                                <label class="control-label" for="date_updated">Date Updated <span class="text-danger">*</span></label>
                                                                                                            </div>
                                                                                                            <div class="col-sm-8">
                                                                                                                <div class="input-group">
                                                                                                                    <input id="ctrl-date_updated" class="form-control datepicker  datepicker" required="" value="<?php  echo $this->set_field_value('date_updated',""); ?>" type="datetime"  name="date_updated" placeholder="Enter Date Updated" data-enable-time="true" data-min-date="" data-max-date="" data-date-format="Y-m-d H:i:S" data-alt-format="F j, Y - H:i" data-inline="false" data-no-calendar="false" data-mode="single" /> 
                                                                                                                        <div class="input-group-append">
                                                                                                                            <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                        <div class="form-group ">
                                                                                                            <div class="row">
                                                                                                                <div class="col-sm-4">
                                                                                                                    <label class="control-label" for="action">Action <span class="text-danger">*</span></label>
                                                                                                                </div>
                                                                                                                <div class="col-sm-8">
                                                                                                                    <div class="">
                                                                                                                        <input id="ctrl-action"  value="<?php  echo $this->set_field_value('action',""); ?>" type="text" placeholder="Enter Action"  required="" name="action"  class="form-control " />
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                            <div class="form-group ">
                                                                                                                <div class="row">
                                                                                                                    <div class="col-sm-4">
                                                                                                                        <label class="control-label" for="kas_awal">Kas Awal <span class="text-danger">*</span></label>
                                                                                                                    </div>
                                                                                                                    <div class="col-sm-8">
                                                                                                                        <div class="">
                                                                                                                            <input id="ctrl-kas_awal"  value="<?php  echo $this->set_field_value('kas_awal',""); ?>" type="number" placeholder="Enter Kas Awal" step="1"  required="" name="kas_awal"  class="form-control " />
                                                                                                                            </div>
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                                <div class="form-group ">
                                                                                                                    <div class="row">
                                                                                                                        <div class="col-sm-4">
                                                                                                                            <label class="control-label" for="kas_akhir">Kas Akhir <span class="text-danger">*</span></label>
                                                                                                                        </div>
                                                                                                                        <div class="col-sm-8">
                                                                                                                            <div class="">
                                                                                                                                <input id="ctrl-kas_akhir"  value="<?php  echo $this->set_field_value('kas_akhir',""); ?>" type="number" placeholder="Enter Kas Akhir" step="1"  required="" name="kas_akhir"  class="form-control " />
                                                                                                                                </div>
                                                                                                                            </div>
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                    <div class="form-group ">
                                                                                                                        <div class="row">
                                                                                                                            <div class="col-sm-4">
                                                                                                                                <label class="control-label" for="total_tagihan">Total Tagihan <span class="text-danger">*</span></label>
                                                                                                                            </div>
                                                                                                                            <div class="col-sm-8">
                                                                                                                                <div class="">
                                                                                                                                    <input id="ctrl-total_tagihan"  value="<?php  echo $this->set_field_value('total_tagihan',""); ?>" type="number" placeholder="Enter Total Tagihan" step="1"  required="" name="total_tagihan"  class="form-control " />
                                                                                                                                    </div>
                                                                                                                                </div>
                                                                                                                            </div>
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                    <div class="form-group form-submit-btn-holder text-center mt-3">
                                                                                                                        <div class="form-ajax-status"></div>
                                                                                                                        <button class="btn btn-primary" type="submit">
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
