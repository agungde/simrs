<?php 
//check if current user role is allowed access to the pages
$can_add = ACL::is_allowed("pendaftaran_poli/add");
$can_edit = ACL::is_allowed("pendaftaran_poli/edit");
$can_view = ACL::is_allowed("pendaftaran_poli/view");
$can_delete = ACL::is_allowed("pendaftaran_poli/delete");
?>
<?php
$comp_model = new SharedController;
$page_element_id = "list-page-" . random_str();
$current_page = $this->set_current_page_link();
$csrf_token = Csrf::$token;
//Page Data From Controller
$view_data = $this->view_data;
$records = $view_data->records;
$record_count = $view_data->record_count;
$total_records = $view_data->total_records;
$field_name = $this->route->field_name;
$field_value = $this->route->field_value;
$view_title = $this->view_title;
$show_header = $this->show_header;
$show_footer = $this->show_footer;
$show_pagination = $this->show_pagination;
?>
<section class="page ajax-page" id="<?php echo $page_element_id; ?>" data-page-type="list"  data-display-type="table" data-page-url="<?php print_link($current_page); ?>">
    <?php
    if( $show_header == true ){
    ?>
    <div  class="bg-white p-1 mb-1">
        <div class="container-fluid">
            <div class="row ">
                <div class="col ">
                    <h4 class="record-title"><div>
                        <?php
                        $id_user = "".USER_ID;
                        $dbhost="".DB_HOST;
                        $dbuser="".DB_USERNAME;
                        $dbpass="".DB_PASSWORD;
                        $dbname="".DB_NAME;
                        //$koneksi=open_connection();
                        $koneksi = new mysqli($dbhost, $dbuser,$dbpass, $dbname);
                        $sql = mysqli_query($koneksi,"select * from user_login WHERE id_userlogin='$id_user'");
                        while ($row=mysqli_fetch_array($sql)){
                        $user_role_id=$row['user_role_id'];
                        $admin_poli   = $row['admin_poli'];
                        }
                        if($user_role_id=="3"){
                        $sql1 = mysqli_query($koneksi,"select * from data_dokter WHERE id_user='$id_user'");
                        while ($row1=mysqli_fetch_array($sql1)){
                        $specialist=$row1['specialist'];
                        //$nama_poli=$row['nama_poli'];
                        }
                        $sql2 = mysqli_query($koneksi,"select * from data_poli WHERE id_poli='$specialist'");
                        while ($row2=mysqli_fetch_array($sql2)){
                        $nama_poli=$row2['nama_poli'];
                        }   
                        ?>
                        <div align="left"><h4 class="record-title">Pasien Poli <?php echo $nama_poli;?></h4> </div>
                        <?php
                        }else{
                        ?>
                        <h4 class="record-title">Pendaftaran Poli</h4>
                        <?php
                        }
                        ?>  
                    </div>
                </h4>
            </div>
            <div class="col-md-3 comp-grid">
                <div class="">  <div>
                    <?php
                    if($user_role_id=="1" or $user_role_id=="4"){?>
                    <a  class="btn btn-primary" href="<?php  print_link("pendaftaran_poli/add");?>">
                        <i class="fa fa-plus"></i>                              
                        Add Pasien Poli 
                    </a>  
                    <?php }?>
                </div>
            </div>
        </div>
        <div class="col-md-3 comp-grid">
            <div class="">  <div>
                <?php
                if($user_role_id=="1" or $user_role_id=="4"){?>
                <a  class="btn btn-primary" href="<?php  print_link("data_pasien/list?poli=true");?>">
                    <i class="fa fa-plus"></i>                              
                    Pilih Data Pasien
                </a>  
                <?php }?>
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
            <div class="col-md-12 comp-grid">
                <div class=""><style>
                    #table-wrappera {
                    position:relative;
                    }
                    #table-scrolla {
                    height:100px;
                    overflow:auto;  
                    margin-top:0px;
                    }
                    #table-wrappera table {
                    width:100%;
                    }
                    #table-wrappera table * {
                    color:black;
                    }
                    #table-wrappera table thead th .text {
                    position:absolute;   
                    top:-20px;
                    z-index:2;
                    height:0px;
                    width:35%;
                    border:1px solid red;
                    }       
                </style>
                <div>
                    <?php
                    $usrnam  = "".USER_NAME;
                    $id_user = "".USER_ID;
                    $dbhost  = "".DB_HOST;
                    $dbuser  = "".DB_USERNAME;
                    $dbpass  = "".DB_PASSWORD;
                    $dbname  = "".DB_NAME;
                    $koneksi = new mysqli($dbhost, $dbuser,$dbpass, $dbname);
                    $idtrace = "$id_user$usrnam";
                    $linksite="".SITE_ADDR;
                    $sekarang = gmdate("Y-m-d", time() + 60 * 60 * 7);
                    $appcek = mysqli_query($koneksi,"select * from pendaftaran_poli WHERE setatus='' and tanggal='$sekarang'");
                    $roapp = mysqli_num_rows($appcek );
                    if ($roapp  <> 0) {
                    while ($datapp = MySQLi_fetch_array($appcek)) {
                    $bayar= $datapp['pembayaran'];
                    $datapoli=$datapp['id_pendaftaran_poli'];
                    $trxcek = mysqli_query($koneksi,"select * from transaksi WHERE no_rekam_medis='".$datapp['no_rekam_medis']."'");
                    $rotrx = mysqli_num_rows($trxcek);
                    if ($rotrx  <> 0) {
                    $datp=mysqli_fetch_assoc($trxcek);
                    $trxset=$datp['setatus_tagihan'];
                    }else{
                    $trxset="";
                    }
                    if(USER_ROLE==12 or USER_ROLE==1 or USER_ROLE==19){
                    $datrm = mysqli_query($koneksi,"select * from data_rekam_medis WHERE idapp='$datapoli' and no_rekam_medis='".$datapp['no_rekam_medis']."'");
                    $rotrxd = mysqli_num_rows($datrm );
                    if ($rotrxd  <> 0) {
                    ?>
                    <div id="appointment-liveap-records">    
                        <div id="page-report-body" class="table-responsive">
                            <div id="table-wrappera">
                                <div id="table-scrolla">
                                    <table class="table  table-striped table-sm text-left">
                                        <thead class="table-header bg-success text-dark">
                                            <tr>
                                                <th  class="td-tanggal"> Tanggal</th>
                                                <th  class="td-no_rekam_medis">NO RM</th>
                                                <th  class="td-nama"> Nama</th>
                                                <th  class="td-alamat"> Alamat</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody class="page-data" id="page-data-list-page-8rt4hbl3u9f5">
                                            <tr>
                                                <td > <?php echo $datapp['tanggal'];?></td>
                                                <td ><?php echo $datapp['no_rekam_medis'];?></td>
                                                <td > <?php echo $datapp['nama_pasien'];?></td>
                                                <td > <?php echo $datapp['alamat'];?></td>
                                                <td ><div class=""> 
                                                    <?php
                                                    if($trxset=="Register"){
                                                    if($bayar=="1"){
                                                    echo "Kasir Proses Closed Dahulu";  
                                                    }else{
                                                    echo "Selesaikan Pembayaran Dahulu"; 
                                                    }
                                                    ?>
                                                    <div>
                                                        <a style="margin-top:2px;margin-bottom:5px;" class="dropdown-item" title="Chekin" href="#">
                                                            <i class="fa fa-sign-in "></i> Chekin
                                                        </a>   </div> </div>  
                                                        <?php
                                                        }else{?>
                                                        <div>
                                                            <a style="margin-top:2px;margin-bottom:5px;" class="dropdown-item" title="Chekin" href="<?php  print_link("pendaftaran_poli/chekin/$datapoli?action=Rujukan");?>">
                                                                <i class="fa fa-sign-in "></i> Chekin
                                                            </a>   </div> </div>   
                                                            <?php }?>
                                                        </td>
                                                    </tr>    
                                                </tbody>
                                            </table>   
                                        </div></div></div>  </div>
                                        <?php 
                                        }
                                        }
                                        }
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div  class="">
                    <div class="container">
                        <div class="row ">
                            <div class="col-sm-6 comp-grid">
                                <div class=""><div>
                                    <?php if(!empty($_GET['pendaftaran_poli_tanggal'])){}else{?> 
                                    <script>
                                        window.onload = function(){
                                        // document.forms['autoform'].submit();
                                        document.getElementById('autobtn').click();
                                        }   
                                    </script>
                                    <?php }?>
                                    <form method="get" action="<?php print_link($current_page) ?>" class="form filter-form">
                                        <div class="input-group">
                                            <input class="form-control datepicker  datepicker"  value="<?php echo $this->set_field_value('pendaftaran_poli_tanggal',date_now()); ?>" type="datetime"  name="pendaftaran_poli_tanggal" placeholder="Tanggal" data-enable-time="" data-date-format="Y-m-d" data-alt-format="M j, Y" data-inline="false" data-no-calendar="false" data-mode="single" />
                                                <div class="input-group-append">
                                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                </div>
                                                &nbsp;&nbsp;
                                                <select required=""  name="pendaftaran_poli_setatus"  placeholder="Select a value ..."    class="custom-select" >
                                                    <option  value="Register" >Register</option>
                                                    <option  value="Closed">Closed</option>
                                                </select>
                                                &nbsp;&nbsp;
                                                <?php
                                                if($user_role_id=="3"){
                                                $sql1 = mysqli_query($koneksi,"select * from data_dokter WHERE id_user='$id_user'");
                                                while ($row1=mysqli_fetch_array($sql1)){
                                                $specialist = $row1['specialist'];
                                                }
                                                ?>
                                                <input type="hidden" name="pendaftaran_poli_nama_poli" value="<?php echo $specialist;?>">
                                                    <?php
                                                    }else{
                                                    $query = mysqli_query($koneksi, "SELECT * from data_poli WHERE id_poli='$admin_poli'")
                                                    or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                                                    $rows = mysqli_num_rows($query);
                                                    if ($rows <> 0) {
                                                    ?>
                                                    <input type="hidden" name="pendaftaran_poli_nama_poli" value="<?php echo $admin_poli;?>">
                                                        <?php
                                                        }else{
                                                        ?>
                                                        <select required=""  name="pendaftaran_poli_nama_poli"  placeholder="Nama Poli ..."    class="custom-select" >
                                                            <option value="0">Nama Poli...</option>
                                                            <?php
                                                            $sql = mysqli_query($koneksi,"select * from data_poli");
                                                            while ($row=mysqli_fetch_array($sql)){
                                                            $id_poli=$row['id_poli'];
                                                            $nama_poli=$row['nama_poli'];
                                                            echo"<option value=\"$id_poli\" >$nama_poli</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                        <?php 
                                                        }
                                                        }   
                                                        ?>
                                                        <div class="input-group-append">
                                                            <button class="btn btn-primary" id="autobtn">Filter</button>
                                                        </div>
                                                    </div>
                                                </form>  
                                            </div>
                                            <div style="margin-bottom:3px;"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div  class="">
                            <div class="container-fluid">
                                <div class="row ">
                                    <div class="col-md-12 comp-grid">
                                        <?php $this :: display_page_errors(); ?>
                                        <div  class=" animated fadeIn page-content">
                                            <div id="pendaftaran_poli-list-records">
                                                <div id="page-report-body" class="table-responsive">
                                                    <?php Html::ajaxpage_spinner(); ?>
                                                    <table class="table  table-sm text-left">
                                                        <thead class="table-header bg-success text-dark">
                                                            <tr>
                                                                <th  class="td-tanggal"> Tanggal</th>
                                                                <th  class="td-no_rekam_medis"> No Rekam Medis</th>
                                                                <th  class="td-nama_pasien"> Nama Pasien</th>
                                                                <th  class="td-tanggal_lahir"> Tanggal Lahir</th>
                                                                <th  class="td-umur"> Umur</th>
                                                                <th  class="td-jenis_kelamin"> Jenis Kelamin</th>
                                                                <th  class="td-alamat"> Alamat</th>
                                                                <th  class="td-keluhan"> Keluhan</th>
                                                                <th  class="td-no_antri_poli"> No Antri Poli</th>
                                                                <th  class="td-nama_poli"> Nama Poli</th>
                                                                <th  class="td-dokter"> Dokter</th>
                                                                <th  class="td-action"> Action</th>
                                                                <th  class="td-pemeriksaan_fisik"> Pemeriksaan Fisik</th>
                                                                <th  class="td-catatan_medis"> Catatan Medis</th>
                                                                <th  class="td-tindakan"> Tindakan</th>
                                                                <th  class="td-lab"> Lab</th>
                                                                <th  class="td-rekam_medis"> Rekam Medis</th>
                                                                <th  class="td-resep_obat"> Resep Obat</th>
                                                                <th  class="td-pembayaran"> Pembayaran</th>
                                                                <th  class="td-setatus_bpjs"> Setatus Bpjs</th>
                                                                <th  class="td-setatus"> Setatus</th>
                                                                <th class="td-btn"></th>
                                                            </tr>
                                                        </thead>
                                                        <?php
                                                        if(!empty($records)){
                                                        ?>
                                                        <tbody class="page-data" id="page-data-<?php echo $page_element_id; ?>">
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
                                                                    <!--endrecord-->
                                                                </tbody>
                                                                <tbody class="search-data" id="search-data-<?php echo $page_element_id; ?>"></tbody>
                                                                <?php
                                                                }
                                                                ?>
                                                            </table>
                                                            <?php 
                                                            if(empty($records)){
                                                            ?>
                                                            <h4 class="bg-light text-center border-top text-muted animated bounce  p-3">
                                                                <i class="fa fa-ban"></i> No record found
                                                            </h4>
                                                            <?php
                                                            }
                                                            ?>
                                                        </div>
                                                        <?php
                                                        if( $show_footer && !empty($records)){
                                                        ?>
                                                        <div class=" border-top mt-2">
                                                            <div class="row justify-content-center">    
                                                                <div class="col-md-auto justify-content-center">    
                                                                    <div class="p-3 d-flex justify-content-between">    
                                                                    </div>
                                                                </div>
                                                                <div class="col">   
                                                                    <?php
                                                                    if($show_pagination == true){
                                                                    $pager = new Pagination($total_records, $record_count);
                                                                    $pager->route = $this->route;
                                                                    $pager->show_page_count = true;
                                                                    $pager->show_record_count = true;
                                                                    $pager->show_page_limit =true;
                                                                    $pager->limit_count = $this->limit_count;
                                                                    $pager->show_page_number_list = true;
                                                                    $pager->pager_link_range=5;
                                                                    $pager->ajax_page = true;
                                                                    $pager->render();
                                                                    }
                                                                    ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
