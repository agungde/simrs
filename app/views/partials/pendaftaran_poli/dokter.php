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
<section class="page" id="<?php echo $page_element_id; ?>" data-page-type="list"  data-display-type="table" data-page-url="<?php print_link($current_page); ?>">
    <?php
    if( $show_header == true ){
    ?>
    <div  class="p-2 mb-2">
        <div class="container-fluid">
            <div class="row ">
                <div class="col ">
                    <h4 class="record-title"><?php if(USER_ROLE==3){ 
                        $id_user = "".USER_ID;
                        $dbhost  = "".DB_HOST;
                        $dbuser  = "".DB_USERNAME;
                        $dbpass  = "".DB_PASSWORD;
                        $dbname  = "".DB_NAME;
                        //$koneksi=open_connection();
                        $koneksi = new mysqli($dbhost, $dbuser,$dbpass, $dbname);
                        $qudt = mysqli_query($koneksi, "SELECT * from data_dokter WHERE id_user='$id_user'")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                        $rodt = mysqli_num_rows($qudt);
                        if ($rodt <> 0) {
                        $cdt= mysqli_fetch_assoc($qudt);
                        $spesial=$cdt['specialist']; 
                        $iddok=$cdt['id_dokter']; 
                        $namadokter=$cdt['nama_dokter'];
                        }
                        $qudtp = mysqli_query($koneksi, "SELECT * from data_poli WHERE id_poli='$spesial'")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                        $rodtp = mysqli_num_rows($qudtp);
                        if ($rodtp <> 0) {
                        $cdtp= mysqli_fetch_assoc($qudtp);
                        $nampoli=$cdtp['nama_poli']; 
                        }
                        ?>
                        Pasien Poli <?php echo $nampoli;
                        }else{
                        ?>
                        <script language="JavaScript">
                            alert('Dilarang Akses!!');
                            document.location='<?php print_link(""); ?>';
                        </script> 
                        <?php
                        }
                    ?></h4>
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
                    <div class=""><div>
                        <?php if(!empty($_GET['cari_pasien_tanggal'])){}else{?> 
                        <script>
                            window.onload = function(){
                            // document.forms['autoform'].submit();
                            document.getElementById('autobtn').click();
                            }   
                        </script>
                        <?php }?>
                        <table width="300"><tr><td>
                            <div style="font-size: 14px;">Cari Pasien Tanggal</div>
                            <form method="get" action="<?php print_link($current_page) ?>" class="form filter-form">
                                <div class="input-group">
                                    <input  class="form-control datepicker  datepicker"  value="<?php echo $this->set_field_value('cari_pasien_tanggal',date_now()); ?>" type="datetime"  name="cari_pasien_tanggal" placeholder="Tanggal" data-enable-time="" data-date-format="Y-m-d" data-alt-format="M j, Y" data-inline="false" data-no-calendar="false" data-mode="single" />
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                        </div>
                                        &nbsp;&nbsp;
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" id="autobtn">Cari</button>
                                        </div>
                                    </div>
                                </form>   
                            </td></tr></table>
                        </div></div>
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
                            <style>
                                textarea {
                                width: 100px;
                                height: 100px;
                                }
                                th{
                                font-size: 12px;
                                }
                                td{
                                font-size: 10px;
                                }
                                #table-wrapper {
                                position:relative;
                                }
                                #table-scroll {
                                height:250px;
                                overflow:auto;  
                                margin-top:3px;
                                }
                                #table-wrapper table {
                                width:100%;
                                }
                                #table-wrapper table * {
                                color:black;
                                }
                                #table-wrapper table thead th .text {
                                position:absolute;   
                                top:-3px;
                                z-index:2;
                                height:20px;
                                width:35%;
                                border:1px solid red;
                                }
                                #table-wrappera {
                                position:relative;
                                }
                                #table-scrolla {
                                height:200px;
                                color: blue;
                                overflow:auto;  
                                margin-top:0px;
                                }
                                #table-wrappera table {
                                width:100%;
                                }
                                #table-wrappera table * {
                                color:blue;
                                }
                                #table-wrappera table thead th .text {
                                position:absolute;   
                                top:-20px;
                                z-index:2;
                                height:0px;
                                width:35%;
                                border:1px solid red;
                                }   
                                #table-wrapperb {
                                position:relative;
                                }
                                #table-scrollb {
                                height:180px;
                                overflow:auto;  
                                margin-top:0px;
                                }
                                #table-wrapperb table {
                                width:100%;
                                }
                                #table-wrapperb table * {
                                color:black;
                                }
                                #table-wrapperb table thead th .text {
                                position:absolute;   
                                top:-20px;
                                z-index:2;
                                height:20px;
                                width:35%;
                                border:1px solid red;
                                }
                            </style>
                            <?php 
                            if(!empty($_GET['cari_pasien_tanggal'])){
                            $sekarang =$_GET['cari_pasien_tanggal'];
                            }else{
                            $sekarang = gmdate("Y-m-d", time() + 60 * 60 * 7);
                            }
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
                            $sqlcek = mysqli_query($koneksi,"select * from pendaftaran_poli WHERE id_pendaftaran_poli='$original_plaintext'");
                            $rowsp = mysqli_num_rows($sqlcek);
                            if ($rowsp <> 0) {
                            $datp=mysqli_fetch_assoc($sqlcek);
                            $datnorm=$datp['no_rekam_medis'];
                            $tgldaftar=$datp['tanggal'];
                            $setatus=$datp['setatus'];
                            $nama_poli=$datp['nama_poli'];
                            $dokter=$datp['dokter'];
                            }else{
                            ?>
                            <script language="JavaScript">
                                alert('Dilarang Akses URL Tidak Valid');
                                document.location='<?php print_link(""); ?>';
                            </script>
                            <?php } 
                            }
                            ?>
                            <div  class=" animated fadeIn page-content">
                                <div id="pendaftaran_poli-list-records">
                                    <div id="page-report-body" class="table-responsive">                       
                                        <div id="pendaftaran_poli-dokter-records">
                                            <div id="page-report-body" class="table-responsive">
                                                <table width="100%" style="border: 1px solid black;">
                                                    <tr>
                                                        <td width="18%" valign="top">
                                                            <table class="table  table-sm text-left" width="100%" style="border: 1px solid black;">
                                                                <thead class="table-header bg-success">
                                                                    <tr style="border: 1px solid black;">
                                                                        <th >
                                                                            No 
                                                                        </th>
                                                                        <th >
                                                                            RM 
                                                                        </th>                                                    
                                                                        <th>
                                                                            Nama 
                                                                        </th>
                                                                        <th>
                                                                        </th>                                                   
                                                                    </tr>
                                                                </thead>
                                                                <tr style="border-bottom: 1px solid black;">
                                                                    <td colspan="3" align="center" style="font-size: 14px;color: blue;">Pending Pasien</td>
                                                                </tr>
                                                            </table>
                                                            <?php  if(!empty($_GET['cari_pasien_tanggal'])){}else{?>                                            
                                                            <div id="table-wrappera">
                                                                <div id="table-scrolla">
                                                                    <table class="table  table-sm text-left" width="100%" style="border: 1px solid black;color: blue;">
                                                                        <?php
                                                                        $queryc1 = mysqli_query($koneksi, "SELECT COUNT(*) AS totp from pendaftaran_poli WHERE dokter='$iddok' and nama_poli='$spesial'  and tanggal='$sekarang'")
                                                                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                                                                        $rowsc1 = mysqli_num_rows($queryc1);
                                                                        if ($rowsc1 <> 0) {
                                                                        $datnum1=mysqli_fetch_assoc($queryc1);
                                                                        $totpas=$datnum1['totp'];
                                                                        }else{
                                                                        $totpas="0";
                                                                        } 
                                                                        $queryc2 = mysqli_query($koneksi, "SELECT COUNT(*) AS sisp from pendaftaran_poli WHERE dokter='$iddok' and nama_poli='$spesial'  and setatus='Register' and tanggal='$sekarang'")
                                                                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                                                                        $rowsc2 = mysqli_num_rows($queryc2);
                                                                        if ($rowsc2 <> 0) {
                                                                        $datnum2=mysqli_fetch_assoc($queryc2);
                                                                        $sispas=$datnum2['sisp'];
                                                                        }else{
                                                                        $sispas="0";
                                                                        }
                                                                        $selesai=$totpas - $sispas;
                                                                        $nreg=1;
                                                                        $qudtpa = mysqli_query($koneksi, "SELECT * from pendaftaran_poli WHERE dokter='$iddok' and nama_poli='$spesial'  and setatus='Register' and tanggal='$sekarang' ORDER BY `no_antri_poli` ASC")
                                                                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                                                                        $rodtpa = mysqli_num_rows($qudtpa);
                                                                        if ($rodtpa <> 0) {
                                                                        // $rodok= mysqli_fetch_assoc($qudtpa);
                                                                        //$spesial= $rodok['dokter']; 
                                                                        // $iddok=$cdt['id_dokter']; 
                                                                        while ($datp = MySQLi_fetch_array($qudtpa)) {
                                                                        $norm=$datp['no_rekam_medis'];
                                                                        $noan=$datp['no_antri_poli'];
                                                                        $idb=$datp['pembayaran'];
                                                                        $qub = mysqli_query($koneksi, "SELECT * from data_bank WHERE id_databank='$idb'")
                                                                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                                                                        $roba = mysqli_num_rows($qub);
                                                                        if ($roba <> 0) {
                                                                        $roban= mysqli_fetch_assoc($qub);
                                                                        $bayar=$roban['nama_bank']; 
                                                                        }
                                                                        $key="dermawangroup";
                                                                        $plaintext = "".$datp['id_pendaftaran_poli'];
                                                                        $ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
                                                                        $iv = openssl_random_pseudo_bytes($ivlen);
                                                                        $ciphertext_raw = openssl_encrypt($plaintext, $cipher, $key, $options=OPENSSL_RAW_DATA, $iv);
                                                                        $hmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary=true);
                                                                        $ciphertext = base64_encode( $iv.$hmac.$ciphertext_raw );
                                                                        ?>
                                                                        <tr >      
                                                                            <td style="border-left: 1px solid black;">
                                                                                <?php echo $nreg;?>
                                                                            </td >
                                                                            <td style="border-left: 1px solid black;">
                                                                                <?php echo $norm;?>
                                                                            </td>                                                
                                                                            <td style="border-left: 1px solid black;color: blue;">
                                                                                <a href="<?php  print_link("pendaftaran_poli/dokter?precord=$ciphertext&datrm=$norm");?>">
                                                                                    <?php echo $datp['tl'];?>    <?php echo $datp['nama_pasien'];?>
                                                                                </a>
                                                                            </td>
                                                                            <td style="border-left: 1px solid black;">
                                                                                <?php echo $bayar;?>
                                                                            </td>                                                 
                                                                        </tr>   
                                                                        <?php $nreg++;
                                                                        }
                                                                        }
                                                                        ?>
                                                                    </table> 
                                                                </div>  </div>  
                                                                <hr>
                                                                    <?php
                                                                    }
                                                                    if(!empty($_GET['precord'])){
                                                                    $sqlcek2 = mysqli_query($koneksi,"select * from pendaftaran_poli WHERE id_pendaftaran_poli='$original_plaintext'");
                                                                    $rowspa = mysqli_num_rows($sqlcek2);
                                                                    if ($rowspa <> 0) {
                                                                    $row= mysqli_fetch_assoc($sqlcek2); 
                                                                    $no_rekam_medis=$row['no_rekam_medis'];
                                                                    $nama_pasien=$row['nama_pasien'];
                                                                    $alamat=$row['alamat'];
                                                                    $tgllahir=$row['tanggal_lahir'];
                                                                    $umur=$row['umur'];
                                                                    }
                                                                    ?>
                                                                    <div align="center">
                                                                        <?php
                                                                        if($setatus=="Closed"){?>
                                                                        <span class="text-danger" style="font-size: 14px;">Detil Pasien Selesai</span> 
                                                                        <?php }else{?>
                                                                        Detil Pasien
                                                                        <?php }?>
                                                                    </div>
                                                                    <table class="table  table-sm text-left" style="border: 1px solid black;">
                                                                        <tr style="border: 1px solid black;">
                                                                            <td > <?php
                                                                                if($setatus=="Closed"){?>
                                                                                <span class="text-danger">     No RM </span>
                                                                                <?php }else{?>No RM <?php }?>
                                                                            </td>  
                                                                            <td>  <?php
                                                                                if($setatus=="Closed"){?>
                                                                                <span class="text-danger">    <?php echo $no_rekam_medis;?></span>
                                                                                <?php }else{?><?php echo $no_rekam_medis;?><?php }?>
                                                                            </td>
                                                                        </tr>  
                                                                        <tr >
                                                                            <td> <?php
                                                                                if($setatus=="Closed"){?>
                                                                                <span class="text-danger"> Nama </span>
                                                                                <?php }else{?>Nama<?php }?>
                                                                            </td>
                                                                            <td>  <?php
                                                                                if($setatus=="Closed"){?>
                                                                                <span class="text-danger">  <?php echo $nama_pasien;?></span>
                                                                                <?php }else{?><?php echo $nama_pasien;?><?php }?>
                                                                            </td>
                                                                        </tr>
                                                                        <tr >
                                                                            <td> <?php
                                                                                if($setatus=="Closed"){?>
                                                                                <span class="text-danger"> TGL Lahir </span>
                                                                                <?php }else{?>TGL Lahir<?php }?>
                                                                            </td>  
                                                                            <td> <?php
                                                                                if($setatus=="Closed"){?> 
                                                                                <span class="text-danger">  <?php echo $tgllahir;?></span>
                                                                                <?php }else{?>
                                                                                <?php echo $tgllahir;?><?php }?>
                                                                            </td>
                                                                        </tr>
                                                                        <tr >
                                                                            <td><?php
                                                                                if($setatus=="Closed"){?> 
                                                                                <span class="text-danger">
                                                                                Umur</span>
                                                                                <?php }else{?>
                                                                                Umur<?php }?>
                                                                                </td>  <td> <?php
                                                                                if($setatus=="Closed"){?> 
                                                                                <span class="text-danger">
                                                                                <?php echo $umur;?></span>
                                                                                <?php }else{?><?php echo $umur;?><?php }?>
                                                                            </td>
                                                                        </tr>
                                                                    </table> 
                                                                    <?php }?>  
                                                                    <hr>
                                                                        <div><span class="text-danger" style="font-size: 14px;margin-top:-150px;">Pasien sudah ditangani</span> </div>
                                                                        <div id="table-wrapperb">
                                                                            <div id="table-scrollb">                                               
                                                                                <table class="table  table-sm text-left" style="border: 1px solid black;">
                                                                                    <?php
                                                                                    ///////////////////////////closed////////////////////
                                                                                    $noc=1;
                                                                                    $nclos=1;
                                                                                    $quclos = mysqli_query($koneksi, "SELECT * from pendaftaran_poli WHERE dokter='$iddok' and nama_poli='$spesial'  and setatus='Closed' and tanggal='$sekarang' ORDER BY `no_antri_poli` ASC")
                                                                                    or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                                                                                    $rocl = mysqli_num_rows($quclos);
                                                                                    if ($rocl <> 0) {
                                                                                    ?>
                                                                                    <?php
                                                                                    while ($dacl = MySQLi_fetch_array($quclos)) { 
                                                                                    $idba=$dacl['pembayaran'];
                                                                                    $quba = mysqli_query($koneksi, "SELECT * from data_bank WHERE id_databank='$idba'")
                                                                                    or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                                                                                    $robaa = mysqli_num_rows($quba);
                                                                                    if ($robaa <> 0) {
                                                                                    $robana= mysqli_fetch_assoc($quba);
                                                                                    $bayara=$robana['nama_bank']; 
                                                                                    }                                              
                                                                                    $key1="dermawangroup";
                                                                                    $plaintext1 = "".$dacl['id_pendaftaran_poli'];
                                                                                    $ivlen1 = openssl_cipher_iv_length($cipher1="AES-128-CBC");
                                                                                    $iv1 = openssl_random_pseudo_bytes($ivlen1);
                                                                                    $ciphertext_raw1 = openssl_encrypt($plaintext1, $cipher1, $key1, $options1=OPENSSL_RAW_DATA, $iv1);
                                                                                    $hmac1 = hash_hmac('sha256', $ciphertext_raw1, $key1, $as_binary1=true);
                                                                                    $ciphertext1 = base64_encode( $iv1.$hmac1.$ciphertext_raw1 );
                                                                                    ?>
                                                                                    <tr>
                                                                                        <td style="border-left: 1px solid black;">
                                                                                            <span class="text-danger">  <?php echo $nclos;?> </span> 
                                                                                        </td>    
                                                                                        <td style="border-left: 1px solid black;">
                                                                                            <span class="text-danger">  <?php echo $dacl['no_rekam_medis'];?> </span> 
                                                                                        </td>
                                                                                        <td style="border-left: 1px solid black;">
                                                                                            <?php                        
                                                                                            if(!empty($_GET['cari_pasien_tanggal'])){
                                                                                            $sekarang =$_GET['cari_pasien_tanggal'];
                                                                                            ?>
                                                                                            <a href="<?php  print_link("pendaftaran_poli/dokter?cari_pasien_tanggal=$sekarang&precord=$ciphertext1&datrm=".$dacl['no_rekam_medis']);?>">   
                                                                                                <span class="text-danger"><?php echo $dacl['nama_pasien'];?></span>  
                                                                                            </a>                           
                                                                                            <?php
                                                                                            }else{
                                                                                            ?>
                                                                                            <a href="<?php  print_link("pendaftaran_poli/dokter?precord=$ciphertext1&datrm=".$dacl['no_rekam_medis']);?>">   
                                                                                                <span class="text-danger"><?php echo $dacl['nama_pasien'];?></span>  
                                                                                            </a>                       
                                                                                            <?php
                                                                                            }                                                 
                                                                                            ?>                             
                                                                                        </td>
                                                                                        <td style="border-left: 1px solid black;">
                                                                                            <span class="text-danger">  <?php echo $bayara;?> </span> 
                                                                                        </td>
                                                                                    </tr>
                                                                                    <?php
                                                                                    $nclos++;
                                                                                    $noc++;
                                                                                    }?>
                                                                                    <?php
                                                                                    }
                                                                                    ?>
                                                                                </table>
                                                                            </div></div>
                                                                        </td>
                                                                        <?php /////////////////////////////// ?>
                                                                        <td width="100%" valign="top" align="right" >
                                                                            <table class="table  table-sm text-left" width="100%" style="border: 1px solid black;">
                                                                                <thead class="table-header bg-success">
                                                                                    <tr >
                                                                                        <th style="border-left: 1px solid black;">Tanggal</th> 
                                                                                        <th style="border-left: 1px solid black;">Jam Sekarang</th> 
                                                                                        <th style="border-left: 1px solid black;">POLI</th> 
                                                                                        <th style="border-left: 1px solid black;">Dokter Pemeriksa</th> 
                                                                                        <th style="border-left: 1px solid black;">Selesai</th>
                                                                                        <th style="border-left: 1px solid black;">Sisa Pasien</th>
                                                                                        <th style="border-left: 1px solid black;">Jumlah Pasien </th>
                                                                                        <?php
                                                                                        if(!empty($_GET['precord'])){
                                                                                        if($setatus=="Closed"){
                                                                                        ?>
                                                                                        <th style="border-left: 1px solid black;"><span class="text-danger">Selesai</span></th>  
                                                                                        <?php                                                        
                                                                                        }else{
                                                                                        ?>
                                                                                        <th style="border-left: 1px solid black;">Sedang Di Periksa</th>  
                                                                                        <th style="border-left: 1px solid black;"><span class="text-danger">*Wajib*</span></th> 
                                                                                        <?php }
                                                                                        }
                                                                                        ?>
                                                                                    </tr>  
                                                                                </thead>
                                                                                <tbody class="page-data" id="page-data-list-page-6rthbuykzo2a">
                                                                                    <tr>
                                                                                        <td style="border-left: 1px solid black;"><b><?php echo $sekarang;?></b> </td>
                                                                                        <td style="border-left: 1px solid black;"><b><div id="jam" style="font-size: 14px;"></div></b> </td>
                                                                                        <td style="border-left: 1px solid black;"> <?php echo $nampoli;?></td>
                                                                                        <td style="border-left: 1px solid black;"> <?php echo $namadokter;?></td>
                                                                                        <td style="border-left: 1px solid black;"> <?php echo $selesai;?></td>
                                                                                        <td style="border-left: 1px solid black;"> <?php echo $sispas;?></td>
                                                                                        <td style="border-left: 1px solid black;"> <?php echo $totpas;?></td>
                                                                                        <?php
                                                                                        if(!empty($_GET['precord'])){
                                                                                        if($setatus=="Closed"){
                                                                                        ?>
                                                                                        <td style="border-left: 1px solid black;"><span class="text-danger"><?php echo $nama_pasien;?></span></td>  
                                                                                        <?php                                                        
                                                                                        }else{
                                                                                        ?>
                                                                                        <td style="border-left: 1px solid black;"> <?php echo $nama_pasien;?></td>  
                                                                                        <td style="border-left: 1px solid black;">
                                                                                            <button class="btn btn-danger" type="button" onclick="controlclosed()">
                                                                                                Proses Closed
                                                                                                <i class="fa fa-send"></i>
                                                                                            </button> 
                                                                                        </td> 
                                                                                        <?php } }?>
                                                                                    </tr>  
                                                                                </tbody>
                                                                            </table> 
                                                                            <form id="closed" role="form" novalidate enctype="multipart/form-data" class="form page-form form-horizontal needs-validation" action="<?php print_link("appointment/add?csrf_token=$csrf_token") ?>" method="post">    
                                                                                <input type="hidden" name="closed" value="closed">
                                                                                    <input type="hidden" name="datid" value="<?php echo $original_plaintext;?>">
                                                                                        <input type="hidden" name="backlink" value="<?php echo $backlink;?>"> 
                                                                                            <input type="hidden" name="norm" value="<?php echo $datnorm;?>">
                                                                                            </form>
                                                                                            <script>
                                                                                                function controlclosed(){ 
                                                                                                <?php
                                                                                                $sqlc= mysqli_query($koneksi,"select * from data_rekam_medis WHERE id_daftar='$original_plaintext' and no_rekam_medis='$datnorm' and tanggal='$tgldaftar'");
                                                                                                $roc = mysqli_num_rows($sqlc);
                                                                                                if ($roc <> 0) {
                                                                                                $datc=mysqli_fetch_assoc($sqlc);
                                                                                                $cdiag=$datc['diagnosa'];
                                                                                                $ctin=$datc['tindakan'];
                                                                                                }else{
                                                                                                $cdiag="";  
                                                                                                $ctin="";
                                                                                                }
                                                                                                if($ctin==""){
                                                                                                ?>
                                                                                                alert('Silahkan Isi Catatan Medis, Tindakan Dan Diahnosa Dahulu!!');  
                                                                                                return false;
                                                                                                <?php
                                                                                                }
                                                                                                if($cdiag==""){
                                                                                                ?>
                                                                                                alert('Silahkan Isi Diagnosa Dahulu');   
                                                                                                return false;
                                                                                                <?php     
                                                                                                }
                                                                                                ?>
                                                                                                var result = confirm("Apakah Yakin ingin Closed Pemeriksaan?");
                                                                                                if (result == true) {
                                                                                                //document.getElementById('autobtn').click();
                                                                                                document.getElementById("closed").submit();
                                                                                                return true;
                                                                                                }
                                                                                                else {
                                                                                                return false;
                                                                                                }   
                                                                                                }
                                                                                            </script>                                  
                                                                                            <?php
                                                                                            if(!empty($_GET['precord'])){
                                                                                            ////////////////////////////////
                                                                                            ///////////////////////////////////////////////
                                                                                            $sqlcekd = mysqli_query($koneksi,"select * from data_rekam_medis WHERE id_daftar='$original_plaintext' and no_rekam_medis='$datnorm' and tanggal='$tgldaftar'");
                                                                                            $rowspd = mysqli_num_rows($sqlcekd);
                                                                                            if ($rowspd <> 0) {
                                                                                            $datpd=mysqli_fetch_assoc($sqlcekd);
                                                                                            $datid=$datpd['id'];
                                                                                            $lab=$datpd['hasil_laboratorium_radiologi'];
                                                                                            $tindakancek=$datpd['tindakan'];
                                                                                            $diagnosacek=$datpd['diagnosa'];
                                                                                            $keluhan=$datpd['keluhan'];
                                                                                            $resepcek=$datpd['resep_obat'];
                                                                                            $catatan_medis=$datpd['catatan_medis'];
                                                                                            $pemeriksaan_fisik=$datpd['pemeriksaan_fisik'];
                                                                                            $namfile=$datpd['nama_file'];
                                                                                            $namfileket=$datpd['nama_file_ket'];
                                                                                            $pemtam=$datpd['pemeriksaan_tambahan'];
                                                                                            $kettam=$datpd['keterangan_tambahan'];
                                                                                            $ketrujuk=$datpd['keterangan_rujukan'];
                                                                                            $idapp=$datpd['idapp'];
                                                                                            if($tindakancek==""){
                                                                                            if($setatus=="Closed"){}else{
                                                                                            ?>
                                                                                            <form id="data_rekam_medis-datarm-form"  novalidate role="form" enctype="multipart/form-data" class="form multi-form page-form" action="<?php print_link("data_rekam_medis/add?csrf_token=$csrf_token") ?>" method="post" >
                                                                                                <!--[main-form-start]-->
                                                                                                <div><input type="hidden" name="precord" value="<?php echo $datid;?>"><input type="hidden" name="iddaftar" value="<?php echo $original_plaintext;?>"><input type="hidden" name="backprecord" value="<?php echo $backlink;?>"><input type="hidden" name="namdok" value="<?php echo $namadokter;?>"><input type="hidden" name="nampoli" value="<?php echo $nampoli;?>">
                                                                                                    <table class="table table-striped table-sm" data-maxrow="10" data-minrow="1" style="border: 1px solid black;">
                                                                                                        <thead class="table-header bg-success">
                                                                                                            <tr >
                                                                                                                <th style="border-left: 1px solid black;"><label for="tanggal" width="100">Keluhan</label></th>
                                                                                                                <th style="border-left: 1px solid black;"><label for="tanggal">Pemeriksaan Fisik</label></th>
                                                                                                                <th style="border-left: 1px solid black;"><label for="catatan_medis" width="170">Catatan Medis</label></th>
                                                                                                                <th style="border-left: 1px solid black;"><label for="tindakan">Tindakan</label></th>
                                                                                                                <th style="border-left: 1px solid black;"><label for="tindakan">Diagnosa</label></th>
                                                                                                                <th style="border-left: 1px solid black;"></th>
                                                                                                            </tr style="border: 1px solid black;">
                                                                                                        </thead>
                                                                                                        <tbody>
                                                                                                            <tr class="input-row" >
                                                                                                                <td width="100" style="border-left: 1px solid black;">
                                                                                                                    <textarea placeholder="Enter Keluhan" id="keluhan"  required="" rows="2" name="keluhan" class=" form-control"><?php echo $keluhan;?></textarea>
                                                                                                                </td>
                                                                                                                <td style="border-left: 1px solid black;">
                                                                                                                    <?php echo $pemeriksaan_fisik;?>
                                                                                                                </td>
                                                                                                                <td width="170" style="border-left: 1px solid black;">
                                                                                                                    <div id="ctrl-catatan_medis" class="">
                                                                                                                        <textarea placeholder="Enter Catatan Medis" id="mytxtarea"  required="" rows="3" name="catatan_medis" class=" form-control"></textarea>
                                                                                                                        <!--<div class="invalid-feedback animated bounceIn text-center">Please enter text</div>-->
                                                                                                                    </div>
                                                                                                                </td>
                                                                                                                <td style="border-left: 1px solid black;">
                                                                                                                    <div id="ctrl-tindakanr" class="">
                                                                                                                        <select required="" data-endpoint="<?php print_link('api/json/data_tindakan_tindakan_option_list') ?>" id="ctrl-tindakan" name="tindakan[]"  placeholder="Select a value ..." multiple   class="selectize-ajax" >
                                                                                                                            <option value="">Select a value ...</option>
                                                                                                                        </select>
                                                                                                                    </div>
                                                                                                                </td>
                                                                                                                <td style="border-left: 1px solid black;">
                                                                                                                    <select required="" data-endpoint="<?php print_link('api/json/data_rekam_medis_diagnosa_option_list') ?>" id="ctrl-diagnosa" name="diagnosa"  placeholder="Select a value ..."    class="selectize-ajax" >
                                                                                                                        <option value="">Select a value ...</option>
                                                                                                                    </select> 
                                                                                                                </td>                                                   
                                                                                                                <td class="text-center" style="border-left: 1px solid black;">
                                                                                                                    <div class="form-group form-submit-btn-holder text-center mt-3">
                                                                                                                        <div class="form-ajax-status"></div>
                                                                                                                        <button class="btn btn-primary" type="button" onclick="cekformadd()">
                                                                                                                            Submit
                                                                                                                            <i class="fa fa-send"></i>
                                                                                                                        </button>
                                                                                                                    </div>
                                                                                                                </form>
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                    </tbody>
                                                                                                </table>
                                                                                            </div>  
                                                                                            <?php }
                                                                                            }else{
                                                                                            if($setatus=="Closed"){
                                                                                            if($idapp=="0"){
                                                                                            if(!empty($_GET['cari_pasien_tanggal'])){}else{
                                                                                            ?>
                                                                                            <style>
                                                                                                /* Style the tab */
                                                                                                .tab {
                                                                                                overflow: hidden;
                                                                                                /* border: 1px solid #ccf;*/
                                                                                                background-color: #f1f1f1;
                                                                                                }
                                                                                                /* Style the buttons inside the tab */
                                                                                                .tab button {
                                                                                                background-color: inherit;
                                                                                                float: left;
                                                                                                border: none;
                                                                                                outline: none;
                                                                                                cursor: pointer;
                                                                                                padding: 8px 10px;
                                                                                                transition: 0.3s;
                                                                                                font-size: 14px;
                                                                                                }
                                                                                                /* Change background color of buttons on hover */
                                                                                                .tab button:hover {
                                                                                                background-color: #ddd;
                                                                                                }
                                                                                                /* Create an active/current tablink class */
                                                                                                .tab button.active {
                                                                                                background-color: #ccc;
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
                                                                                            <div align="left" style="font-size: 14px;"><b>Jadwal Kontrol Dan Rujukan Pasien</b></div>                
                                                                                            <div class="tab">
                                                                                                <button class="tablinks" onclick="openResep(event, 'jadwal')" id="jadwalkontrol">Jadwal Kontrol</button>
                                                                                                <button class="tablinks" onclick="openResep(event, 'poli')" id="rujukpoli">Rujuk Ke POLI Lain</button>                        
                                                                                                <button class="tablinks" onclick="openResep(event, 'igd')" id="rujukigd">Rujuk Ke IGD</button>
                                                                                            </div>
                                                                                            <div id="jadwal" class="tabcontent">
                                                                                                <div align="left" style="font-size: 14px;"><b>Jadwal Kontrol</b></div>
                                                                                                <form id="jadwalkontrolform" role="form" novalidate enctype="multipart/form-data" class="form page-form form-horizontal needs-validation" action="<?php print_link("appointment/add?csrf_token=$csrf_token") ?>" method="post">    
                                                                                                    <input type="hidden" name="kontrol" value="kontrol"><input type="hidden" name="backlink" value="<?php echo $backlink;?>"> 
                                                                                                        <input type="hidden" name="idpass" value="<?php echo $original_plaintext;?>">
                                                                                                            <input type="hidden" name="iddt" value="<?php echo $datid;?>">
                                                                                                                <table class="table  table-sm text-left" width="100%" style="border: 1px solid black;">
                                                                                                                    <thead class="table-header bg-success">
                                                                                                                        <tr >
                                                                                                                            <th style="border-left: 1px solid black;">
                                                                                                                                Tanggal
                                                                                                                            </th> 
                                                                                                                            <th style="border-left: 1px solid black;">
                                                                                                                                Poli
                                                                                                                            </th>                                        
                                                                                                                            <th style="border-left: 1px solid black;">
                                                                                                                                Dokter
                                                                                                                            </th>
                                                                                                                            <th> </th>
                                                                                                                        </tr>
                                                                                                                    </thead> 
                                                                                                                    <tr >
                                                                                                                        <td style="border-left: 1px solid black;"><div class="input-group" >
                                                                                                                            <input id="ctrl-tanggal_appointment" class="form-control datepicker  datepicker"  required="" value="<?php  echo $this->set_field_value('tanggal_appointment',""); ?>" type="datetime" name="tanggal_appointment" placeholder="Pilih Tanggal" data-enable-time="false" data-min-date="<?php echo date('Y-m-d', strtotime('+1day')); ?>" data-max-date="" data-date-format="Y-m-d" data-alt-format="F j, Y" data-inline="false" data-no-calendar="false" data-mode="single" />
                                                                                                                                <div class="input-group-append">
                                                                                                                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                                                                                                </div>                                        
                                                                                                                            </div>       </td>
                                                                                                                            <td style="border-left: 1px solid black;">
                                                                                                                                <?php echo $nampoli;?>      
                                                                                                                                <input type="hidden" name="nama_poli" value="<?php echo $nama_poli;?>">
                                                                                                                                </td>
                                                                                                                                <td style="border-left: 1px solid black;">
                                                                                                                                    <?php echo $namadokter;?>      
                                                                                                                                    <input type="hidden"  name="dokter" value="<?php echo $dokter;?>">
                                                                                                                                    </td>
                                                                                                                                    <td style="border-left: 1px solid black;">
                                                                                                                                        <button class="btn btn-primary" type="button" onclick="formaddcontrol()">
                                                                                                                                            Simpan
                                                                                                                                            <i class="fa fa-send"></i>
                                                                                                                                        </button>                                       
                                                                                                                                    </td>
                                                                                                                                </tr>
                                                                                                                            </table></form>
                                                                                                                            <script>
                                                                                                                                function formaddcontrol(){ 
                                                                                                                                var tgl= $('#ctrl-tanggal_appointment').val();
                                                                                                                                if(tgl==""){
                                                                                                                                document.getElementById("ctrl-tanggal_appointment").focus();
                                                                                                                                alert('Silahkan Isi Tanggal');
                                                                                                                                return false;
                                                                                                                                }
                                                                                                                                var result = confirm("Apakah Semua Data Sudah Benar?");
                                                                                                                                if (result == true) {
                                                                                                                                //document.getElementById('autobtn').click();
                                                                                                                                document.getElementById("jadwalkontrolform").submit();
                                                                                                                                return true;
                                                                                                                                }
                                                                                                                                else {
                                                                                                                                return false;
                                                                                                                                }   
                                                                                                                                }
                                                                                                                            </script>                                
                                                                                                                        </div>    
                                                                                                                        <div id="poli" class="tabcontent">
                                                                                                                            <div align="left" style="font-size: 14px;"><b>Rujuk Ke POLI Lain</b></div>        
                                                                                                                            <form id="formrujukpoli" role="form" novalidate enctype="multipart/form-data" class="form page-form form-horizontal needs-validation" action="<?php print_link("appointment/add?csrf_token=$csrf_token") ?>" method="post">    
                                                                                                                                <input type="hidden" name="rujukpoli" value="rujukpili"><input type="hidden" name="backlink" value="<?php echo $backlink;?>"> 
                                                                                                                                    <input type="hidden" name="idpass" value="<?php echo $original_plaintext;?>">
                                                                                                                                        <input type="hidden" name="iddt" value="<?php echo $datid;?>">
                                                                                                                                            <table class="table  table-sm text-left" width="100%" style="border: 1px solid black;">
                                                                                                                                                <thead class="table-header bg-success">
                                                                                                                                                    <tr >
                                                                                                                                                        <th style="border-left: 1px solid black;">
                                                                                                                                                            Tanggal
                                                                                                                                                        </th> 
                                                                                                                                                        <th style="border-left: 1px solid black;">
                                                                                                                                                            Poli
                                                                                                                                                        </th>                                        
                                                                                                                                                        <th style="border-left: 1px solid black;">
                                                                                                                                                            Dokter
                                                                                                                                                        </th>
                                                                                                                                                        <th style="border-left: 1px solid black;">
                                                                                                                                                            Keterangan Rujukan
                                                                                                                                                        </th>                                        
                                                                                                                                                        <th> </th>
                                                                                                                                                    </tr>
                                                                                                                                                </thead> 
                                                                                                                                                <tr >
                                                                                                                                                    <td style="border-left: 1px solid black;">
                                                                                                                                                        <div class="col-sm-8">
                                                                                                                                                            <div class="input-group">
                                                                                                                                                                <input id="ctrl-tanggal" class="form-control datepicker  datepicker"  required="" value="<?php  echo $this->set_field_value('tanggal',date_now()); ?>" type="datetime" name="tanggal" placeholder="Enter Tanggal" data-enable-time="false" data-min-date="" data-max-date="" data-date-format="Y-m-d" data-alt-format="F j, Y" data-inline="false" data-no-calendar="false" data-mode="single" />
                                                                                                                                                                    <div class="input-group-append">
                                                                                                                                                                        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                                                                                                                                    </div>
                                                                                                                                                                </div>
                                                                                                                                                            </div>                                    
                                                                                                                                                        </td>
                                                                                                                                                        <td style="border-left: 1px solid black;">
                                                                                                                                                            <select required=""  id="ctrl-nama_poli" data-load-select-options="dokter" name="nama_poli"  placeholder="Select a value ..."    class="custom-select" >
                                                                                                                                                                <option value="">Select a value ...</option>
                                                                                                                                                                <?php 
                                                                                                                                                                $nama_poli_options = $comp_model -> appointment_nama_poli_option_list();
                                                                                                                                                                if(!empty($nama_poli_options)){
                                                                                                                                                                foreach($nama_poli_options as $option){
                                                                                                                                                                $value = (!empty($option['value']) ? $option['value'] : null);
                                                                                                                                                                $label = (!empty($option['label']) ? $option['label'] : $value);
                                                                                                                                                                $selected = $this->set_field_selected('nama_poli',$value, "");
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
                                                                                                                                                        <td style="border-left: 1px solid black;">
                                                                                                                                                            <select required=""  id="ctrl-dokter" data-load-path="<?php print_link('api/json/appointment_dokter_option_list') ?>" name="dokter"  placeholder="Select a value ..."    class="custom-select" >
                                                                                                                                                                <option value="">Select a value ...</option>
                                                                                                                                                            </select>                                        
                                                                                                                                                        </td>
                                                                                                                                                        <td width="200" style="border-left: 1px solid black;">
                                                                                                                                                            <div id="ctrl-keterangan_rujukan" class="">
                                                                                                                                                                <textarea placeholder="Enter Keterangan" id="ketrujukpoli"  required="" rows="3" name="keterangan_rujukan" class=" form-control"></textarea>
                                                                                                                                                                <!--<div class="invalid-feedback animated bounceIn text-center">Please enter text</div>-->
                                                                                                                                                            </div>
                                                                                                                                                        </td>                                    
                                                                                                                                                        <td style="border-left: 1px solid black;">
                                                                                                                                                            <button class="btn btn-primary" type="button" onclick="formaddrujukpoli()">
                                                                                                                                                                Simpan
                                                                                                                                                                <i class="fa fa-send"></i>
                                                                                                                                                            </button>                                       
                                                                                                                                                        </td>
                                                                                                                                                    </tr>
                                                                                                                                                </table></form>
                                                                                                                                                <script>
                                                                                                                                                    $('#ctrl-nama_poli').on('change', function(){ 
                                                                                                                                                    var dpol = document.getElementById("ctrl-nama_poli").value;
                                                                                                                                                    var ctrlVal = $(this).val();
                                                                                                                                                    if(dpol==<?php echo $nama_poli;?>){
                                                                                                                                                    alert('Tidak Boleh Pilih Poli Yang Sama!!');
                                                                                                                                                    $(this).val('');
                                                                                                                                                    }
                                                                                                                                                    });                               
                                                                                                                                                    function formaddrujukpoli(){ 
                                                                                                                                                    var tgl= $('#ctrl-tanggal').val();
                                                                                                                                                    //  var cat=  document.getElementById("ctrl-catatan_medis").value;
                                                                                                                                                    var pol= $('#ctrl-nama_poli').val();
                                                                                                                                                    var dok= $('#ctrl-dokter').val();
                                                                                                                                                    var ket= $('#ketrujukpoli').val();
                                                                                                                                                    if(tgl==""){
                                                                                                                                                    document.getElementById("ctrl-tanggal").focus();
                                                                                                                                                    alert('Silahkan Isi Tanggal');
                                                                                                                                                    return false;
                                                                                                                                                    }
                                                                                                                                                    if(pol==""){
                                                                                                                                                    document.getElementById("ctrl-nama_poli").focus();
                                                                                                                                                    alert('Silahkan Pilih Poli');
                                                                                                                                                    return false;
                                                                                                                                                    }
                                                                                                                                                    if(dok==""){
                                                                                                                                                    document.getElementById("ctrl-dokter").focus();
                                                                                                                                                    alert('Silahkan Pilih Dokter');
                                                                                                                                                    return false;
                                                                                                                                                    }
                                                                                                                                                    if(ket==""){
                                                                                                                                                    document.getElementById("ketrujukpoli").focus();
                                                                                                                                                    alert('Silahkan isi Keterangan Rujukan');
                                                                                                                                                    return false;
                                                                                                                                                    }
                                                                                                                                                    var result = confirm("Apakah Semua Data Sudah Benar?");
                                                                                                                                                    if (result == true) {
                                                                                                                                                    //document.getElementById('autobtn').click();
                                                                                                                                                    document.getElementById("formrujukpoli").submit();
                                                                                                                                                    return true;
                                                                                                                                                    }
                                                                                                                                                    else {
                                                                                                                                                    return false;
                                                                                                                                                    }   
                                                                                                                                                    }
                                                                                                                                                </script> 
                                                                                                                                            </div>   
                                                                                                                                            <div id="igd" class="tabcontent">
                                                                                                                                                <div align="left" style="font-size: 14px;"><b>Rujuk Ke IGD</b></div>
                                                                                                                                                <form id="formrujukigd" role="form" novalidate enctype="multipart/form-data" class="form page-form form-horizontal needs-validation" action="<?php print_link("appointment/add?csrf_token=$csrf_token") ?>" method="post">    
                                                                                                                                                    <input type="hidden" name="rujukigd" value="rujukigd"><input type="hidden" name="backlink" value="<?php echo $backlink;?>"> 
                                                                                                                                                        <input type="hidden" name="idpass" value="<?php echo $original_plaintext;?>">
                                                                                                                                                            <input type="hidden" name="iddt" value="<?php echo $datid;?>">
                                                                                                                                                                <table class="table  table-sm text-left" width="100%" style="border: 1px solid black;">
                                                                                                                                                                    <thead class="table-header bg-success">
                                                                                                                                                                        <tr >
                                                                                                                                                                            <th style="border-left: 1px solid black;">
                                                                                                                                                                                Tanggal
                                                                                                                                                                            </th> 
                                                                                                                                                                            <th style="border-left: 1px solid black;">
                                                                                                                                                                                Keterangan Rujukan
                                                                                                                                                                            </th>                                        
                                                                                                                                                                            <th> </th>
                                                                                                                                                                        </tr>
                                                                                                                                                                    </thead> 
                                                                                                                                                                    <tr >
                                                                                                                                                                        <td style="border-left: 1px solid black;">
                                                                                                                                                                            <?php echo $sekarang;?>
                                                                                                                                                                            <input type="hidden" name="tanggal" value="<?php echo $sekarang;?>">
                                                                                                                                                                            </td>
                                                                                                                                                                            <td width="200" style="border-left: 1px solid black;">
                                                                                                                                                                                <div id="ctrl-keterangan_rujukan" class="">
                                                                                                                                                                                    <textarea placeholder="Enter Keterangan" id="ketrujukigd"  required="" rows="3" name="keterangan_rujukan" class=" form-control"></textarea>
                                                                                                                                                                                    <!--<div class="invalid-feedback animated bounceIn text-center">Please enter text</div>-->
                                                                                                                                                                                </div>
                                                                                                                                                                            </td>                                    
                                                                                                                                                                            <td style="border-left: 1px solid black;">
                                                                                                                                                                                <button class="btn btn-primary" type="button" onclick="formaddrujukigd()">
                                                                                                                                                                                    Simpan
                                                                                                                                                                                    <i class="fa fa-send"></i>
                                                                                                                                                                                </button>                                       
                                                                                                                                                                            </td>
                                                                                                                                                                        </tr>
                                                                                                                                                                    </table></form>
                                                                                                                                                                    <script>
                                                                                                                                                                        function formaddrujukigd(){ 
                                                                                                                                                                        var tgl= $('#ctrl-tanggal').val();
                                                                                                                                                                        var ket= $('#ketrujukigd').val();
                                                                                                                                                                        if(tgl==""){
                                                                                                                                                                        document.getElementById("ctrl-tanggal").focus();
                                                                                                                                                                        alert('Silahkan Isi Tanggal');
                                                                                                                                                                        return false;
                                                                                                                                                                        }
                                                                                                                                                                        if(ket==""){
                                                                                                                                                                        document.getElementById("ketrujukigd").focus();
                                                                                                                                                                        alert('Silahkan isi Keterangan Rujukan');
                                                                                                                                                                        return false;
                                                                                                                                                                        }
                                                                                                                                                                        var result = confirm("Apakah Semua Data Sudah Benar?");
                                                                                                                                                                        if (result == true) {
                                                                                                                                                                        //document.getElementById('autobtn').click();
                                                                                                                                                                        document.getElementById("formrujukigd").submit();
                                                                                                                                                                        return true;
                                                                                                                                                                        }
                                                                                                                                                                        else {
                                                                                                                                                                        return false;
                                                                                                                                                                        }   
                                                                                                                                                                        }
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
                                                                                                                                                                    document.getElementById("jadwalkontrol").click();
                                                                                                                                                                </script>
                                                                                                                                                                <?php  
                                                                                                                                                                }
                                                                                                                                                                }else{
                                                                                                                                                                if($ketrujuk==""){
                                                                                                                                                                ///////////////////////////////kontrolinfo///////////////
                                                                                                                                                                // echo "tes $setatus";
                                                                                                                                                                $queryp = mysqli_query($koneksi, "select * from appointment WHERE id_appointment='$idapp'")
                                                                                                                                                                or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                                                                                                                                                                $rowsp = mysqli_num_rows($queryp);
                                                                                                                                                                if ($rowsp <> 0) {
                                                                                                                                                                $datap = mysqli_fetch_assoc($queryp);
                                                                                                                                                                $tglap=$datap['tanggal_appointment'];
                                                                                                                                                                $idpoli=$datap['nama_poli'];
                                                                                                                                                                $iddok=$datap['dokter'];
                                                                                                                                                                $queryp1 = mysqli_query($koneksi, "select * from data_poli WHERE id_poli='$idpoli'")
                                                                                                                                                                or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                                                                                                                                                                $rowsp1 = mysqli_num_rows($queryp1);
                                                                                                                                                                if ($rowsp1 <> 0) {
                                                                                                                                                                $datap1 = mysqli_fetch_assoc($queryp1);
                                                                                                                                                                $nampoli=$datap1['nama_poli'];
                                                                                                                                                                }
                                                                                                                                                                $queryp2 = mysqli_query($koneksi, "select * from data_dokter WHERE id_dokter='$iddok'")
                                                                                                                                                                or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                                                                                                                                                                $rowsp2 = mysqli_num_rows($queryp2);
                                                                                                                                                                if ($rowsp2 <> 0) {
                                                                                                                                                                $datap2 = mysqli_fetch_assoc($queryp2);
                                                                                                                                                                $namdokter=$datap2['nama_dokter'];
                                                                                                                                                                }                        
                                                                                                                                                                ?>
                                                                                                                                                                <div align="left" style="font-size: 14px;">Jadwal Kontrol Ulang</div>
                                                                                                                                                                <table class="table  table-sm text-left"><thead class="table-header bg-success" style="border: 1px solid black;">
                                                                                                                                                                    <tr style="border: 1px solid black;">
                                                                                                                                                                        <th style="border-left: 1px solid black;">
                                                                                                                                                                            Tanggal Kontrol
                                                                                                                                                                        </th>
                                                                                                                                                                        <th style="border-left: 1px solid black;">
                                                                                                                                                                            Poli
                                                                                                                                                                        </th>
                                                                                                                                                                        <th style="border-left: 1px solid black;">
                                                                                                                                                                            Dokter
                                                                                                                                                                        </th>
                                                                                                                                                                    </tr></thead>
                                                                                                                                                                    <tr style="border: 1px solid black;">
                                                                                                                                                                        <td style="border-left: 1px solid black;">
                                                                                                                                                                            <?php echo $tglap;?>
                                                                                                                                                                        </td>
                                                                                                                                                                        <td style="border-left: 1px solid black;">
                                                                                                                                                                            <?php echo $nampoli;?>
                                                                                                                                                                        </td>
                                                                                                                                                                        <td style="border-left: 1px solid black;">
                                                                                                                                                                            <?php echo $namdokter;?>
                                                                                                                                                                        </td>
                                                                                                                                                                    </tr>    
                                                                                                                                                                </table>
                                                                                                                                                                <?php   }   
                                                                                                                                                                }else{
                                                                                                                                                                $qupol = mysqli_query($koneksi, "select * from pendaftaran_poli WHERE id_pendaftaran_poli='$idapp'")
                                                                                                                                                                or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                                                                                                                                                                $rospol = mysqli_num_rows($qupol);
                                                                                                                                                                if ($rospol <> 0) {  
                                                                                                                                                                $datap = mysqli_fetch_assoc($qupol);
                                                                                                                                                                $tglap=$datap['tanggal'];
                                                                                                                                                                $idpoli=$datap['nama_poli'];
                                                                                                                                                                $iddok=$datap['dokter'];
                                                                                                                                                                $queryp1 = mysqli_query($koneksi, "select * from data_poli WHERE id_poli='$idpoli'")
                                                                                                                                                                or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                                                                                                                                                                $rowsp1 = mysqli_num_rows($queryp1);
                                                                                                                                                                if ($rowsp1 <> 0) {
                                                                                                                                                                $datap1 = mysqli_fetch_assoc($queryp1);
                                                                                                                                                                $nampoli=$datap1['nama_poli'];
                                                                                                                                                                }
                                                                                                                                                                $queryp2 = mysqli_query($koneksi, "select * from data_dokter WHERE id_dokter='$iddok'")
                                                                                                                                                                or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                                                                                                                                                                $rowsp2 = mysqli_num_rows($queryp2);
                                                                                                                                                                if ($rowsp2 <> 0) {
                                                                                                                                                                $datap2 = mysqli_fetch_assoc($queryp2);
                                                                                                                                                                $namdokter=$datap2['nama_dokter'];
                                                                                                                                                                } 
                                                                                                                                                                ?>
                                                                                                                                                                <div align="left" style="font-size: 14px;">Rujuk Poli</div>
                                                                                                                                                                <table class="table  table-sm text-left"><thead class="table-header bg-success" style="border: 1px solid black;">
                                                                                                                                                                    <tr style="border: 1px solid black;">
                                                                                                                                                                        <th style="border-left: 1px solid black;">
                                                                                                                                                                            Tanggal
                                                                                                                                                                        </th>
                                                                                                                                                                        <th style="border-left: 1px solid black;">
                                                                                                                                                                            Poli
                                                                                                                                                                        </th>
                                                                                                                                                                        <th style="border-left: 1px solid black;">
                                                                                                                                                                            Dokter
                                                                                                                                                                        </th>
                                                                                                                                                                        <th style="border-left: 1px solid black;">
                                                                                                                                                                            Keterangan Rujukan
                                                                                                                                                                        </th>                                                    
                                                                                                                                                                    </tr></thead>
                                                                                                                                                                    <tr style="border: 1px solid black;">
                                                                                                                                                                        <td style="border-left: 1px solid black;">
                                                                                                                                                                            <?php echo $tglap;?>
                                                                                                                                                                        </td>
                                                                                                                                                                        <td style="border-left: 1px solid black;">
                                                                                                                                                                            <?php echo $nampoli;?>
                                                                                                                                                                        </td>
                                                                                                                                                                        <td style="border-left: 1px solid black;">
                                                                                                                                                                            <?php echo $namdokter;?>
                                                                                                                                                                        </td>
                                                                                                                                                                        <td style="border-left: 1px solid black;">
                                                                                                                                                                            <?php echo $ketrujuk;?>
                                                                                                                                                                        </td>
                                                                                                                                                                    </tr>    
                                                                                                                                                                </table>                            
                                                                                                                                                                <?php
                                                                                                                                                                }
                                                                                                                                                                $quigd = mysqli_query($koneksi, "SELECT * FROM `igd` WHERE `id_igd`='$idapp'")
                                                                                                                                                                or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                                                                                                                                                                $rosigd = mysqli_num_rows($quigd);
                                                                                                                                                                if ($rosigd <> 0) {  
                                                                                                                                                                $daig = mysqli_fetch_assoc($quigd);
                                                                                                                                                                $tglig= DATE($daig['tanggal_masuk']);
                                                                                                                                                                ?>
                                                                                                                                                                <div align="left" style="font-size: 14px;">Rujuk IGD</div>
                                                                                                                                                                <table class="table  table-sm text-left"><thead class="table-header bg-success" style="border: 1px solid black;">
                                                                                                                                                                    <tr style="border: 1px solid black;">
                                                                                                                                                                        <th style="border-left: 1px solid black;">
                                                                                                                                                                            Tanggal
                                                                                                                                                                        </th>
                                                                                                                                                                        <th style="border-left: 1px solid black;">
                                                                                                                                                                            Keterangan Rujukan
                                                                                                                                                                        </th>                                                    
                                                                                                                                                                    </tr></thead>
                                                                                                                                                                    <tr style="border: 1px solid black;">
                                                                                                                                                                        <td style="border-left: 1px solid black;">
                                                                                                                                                                            <?php echo $tglig;?>
                                                                                                                                                                        </td>
                                                                                                                                                                        <td style="border-left: 1px solid black;">
                                                                                                                                                                            <?php echo $ketrujuk;?>
                                                                                                                                                                        </td>
                                                                                                                                                                    </tr>    
                                                                                                                                                                </table>                            
                                                                                                                                                                <?php
                                                                                                                                                                } 
                                                                                                                                                                }
                                                                                                                                                                /////////////////////////////////////////////
                                                                                                                                                                }
                                                                                                                                                                ///////////////////////////////////////////////////////////////////////////////////////
                                                                                                                                                                }else{
                                                                                                                                                                ?>
                                                                                                                                                                <table class="table  table-sm text-left" width="100%" style="border: 1px solid black;">
                                                                                                                                                                    <thead class="table-header bg-success"
                                                                                                                                                                        <tr >
                                                                                                                                                                        <th style="border-left: 1px solid black;"><label for="tanggal" width="100">Keluhan</label></th>
                                                                                                                                                                        <th style="border-left: 1px solid black;"><label for="tanggal">Pemeriksaan Fisik</label></th>
                                                                                                                                                                        <th style="border-left: 1px solid black;"><label for="catatan_medis" width="130">Catatan Medis</label></th>
                                                                                                                                                                        <th style="border-left: 1px solid black;"><label for="tindakan">Tindakan</label></th>
                                                                                                                                                                        <th style="border-left: 1px solid black;"><label for="tindakan">Diagnosa</label></th>
                                                                                                                                                                        <th style="border-left: 1px solid black;">Resep Obat</th>
                                                                                                                                                                        <th style="border-left: 1px solid black;">Lab</th>
                                                                                                                                                                        <th style="border-left: 1px solid black;">Pemeriksaan Tambahan/upload</th>
                                                                                                                                                                        <th style="border-left: 1px solid black;">Keterangan Tambahan/upload</th>
                                                                                                                                                                    </tr>
                                                                                                                                                                </thead>
                                                                                                                                                                <tr >
                                                                                                                                                                    <td style="border-left: 1px solid black;">
                                                                                                                                                                        <?php echo $keluhan;?>
                                                                                                                                                                    </td>             
                                                                                                                                                                    <td style="border-left: 1px solid black;">
                                                                                                                                                                        <?php echo $pemeriksaan_fisik?>
                                                                                                                                                                    </td>
                                                                                                                                                                    <td width="130" style="border-left: 1px solid black;">
                                                                                                                                                                        <?php echo $catatan_medis;?>                
                                                                                                                                                                    </td>
                                                                                                                                                                    <td style="border-left: 1px solid black;">
                                                                                                                                                                        <?php echo $tindakancek;?>                
                                                                                                                                                                    </td>
                                                                                                                                                                    <td style="border-left: 1px solid black;">  
                                                                                                                                                                        <?php
                                                                                                                                                                        if($diagnosacek==""){
                                                                                                                                                                        ?>
                                                                                                                                                                        <a style="margin-top:2px;" class="btn btn-sm btn-primary has-tooltip page-modal"  href="<?php  print_link("data_rekam_medis/diagnosa/$datid");?>">
                                                                                                                                                                        <i class="fa plus"></i> Add Diagnosa</a> 
                                                                                                                                                                        <?php
                                                                                                                                                                        }else{
                                                                                                                                                                        $qudtpa = mysqli_query($koneksi, "SELECT * from diagnosa WHERE id='$diagnosacek'")
                                                                                                                                                                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                                                                                                                                                                        $rodtpa = mysqli_num_rows($qudtpa);
                                                                                                                                                                        if ($rodtpa <> 0) {
                                                                                                                                                                        $cdt= mysqli_fetch_assoc($qudtpa);
                                                                                                                                                                        $descr=$cdt['description'];
                                                                                                                                                                        echo $descr;
                                                                                                                                                                        }else{
                                                                                                                                                                        echo $drm['diagnosa'];
                                                                                                                                                                        }
                                                                                                                                                                        }
                                                                                                                                                                        ?>
                                                                                                                                                                    </td> 
                                                                                                                                                                    <td style="border-left: 1px solid black;">
                                                                                                                                                                        <?php
                                                                                                                                                                        if($resepcek==""){?>
                                                                                                                                                                        <a style="margin-top:2px;" class="btn btn-sm btn-primary has-tooltip"  href="<?php  print_link("rekam_medis/resep?precord=$backlink");?>">
                                                                                                                                                                        <i class="fa plus"></i> Add Resep Obat</a> 
                                                                                                                                                                        <?php }else{ echo $resepcek; }?>
                                                                                                                                                                    </td>
                                                                                                                                                                    <td style="border-left: 1px solid black;">
                                                                                                                                                                        <?php
                                                                                                                                                                        $queryl = mysqli_query($koneksi, "SELECT * from pendaftaran_lab WHERE id_daftar='$original_plaintext' and no_rekam_medis='$datnorm'")
                                                                                                                                                                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                                                                                                                                                                        // ambil jumlah baris data hasil query
                                                                                                                                                                        $rowsl = mysqli_num_rows($queryl);
                                                                                                                                                                        if ($rowsl <> 0) {
                                                                                                                                                                        while ($datacekl=mysqli_fetch_array($queryl)){
                                                                                                                                                                        if($datacekl['setatus']=="Closed"){
                                                                                                                                                                        }else{
                                                                                                                                                                    echo"</br>Masih Proses";
                                                                                                                                                                    }
                                                                                                                                                                    }
                                                                                                                                                                    }else{
                                                                                                                                                                    $qupas = mysqli_query($koneksi, "SELECT * from data_pasien WHERE no_rekam_medis='$no_rekam_medis'")
                                                                                                                                                                    or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                                                                                                                                                                    $rodtpab = mysqli_num_rows($qupas);
                                                                                                                                                                    if ($rodtpab <> 0) {
                                                                                                                                                                    $cdt= mysqli_fetch_assoc($qupas);
                                                                                                                                                                    $ipas=$cdt['id_pasien'];
                                                                                                                                                                    }
                                                                                                                                                                    ?>
                                                                                                                                                                    <a style="margin-top:2px;" class="btn btn-sm btn-primary has-tooltip"  href="<?php  print_link("pendaftaran_lab/lab?precord=$backlink&datprecord=$ipas&pasien=POLI");?>">
                                                                                                                                                                    <i class="fa plus"></i> Add Lab</a> 
                                                                                                                                                                    <?php
                                                                                                                                                                    }
                                                                                                                                                                    ?>               
                                                                                                                                                                </td>
                                                                                                                                                                <td style="border-left: 1px solid black;">
                                                                                                                                                                    <a style="margin-top:2px;" class="btn btn-sm btn-primary has-tooltip page-modal"  href="<?php  print_link("data_rekam_medis/pemtambahan?precord=$datid");?>">
                                                                                                                                                                    <i class="fa plus"></i>Add Upload</a> 
                                                                                                                                                                    <?php
                                                                                                                                                                    if($namfile==""){}else{
                                                                                                                                                                    $nam = explode(',', $namfile);
                                                                                                                                                                    // echo count($nam);
                                                                                                                                                                    for($a = 0; $a < count($nam); $a++){
                                                                                                                                                                    // $nams=$nam[$a];
                                                                                                                                                                echo "</br>".$nam[$a]; 
                                                                                                                                                                }
                                                                                                                                                                }
                                                                                                                                                                // $tgld="".$tanggald[1]."-".$tanggald[0]."-".$tanggald[2];
                                                                                                                                                                ?>
                                                                                                                                                            </td>
                                                                                                                                                            <td style="border-left: 1px solid black;">
                                                                                                                                                                <a style="margin-top:2px;" class="btn btn-sm btn-primary has-tooltip page-modal"  href="<?php  print_link("data_rekam_medis/kettambahan?precord=$datid");?>">
                                                                                                                                                                <i class="fa plus"></i>Add Upload</a>  
                                                                                                                                                                <?php
                                                                                                                                                                if($namfileket==""){}else{
                                                                                                                                                                $namket = explode(',', $namfileket);
                                                                                                                                                                // echo count($nam);
                                                                                                                                                                for($a = 0; $a < count($namket); $a++){
                                                                                                                                                                // $nams=$nam[$a];
                                                                                                                                                            echo "</br>".$namket[$a]; 
                                                                                                                                                            }
                                                                                                                                                            }
                                                                                                                                                            ?>
                                                                                                                                                        </td>                                        
                                                                                                                                                    </tr>
                                                                                                                                                </table>
                                                                                                                                                <?php
                                                                                                                                                }
                                                                                                                                                }
                                                                                                                                                ///////////////////
                                                                                                                                                } 
                                                                                                                                                /////////////////////////////////////////////////////////////////////////////////////////////
                                                                                                                                                if(!empty($_GET['precord'])){
                                                                                                                                                ////////////////////////////////
                                                                                                                                                // if($tindakancek==""){}else{
                                                                                                                                                $sqlrujuk = mysqli_query($koneksi,"select * from data_rekam_medis WHERE idapp='$original_plaintext' and no_rekam_medis='$datnorm'");
                                                                                                                                                $roru = mysqli_num_rows($sqlrujuk);
                                                                                                                                                if ($roru <> 0) {
                                                                                                                                                $datr=mysqli_fetch_assoc($sqlrujuk);
                                                                                                                                                ?>
                                                                                                                                                <div align="left" style="font-size: 14px;">Pasiean Rujukan Dari Poli</div>
                                                                                                                                                <table class="table  table-sm text-left"><thead class="table-header bg-success" style="border: 1px solid black;">
                                                                                                                                                    <tr style="border: 1px solid black;">
                                                                                                                                                        <th style="border-left: 1px solid black;">
                                                                                                                                                            Poli
                                                                                                                                                        </th>
                                                                                                                                                        <th style="border-left: 1px solid black;">
                                                                                                                                                            Dokter
                                                                                                                                                        </th>
                                                                                                                                                        <th style="border-left: 1px solid black;">
                                                                                                                                                            Keterangan Rujukan
                                                                                                                                                        </th>                                                    
                                                                                                                                                    </tr></thead>
                                                                                                                                                    <tr style="border: 1px solid black;">
                                                                                                                                                        <td style="border-left: 1px solid black;">
                                                                                                                                                            <?php echo $datr['nama_poli'];?>
                                                                                                                                                        </td>
                                                                                                                                                        <td style="border-left: 1px solid black;">
                                                                                                                                                            <?php echo $datr['dokter_pemeriksa'];?>
                                                                                                                                                        </td>
                                                                                                                                                        <td style="border-left: 1px solid black;">
                                                                                                                                                            <?php echo $datr['keterangan_rujukan'];?>
                                                                                                                                                        </td>
                                                                                                                                                    </tr>    
                                                                                                                                                </table>                                       
                                                                                                                                                <?php
                                                                                                                                                }
                                                                                                                                                }
                                                                                                                                                /////////////////////////////////////
                                                                                                                                                ?>
                                                                                                                                                <div align="left" style="font-size: 14px;"><b>Riwayat Pasien</b></div>
                                                                                                                                                <div id="table-wrapper">
                                                                                                                                                    <div id="table-scroll"> 
                                                                                                                                                        <table class="table  table-sm text-left"  style="border: 1px solid black;">
                                                                                                                                                            <thead class="table-header bg-success">
                                                                                                                                                                <tr>
                                                                                                                                                                    <th  class="td-tanggal" style="border-left: 1px solid black;"> Tanggal</th>
                                                                                                                                                                    <th  class="td-nama_poli" style="border-left: 1px solid black;"> Nama Poli</th>
                                                                                                                                                                    <th  class="td-dokter_pemeriksa" style="border-left: 1px solid black;"> Dokter Pemeriksa</th>
                                                                                                                                                                    <th  class="td-keluhan" style="border-left: 1px solid black;"> Keluhan</th>
                                                                                                                                                                    <th  class="td-pemeriksaan_fisik" style="border-left: 1px solid black;">Pemeriksaan Fisik</th>
                                                                                                                                                                    <th  class="td-catatan_medis" width="150" style="border-left: 1px solid black;"> Catatan Medis</th>
                                                                                                                                                                    <th  class="td-tindakan" style="border-left: 1px solid black;"> Tindakan</th>
                                                                                                                                                                    <th  class="td-diagnosa" style="border-left: 1px solid black;"> Diagnosa</th>
                                                                                                                                                                    <th style="border-left: 1px solid black;">Resep Obat</th>
                                                                                                                                                                    <th style="border-left: 1px solid black;">Lab</th>
                                                                                                                                                                    <th style="border-left: 1px solid black;">Pemeriksaan Tambahan</th>
                                                                                                                                                                    <th style="border-left: 1px solid black;">Keterangan Tambahan</th> 
                                                                                                                                                                    <th style="border-left: 1px solid black;">Keterangan Rujukan</th> 
                                                                                                                                                                </tr>
                                                                                                                                                            </thead>
                                                                                                                                                            <tbody class="page-data" id="page-data-list-page-6rthbuykzo2a">
                                                                                                                                                                <!--record-->
                                                                                                                                                                <?php
                                                                                                                                                                $norm=trim($norm);
                                                                                                                                                                $sqlrm = mysqli_query($koneksi, "SELECT * FROM `data_rekam_medis` WHERE `no_rekam_medis`='$datnorm' ORDER BY `id` DESC")
                                                                                                                                                                or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                                                                                                                                                                $rorm = mysqli_num_rows($sqlrm);
                                                                                                                                                                if ($rorm<> 0) {
                                                                                                                                                                // $rodok= mysqli_fetch_assoc($qudtpa);
                                                                                                                                                                //$spesial= $rodok['dokter']; 
                                                                                                                                                                // $iddok=$cdt['id_dokter']; 
                                                                                                                                                                while ($drm = MySQLi_fetch_array($sqlrm)) {            
                                                                                                                                                                //$sqlrm = mysqli_query($koneksi,"SELECT * FROM `data_rekam_medis` WHERE `no_rekam_medis`='$norm' ORDER BY `id` DESC");
                                                                                                                                                                // while ($drm = MySQLi_fetch_array($sqlrm)) {
                                                                                                                                                                //  while ($dat = MySQLi_fetch_array($sqlrm)) { 
                                                                                                                                                                ?>
                                                                                                                                                                <tr>
                                                                                                                                                                    <td class="td-tanggal" style="border-left: 1px solid black;"> <?php echo $drm['tanggal'];?></td>
                                                                                                                                                                    <td class="td-nama_poli" style="border-left: 1px solid black;"> <?php echo $drm['nama_poli'];?></td>
                                                                                                                                                                    <td class="td-dokter_pemeriksa" style="border-left: 1px solid black;"><?php echo $drm['dokter_pemeriksa'];?> </td>
                                                                                                                                                                    <td class="td-keluhan" style="border-left: 1px solid black;"> <?php echo $drm['keluhan'];?></td>
                                                                                                                                                                    <td class="td-pemeriksaan_fisik" style="border-left: 1px solid black;"><span><?php echo $drm['pemeriksaan_fisik'];?></span></td> 
                                                                                                                                                                    <td class="td-catatan_medis" width="150" style="border-left: 1px solid black;"> <span><?php echo $drm['catatan_medis'];?></span></td>
                                                                                                                                                                    <td class="td-tindakan" style="border-left: 1px solid black;"> <span><?php echo $drm['tindakan'];?></span></td>
                                                                                                                                                                    <td class="td-diagnosa" style="border-left: 1px solid black;"> <span> <?php
                                                                                                                                                                        $qudtpa = mysqli_query($koneksi, "SELECT * from diagnosa WHERE id='".$drm['diagnosa']."'")
                                                                                                                                                                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                                                                                                                                                                        $rodtpa = mysqli_num_rows($qudtpa);
                                                                                                                                                                        if ($rodtpa <> 0) {
                                                                                                                                                                        $cdt= mysqli_fetch_assoc($qudtpa);
                                                                                                                                                                        $descr=$cdt['description'];
                                                                                                                                                                        echo $descr;
                                                                                                                                                                        }else{
                                                                                                                                                                        echo $drm['diagnosa'];
                                                                                                                                                                        }
                                                                                                                                                                    ?></span></td>
                                                                                                                                                                    <td class="td-resep_obat" width="150" style="border-left: 1px solid black;"> <span> <?php echo $drm['resep_obat'];?> </span></td>
                                                                                                                                                                    <td class="td-hasil_laboratorium_radiologi" style="border-left: 1px solid black;" width="50">
                                                                                                                                                                        <?php
                                                                                                                                                                        ///////////////////////////////////////////////////
                                                                                                                                                                        $iddaftar=$drm['id_daftar'];
                                                                                                                                                                        //echo $iddaftar;
                                                                                                                                                                        ?>
                                                                                                                                                                        <?php
                                                                                                                                                                        $cekdaf=0;
                                                                                                                                                                        $query = mysqli_query($koneksi, "SELECT * from pendaftaran_lab WHERE id_daftar='$iddaftar' and no_rekam_medis='$datnorm'")
                                                                                                                                                                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                                                                                                                                                                        // ambil jumlah baris data hasil query
                                                                                                                                                                        $rows = mysqli_num_rows($query);
                                                                                                                                                                        if ($rows <> 0) {
                                                                                                                                                                        while ($datacek=mysqli_fetch_array($query)){
                                                                                                                                                                        $nodaf=$cekdaf;
                                                                                                                                                                        if($nodaf=="0"){
                                                                                                                                                                        $labke="Lab";
                                                                                                                                                                        }else{
                                                                                                                                                                        $nodaf=$nodaf + 1; 
                                                                                                                                                                        $labke="Lab Ke $nodaf";
                                                                                                                                                                        } 
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
                                                                                                                                                                        <a style="margin-top:2px;margin-left:-5px;margin-right:-5px;" class="dropdown-item page-modal"  href="<?php  print_link("hasil_lab/hasil?csrf_token=$csrf_token&precord=$ciphertext");?>">
                                                                                                                                                                        <i class="fa fa-send"></i>Lihat <?php echo $labke;?></a> 
                                                                                                                                                                        <?php 
                                                                                                                                                                        }else{
                                                                                                                                                                        ?>
                                                                                                                                                                        <a style="margin-top:2px;margin-left:-5px;margin-right:-5px;" class="dropdown-item" href="#"> 
                                                                                                                                                                        <i class="fa fa-users"></i><?php echo $labke;?> Masih Proses</a> 
                                                                                                                                                                        <?php
                                                                                                                                                                    // echo "<i class=\"fa fa-users \"></i> Masih Proses $labke</a>";
                                                                                                                                                                    // $norekam=$data['no_rekam_medis'];
                                                                                                                                                                    }
                                                                                                                                                                    $cekdaf++;
                                                                                                                                                                    }
                                                                                                                                                                    }
                                                                                                                                                                    ?>
                                                                                                                                                                </td>
                                                                                                                                                                <td class="td-uploads" style="border-left: 1px solid black;"> <span> 
                                                                                                                                                                    <?php
                                                                                                                                                                    $datnamfile=$drm['nama_file'];
                                                                                                                                                                    $datpemtam=$drm['pemeriksaan_tambahan'];
                                                                                                                                                                    if($datnamfile==""){}else{
                                                                                                                                                                    $datnam = explode(',', $datnamfile);
                                                                                                                                                                    $datpem= explode(',', $datpemtam);
                                                                                                                                                                    for($b = 0; $b < count($datnam); $b++){
                                                                                                                                                                    $datnams=$datnam[$b];
                                                                                                                                                                    $datpems=$datpem[$b];
                                                                                                                                                                    ?>
                                                                                                                                                                    <a style="margin-top:2px;margin-left:-5px;margin-right:-5px;" class="dropdown-item page-modal" href="<?php  print_link("data_rekam_medis/datfile?datfile=$datpems&dari=Pemtem");?>"><i class="fa fa-eye"></i><?php echo $datnams;?></a> 
                                                                                                                                                                    <?php
                                                                                                                                                                    }
                                                                                                                                                                    }
                                                                                                                                                                    ?>
                                                                                                                                                                </span></td>   
                                                                                                                                                                <td class="td-uploads" style="border-left: 1px solid black;"> <span> 
                                                                                                                                                                    <?php
                                                                                                                                                                    $datnamfileket=$drm['nama_file_ket'];
                                                                                                                                                                    $datkettam=$drm['keterangan_tambahan'];
                                                                                                                                                                    if($datnamfileket==""){}else{
                                                                                                                                                                    $datnamket = explode(',', $datnamfileket);
                                                                                                                                                                    $datket= explode(',', $datkettam);
                                                                                                                                                                    for($b = 0; $b < count($datnamket); $b++){
                                                                                                                                                                    $datnamkets=$datnamket[$b];
                                                                                                                                                                    $datkets=$datket[$b];
                                                                                                                                                                    ?>
                                                                                                                                                                    <a style="margin-top:2px;margin-left:-5px;margin-right:-5px;" class="dropdown-item page-modal" href="<?php  print_link("data_rekam_medis/datfile?datfile=$datkets&dari=Kettem");?>"><i class="fa fa-eye"></i><?php echo $datnamkets;?></a> 
                                                                                                                                                                    <?php
                                                                                                                                                                    }
                                                                                                                                                                    }
                                                                                                                                                                    ?>
                                                                                                                                                                </span></td> 
                                                                                                                                                                <td>
                                                                                                                                                                    <span><?php echo $drm['keterangan_rujukan'];?></span> 
                                                                                                                                                                </td>
                                                                                                                                                            </tr>
                                                                                                                                                            <?php
                                                                                                                                                            }
                                                                                                                                                            }
                                                                                                                                                            ?>
                                                                                                                                                            <!--endrecord-->
                                                                                                                                                        </tbody>
                                                                                                                                                        <tbody class="search-data" id="search-data-list-page-6rthbuykzo2a"></tbody>
                                                                                                                                                    </table>  
                                                                                                                                                </div> </div>
                                                                                                                                                <?php 
                                                                                                                                                /////////////////////////////////////////////////////////////////////////////////////////////////////
                                                                                                                                                }?>
                                                                                                                                            </td>
                                                                                                                                        </tr>
                                                                                                                                    </table>
                                                                                                                                </div>
                                                                                                                            </div>
                                                                                                                        </div> </div> </div>            
                                                                                                                        <script type="text/javascript">
                                                                                                                            window.onload = function() { jam(); }
                                                                                                                            function jam() {
                                                                                                                            var e = document.getElementById('jam'),
                                                                                                                            d = new Date(), h, m, s;
                                                                                                                            h = d.getHours();
                                                                                                                            m = set(d.getMinutes());
                                                                                                                            s = set(d.getSeconds());
                                                                                                                            e.innerHTML = h +':'+ m +':'+ s;
                                                                                                                            setTimeout('jam()', 1000);
                                                                                                                            }
                                                                                                                            function set(e) {
                                                                                                                            e = e < 10 ? '0'+ e : e;
                                                                                                                            return e;
                                                                                                                            }
                                                                                                                        </script>
                                                                                                                        <script>
                                                                                                                            function cekformadd(){ 
                                                                                                                            var cat= $('#mytxtarea').val();
                                                                                                                            // var cat=  document.getElementById("ctrl-catatan_medis").value;
                                                                                                                            var tin= $('#ctrl-tindakan').val();
                                                                                                                            var dig= $('#ctrl-diagnosa').val();
                                                                                                                            if(cat==""){
                                                                                                                            document.getElementById("mytxtarea").focus();
                                                                                                                            alert('Silahkan Isi Catatan Medis');
                                                                                                                            return false;
                                                                                                                            }
                                                                                                                            if(tin==""){
                                                                                                                            document.getElementById("ctrl-tindakan").focus();
                                                                                                                            alert('Silahkan Isi Tindakan');
                                                                                                                            return false;
                                                                                                                            }
                                                                                                                            if(dig==""){
                                                                                                                            document.getElementById("ctrl-diagnosa").focus();
                                                                                                                            alert('Silahkan Isi Diagnosa');
                                                                                                                            return false;
                                                                                                                            }
                                                                                                                            var result = confirm("Apakah Semua Data Sudah Benar?");
                                                                                                                            if (result == true) {
                                                                                                                            //document.getElementById('autobtn').click();
                                                                                                                            document.getElementById("data_rekam_medis-datarm-form").submit();
                                                                                                                            return true;
                                                                                                                            }
                                                                                                                            else {
                                                                                                                            return false;
                                                                                                                            }   
                                                                                                                            }
                                                                                                                        </script>
                                                                                                                    </div>
                                                                                                                    <div class=" ">
                                                                                                                        <?php  
                                                                                                                        $this->render_page("rm_lama/rmlama/rm_lama.no_rekam_medis/$_GET[datrm]?limit_count=20"); 
                                                                                                                        ?>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </section>
