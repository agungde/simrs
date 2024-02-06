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
    <div  class=" p-2 mb-2">
        <div class="container">
            <div class="row ">
                <div class="col ">
                    <h4 class="record-title"><?php
                        if(!empty($_GET['pasien'])){
                        $pasien=$_GET['pasien'];
                        }else{
                        $pasien="";
                        }
                        echo "Add Pendaftaran Lab $pasien";
                        ?>
                        <script> 
                            function appnam() { 
                            var jen = $('#ctrl-jenis_pemeriksaan').val();
                            var nam = $('#ctrl-nama_pemeriksaan').val();
                            $.ajax({
                            url:"<?php print_link("namalab.php");?>",
                            method:"POST",
                            data:{nam:nam,jen:jen},
                            dataType:"JSON",
                            success:function(data)
                            {
                            var hasil=""+ data.passok; 
                            if(hasil=="OK"){
                            //document.getElementById("transaksi-shift-form").submit();
                            var result = confirm("Proses Pendaftaran Lab?");
                            if (result == true) {
                            //document.getElementById('autobtn').click();
                            // document.getElementById("transaksi-shift-form").submit();
                            alert("Nama Pemeriksaan OK");
                            return true;
                            }
                            else {
                            return false;
                            }
                            }else{
                            // document.getElementById('keyerror').innerHTML = "Password Salah!!";  
                            alert("Silahkan Pilih Nama Pemeriksaan");
                            }
                            }
                            });
                            }
                        </script></h4>
                        <div class=""><style>
                            .rowder::after {
                            content: "";
                            clear: both;
                            display: block;
                            margin: 5px;
                            }
                            [class*="coll-"] {
                            float: left;
                            padding: 5px;
                            }
                            .coll-1 {width: 8.33%;}
                            .coll-2 {width: 16.66%;}
                            .coll-3 {width: 25%;}
                            .coll-4 {width: 33.33%;}
                            .coll-5 {width: 41.66%;}
                            .coll-6 {width: 50%;}
                            .coll-7 {width: 58.33%;}
                            .coll-8 {width: 66.66%;}
                            .coll-9 {width: 75%;}
                            .coll-10 {width: 83.33%;}
                            .coll-11 {width: 91.66%;}
                            .coll-12 {width: 100%;}
                            .round3 {
                            border: 2px solid #DCDCDC;
                            border-radius: 12px;
                            padding: 5px;
                            }
                        </style>
                        <div>
                            <?php
                            $id_user = "".USER_ID;
                            $dbhost  = "".DB_HOST;
                            $dbuser  = "".DB_USERNAME;
                            $dbpass  = "".DB_PASSWORD;
                            $dbname  = "".DB_NAME;
                            $koneksi = new mysqli($dbhost, $dbuser,$dbpass, $dbname);
                            if(!empty($_GET['precord'])){
                            //$precord=$_GET['precord']; 
                            $ciphertext = $_GET['precord'];
                            $backlink=$ciphertext;       
                            $precord=$_GET['precord'];
                            $datprecord=$_GET['datprecord'];
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
                            $id_daftar=$original_plaintext;
                            if($pasien=="POLI"){   
                            $queryb = mysqli_query($koneksi, "select * from pendaftaran_poli WHERE id_pendaftaran_poli='$original_plaintext'")
                            or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                            }
                            if($pasien=="IGD"){        
                            $queryb = mysqli_query($koneksi, "select * from igd WHERE id_igd='$original_plaintext'")
                            or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));                               
                            }    
                            if($pasien=="RANAP"){        
                            $queryb = mysqli_query($koneksi, "select * from rawat_inap WHERE id='$original_plaintext'")
                            or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));                               
                            }  
                            if($pasien=="RANAP ANAK"){        
                            $queryb = mysqli_query($koneksi, "select * from ranap_anak WHERE id='$original_plaintext'")
                            or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));                               
                            }  
                            if($pasien=="RANAP BERSALIN"){        
                            $queryb = mysqli_query($koneksi, "select * from ranap_bersalin WHERE id='$original_plaintext'")
                            or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));                               
                            } 
                            if($pasien=="RANAP PERINA"){        
                            $queryb = mysqli_query($koneksi, "select * from ranap_perina WHERE id='$original_plaintext'")
                            or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));                               
                            } 
                            // ambil jumlah baris data hasil query
                            $rowsb = mysqli_num_rows($queryb);
                            if ($rowsb <> 0) {
                            $row   = mysqli_fetch_assoc($queryb); 
                            $no_rekam_medis=$row['no_rekam_medis'];
                            $nama_pasien=$row['nama_pasien'];
                            $alamat=$row['alamat'];
                            $no_hp=$row['no_hp'];
                            $tanggal_lahir=$row['tanggal_lahir'];
                            $jenis_kelamin=$row['jenis_kelamin'];
                            $email=$row['email'];
                            $umur=$row['umur'];
                            //////////////////////////
                            // $tinggi=$row['tinggi'];
                            //$berat_badan=$row['berat_badan'];
                            $id_transaksi=$row['id_transaksi'];
                            //dokter_pengirim
                            // $keluhan=$row['keluhan'];
                            if($pasien=="IGD"){ 
                            $keluhan="";
                            $id_daftar=$row['id_igd'];
                            $dokter=$row['dokter'];
                            }else if($pasien=="RANAP"){
                            $keluhan="";
                            $id_daftar=$row['id'];
                            $dokter=$row['dokter_rawat_inap'];
                            }else if($pasien=="RANAP ANAK"){
                            $keluhan="";
                            $id_daftar=$row['id'];
                            $dokter=$row['dokter_ranap_anak'];
                            }else if($pasien=="RANAP BERSALIN"){
                            $keluhan="";
                            $id_daftar=$row['id'];
                            $dokter=$row['dokter_ranap_bersalin'];
                            }else if($pasien=="RANAP PERINA"){
                            $keluhan="";
                            $id_daftar=$row['id'];
                            $dokter=$row['dokter_ranap_perina'];
                            }else if($pasien=="POLI"){ 
                            $nama_poli=$row['nama_poli'];
                            $id_daftar=$row['id_pendaftaran_poli'];
                            $keluhan=$row['keluhan'];
                            $dokter=$row['dokter'];
                            }else{
                            $dokter=$row['dokter'];
                            }
                            $querybc = mysqli_query($koneksi, "select * from pemeriksaan_fisik WHERE id_daftar='$original_plaintext' and no_rekam_medis='$no_rekam_medis'")
                            or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));  
                            $rowsbc = mysqli_num_rows($querybc);
                            if ($rowsbc <> 0) {
                            $rowc   = mysqli_fetch_assoc($querybc); 
                            $keluhan=$rowc['keluhan'];
                            }
                            if($no_hp==""){
                            $no_hp="123456";
                            }
                            ///////////////////
                            }else{
                            ?>
                            <script language="JavaScript">
                                alert('Dilarang Akses URL Tidak Valid');
                                document.location='<?php print_link(""); ?>';
                            </script>
                            <?php }
                            if($pasien=="POLI"){ 
                            $sqlp = mysqli_query($koneksi,"select * from data_poli WHERE id_poli='$nama_poli'");
                            while ($rowp=mysqli_fetch_array($sqlp)){
                            $nama_poli=$rowp['nama_poli'];
                            }
                            }else{
                            $nama_poli=$pasien; 
                            }
                            $sqld = mysqli_query($koneksi,"select * from data_dokter WHERE id_dokter='$dokter'");
                            while ($rowd=mysqli_fetch_array($sqld)){
                            $dokter=$rowd['nama_dokter'];
                            }
                            $namadokter=$dokter;
                            }else{
                            $no_rekam_medis="";
                            $nama_pasien="";
                            $alamat="";
                            $no_hp="";
                            $tanggal_lahir="";
                            $jenis_kelamin="";
                            $email="";
                            $umur="";
                            $tinggi="";
                            $berat_badan="";
                            $tensi="";
                            $dokter="";
                            $nama_poli="";
                            $keluhan="";
                            $id_daftar="";
                            $id_transaksi="";
                            }
                            ?>
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
                    <div class="col-md-8 comp-grid">
                        <div class=" ">
                            <?php  
                            $this->render_page("data_pasien/pasien/$_GET[datprecord]"); 
                            ?>
                        </div>
                        <?php $this :: display_page_errors(); ?>
                        <div  class="p-2 animated fadeIn page-content">
                            <form id="pendaftaran_lab-lab-form" name="pendaftaran_lab-lab-form" role="form" novalidate enctype="multipart/form-data" class="form page-form form-horizontal needs-validation" action="<?php print_link("pendaftaran_lab/lab?csrf_token=$csrf_token") ?>" method="post">
                                <div>
                                    <div class="form-group ">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <label class="control-label" for="tanggal">Tanggal <span class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-sm-8">
                                                <div class="input-group">
                                                    <input id="ctrl-tanggal" class="form-control datepicker  datepicker" required="" value="<?php  echo $this->set_field_value('tanggal',datetime_now()); ?>" type="datetime"  name="tanggal" placeholder="Enter Tanggal" data-enable-time="true" data-min-date="" data-max-date="" data-date-format="Y-m-d H:i:S" data-alt-format="F j, Y - H:i" data-inline="false" data-no-calendar="false" data-mode="single" /> 
                                                        <div class="input-group-append">
                                                            <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <input id="ctrl-nama_pasien"  value="<?php echo $nama_pasien;?>" type="hidden" placeholder="Enter Nama Pasien"  required="" name="nama_pasien"  class="form-control " />
                                            <input id="ctrl-id_transaksi"  value="<?php echo $id_transaksi;?>" type="hidden"  required="" name="id_transaksi"  class="form-control " />               
                                                <input id="ctrl-no_rekam_medis"  value="<?php echo $no_rekam_medis;?>" type="hidden" placeholder="Enter No Rekam Medis"  required="" name="no_rekam_medis"  class="form-control " />
                                                    <input id="ctrl-alamat"  value="<?php echo $alamat;?>" type="hidden" placeholder="Enter Alamat"  required="" name="alamat"  class="form-control " />
                                                        <input id="ctrl-no_hp"  value="<?php echo $no_hp;?>" type="hidden" placeholder="Enter No Hp"  required="" name="no_hp"  class="form-control " />
                                                            <div class="form-group ">
                                                                <div class="row">
                                                                    <div class="col-sm-4">
                                                                        <label class="control-label" for="keluhan">Keluhan <span class="text-danger">*</span></label>
                                                                    </div>
                                                                    <div class="col-sm-8">
                                                                        <div class="">
                                                                            <input id="ctrl-keluhan"  value="<?php echo $keluhan;?>" type="text" placeholder="Enter Keluhan"  required="" name="keluhan"  class="form-control " />
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
                                                                                <input id="ctrl-pasien"  value="<?php echo $pasien;?>" type="text" placeholder="Enter Pasien"  readonly required="" name="pasien"  class="form-control " />
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group ">
                                                                        <div class="row">
                                                                            <div class="col-sm-4">
                                                                                <label class="control-label" for="nama_poli">Nama Poli <span class="text-danger">*</span></label>
                                                                            </div>
                                                                            <div class="col-sm-8">
                                                                                <div class="">
                                                                                    <input id="ctrl-nama_poli"  value="<?php echo $nama_poli;?>" type="text" placeholder="Enter Nama Poli"  readonly required="" name="nama_poli"  class="form-control " />
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <input id="ctrl-id_daftar"  value="<?php echo $id_daftar;?>" type="hidden" placeholder="Enter Id Daftar"  required="" name="id_daftar"  class="form-control " />
                                                                            <div class="form-group ">
                                                                                <div class="row">
                                                                                    <div class="col-sm-4">
                                                                                        <label class="control-label" for="dokter_pengirim">Dokter Pengirim <span class="text-danger">*</span></label>
                                                                                    </div>
                                                                                    <div class="col-sm-8">
                                                                                        <div class="">
                                                                                            <input id="ctrl-dokter_pengirim"  value="<?php echo $dokter;?>" type="text" placeholder="Enter Dokter Pengirim"  readonly required="" name="dokter_pengirim"  class="form-control " />
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class=""><div>
                                                                            <?php
                                                                            $qudtp = mysqli_query($koneksi, "SELECT * from jenis_pemeriksaan_lab")
                                                                            or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                                                                            $rodtp = mysqli_num_rows($qudtp);
                                                                            if ($rodtp <> 0) {
                                                                            //  $cdt= mysqli_fetch_assoc($qudt);
                                                                            //  $spesial=$cdt['specialist'];
                                                                            while ($datp = MySQLi_fetch_array($qudtp)) {
                                                                            ?>
                                                                            <div class="coll-6">
                                                                                <div class="round3">
                                                                                    <div></div>
                                                                                    <div><b><?php echo $datp['jenis_pemeriksaan'];?></b></div>
                                                                                    <?php
                                                                                    $qudtpab = mysqli_query($koneksi, "SELECT * from nama_pemeriksaan_lab WHERE jenis_pemeriksaan='".$datp['id']."'")
                                                                                    or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                                                                                    $rodtpab = mysqli_num_rows($qudtpab);
                                                                                    if ($rodtpab <> 0) {
                                                                                    //  $cdt= mysqli_fetch_assoc($qudt);
                                                                                    //  $spesial=$cdt['specialist'];
                                                                                    while ($datpb = MySQLi_fetch_array($qudtpab)) {
                                                                                    ?>
                                                                                    <table class="table table-striped table-sm">
                                                                                        <tr>
                                                                                            <td valign="top">
                                                                                                <label class="custom-control custom-checkbox custom-control-inline">
                                                                                                    <input class="custom-control-input" id="ctrl-nama_pemeriksaan[]" value="<?php echo $datpb['id'];?>" type="checkbox"  name="nama_pemeriksaan[]"  />
                                                                                                        <span class="custom-control-label input-label-text"><?php echo $datpb['nama_pemeriksaan'];?></span>
                                                                                                    </label>
                                                                                                </td>
                                                                                            </tr></table>
                                                                                            <?php
                                                                                            }
                                                                                            }
                                                                                            ?>
                                                                                        </div> 
                                                                                    </div>
                                                                                    <?php
                                                                                    }
                                                                                    }
                                                                                    ?>  
                                                                                    <script>   
                                                                                        function ceknamalab() { 
                                                                                        var kelu = $('#ctrl-keluhan').val();
                                                                                        if(kelu==""){
                                                                                        document.getElementById("ctrl-keluhan").focus();
                                                                                        alert('Silahkan Isi Keluhan');
                                                                                        return false;
                                                                                        }
                                                                                        //alert('Submit OK');
                                                                                        $.ajax({
                                                                                        url:"<?php print_link("namalab.php");?>",
                                                                                        method:"POST",
                                                                                        data: $('#pendaftaran_lab-lab-form').serialize(),
                                                                                        dataType:"JSON",
                                                                                        success:function(data)
                                                                                        {
                                                                                        var hasil=""+ data.passok; 
                                                                                        if(hasil=="OK"){
                                                                                        //document.getElementById("transaksi-shift-form").submit();
                                                                                        var result = confirm("Apakah Semua Data Sudah Benar?");
                                                                                        if (result == true) {
                                                                                        //document.getElementById('autobtn').click();
                                                                                        document.getElementById("pendaftaran_lab-lab-form").submit();
                                                                                        return true;
                                                                                        }
                                                                                        else {
                                                                                        return false;
                                                                                        }
                                                                                        }else  {
                                                                                        alert('Silahkan Pilih Nama Pemeriksaan!!');
                                                                                        return false; 
                                                                                        }       
                                                                                        // alert('Data OK');
                                                                                        }
                                                                                        });
                                                                                        }
                                                                                    </script>  
                                                                                    <div class="coll-12">
                                                                                        <div class="form-group form-submit-btn-holder text-center mt-3">
                                                                                            <div class="form-ajax-status"></div>
                                                                                            <button class="btn btn-primary" type="button" onclick="ceknamalab()">
                                                                                                Submit
                                                                                                <i class="fa fa-send"></i>
                                                                                            </button>
                                                                                        </div>
                                                                                    </form>    
                                                                                </div>
                                                                                </div></div><div class=""><div>
                                                                                <?php if(USER_ROLE==3){
                                                                                if(!empty($_GET['pasien'])){
                                                                                $pasien= $_GET['pasien'];
                                                                                }
                                                                                ?>
                                                                                <iframe src="<?php print_link("datarekam.php?precord=$backlink&pasien=$pasien") ?>" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                                                                                <?php }?> 
                                                                            </div></div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </section>
