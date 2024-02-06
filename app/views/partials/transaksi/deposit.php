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
                    </div></div>
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
                                    <h4>Pasien <?php echo $transaksi; ?></h4>
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
                                </table>         
                            </td>  
                        </tr>
                    </table> 
                    <div align="center">
                        <h4>Deposit Untuk Pasien <?php echo $transaksi; ?></h4>
                    </div>
                    <div id="page-report-body" class="table-responsive">
                        <form id="transaksi-add-form" role="form" novalidate enctype="multipart/form-data" class="form page-form form-horizontal needs-validation" action="<?php print_link("transaksi/add?csrf_token=$csrf_token") ?>" method="post">
                            <div class="form-group ">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <label class="control-label" for="tanggal_transaksi">Tanggal Transaksi<span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-sm-8">
                                        <div class="input-group">
                                            <input id="ctrl-tanggal_transaksi" class="form-control datepicker  datepicker"  required="" value="<?php  echo $this->set_field_value('tanggal',date_now()); ?>" type="datetime" name="tanggal_transaksi" placeholder="Enter Tanggal" data-enable-time="false" data-min-date="" data-max-date="" data-date-format="Y-m-d" data-alt-format="F j, Y" data-inline="false" data-no-calendar="false" data-mode="single" />
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
                                            <label class="control-type_transaksi" for="type_transaksi">Type Transaksi<span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="">
                                                <select required=""  id="ctrl-type_transaksi" name="type_transaksi"  placeholder="Select Transaksi..."    class="custom-select" >
                                                    <option value="">Select Transaksi...</option>
                                                    <option value="2" >Cash</option>  
                                                    <option value="0" >Transfer / Debet (Non Cash)</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>      
                                <table class="table table-hover table-borderless table-striped">
                                    <input type="hidden" name="precod" value="<?php echo $ciphertext;?>"/>
                                        <!-- Table Body Start -->
                                        <tbody class="page-data" id="page-data-view-page-amwxg0lkiqju">
                                            <tr  class="td-tanggal">
                                                <th class="title"> <label class="control-label" for="deposit">Deposit <span class="text-danger">*</span></label> </th>
                                                <td class="value">
                                                    <span >
                                                        <input id="ctrl-deposit"  value="<?php  echo $this->set_field_value('deposit',""); ?>" type="number" placeholder="Enter Deposit" step="1"  required="" name="deposit"  class="form-control " />
                                                        </span>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table> 
                                        <div class="form-group form-submit-btn-holder text-center mt-3">
                                            <div class="form-ajax-status"></div>
                                            <button class="btn btn-primary" type="submit">
                                                Submit
                                                <i class="fa fa-send"></i>
                                            </button>
                                        </div>                                    
                                    </form>
                                </div>
                                <div id="report-header2"> </div>
                            </div>
                        </br>
                    </body>
                </div>
            </div>
        </div>
    </div>
</div>
</section>
