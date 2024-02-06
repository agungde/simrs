<?php 
//check if current user role is allowed access to the pages
$can_add = ACL::is_allowed("transaksi/add");
$can_edit = ACL::is_allowed("transaksi/edit");
$can_view = ACL::is_allowed("transaksi/view");
$can_delete = ACL::is_allowed("transaksi/delete");
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
    <div  class="">
        <div class="container-fluid">
            <div class="row ">
                <div class="col-md-12 comp-grid">
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
                        $queryb = mysqli_query($koneksi, "select * from transaksi WHERE id='$original_plaintext'")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                        // ambil jumlah baris data hasil query
                        $rowsb = mysqli_num_rows($queryb);
                        if ($rowsb <> 0) {
                        $row   = mysqli_fetch_assoc($queryb); 
                        $datid=$row['id'];
                        $tanggal=$row['tanggal'];
                        $no_rekam_medis=$row['no_rekam_medis'];
                        $nama_pasien=$row['nama_pasien'];
                        $alamat=$row['alamat'];
                        $deposit=$row['deposit'];
                        $pembayaran=$row['pembayaran'];
                        $setatus_bpjs=$row['setatus_bpjs'];
                        $total_tagihan=$row['total_tagihan'];
                        $sisa_tagihan=$row['sisa_tagihan'];
                        $bayar=$row['bayar'];
                        $kembalian=$row['kembalian'];
                        if($sisa_tagihan=="" or $sisa_tagihan=="0"){
                        $sisa_tagihan=$total_tagihan;
                        }
                        //$keterangan_tindakan=$row['keterangan_tindakan'];
                        //$keterangan_resep=$row['keterangan_resep'];
                        $pasien=$row['pasien'];
                        $setatus_tagihan=$row['setatus_tagihan'];
                        $no_invoice=$row['no_invoice'];
                        $transaksi=$row['transaksi'];
                        }else{
                        ?>
                        <script language="JavaScript">
                            alert('Dilarang Akses URL Tidak Valid');
                            document.location='<?php print_link(""); ?>';
                        </script>
                        <?php }
                        if($pasien=="POLI"){
                        $qudat= mysqli_query($koneksi, "select * from data_tagihan_pasien WHERE id_transaksi='$datid' and pasien='POLI'")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                        $rowdat   = mysqli_fetch_assoc($qudat); 
                        $id_data=$rowdat['id_data'];
                        $querdok= mysqli_query($koneksi, "select * from pendaftaran_poli WHERE id_pendaftaran_poli='$id_data'")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                        $qu= mysqli_query($koneksi, "select * from pendaftaran_poli WHERE id_pendaftaran_poli='$id_data'")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                        $rowdokter   = mysqli_fetch_assoc($querdok);  
                        $iddokter= $rowdokter['dokter'];
                        $qudok= mysqli_query($koneksi, "select * from data_dokter WHERE id_dokter='$iddokter'")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));    
                        $rowdok   = mysqli_fetch_assoc($qudok); 
                        $dokter_pemeriksa=$rowdok['nama_dokter'];                                   
                        }else if($pasien=="IGD"){
                        $qudat= mysqli_query($koneksi, "select * from data_tagihan_pasien WHERE id_transaksi='$datid' and pasien='IGD'")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                        $rowdat   = mysqli_fetch_assoc($qudat); 
                        $id_data=$rowdat['id_data'];
                        $querdok= mysqli_query($koneksi, "select * from igd WHERE id_igd='$id_data'")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                        $qu= mysqli_query($koneksi, "select * from igd WHERE id_igd='$id_data'")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                        $rowdokter   = mysqli_fetch_assoc($querdok);  
                        $iddokter= $rowdokter['dokter'];
                        $qudok= mysqli_query($koneksi, "select * from data_dokter WHERE id_dokter='$iddokter'")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));    
                        $rowdok   = mysqli_fetch_assoc($qudok); 
                        $dokter_pemeriksa=$rowdok['nama_dokter'];  
                        $specialist=$rowdok['specialist']; 
                        }                                
                        // ambil jumlah baris data hasil query
                        $ro = mysqli_num_rows($qu);
                        if ($ro <> 0) {
                        $rowd   = mysqli_fetch_assoc($qu); 
                        //////////////////////////   
                        if($pasien=="POLI")  {  
                        $nama_moli=$rowd['nama_poli'];
                        $qud= mysqli_query($koneksi, "select * from data_poli WHERE id_poli='$nama_moli'")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                        // ambil jumlah baris data hasil query
                        $rod = mysqli_num_rows($qud);
                        if ($rod <> 0) {
                        $rowdd   = mysqli_fetch_assoc($qud); 
                        $specialist=$rowdd['nama_poli'];
                        }
                        }
                        ///////////////////
                        $tanggal_lahir=$rowd['tanggal_lahir'];
                        $umur=$rowd['umur'];
                        if($pasien=="IGD")  { 
                        $tanggal_masuk=$rowd['tanggal_masuk'];
                        $tanggal_keluar=$rowd['tanggal_keluar'];
                        }
                        }
                        }
                        ?>
                    </div>
                    <script>
                        $(document).ready(function() {
                        <?php if($pembayaran==""){}else{
                        $querb = mysqli_query($koneksi, "select * from data_bank order by id_databank asc")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));  
                        $hitung=0;                    
                        while ($rowb=mysqli_fetch_array($querb)){
                        $cekidb = $rowb['id_databank'];
                        if($cekidb==0){}else{
                        $hitung=$hitung + 1; 
                        if($pembayaran=="$cekidb"){
                        $indexvalp="$hitung";
                        ?>
                        document.getElementById("ctrl-pembayaran").selectedIndex = "<?php echo $indexvalp;?>";
                        <?php
                        if($indexvalp=="1"){}else{?>
                        document.getElementById("ctrl-setatus_bpjs").selectedIndex = 1;
                        <?php }
                        }     
                        }
                        }
                        }
                        ?>   
                        $('#ctrl-pembayaran').on('change', function(){ 
                        //do something like 
                        //$(this).hide(); 
                        //$(#anotherfieldid).show();
                        //var pem = document.getElementById("ctrl-pembayaran").value;
                        var pem =  $('#ctrl-pembayaran').val();
                        //  alert('Tes' +pem);
                        if(pem==1){
                        //$('#ctrl-setatus_bpjs')..disabled=false;  
                        document.getElementById("ctrl-setatus_bpjs").disabled=false;
                        document.getElementById("ctrl-setatus_bpjs").selectedIndex = 0;
                        BPJSopenTab();
                        }else{
                        document.getElementById("ctrl-setatus_bpjs").selectedIndex = 1;
                        }
                        });  
                        $('#ctrl-type_transaksi').on('change', function(){ 
                        //do something like 
                        //$(this).hide(); 
                        //$(#anotherfieldid).show();
                        //var pem = document.getElementById("ctrl-pembayaran").value;
                        var pemt =  $('#ctrl-type_transaksi').val();
                        //  alert('Tes' +pem);
                        if(pemt==1101){
                        BAYARopenTab();
                        }
                        }); 
                        });
                    </script></div>
                    <?php $this :: display_page_errors(); ?>
                    <div  class=" animated fadeIn page-content">
                        <head>
                            <style>
                                @page {
                                margin: 0px;
                                font-family: Arial, Helvetica, sans-serif;
                                }
                                body,
                                h1,
                                h2,
                                h3,
                                h4,
                                h5,
                                h6 {
                                margin: 0px;
                                padding: 0px;
                                font-family: Arial, Helvetica, sans-serif;
                                }
                                small {
                                font-size: 12px;
                                color: #888;
                                }
                                .ajax-page-load-indicator {
                                display: none;
                                visibility: hidden;
                                }
                                #report-header {
                                position: relative;
                                border-top: 3px solid #0066cc;
                                border-bottom: 3px solid #0066cc;
                                background: #fafafa;
                                padding: 5px;
                                }
                                #report-header2 {
                                position: relative;
                                border-bottom: 3px solid #0066cc;
                                background: #fafafa;
                                }   
                                #report-strip {
                                position: relative;
                                border-bottom: 3px solid #0066cc;
                                margin-bottom: 5px;
                                margin-top: 5px;
                                }
                                #report-header table{
                                margin:0;
                                }
                                #report-header .sub-title {
                                font-size: small;
                                color: #888;
                                }
                                #report-header img {
                                height: 50px;
                                width: 50px;
                                }
                                #report-title {
                                background: #fafafa;
                                margin-top: 20px;
                                margin-bottom: 20px;
                                padding: 10px 20px;
                                font-size: 24px;
                                }
                                #report-body{
                                padding: 2px;
                                }
                                #report-footer {
                                padding: 10px;
                                background: #fafafa;
                                border-top: 2px solid #0066cc;
                                position: absolute;
                                bottom: 0;
                                left:0;
                                width: 98%;
                                overflow: hidden;
                                margin: 0 auto;
                                }
                                #report-footer table{
                                margin: 0;
                                overflow: hidden;
                                }
                                table,
                                .table {
                                width: 100%;
                                max-width: 100%;
                                margin-bottom: 1rem;
                                border-collapse: collapse;
                                }
                                .table th,
                                .table td {
                                padding: 0.75rem;
                                vertical-align: top;
                                border-top: 1px solid #eceeef;
                                }
                                .table thead th {
                                vertical-align: bottom;
                                border-bottom: 2px solid #eceeef;
                                }
                                .table tbody+tbody {
                                border-top: 2px solid #eceeef;
                                }
                                .table .table {
                                background-color: #fff;
                                }
                                .table-sm th,
                                .table-sm td {
                                padding: 0.3rem;
                                }
                                .table-bordered {
                                border: 1px solid #eceeef;
                                }
                                .table-bordered th,
                                .table-bordered td {
                                border: 1px solid #eceeef;
                                }
                                .table-bordered thead th,
                                .table-bordered thead td {
                                border-bottom-width: 2px;
                                }
                                .table-striped tbody tr:nth-of-type(odd) {
                                background-color: rgba(0, 0, 0, 0.05);
                                }
                                .table-hover tbody tr:hover {
                                background-color: rgba(0, 0, 0, 0.075);
                                }
                                .table-active,
                                .table-active>th,
                                .table-active>td {
                                background-color: rgba(0, 0, 0, 0.075);
                                }
                                .table-hover .table-active:hover {
                                background-color: rgba(0, 0, 0, 0.075);
                                }
                                .table-hover .table-active:hover>td,
                                .table-hover .table-active:hover>th {
                                background-color: rgba(0, 0, 0, 0.075);
                                }
                                .table-success,
                                .table-success>th,
                                .table-success>td {
                                background-color: #dff0d8;
                                }
                                .table-hover .table-success:hover {
                                background-color: #d0e9c6;
                                }
                                .table-hover .table-success:hover>td,
                                .table-hover .table-success:hover>th {
                                background-color: #d0e9c6;
                                }
                                .table-info,
                                .table-info>th,
                                .table-info>td {
                                background-color: #d9edf7;
                                }
                                .table-hover .table-info:hover {
                                background-color: #c4e3f3;
                                }
                                .table-hover .table-info:hover>td,
                                .table-hover .table-info:hover>th {
                                background-color: #c4e3f3;
                                }
                                .table-warning,
                                .table-warning>th,
                                .table-warning>td {
                                background-color: #fcf8e3;
                                }
                                .table-hover .table-warning:hover {
                                background-color: #faf2cc;
                                }
                                .table-hover .table-warning:hover>td,
                                .table-hover .table-warning:hover>th {
                                background-color: #faf2cc;
                                }
                                .table-danger,
                                .table-danger>th,
                                .table-danger>td {
                                background-color: #f2dede;
                                }
                                .table-hover .table-danger:hover {
                                background-color: #ebcccc;
                                }
                                .table-hover .table-danger:hover>td,
                                .table-hover .table-danger:hover>th {
                                background-color: #ebcccc;
                                }
                                .thead-inverse th {
                                color: #fff;
                                background-color: #292b2c;
                                }
                                .thead-default th {
                                color: #464a4c;
                                background-color: #eceeef;
                                }
                                .table-inverse {
                                color: #fff;
                                background-color: #292b2c;
                                }
                                .table-inverse th,
                                .table-inverse td,
                                .table-inverse thead th {
                                border-color: #fff;
                                }
                                .table-inverse.table-bordered {
                                border: 0;
                                }
                                .table-responsive {
                                display: block;
                                width: 100%;
                                overflow-x: auto;
                                -ms-overflow-style: -ms-autohiding-scrollbar;
                                }
                                .table-responsive.table-bordered {
                                border: 0;
                                }
                            </style>
                            <?php
                            $query = mysqli_query($koneksi, "select * from data_owner")
                            or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                            $rows = mysqli_num_rows($query);
                            if ($rows <> 0) {
                            $data       = mysqli_fetch_assoc($query);
                            $nama_clinik = $data['nama'];
                            $alamat_clinik= $data['alamat'];
                            $email= $data['email'];
                            $phone= $data['phone'];
                            $logo= $data['logo'];
                        $alphon="$alamat_clinik</br>$email</br>$phone";
                        $namclin="$nama_clinik";
                        }else{
                        $alphon="Print Transaksi";
                        $namclin="Clinik Medic+";
                        $logo="";
                        }
                        ?>
                    </head>
                    <body>
                        <div id="report-header">
                            <table class="table table-sm">
                                <tr>
                                    <th align="left" valign="middle" width="60">
                                        <?php
                                        if(!empty($logo)){
                                        ?>
                                        <?php Html :: page_img($logo,50,50,1); ?>
                                        <?php
                                        }else{
                                        ?>
                                        <img src="<?php  print_link("".SITE_FAVICON);?>">
                                            <?php
                                            }?>
                                        </th>
                                        <th align="left" valign="middle">
                                            <h3 class="company-name"><?php echo $namclin;?></h3>
                                        </th>
                                        <th align="right" valign="middle">
                                            <div class="company-info">
                                                <?php echo $alphon;?>
                                            </div>
                                        </th>
                                    </tr>
                                </table>
                            </div>   
                            <div id="report-body">
                                <div class="ajax-page-load-indicator" style="display:none">
                                    <div class="text-center d-flex justify-content-center load-indicator">
                                        <span class="loader mr-3"></span>
                                        <span class="font-weight-bold">Loading...</span>
                                    </div>
                                </div>
                                <div align="center">
                                    <h1>INVOICE</h1>
                                </div>
                                <div align="center">
                                    <h4><?php echo $no_invoice; ?></h4>
                                </div>
                                <div align="center">
                                    <h4>Biaya Perawatan <?php echo $transaksi; ?></h4>
                                </div>
                                <table>
                                    <tr><th></th><th></th></tr>
                                    <tr><td>
                                        <table >
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
                                            <th align="left"> Tanggal Lahir/Umur: </th>
                                            <td >
                                                <?php echo $tanggal_lahir; ?> / <?php echo $umur; ?> 
                                            </td>
                                        </tr> 
                                    </table>
                                </td>
                                <td>  
                                    <table>
                                        <?php
                                        if($pasien=="POLI")  { 
                                        ?>
                                        <tr>
                                            <th align="left"> Tanggal: </th>
                                            <td >
                                                <?php echo $tanggal; ?> 
                                            </td>
                                        </tr>
                                        <tr>
                                            <th align="left"> Dokter Pemeriksa: </th>
                                            <td >
                                                <?php echo $dokter_pemeriksa; ?> 
                                            </td>
                                        </tr>
                                        <tr >
                                            <th align="left"> Specialist: </th>
                                            <td >
                                                <?php echo $specialist; ?> 
                                            </td>
                                        </tr>
                                        <?php }?>
                                        <?php
                                        if($pasien=="IGD")  { 
                                        ?>
                                        <tr>
                                            <th align="left"> Tanggal Masuk: </th>
                                            <td >
                                                <?php echo $tanggal_masuk; ?> 
                                            </td>
                                        </tr>           
                                        <tr>
                                            <th align="left"> Dokter IGD: </th>
                                            <td >
                                                <?php echo $dokter_pemeriksa; ?> 
                                            </td>
                                        </tr>
                                        <tr>
                                            <th align="left"> Tanggal Keluar: </th>
                                            <td >
                                                <?php echo $tanggal_keluar; ?> 
                                            </td>
                                        </tr>      
                                        <?php }?>  
                                    </table>         
                                </td>  
                            </tr>
                        </table> 
                        <div align="center">
                            <h4>Detail Transaksi <?php echo $transaksi; ?></h4>
                        </div>
                        <div id="page-report-body" class="table-responsive"><form id="proses" name="proses" role="form" novalidate enctype="multipart/form-data" class="form page-form form-horizontal needs-validation" action="<?php print_link("transaksi/add?csrf_token=$csrf_token") ?>" method="post">
                            <table class="table  table-striped table-sm text-left"><input type="hidden" name="prosestrx" value="<?php echo $ciphertext;?>"/>
                                <thead class="table-header">
                                    <tr>
                                        <th > Layanan</th>
                                        <th > Rincian</th>
                                        <th > Jumlah</th>
                                        <th > Harga</th>
                                        <th > Total Harga</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $quert = mysqli_query($koneksi, "select * from data_tagihan_pasien WHERE id_transaksi='$datid'")
                                    or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                                    // ambil jumlah baris data hasil query
                                    $rowst = mysqli_num_rows($quert);
                                    if ($rowst <> 0) {
                                    while ($row=mysqli_fetch_array($quert)){
                                    $iddata=$row['id_data'];
                                    $namatagihan= $row['nama_tagihan'];
                                    $pasien= $row['pasien'];
                                    $no_rekam_medis= $row['no_rekam_medis'];
                                    if($row['nama_tagihan']=="Layanan Pasien Baru" or $row['nama_tagihan']=="Layanan Pasien Lama" and $row['id_transaksi']=="$datid"){
                                    ///////////////////////////Tagihan Pendaftaran///////////////////////////
                                    ?>
                                    <td><?php echo $row['nama_tagihan'];?> (<?php echo $pasien;?>)</td>
                                    <td><?php echo $row['keterangan'];?></td>
                                    <td>1</td>
                                    <td>Rp.<?php echo number_format($row['total_tagihan'],0,",",".");?></td>
                                    <td>Rp.<?php echo number_format($row['total_tagihan'],0,",",".");?></td>
                                </tr> 
                                <?php
                                }else if($row['nama_tagihan']=="Jasa Dokter"  and $row['id_transaksi']=="$datid"){
                                ///////////////////////Jasa Dokter////////////////////////////
                                ?>
                                <td><?php echo $row['nama_tagihan'];?> (<?php echo $pasien;?>)</td>
                                <td><?php echo $row['keterangan'];?></td>
                                <td>1</td>
                                <td>Rp.<?php echo number_format($row['total_tagihan'],0,",",".");?></td>
                                <td>Rp.<?php echo number_format($row['total_tagihan'],0,",",".");?></td>
                            </tr> 
                            <?php
                            }else if($row['nama_tagihan']=="Laboratorium"  and $row['id_transaksi']=="$datid"){
                            ////////////////////////Tagihan Lab//////////////////////////////
                            $querlab = mysqli_query($koneksi, "select * from data_hasil_lab WHERE id_hasil_lab='$iddata' ")
                            or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));  
                            while ($rowlab=mysqli_fetch_array($querlab)){                       
                            ?>
                            <td><?php echo $namatagihan;?> (<?php echo $pasien;?>)</td>
                            <td><?php echo $rowlab['nama_pemeriksaan'];?></td>
                            <td>1</td>
                            <td>Rp.<?php echo number_format($rowlab['harga'],0,",",".");?></td>
                            <td>Rp.<?php echo number_format($rowlab['harga'],0,",",".");?></td>
                        </tr>     
                        <?php
                        }
                        }else if($row['nama_tagihan']=="Tindakan"  and $row['id_transaksi']=="$datid"){
                        //////////////////////////////////////Tgiahan Tindakan/////////////////////////////
                        $quertin = mysqli_query($koneksi, "select * from data_tindakan WHERE id_daftar='$iddata'")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));  
                        while ($rowtin=mysqli_fetch_array($quertin)){
                        ?>
                        <td><?php echo $namatagihan;?> (<?php echo $pasien;?>)</td>
                        <td><?php echo $rowtin['nama_tindakan'];?></td>
                        <td>1</td>
                        <td>Rp.<?php echo number_format($rowtin['harga'],0,",",".");?></td>
                        <td>Rp.<?php echo number_format($rowtin['harga'],0,",",".");?></td>
                    </tr> 
                    <?php     
                    }
                    }else if($row['nama_tagihan']=="Resep Obat"  and $row['id_transaksi']=="$datid"){
                    /////////////////////////////Tagihan Obat////////////////////////
                    $nrm=$row['no_rekam_medis'];
                    $querob = mysqli_query($koneksi, "select * from data_penjualan WHERE id_penjualan='$iddata' and id_pelanggan='$nrm'")
                    or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));  
                    while ($rowob=mysqli_fetch_array($querob)){
                    ?>
                    <td><?php echo $namatagihan;?> (<?php echo $pasien;?>)</td>
                    <td><?php echo $rowob['nama_barang'];?></td>
                    <td><?php echo $rowob['jumlah'];?></td>
                    <td>Rp.<?php echo number_format($rowob['harga'],0,",",".");?></td>
                    <td>Rp.<?php echo number_format($rowob['total_harga'],0,",",".");?></td>
                </tr> 
                <?php  
                }
                ////////////////////////////////End Tagihan Obat/////////////////////////         
                }else  if($row['nama_tagihan']=="Tagihan Kamar"  and $row['id_transaksi']=="$datid"){
                /////////////////////////Tagihan Kamar//////////////////////////////
                ?>
                <td><?php echo $row['nama_tagihan'];?> (<?php echo $pasien;?>)</td>
                <td><?php echo $row['keterangan'];?></td>
                <td>1</td>
                <td>Rp.<?php echo number_format($row['total_tagihan'],0,",",".");?></td>
                <td>Rp.<?php echo number_format($row['total_tagihan'],0,",",".");?></td>
            </tr> 
            <?php 
            }else  if($row['nama_tagihan']=="Kunjungan Dokter"  and $row['id_transaksi']=="$datid"){
            /////////////////////////Tagihan Kunjungan//////////////////////////////
            ?>
            <td><?php echo $row['nama_tagihan'];?> (<?php echo $pasien;?>)</td>
            <td><?php echo $row['keterangan'];?></td>
            <td>1</td>
            <td>Rp.<?php echo number_format($row['total_tagihan'],0,",",".");?></td>
            <td>Rp.<?php echo number_format($row['total_tagihan'],0,",",".");?></td>
        </tr> 
        <?php 
        }else  if($row['nama_tagihan']=="Tagihan Embalase"){
        /////////////////////////Tagihan Embalase//////////////////////////////
        ?>
        <td><?php echo $row['nama_tagihan'];?> (<?php echo $pasien;?>)</td>
        <td><?php echo $row['keterangan'];?></td>
        <td>1</td>
        <td>Rp.<?php echo number_format($row['total_tagihan'],0,",",".");?></td>
        <td>Rp.<?php echo number_format($row['total_tagihan'],0,",",".");?></td>
    </tr> 
    <?php 
    }else if($row['nama_tagihan']=="Tambahan"){
    /////////////////////////Tagihan Tambahan//////////////////////////////
    ?>
    <td><?php echo $row['nama_tagihan'];?> (<?php echo $pasien;?>)</td>
    <td><?php echo $row['keterangan'];?></td>
    <td>1</td>
    <td>Rp.<?php echo number_format($row['total_tagihan'],0,",",".");?></td>
    <td>Rp.<?php echo number_format($row['total_tagihan'],0,",",".");?></td>
</tr> 
<?php 
}
}
}
?>
<?php   if($setatus_bpjs=="Active"){
?>
<tr> <th colspan="3"></th><th>Tanggal Transaksi</th><th>
    <span >
        <div class="input-group">
            <input id="ctrl-tanggal_transaksi" class="form-control datepicker  datepicker"  required="" value="<?php  echo $this->set_field_value('tanggal_transaksi',date_now()); ?>" type="datetime" name="tanggal_transaksi" placeholder="Enter Tanggal" data-enable-time="false" data-min-date="" data-max-date="" data-date-format="Y-m-d" data-alt-format="F j, Y" data-inline="false" data-no-calendar="false" data-mode="single" />
                <div class="input-group-append">
                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                </div>  
            </span>
        </th></tr> 
        <tr> <th colspan="3"></th><th>Pembayaran</th><th>
            <select required=""  id="ctrl-pembayaran" name="pembayaran"  placeholder="Select a value ..."    class="custom-select" >
                <option value="">Select a value ...</option>
                <?php 
                $pembayaran_options = $comp_model -> pendaftaran_poli_pembayaran_option_list();
                if(!empty($pembayaran_options)){
                foreach($pembayaran_options as $option){
                $value = (!empty($option['value']) ? $option['value'] : null);
                $label = (!empty($option['label']) ? $option['label'] : $value);
                $selected = $this->set_field_selected('pembayaran',$value, "");
                ?>
                <option <?php echo $selected; ?> value="<?php echo $value; ?>">
                    <?php echo $label; ?>
                </option>
                <?php
                }
                }
                ?>
            </select>
        </th></tr> 
        <tr> <th colspan="3"></th><th>Setatus BPJS</th><th>
            <select required=""  id="ctrl-setatus_bpjs" name="setatus_bpjs"  placeholder="Select a value ..."    class="custom-select" >
                <option value="">Select a value ...</option>
                <?php
                $setatus_bpjs_options = Menu :: $setatus_bpjs;
                if(!empty($setatus_bpjs_options)){
                foreach($setatus_bpjs_options as $option){
                $value = $option['value'];
                $label = $option['label'];
                $selected = $this->set_field_selected('setatus_bpjs', $value, "");
                ?>
                <option <?php echo $selected ?> value="<?php echo $value ?>">
                    <?php echo $label ?>
                </option>                                   
                <?php
                }
                }
                ?>
            </select>
        </th></tr>  
        <?php
        }else{?> 
        <tr> <th colspan="3"></th><th>Deposit</th><th>Rp.<?php 
        echo number_format($deposit,0,",",".");?></th></tr> 
        <tr> <th colspan="3"></th><th>Sisa Total Tagihan</th><th>Rp.<?php 
            echo number_format($sisa_tagihan,0,",",".");?>
        </th></tr> 
        <tr> <th colspan="3"></th><th>Pembayaran</th><th>
            <select required=""  id="ctrl-pembayaran" name="pembayaran"  placeholder="Select a value ..."    class="custom-select" >
                <option value="">Select a value ...</option>
                <?php 
                $pembayaran_options = $comp_model -> pendaftaran_poli_pembayaran_option_list();
                if(!empty($pembayaran_options)){
                foreach($pembayaran_options as $option){
                $value = (!empty($option['value']) ? $option['value'] : null);
                $label = (!empty($option['label']) ? $option['label'] : $value);
                $selected = $this->set_field_selected('pembayaran',$value, "");
                ?>
                <option <?php echo $selected; ?> value="<?php echo $value; ?>">
                    <?php echo $label; ?>
                </option>
                <?php
                }
                }
                ?>
            </select>
        </th></tr> 
        <tr> <th colspan="3"></th><th>Setatus BPJS</th><th>
            <select required=""  id="ctrl-setatus_bpjs" name="setatus_bpjs"  placeholder="Select a value ..."    class="custom-select" >
                <option value="">Select a value ...</option>
                <?php
                $setatus_bpjs_options = Menu :: $setatus_bpjs;
                if(!empty($setatus_bpjs_options)){
                foreach($setatus_bpjs_options as $option){
                $value = $option['value'];
                $label = $option['label'];
                $selected = $this->set_field_selected('setatus_bpjs', $value, "");
                ?>
                <option <?php echo $selected ?> value="<?php echo $value ?>">
                    <?php echo $label ?>
                </option>                                   
                <?php
                }
                }
                ?>
            </select>
        </th></tr>   
        <input onFocus="startCalc();" onBlur="stopCalc();" id="ctrl-total"  value="<?php echo $sisa_tagihan;?>" type="hidden" placeholder="Enter Jumlah" step="1"  required="" name="totalall"  class="form-control " /> 
            <tr> <th colspan="3"></th><th>Bayar</th><th>
                <span >
                    <input onFocus="startCalc();" onBlur="stopCalc();" id="ctrl-bayar"  value="" type="number" placeholder="Enter Jumlah" step="1"  required="" name="bayar"  class="form-control " /> 
                </span>
            </th></tr> 
            <tr> <th colspan="3"></th><th>Kembalian</th><th>
                <span >
                    <input onFocus="startCalc();" onBlur="stopCalc();" id="ctrl-total"  value="" type="number" placeholder="Enter Jumlah" step="1"  required="" name="kembalian"  class="form-control " readonly/>  
                </span>
            </th></tr> 
            <tr> <th colspan="3"></th><th>Type Transaksi</th><th>
                <span >
                    <select required=""  id="ctrl-type_transaksi" name="type_transaksi"  placeholder="Select Transaksi..."    class="custom-select" >
                        <option value="">Select Transaksi...</option>
                        <option value="2" >Cash</option>  
                        <option value="1101" >Transfer / Debet (Non Cash)</option>
                    </select>   
                </span>
            </th></tr>       
            <tr> <th colspan="3"></th><th>Tanggal Transaksi</th><th>
                <span >
                    <div class="input-group">
                        <input id="ctrl-tanggal_transaksi" class="form-control datepicker  datepicker"  required="" value="<?php  echo $this->set_field_value('tanggal_transaksi',date_now()); ?>" type="datetime" name="tanggal_transaksi" placeholder="Enter Tanggal" data-enable-time="false" data-min-date="" data-max-date="" data-date-format="Y-m-d" data-alt-format="F j, Y" data-inline="false" data-no-calendar="false" data-mode="single" />
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                            </div>  
                        </span>
                    </th></tr>        
                    <?php }
                    if($setatus_bpjs=="Non Active"){
                    ?>
                    <div align="center">Lakukan Pembayaran BPJS Dahulu</div>
                    <div align="center">Ganti Pemayaran Cash/Debit</div>
                    <?php
                    }else{
                    ?>
                    <tr> <th colspan="4"></th><th>
                        <div class="form-ajax-status"></div>
                        <a class="btn btn-sm btn-info" onclick="prosestrx();" style="color: #fff;">
                            <i class="fa fa-send"></i> Proses Transaksi
                        </a> 
                    </th></tr>      
                    <?php  
                    }?>
                </form>
            </tbody>
        </table> 
    </div>
    <div id="report-header2"> </div>
</div>
<script>
    <?php   if($setatus_bpjs=="Active"){
    ?>
    function prosestrx() {
    var result = confirm("Proses Transaksi Pasien <?php echo $nama_pasien;?>?");
    if (result == true) {
    //document.getElementById('autobtn').click();
    document.getElementById("proses").submit();
    return true;
    }
    else {
    return false;
    }
    }  
    <?php    
    }else{?> 
    function prosestrx() {
    let x = document.forms["proses"]["bayar"].value;
    let b = document.forms["proses"]["type_transaksi"].value;
    if (x == "") {
    alert("Bayar Dulu!!");
    return false;
    }
    if (b == "") {
    alert("Silahkan Pilih Type Transaksi!!");
    return false;
    } 
    var result = confirm("Proses Transaksi?");
    if (result == true) {
    //document.getElementById('autobtn').click();
    document.getElementById("proses").submit();
    return true;
    }
    else {
    return false;
    }
    }
    function startCalc(){
    interval = setInterval("calc()",1);}
    function calc(){
    satu = document.proses.bayar.value;
    dua = document.proses.totalall.value; 
    //tiga = document.formid.total.value; 
    document.proses.kembalian.value = (satu * 1) - (dua * 1);}
    function stopCalc(){
    clearInterval(interval);}
    <?php }?>
</script>
</br>
</body>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</section>
