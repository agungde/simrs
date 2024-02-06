<?php 
//check if current user role is allowed access to the pages
$can_add = ACL::is_allowed("pendaftaran_poli/add");
$can_edit = ACL::is_allowed("pendaftaran_poli/edit");
$can_view = ACL::is_allowed("pendaftaran_poli/view");
$can_delete = ACL::is_allowed("pendaftaran_poli/delete");
?>
<?php
$current_page = $this->set_current_page_link();
$csrf_token = Csrf::$token;
$field_name = $this->route->field_name;
$field_value = $this->route->field_value;
$view_data = $this->view_data;
$records = $view_data->records;
$record_count = $view_data->record_count;
$total_records = $view_data->total_records;
if (!empty($records)) {
?>
<!--record-->
<?php
$counter = 0;
foreach($records as $data){
$rec_id = (!empty($data['id_pendaftaran_poli']) ? urlencode($data['id_pendaftaran_poli']) : null);
$counter++;
?>
<tr>
    <td class="td-tanggal"> <?php echo $data['tanggal']; ?></td>
    <td class="td-no_rekam_medis"> <?php echo $data['no_rekam_medis']; ?></td>
    <td class="td-nama_pasien"> <?php echo $data['nama_pasien']; ?></td>
    <td class="td-tanggal_lahir"> <?php echo $data['tanggal_lahir']; ?></td>
    <td class="td-umur"> <?php echo $data['umur']; ?></td>
    <td class="td-jenis_kelamin"> <?php echo $data['jenis_kelamin']; ?></td>
    <td class="td-alamat"> <?php echo $data['alamat']; ?></td>
    <td class="td-keluhan"> <?php echo $data['keluhan']; ?></td>
    <td class="td-no_antri_poli"> <?php
        $key="dermawangroup";
        $plaintext = "$rec_id";
        $ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
        $iv = openssl_random_pseudo_bytes($ivlen);
        $ciphertext_raw = openssl_encrypt($plaintext, $cipher, $key, $options=OPENSSL_RAW_DATA, $iv);
        $hmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary=true);
        $ciphertext = base64_encode( $iv.$hmac.$ciphertext_raw );
        $id_user = "".USER_ID;
        $dbhost="".DB_HOST;
        $dbuser="".DB_USERNAME;
        $dbpass="".DB_PASSWORD;
        $dbname="".DB_NAME;
        //$koneksi=open_connection();
        $koneksi = new mysqli($dbhost, $dbuser,$dbpass, $dbname);
        $idpol=$data['nama_poli'];
        $queryh = mysqli_query($koneksi, "SELECT * from data_poli WHERE id_poli='$idpol'")
        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
        $rowsh = mysqli_num_rows($queryh);
        if ($rowsh <> 0) {
        $datacekh= mysqli_fetch_assoc($queryh);
        $nampol=$datacekh['nama_poli'];
        }else{
        $nampol="";
        }
        if($data['tl']=="TN"){
        $tl= "Tuan";
        }else   if($data['tl']=="NY"){
        $tl= "nyonya ";
        }else   if($data['tl']=="AN "){
        $tl= "Anak";
        }else  if($data['tl']=="BY "){
        $tl=  "Bayi ";
        }else{
        $tl=  "";  
        } 
        ?>
        <span ><button id="tabel-antrian<?php echo $rec_id; ?>" style="border-radius: 8px; background-color: #1E90FF; color: white; padding:5px; font-weight: bold;"><?php echo $data['no_antri_poli']; ?></button></span>
        <script>
            $(document).ready(function() {
            //$('#tabel-antrian').on('click', 'button', function() {
            $('#tabel-antrian<?php echo $rec_id; ?>').on('click', function() {
            // ambil data dari datatables 
            // var data = table.row($(this).parents('tr')).data();
            // buat variabel untuk menampilkan data "id"
            var id = 1;
            // buat variabel untuk menampilkan audio bell antrian
            var bell = document.getElementById('tingtung');
            // var audio=$("audio").get[0];
            if (bell.paused || bell.currentTime == 0 || bell.currentTime==bell.duration){
            //audio paused,ended or not started
            bell.play();
            } else {
            //audio is playing
            bell.pause();
            }
            // mainkan suara bell antrian
            //bell.pause();
            // bell.currentTime = 0;
            // bell.play();
            
            // set delay antara suara bell dengan suara nomor antrian
            durasi_bell = bell.duration * 770;
            
            // mainkan suara nomor antrian
            setTimeout(function() {
            responsiveVoice.speak("Nomor Antrian, " + <?php echo $data['no_antri_poli']; ?> + ",<?php echo $tl;?>  <?php echo $data['nama_pasien'];?>, menuju, poli <?php echo $nampol;?>", "Indonesian Male", {
            rate: 0.9,
            pitch: 1,
            volume: 1
            });
            }, durasi_bell);
            
            // proses update data
            // $.ajax({
            // type: "POST",               // mengirim data dengan method POST
            //  url: "update.php",          // url file proses update data
            //  data: { id: id }            // tentukan data yang dikirim
            // });
            });  
            });
        </script></td>
        <td class="td-nama_poli"> <span>
            <a size="sm" class="btn btn-sm btn-primary page-modal" href="#"><i class="fa fa-eye"></i> <?php echo $nampol;?></a>
        </span></td>
        <td class="td-dokter">
            <a size="sm" class="btn btn-sm btn-primary page-modal" href="<?php print_link("data_dokter/view/" . urlencode($data['dokter'])) ?>">
                <i class="fa fa-eye"></i> <?php echo $data['data_dokter_nama_dokter'] ?>
            </a>
        </td>
        <td class="td-action"><?php
            $sekarang = gmdate("Y-m-d", time() + 60 * 60 * 7);
            $id_user = "".USER_ID;
            $dbhost="".DB_HOST;
            $dbuser="".DB_USERNAME;
            $dbpass="".DB_PASSWORD;
            $dbname="".DB_NAME;
            //$koneksi=open_connection();
            $koneksi = new mysqli($dbhost, $dbuser,$dbpass, $dbname);
            $norm=$data['no_rekam_medis'];
            $qudt = mysqli_query($koneksi, "SELECT * from penjualan WHERE id_jual='$rec_id' and id_pelanggan='$norm'  ORDER BY `id_penjualan` DESC")
            or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
            $rodt = mysqli_num_rows($qudt);
            if ($rodt <> 0) {
            $cdt= mysqli_fetch_assoc($qudt);
            $idpnj=$cdt['id_penjualan']; 
            $totbeli=$cdt['total_harga_beli']; 
            $totjual=$cdt['total_harga_jual'];
            $totuntung=$totjual - $totbeli;
            // total_untung
            mysqli_query($koneksi,"UPDATE penjualan SET total_untung='$totuntung'  WHERE id_penjualan='$idpnj'");
            } 
            $key="dermawangroup";
            $plaintext = "$rec_id";
            $ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
            $iv = openssl_random_pseudo_bytes($ivlen);
            $ciphertext_raw = openssl_encrypt($plaintext, $cipher, $key, $options=OPENSSL_RAW_DATA, $iv);
            $hmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary=true);
            $ciphertext = base64_encode( $iv.$hmac.$ciphertext_raw );
            ?>
            <span>
                <div class="dropdown" >
                    <button data-toggle="dropdown" class="dropdown-toggle btn btn-primary btn-sm">
                        <i class="fa fa-bars"></i> 
                        </button><ul class="dropdown-menu">
                        <?php //if(USER_ROLE==3 or USER_ROLE==6){
                        $querydt = mysqli_query($koneksi, "SELECT * from data_rekam_medis WHERE no_rekam_medis='$norm'")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                        $rowsdt = mysqli_num_rows($querydt);
                        if ($rowsdt <> 0) { 
                        $querydtb = mysqli_query($koneksi, "SELECT * from rekam_medis WHERE no_rekam_medis='$norm'")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                        $rowsdtb = mysqli_num_rows($querydtb);
                        if ($rowsdtb <> 0) {      
                        $datidb= mysqli_fetch_assoc($querydtb);
                        $idrekam=$datidb['id_rekam_medis'];
                        }
                        }else{
                        $queryt = mysqli_query($koneksi, "SELECT * from data_tindakan WHERE id_daftar='$rec_id' and no_rekam_medis='$norm'")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                        // ambil jumlah baris data hasil query
                        $rowst = mysqli_num_rows($queryt);
                        // cek hasil query
                        // jika "no_antrian" sudah ada
                        if ($rowst <> 0) {
                        /////////////////////////////////////pulang/////////////////////
                        $no_rekam_medis=$data['no_rekam_medis'];
                        $queijin = mysqli_query($koneksi, "select * from ijin_pulang WHERE id_daftar='$rec_id' and no_rekam_medis='$no_rekam_medis'")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                        // ambil jumlah baris data hasil query
                        $roijin = mysqli_num_rows($queijin);
                        if ($roijin <> 0) {
                        $datijin    = mysqli_fetch_assoc($queijin);
                        $idijin=$datijin['id'];
                        ?>
                        <a style="margin-top:2px;" class="btn btn-sm btn-primary has-tooltip page-modal"  href="<?php  print_link("ijin_pulang/view/$idijin?precord=$ciphertext");?>">
                        <i class="fa fa-send"></i> Lihat Ijin Pulang</a>  
                        <?php  }else{ 
                        $quep = mysqli_query($koneksi, "SELECT * from data_pasien WHERE no_rekam_medis='$no_rekam_medis'")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                        $rowp = mysqli_num_rows($quep);
                        if ($rowp <> 0) {
                        $ckrmp= mysqli_fetch_assoc($quep);
                        $ipas=$ckrmp['id_pasien'];
                        }
                        ?>
                        <a style="margin-top:2px;" class="btn btn-sm btn-primary has-tooltip"  href="<?php  print_link("ijin_pulang/pulang?precord=$ciphertext&datprecord=$ipas&darecord=pendaftaran_poli");?>">
                        <i class="fa fa-send"></i> Add Ijin Pulang</a>     
                        <?php }
                        /////////////
                        $querydt = mysqli_query($koneksi, "SELECT * from data_rekam_medis WHERE id_daftar='$rec_id'  and no_rekam_medis='$norm'")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                        $rowsdt = mysqli_num_rows($querydt);
                        if ($rowsdt <> 0) { 
                        //  $datid= mysqli_fetch_assoc($querydt);
                        }else{    
                        }
                        }    
                        }
                        //}
                        ?>
                        <a style="margin-top:2px;" class="btn btn-sm btn-primary has-tooltip"  href="<?php  print_link("appointment/add?csrf_token=$csrf_token&precord=$ciphertext&pasien=POLI");?>">
                        <i class="fa fa-send"></i>Daftar Appointment</a> 
                        <a class="btn btn-sm btn-primary has-tooltip" style="margin-top:2px;" href="<?php  print_link("pendaftaran_poli/add?csrf_token=$csrf_token&precord=$ciphertext&daftarpoli=2");?>">
                        <i class="fa fa-send"></i>Daftar Ke Poli Lain</a> 
                        <a style="margin-top:2px;" class="btn btn-sm btn-primary has-tooltip"  href="<?php  print_link("rawat_inap/add?csrf_token=$csrf_token&precord=$ciphertext&pasien=POLI");?>">
                        <i class="fa fa-send"></i>Add Rawat Inap</a>  
                    </ul>
                </div>
            </span>
        </span></td>
        <td class="td-pemeriksaan_fisik"> <span>
            <div class="dropdown" >
                <button data-toggle="dropdown" class="dropdown-toggle btn btn-primary btn-sm">
                    <i class="fa fa-bars"></i> 
                </button>
                <ul class="dropdown-menu">
                    <?php
                    $dtrekam=$data['no_rekam_medis'];
                    $qutrif = mysqli_query($koneksi, "SELECT * from pemeriksaan_fisik WHERE id_daftar='$rec_id' and no_rekam_medis='$norm'")
                    or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                    $rotrif = mysqli_num_rows($qutrif);
                    if ($rotrif <> 0) {
                    $ctrif= mysqli_fetch_assoc($qutrif);
                    $idtrif=$ctrif['id_fisik'];
                    ?>
                    <a style="margin-top:2px;" class="btn btn-sm btn-primary has-tooltip page-modal"  href="<?php  print_link("pemeriksaan_fisik/view/$idtrif?precord=$ciphertext&datprecord=$rec_id");?>">
                    <i class="fa fa-send"></i> Lihat Pemeriksaan Fisik</a>                                
                    <?php
                    }else{
                    if($data['setatus']=="" or $data['setatus']=="Register"){?>
                    <a style="margin-top:2px;" class="btn btn-sm btn-primary has-tooltip"  href="<?php  print_link("pemeriksaan_fisik/poli?precord=$ciphertext&datprecord=$rec_id");?>">
                    <i class="fa fa-send"></i> Add Pemeriksaan Fisik</a>                      
                    <?php  
                    }
                    }?>    
                </ul>
            </div>
        </span>
    </td>
    <td class="td-catatan_medis">
        <span>
            <div class="dropdown" >
                <button data-toggle="dropdown" class="dropdown-toggle btn btn-danger btn-sm">
                    <i class="fa fa-bars"></i> 
                    </button><ul class="dropdown-menu">
                    
                    <?php
                    //  if(USER_ROLE==3){
                    $norekam=$data['no_rekam_medis'];
                    $quep = mysqli_query($koneksi, "SELECT * from data_pasien WHERE no_rekam_medis='$norekam'")
                    or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                    $rowp = mysqli_num_rows($quep);
                    if ($rowp <> 0) {
                    $ckrmp= mysqli_fetch_assoc($quep);
                    $ipas=$ckrmp['id_pasien'];
                    }          
                    $querydt = mysqli_query($koneksi, "SELECT * from catatan_medis WHERE no_rekam_medis='$norekam'")
                    or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                    $rowsdt = mysqli_num_rows($querydt);
                    if ($rowsdt <> 0) { 
                    
                    ?>
                    <a class="btn btn-sm btn-danger has-tooltip page-modal"  href="<?php  print_link("catatan_medis?detile_precord=$norekam&datprecord=$ipas");?>">
                    <i class="fa fa-eye"></i> Lihat Catatan Medis</a>
                    <?php
                    }
                    //}
                    ?>
                    <a class="btn btn-sm btn-danger has-tooltip"  href="<?php  print_link("catatan_medis/add?precord=$ciphertext&pasien=POLI&datprecord=$ipas");?>">
                    <i class="fa fa-plus"></i> Add Catatan Medis</a>
                </ul>
            </div>
        </span></td>
        <td class="td-tindakan"> 
            <span>
                <div class="dropdown" >
                    <button data-toggle="dropdown" class="dropdown-toggle btn btn-warning btn-sm">
                        <i class="fa fa-bars"></i> 
                        </button><ul class="dropdown-menu">
                        <?php 
                        $dtrekam=$data['no_rekam_medis'];
                        $query = mysqli_query($koneksi, "SELECT * from data_tindakan WHERE no_rekam_medis='$dtrekam'")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                        // ambil jumlah baris data hasil query
                        $rows = mysqli_num_rows($query);
                        
                        // cek hasil query
                        // jika "no_antrian" sudah ada
                        if ($rows <> 0) {
                        // $datacek= mysqli_fetch_assoc($query);
                        $queryrm = mysqli_query($koneksi, "SELECT * from rekam_medis WHERE no_rekam_medis='$dtrekam'")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                        // ambil jumlah baris data hasil query
                        $rowsrm = mysqli_num_rows($queryrm);
                        
                        // cek hasil query
                        // jika "no_antrian" sudah ada
                        if ($rowsrm <> 0) {
                        $datrm= mysqli_fetch_assoc($queryrm);
                        $iddatrm=$datrm['id_rekam_medis'];
                        ?>
                        <a style="margin-top:2px;" class="btn btn-sm btn-warning has-tooltip page-modal"  href="<?php  print_link("rekam_medis/tindakan/$iddatrm?detile_precord=$dtrekam");?>">
                        <i class="fa fa-user "></i> Lihat Tindakan</a> 
                        <?php     
                        }
                        
                        }
                        //   if(USER_ROLE==3){
                        $qutrif = mysqli_query($koneksi, "SELECT * from pemeriksaan_fisik WHERE id_daftar='$rec_id' and no_rekam_medis='$dtrekam'")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                        $rotrif = mysqli_num_rows($qutrif);
                        if ($rotrif <> 0) {
                        $key="dermawangroup";
                        $plaintext = "$rec_id";
                        $ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
                        $iv = openssl_random_pseudo_bytes($ivlen);
                        $ciphertext_raw = openssl_encrypt($plaintext, $cipher, $key, $options=OPENSSL_RAW_DATA, $iv);
                        $hmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary=true);
                        $ciphertext = base64_encode( $iv.$hmac.$ciphertext_raw );
                        if($data['setatus']=="Register"){
                        /*
                        $queryc = mysqli_query($koneksi, "select * from data_rekam_medis WHERE id_daftar='$id_daftar' and no_rekam_medis='$no_rekam_medis' ORDER BY id DESC")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));  
                        $rowsc = mysqli_num_rows($queryc);
                        if ($rowsc <> 0) {
                        $rowc  = mysqli_fetch_assoc($queryc); 
                        $idapp = $rowc['id'];
                        mysqli_query($koneksi, "UPDATE data_rekam_medis SET catatan_medis='$catatan_medis' WHERE id='$idapp'");
                        }
                        */
                        ?>
                        <a class="btn btn-sm btn-warning has-tooltip" style="margin-top:2px;" href="<?php  print_link("data_tindakan/add?precord=$ciphertext&pasien=POLI");?>">
                        <i class="fa fa-send"></i>Isi Tindakan</a>
                        <?php 
                        }     
                        } 
                        //  }
                        // echo $data['tindakan']; 
                        ?>
                    </ul>
                </div>
            </span></td>
            <td class="td-lab"> <span>
                <div class="dropdown" >
                    <button data-toggle="dropdown" class="dropdown-toggle btn btn-secondary btn-sm">
                        <i class="fa fa-bars"></i> 
                        </button><ul class="dropdown-menu">
                        
                        <?php
                        $query = mysqli_query($koneksi, "SELECT * from pendaftaran_lab WHERE id_daftar='$rec_id'")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                        // ambil jumlah baris data hasil query
                        $rows = mysqli_num_rows($query);
                        
                        // cek hasil query
                        // jika "no_antrian" sudah ada
                        if ($rows <> 0) {
                        $datacek= mysqli_fetch_assoc($query);
                        $iddaftarlab=$datacek['id'];
                        if($datacek['setatus']=="Closed"){
                        $queryh = mysqli_query($koneksi, "SELECT * from hasil_lab WHERE id_daftar_lab='$iddaftarlab'")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                        // ambil jumlah baris data hasil query
                        $rowsh = mysqli_num_rows($queryh);
                        
                        // cek hasil query
                        // jika "no_antrian" sudah ada
                        if ($rowsh <> 0) {
                        $datacekh= mysqli_fetch_assoc($queryh);
                        $id_hasil_lab= $datacekh['id_hasil_lab']; 
                        $key="dermawangroup";
                        $plaintext = "$id_hasil_lab";
                        $ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
                        $iv = openssl_random_pseudo_bytes($ivlen);
                        $ciphertext_raw = openssl_encrypt($plaintext, $cipher, $key, $options=OPENSSL_RAW_DATA, $iv);
                        $hmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary=true);
                        $ciphertext = base64_encode( $iv.$hmac.$ciphertext_raw );
                        }
                        ?>
                        <a style="margin-top:2px;" class="btn btn-sm btn-secondary has-tooltip page-modal"  href="<?php  print_link("hasil_lab/hasil?csrf_token=$csrf_token&precord=$ciphertext");?>">
                        <i class="fa fa-send"></i>Lihat Lab</a> 
                        <?php 
                        }else{
                        echo "<i class=\"fa fa-users \"></i> Masih Proses";
                        $norekam=$data['no_rekam_medis'];
                        }
                        }else{
                        $norekam=$data['no_rekam_medis'];
                        $quep = mysqli_query($koneksi, "SELECT * from data_pasien WHERE no_rekam_medis='$norekam'")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                        $rowp = mysqli_num_rows($quep);
                        if ($rowp <> 0) {
                        $ckrmp= mysqli_fetch_assoc($quep);
                        $ipas=$ckrmp['id_pasien'];
                        }          
                        $no_rekam_medis=$data['no_rekam_medis'];
                        $quetrx= mysqli_query($koneksi, "select * from transaksi WHERE no_rekam_medis='$no_rekam_medis' and setatus_tagihan='Register'")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                        // ambil jumlah baris data hasil query
                        $rotrx = mysqli_num_rows($quetrx);
                        if ($rotrx <> 0) {
                        $key="dermawangroup";
                        $plaintext = "$rec_id";
                        $ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
                        $iv = openssl_random_pseudo_bytes($ivlen);
                        $ciphertext_raw = openssl_encrypt($plaintext, $cipher, $key, $options=OPENSSL_RAW_DATA, $iv);
                        $hmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary=true);
                        $ciphertext = base64_encode( $iv.$hmac.$ciphertext_raw );
                        // pendaftaran_lab/add?csrf_token=$csrf_token&precord=$ciphertext
                        if($data['setatus']=="Closed"){}else{
                        ?>
                        <a style="margin-top:2px;" class="btn btn-sm btn-secondary has-tooltip"  href="<?php  print_link("pendaftaran_lab/lab?precord=$ciphertext&datprecord=$ipas&pasien=POLI");?>">
                        <i class="fa fa-send"></i>Daftar Ke Lab</a> 
                        <?php }
                        }
                        }
                        $no_rekam_medis=$data['no_rekam_medis'];
                        $quespl= mysqli_query($koneksi, "select * from hasil_lab_luar WHERE no_rekam_medis='$no_rekam_medis' and id_daftar='$rec_id'")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                        // ambil jumlah baris data hasil query
                        $rospl = mysqli_num_rows($quespl);
                        if ($rospl <> 0) {
                        $daspl= mysqli_fetch_assoc($quespl);
                        $idlbl=$daspl['id'];
                        ?>
                        <a style="margin-top:2px;" class="btn btn-sm btn-secondary has-tooltip page-modal"  href="<?php  print_link("hasil_lab_luar/view/$idlbl?csrf_token=$csrf_toke");?>">
                        <i class="fa fa-send"></i>Lihat Hasil Lab Luar</a>       
                        <?php
                        }
                        ?>
                        <a style="margin-top:2px;" class="btn btn-sm btn-secondary has-tooltip"  href="<?php  print_link("hasil_lab_luar/add?csrf_token=$csrf_toke&pasien=POLI&datrecord=$rec_id");?>">
                        <i class="fa fa-send"></i>Uploads Hasil Lab Luar</a>    
                        <?php      
                        $quesp= mysqli_query($koneksi, "select * from surat_pengantar_lab WHERE no_rekam_medis='$no_rekam_medis' and id_daftar='$rec_id'")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                        // ambil jumlah baris data hasil query
                        $rosp = mysqli_num_rows($quesp);
                        if ($rosp <> 0) {
                        $dasp= mysqli_fetch_assoc($quesp);
                        $idsp=$dasp['id_surat'];
                        ?>
                        <a style="margin-top:2px;" class="btn btn-sm btn-secondary has-tooltip page-modal"  href="<?php  print_link("surat_pengantar_lab/view/$idsp?csrf_token=$csrf_toke");?>">
                        <i class="fa fa-send"></i>Lihat Pengantar Lab</a>       
                        <?php
                        }else{
                        // echo $data['tindakan']; ?>
                        <a style="margin-top:2px;" class="btn btn-sm btn-secondary has-tooltip"  href="<?php  print_link("surat_pengantar_lab/add?csrf_token=$csrf_token&precord=$ciphertext&pasien=POLI");?>">
                        <i class="fa fa-send"></i>Add Pengantar Lab</a> 
                    <?php }?> </ul>
                </div>
            </span></td>
            <td class="td-rekam_medis"><span>
                <div class="dropdown" >
                    <button data-toggle="dropdown" class="dropdown-toggle btn btn-primary btn-sm">
                        <i class="fa fa-bars"></i> 
                    </button>
                    <ul class="dropdown-menu">
                        <?php
                        $quep = mysqli_query($koneksi, "SELECT * from data_pasien WHERE no_rekam_medis='$norm'")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                        $rowp = mysqli_num_rows($quep);
                        if ($rowp <> 0) {
                        $ckrmp= mysqli_fetch_assoc($quep);
                        $idpas=$ckrmp['id_pasien'];
                        }
                        $querydt = mysqli_query($koneksi, "SELECT * from data_rekam_medis WHERE no_rekam_medis='$norm'")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                        $rowsdt = mysqli_num_rows($querydt);
                        if ($rowsdt <> 0) { 
                        $querydtb = mysqli_query($koneksi, "SELECT * from rekam_medis WHERE no_rekam_medis='$norm'")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                        $rowsdtb = mysqli_num_rows($querydtb);
                        if ($rowsdtb <> 0) {      
                        $datidb= mysqli_fetch_assoc($querydtb);
                        $idrekam=$datidb['id_rekam_medis'];
                        ?>
                        <a class="btn btn-sm btn-primary has-tooltip"  href="<?php  print_link("data_rekam_medis/rm?datprecord=$idpas&precord=$norm");?>">
                        <i class="fa fa-eye"></i> Lihat Rekam Medis</a>
                        <?php  
                        }
                        }
                        $querydt = mysqli_query($koneksi, "SELECT * from data_rekam_medis WHERE id_daftar='$rec_id'  and no_rekam_medis='$norm'")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                        $rowsdt = mysqli_num_rows($querydt);
                        if ($rowsdt <> 0) { 
                        //  $datid= mysqli_fetch_assoc($querydt);
                        }else{    
                        /*
                        ?>
                        <a class="btn btn-sm btn-primary has-tooltip" style="margin-top:2px;" href="<?php  print_link("data_rekam_medis/add?precord=$ciphertext&pasien=POLI");?>">
                        <i class="fa fa-send"></i>Isi Rekam Medis</a>
                        <?php 
                        */
                        }
                        ?>
                    </ul>
                </div>    
            </span></td>
            <td class="td-resep_obat"> <span>
                <div class="dropdown" >
                    <button data-toggle="dropdown" class="dropdown-toggle btn btn-success btn-sm">
                        <i class="fa fa-bars"></i> 
                        </button><ul class="dropdown-menu">
                        
                        <?php
                        $normmed=$data['no_rekam_medis'];
                        $qupas = mysqli_query($koneksi, "SELECT * from data_pasien WHERE no_rekam_medis='$normmed'")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                        $ropas = mysqli_num_rows($qupas);
                        if ($ropas <> 0) {
                        $dapas= mysqli_fetch_assoc($qupas);
                        $idpas=$dapas['id_pasien'];
                        }
                        $querydt = mysqli_query($koneksi, "SELECT * from resep_obat WHERE no_rekam_medis='$normmed' and setatus='Register' or setatus='Closed'")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                        $rowsdt = mysqli_num_rows($querydt);
                        if ($rowsdt <> 0) {
                        $datr= mysqli_fetch_assoc($querydt);
                        $idresp=$datr['id_resep_obat'];
                        
                        ?>
                        <a style="margin-top:1px;" class="btn btn-sm btn-secondary has-tooltip page-modal"  href="<?php  print_link("data_resep/obat?detile_precord=$normmed&datprecord=$idpas");?>">
                        <i class="fa fa-eye"></i> Lihat Resep</a> 
                        <?php 
                        }
                        $queryr = mysqli_query($koneksi, "SELECT * from data_rekam_medis WHERE id_daftar='$rec_id' and no_rekam_medis='$normmed'")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                        $rowsr = mysqli_num_rows($queryr);
                        if ($rowsr <> 0) {
                        
                        // if(USER_ROLE==3 or USER_ROLE==6){
                        $key="dermawangroup";
                        $plaintext = "$rec_id";
                        $ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
                        $iv = openssl_random_pseudo_bytes($ivlen);
                        $ciphertext_raw = openssl_encrypt($plaintext, $cipher, $key, $options=OPENSSL_RAW_DATA, $iv);
                        $hmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary=true);
                        $ciphertext = base64_encode( $iv.$hmac.$ciphertext_raw );
                        
                        if($data['setatus']=="Register"){
                        ?>
                        <a class="btn btn-sm btn-success has-tooltip " style="margin-top:2px;" href="<?php  print_link("rekam_medis/resep?precord=$ciphertext");?>">
                        <i class="fa fa-folder-open "></i>Isi Resep</a>
                        <?php } 
                        }
                        ?>
                    </ul>
                </div>
            </span></td>
            <td class="td-pembayaran">
                <a size="sm" class="btn btn-sm btn-primary page-modal" href="<?php print_link("data_bank/view/" . urlencode($data['pembayaran'])) ?>">
                    <i class="fa fa-eye"></i> <?php echo $data['data_bank_nama_bank'] ?>
                </a>
            </td>
            <td class="td-setatus_bpjs"> <?php echo $data['setatus_bpjs']; ?></td>
            <td class="td-setatus"> <?php
                if($data['setatus']=="Closed"){
                ?>
                <span style="border-radius: 8px; background-color:     #DC143C; color: white; padding:5px; font-weight: bold;"><?php echo $data['setatus']; ?></span>
                <?php
                }else if($data['setatus']=="Register"){
                ?>
                <span style="border-radius: 8px; background-color: #1E90FF; color: white; padding:5px; font-weight: bold;"><?php echo $data['setatus']; ?></span>
                <?php
                }else{
                ?>
                <span ><?php echo $data['setatus']; ?></span>
                <?php
                }
                ?>
            </td>
            <td class="page-list-action td-btn">
                <div class="dropdown" >
                    <button data-toggle="dropdown" class="dropdown-toggle btn btn-primary btn-sm">
                        <i class="fa fa-bars"></i> 
                    </button>
                    <ul class="dropdown-menu">
                        <?php if($can_view){ ?>
                        <a class="dropdown-item page-modal" href="<?php print_link("pendaftaran_poli/view/$rec_id"); ?>">
                            <i class="fa fa-eye"></i> View 
                        </a>
                        <?php } ?>
                        <?php if($can_edit){ ?>
                        <a class="dropdown-item page-modal" href="<?php print_link("pendaftaran_poli/edit/$rec_id"); ?>">
                            <i class="fa fa-edit"></i> Edit
                        </a>
                        <?php } ?>
                    </ul>
                </div>
            </td>
            </tr>
            <?php 
            }
            ?>
            <?php
            } else {
            ?>
            <td class="no-record-found col-12" colspan="100">
                <h4 class="text-muted text-center ">
                    No Record Found
                </h4>
            </td>
            <?php
            }
            ?>
            