<?php 
//check if current user role is allowed access to the pages
$can_add = ACL::is_allowed("hasil_lab/add");
$can_edit = ACL::is_allowed("hasil_lab/edit");
$can_view = ACL::is_allowed("hasil_lab/view");
$can_delete = ACL::is_allowed("hasil_lab/delete");
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
    <div  class="bg-white p-1 mb-1">
        <div class="container-fluid">
            <div class="row ">
                <div class="col ">
                    <h4 class="record-title"><?php
                        $id_user = "".USER_ID;
                        $dbhost  = "".DB_HOST;
                        $dbuser  = "".DB_USERNAME;
                        $dbpass  = "".DB_PASSWORD;
                        $dbname  = "".DB_NAME;
                        $koneksi = new mysqli($dbhost, $dbuser,$dbpass, $dbname);
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
                        $queryb = mysqli_query($koneksi, "select * from hasil_lab WHERE id_hasil_lab='$original_plaintext'")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                        // ambil jumlah baris data hasil query
                        $rowsb = mysqli_num_rows($queryb);
                        if ($rowsb <> 0) {
                        $row   = mysqli_fetch_assoc($queryb);
                        $id_hasil_lab=$row['id_hasil_lab'];
                        $no_rekam_medis=$row['no_rekam_medis'];
                        $nama_pasien=$row['nama_pasien'];
                        $alamat=$row['alamat'];
                        $no_hp=$row['no_hp'];
                        $tanggal=$row['tanggal'];
                        $dokter_pengirim=$row['dokter_pengirim'];
                        $nama_poli=$row['nama_poli'];
                        $keluhan=$row['keluhan'];
                        $diagnosa=$row['diagnosa'];
                        $pasien=$row['pasien'];
                        $dokter_lab=$row['dokter_lab'];
                        $jenis_pemeriksaan=$row['jenis_pemeriksaan'];
                        }else{
                        ?>
                        <script language="JavaScript">
                            alert('Dilarang Akses URL Tidak Valid');
                            document.location='<?php print_link(""); ?>';
                        </script>
                        <?php }
                        ?>
                    Hasil Lab Pasien <?php echo $nama_pasien;?></h4>
                </div>
            </div>
        </div>
    </div>
    <?php
    }
    ?>
    <div  class="">
        <div class="container-fluid">
            <div class="row ">
                <div class="col-md-12 comp-grid">
                    <?php $this :: display_page_errors(); ?>
                    <div  class=" animated fadeIn page-content">
                        <div  id="divToPrint" style="display:none;">
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
                                    padding: 10px;
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
                                $queryd = mysqli_query($koneksi, "select * from data_owner")
                                or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                                $rowsd = mysqli_num_rows($queryd);
                                if ($rowsd <> 0) {
                                $datad      = mysqli_fetch_assoc($queryd);
                                $nama_clinik = $datad['nama'];
                                $alamat_clinik= $datad['alamat'];
                                $email= $datad['email'];
                                $phone= $datad['phone'];
                            $alphon="$alamat_clinik</br>$email</br>$phone";
                            $namclin="$nama_clinik";
                            }else{
                            $alphon="Print Hasil Lab";
                            $namclin="Clinik Medic+";
                            }
                            ?>
                        </head>
                        <body>
                            <div id="report-header">
                                <table class="table table-sm">
                                    <tr>
                                        <th align="left" valign="middle" width="60">
                                            <img src="<?php  print_link("".SITE_FAVICON);?>">
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
                                    <div  class="">
                                        <div class="container">
                                            <div class="row ">
                                                <div class="col-md-12 comp-grid">
                                                    <div  class="card animated fadeIn page-content">
                                                        <div id="page-report-body" class="">
                                                            <table class="table table-hover table-borderless table-striped">
                                                                <input type="hidden" name="precod" value="<?php echo $original_plaintext;?>"/>
                                                                    <input type="hidden" name="precodback" value="<?php echo $ciphertext;?>"/>
                                                                        <!-- Table Body Start -->
                                                                        <tbody class="page-data" id="page-data-view-page-amwxg0lkiqju">
                                                                            <tr  class="td-tanggal">
                                                                                <th class="title" align="left"> Tanggal: </th>
                                                                                <td class="value">
                                                                                    <span >
                                                                                        <?php echo $tanggal;?>
                                                                                    </span>
                                                                                </td>
                                                                            </tr>
                                                                            <tr  class="td-no_rekam_medis">
                                                                                <th class="title" align="left"> Pasien: </th>
                                                                                <td class="value">
                                                                                    <span >
                                                                                        <?php echo $pasien;?> 
                                                                                    </span>
                                                                                </td>
                                                                            </tr>                                    
                                                                            <tr  class="td-no_rekam_medis">
                                                                                <th class="title" align="left"> No Rekam Medis: </th>
                                                                                <td class="value">
                                                                                    <span >
                                                                                        <?php echo $no_rekam_medis;?> 
                                                                                    </span>
                                                                                </td>
                                                                            </tr>                                    
                                                                            <tr  class="td-nama_pasien">
                                                                                <th class="title" align="left"> Nama Pasien: </th>
                                                                                <td class="value">
                                                                                    <span >
                                                                                        <?php echo $nama_pasien;?>
                                                                                    </span>
                                                                                </td>
                                                                            </tr>
                                                                            <tr  class="td-alamat">
                                                                                <th class="title" align="left"> Alamat: </th>
                                                                                <td class="value">
                                                                                    <span>
                                                                                        <?php echo $alamat;?>
                                                                                    </span>
                                                                                </td>
                                                                            </tr>
                                                                            <tr  class="td-no_hp">
                                                                                <th class="title" align="left"> No Hp: </th>
                                                                                <td class="value">
                                                                                    <span>
                                                                                        <?php echo $no_hp;?>
                                                                                    </span>
                                                                                </td>
                                                                            </tr>
                                                                            <tr  class="td-nama_poli">
                                                                                <th class="title" align="left"> Nama Poli: </th>
                                                                                <td class="value">
                                                                                    <span>
                                                                                        <?php echo $nama_poli;?>
                                                                                    </span>
                                                                                </td>
                                                                            </tr>
                                                                            <tr  class="td-dokter_pemeriksa">
                                                                                <th class="title" align="left"> Dokter Pengirim: </th>
                                                                                <td class="value">
                                                                                    <span>
                                                                                        <?php echo $dokter_pengirim;?>
                                                                                    </span>
                                                                                </td>
                                                                            </tr>
                                                                            <tr  class="td-keluhan">
                                                                                <th class="title" align="left"> Keluhan: </th>
                                                                                <td class="value">
                                                                                    <span>
                                                                                        <?php echo $keluhan;?>
                                                                                    </span>
                                                                                </td>
                                                                            </tr>                                    
                                                                            <tr  class="td-jenis_pemeriksaan">
                                                                                <th class="title" align="left"> Jenis Pemeriksaan: </th>
                                                                                <td class="value">
                                                                                    <span>
                                                                                        <?php echo $jenis_pemeriksaan;?>
                                                                                    </span>
                                                                                </td>
                                                                            </tbody>
                                                                            <!-- Table Body End -->
                                                                        </table>   
                                                                    </div>
                                                                    <div class="p-3 d-flex">
                                                                    </div>
                                                                </div>
                                                                <div class=""><div>
                                                                    <table class="table  table-striped table-sm text-left">
                                                                        <thead class="table-header bg-success">
                                                                            <tr>
                                                                                <th  class="td-nama_pemeriksaan" align="left"> Jenis Pemeriksaan</th>
                                                                                <th  class="td-hasil_pemeriksaan" align="left"> Hasil Pemeriksaan</th>
                                                                                <th  class="td-nilai_rujukan" align="left"> Nilai Rujukan</th>
                                                                                <th class="td-btn"></th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody class="page-data" >
                                                                            <!--record-->
                                                                            <?php
                                                                            $query = mysqli_query($koneksi, "SELECT  DISTINCT jenis_pemeriksaan AS jen,id_daftar_lab AS iddaf from data_hasil_lab WHERE id_hasil_lab='$original_plaintext'")
                                                                            or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                                                                            // ambil jumlah baris data hasil query
                                                                            $rowsb = mysqli_num_rows($query);
                                                                            if ($rowsb <> 0) {
                                                                            while ($row=mysqli_fetch_array($query)){
                                                                            ?>
                                                                            <tr><td><b><?php echo $row['jen']; ?></b></td><td></td><td></td></tr>
                                                                            <?php
                                                                            $querynam = mysqli_query($koneksi, "select * from data_hasil_lab WHERE id_hasil_lab='$original_plaintext' and jenis_pemeriksaan='".$row['jen']."' AND id_daftar_lab='".$row['iddaf']."'")
                                                                            or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                                                                            while ($rownam=mysqli_fetch_array($querynam)){  
                                                                            $namapem=$rownam['nama_pemeriksaan'];
                                                                            $namaruj=$rownam['nilai_rujukan'];
                                                                            ?>
                                                                            <tr>
                                                                                <td class="td-nama_pemeriksaan">
                                                                                    <span>&#8226;
                                                                                        <?php echo $namapem; ?>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="td-hasil_pemeriksaan">
                                                                                    <span >
                                                                                        <?php echo $rownam['hasil_pemeriksaan']; ?>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="td-nilai_rujukan">
                                                                                    <span  >
                                                                                        <?php echo $namaruj; ?>
                                                                                    </span>
                                                                                </td>
                                                                            </tr>
                                                                            <?php }
                                                                            }
                                                                            }
                                                                            ?>
                                                                            <!--endrecord-->
                                                                        </tbody>
                                                                        <tbody class="search-data" > </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </body></br>
                                </div>
                                <?php ///////////////////////////////////////?>
                                <div  class="">
                                    <div class="container">
                                        <div class="row ">
                                            <div class="col-md-12 comp-grid">
                                                <div  class="card animated fadeIn page-content">
                                                    <div id="page-report-body" class="">
                                                        <table class="table table-hover table-borderless table-striped">
                                                            <input type="hidden" name="precod" value="<?php echo $original_plaintext;?>"/>
                                                                <input type="hidden" name="precodback" value="<?php echo $ciphertext;?>"/>
                                                                    <!-- Table Body Start -->
                                                                    <tbody class="page-data" id="page-data-view-page-amwxg0lkiqju">
                                                                        <tr  class="td-tanggal">
                                                                            <th class="title"> Tanggal: </th>
                                                                            <td class="value">
                                                                                <span >
                                                                                    <?php echo $tanggal;?>
                                                                                </span>
                                                                            </td>
                                                                        </tr>
                                                                        <tr  class="td-no_rekam_medis">
                                                                            <th class="title" align="left"> Pasien: </th>
                                                                            <td class="value">
                                                                                <span >
                                                                                    <?php echo $pasien;?> 
                                                                                </span>
                                                                            </td>
                                                                        </tr>                                    
                                                                        <tr  class="td-no_rekam_medis">
                                                                            <th class="title"> No Rekam Medis: </th>
                                                                            <td class="value">
                                                                                <span >
                                                                                    <?php echo $no_rekam_medis;?> 
                                                                                </span>
                                                                            </td>
                                                                        </tr>                                    
                                                                        <tr  class="td-nama_pasien">
                                                                            <th class="title"> Nama Pasien: </th>
                                                                            <td class="value">
                                                                                <span >
                                                                                    <?php echo $nama_pasien;?>
                                                                                </span>
                                                                            </td>
                                                                        </tr>
                                                                        <tr  class="td-alamat">
                                                                            <th class="title"> Alamat: </th>
                                                                            <td class="value">
                                                                                <span>
                                                                                    <?php echo $alamat;?>
                                                                                </span>
                                                                            </td>
                                                                        </tr>
                                                                        <tr  class="td-no_hp">
                                                                            <th class="title"> No Hp: </th>
                                                                            <td class="value">
                                                                                <span>
                                                                                    <?php echo $no_hp;?>
                                                                                </span>
                                                                            </td>
                                                                        </tr>
                                                                        <tr  class="td-nama_poli">
                                                                            <th class="title"> Nama Poli: </th>
                                                                            <td class="value">
                                                                                <span>
                                                                                    <?php echo $nama_poli;?>
                                                                                </span>
                                                                            </td>
                                                                        </tr>
                                                                        <tr  class="td-dokter_pemeriksa">
                                                                            <th class="title"> Dokter Pengirim: </th>
                                                                            <td class="value">
                                                                                <span>
                                                                                    <?php echo $dokter_pengirim;?>
                                                                                </span>
                                                                            </td>
                                                                        </tr>
                                                                        <tr  class="td-keluhan">
                                                                            <th class="title"> Keluhan: </th>
                                                                            <td class="value">
                                                                                <span>
                                                                                    <?php echo $keluhan;?>
                                                                                </span>
                                                                            </td>
                                                                        </tr>                                    
                                                                        <tr  class="td-jenis_pemeriksaan">
                                                                            <th class="title"> Jenis Pemeriksaan: </th>
                                                                            <td class="value">
                                                                                <span>
                                                                                    <?php echo $jenis_pemeriksaan;?>
                                                                                </span>
                                                                            </td>
                                                                        </tr>                                    
                                                                    </tbody>
                                                                    <!-- Table Body End -->
                                                                </table>   
                                                            </div>
                                                            <div class="p-3 d-flex">
                                                            </div>
                                                        </div>
                                                        <div class=""><div>
                                                            <table class="table  table-striped table-sm text-left">
                                                                <thead class="table-header bg-success">
                                                                    <tr>
                                                                        <th  class="td-nama_pemeriksaan"> Jenis Pemeriksaan</th>
                                                                        <th  class="td-hasil_pemeriksaan"> Hasil Pemeriksaan</th>
                                                                        <th  class="td-nilai_rujukan"> Nilai Rujukan</th>
                                                                        <th class="td-btn"></th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody class="page-data" >
                                                                    <!--record-->
                                                                    <?php
                                                                    $query = mysqli_query($koneksi, "SELECT  DISTINCT jenis_pemeriksaan AS jen from data_hasil_lab WHERE id_hasil_lab='$original_plaintext'")
                                                                    or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                                                                    // ambil jumlah baris data hasil query
                                                                    $rowsb = mysqli_num_rows($query);
                                                                    if ($rowsb <> 0) {
                                                                    while ($row=mysqli_fetch_array($query)){
                                                                    ?>
                                                                    <tr><td><b><?php echo $row['jen']; ?></b></td><td></td><td></td></tr>
                                                                    <?php
                                                                    $querynam = mysqli_query($koneksi, "select * from data_hasil_lab WHERE id_hasil_lab='$original_plaintext' and jenis_pemeriksaan='".$row['jen']."'")
                                                                    or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                                                                    while ($rownam=mysqli_fetch_array($querynam)){  
                                                                    $namapem=$rownam['nama_pemeriksaan'];
                                                                    $namaruj=$rownam['nilai_rujukan'];
                                                                    ?>
                                                                    <tr>
                                                                        <td class="td-nama_pemeriksaan">
                                                                            <span>&#8226;
                                                                                <?php echo $namapem; ?>
                                                                            </span>
                                                                        </td>
                                                                        <td class="td-hasil_pemeriksaan">
                                                                            <span >
                                                                                <?php echo $rownam['hasil_pemeriksaan']; ?>
                                                                            </span>
                                                                        </td>
                                                                        <td class="td-nilai_rujukan">
                                                                            <span  >
                                                                                <?php echo $namaruj; ?>
                                                                            </span>
                                                                        </td>
                                                                    </tr>
                                                                    <?php }
                                                                    }
                                                                    }
                                                                    ?>
                                                                    <!--endrecord-->
                                                                </tbody>
                                                                <tbody class="search-data" > </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        </div></br><div align="center">
                                        <input type="button" class="btn btn-sm btn-info has-tooltip"value="Print Hasil Lab" onclick="PrintDiv();" />
                                    </div>
                                </br>
                                <script type="text/javascript">     
                                    function PrintDiv() {    
                                    var divToPrint = document.getElementById('divToPrint');
                                    var popupWin = window.open('<?php  print_link("hasil_lab/hasil");?>', '_blank');
                                    popupWin.document.open();
                                    popupWin.document.write('<html><body onload="window.print()">' + divToPrint.innerHTML + '</html>');
                                        popupWin.document.close();
                                        }
                                    </script>
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
