<?php 
//check if current user role is allowed access to the pages
$can_add = ACL::is_allowed("penjualan/add");
$can_edit = ACL::is_allowed("penjualan/edit");
$can_view = ACL::is_allowed("penjualan/view");
$can_delete = ACL::is_allowed("penjualan/delete");
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
    <div  class="bg-white p-1 mb-1">
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
                        $queryb = mysqli_query($koneksi, "select * from penjualan WHERE id_penjualan='$original_plaintext'")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                        // ambil jumlah baris data hasil query
                        $rowsb = mysqli_num_rows($queryb);
                        if ($rowsb <> 0) {
                        $row   = mysqli_fetch_assoc($queryb); 
                        $datid=$row['id_penjualan'];
                        $tanggal=$row['tanggal'];
                        $nama_pelanggan=$row['nama_pelanggan'];
                        $alamat=$row['alamat'];
                        $no_invoice=$row['no_invoice'];
                        $no_hp=$row['no_hp'];
                        }else{
                        ?>
                        <script language="JavaScript">
                            alert('Dilarang Akses URL Tidak Valid');
                            document.location='<?php print_link(""); ?>';
                        </script>
                        <?php }
                        }
                        ?>
                    </div>
                </div>
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
                    $alphon="$alamat_clinik</br>$email</br>$phone";
                    $namclin="$nama_clinik";
                    }else{
                    $alphon="Print Penjualan";
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
                            <div align="center">
                                <h1>INVOICE PENJUALAN</h1>
                            </div>
                            <div align="center">
                                <h4><?php echo $no_invoice; ?></h4>
                            </div>
                            <table>
                                <tr><th></th><th></th></tr>
                                <tr><td>
                                    <table >
                                        <tr>
                                            <th align="left"> Nama Pelanggan: </th>
                                            <td >
                                                <?php echo $nama_pelanggan; ?> 
                                            </td>
                                        </tr>
                                        <tr>
                                            <th align="left"> Alamat: </th>
                                            <td >
                                                <?php echo $alamat; ?> 
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                                <td align="right">  
                                    <table>
                                        <tr>
                                            <th align="left"> Tanggal: </th>
                                            <td >
                                                <?php echo $tanggal; ?> 
                                            </td>
                                        </tr>
                                        <tr>
                                            <th align="left"> No Hp: </th>
                                            <td >
                                                <?php echo $no_hp; ?> 
                                            </td>
                                        </tr>
                                    </table>         
                                </td>  
                            </tr>
                        </table> 
                        <div align="center">
                            <h4>Detail Transaksi Penjualan</h4>
                        </div>
                        <div id="page-report-body" class="table-responsive">
                            <table class="table  table-striped table-sm text-left">
                                <thead class="table-header">
                                    <tr>
                                        <th > Kode Barang</th>
                                        <th > Nama Barang</th>
                                        <th > Jumlah</th>
                                        <th > Harga</th>
                                        <th > Diskon</th>
                                        <th > Total Harga</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $quero = mysqli_query($koneksi, "select * from data_penjualan WHERE id_penjualan='$datid'")
                                    or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                                    // ambil jumlah baris data hasil query
                                    $rowso = mysqli_num_rows($quero);
                                    if ($rowso <> 0) {
                                    while ($rowo=mysqli_fetch_array($quero)){
                                    ?>
                                    <tr>
                                        <td><?php echo $rowo['kode_barang'];?></td>
                                        <td><?php echo $rowo['nama_barang'];?></td>
                                        <td><?php echo $rowo['jumlah'];?></td>
                                        <td>Rp.<?php echo number_format($rowo['harga'],0,",",".");?></td>
                                        <td><?php echo number_format($rowo['diskon'],0,",",".");?></td>
                                        <td>Rp.<?php $total=$rowo['jumlah'] * $rowo['harga']; echo number_format($total,0,",",".");?></td>
                                    </tr> 
                                    <?php }} 
                                    $querob = mysqli_query($koneksi, "select SUM(total_harga) AS valu from data_penjualan WHERE id_penjualan='$datid'")
                                    or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                                    $rowsob = mysqli_num_rows($querob);
                                    if ($rowsob <> 0) {
                                    $datob   = mysqli_fetch_assoc($querob);
                                    }
                                    ?>
                                    <tr> <th colspan="4"></th><th>Grandtotal</th><th>Rp.<?php 
                                        $grandtot=$datob['valu'];
                                    echo number_format($grandtot,0,",",".");?></th></tr>                                 </tbody>
                                </table> 
                            </div>
                            <div id="report-header2"> </div>
                        </div>
                        <div align="center">
                            <?php if(!empty($_GET['view'])){
                            echo "<div>Penjualan Obat Poli</div>";
                            }else{
                            echo "<div>Penjualan Obat Apotek</div>";
                            }
                            ?><div> <i class="fa fa-print"></i>
                            <input type="button" class="btn btn-sm btn-primary has-tooltip" value="Print Invoice" onclick="PrintDiv();" /></div>
                        </div></br>
                        <script type="text/javascript">     
                            function PrintDiv() {    
                            var divToPrint = document.getElementById('divToPrint');
                            var popupWin = window.open('<?php  print_link("penjualan/invoice?csrf_token=$csrf_token&precord=$ciphertext");?>', '_blank');
                            popupWin.document.open();
                            popupWin.document.write('<html><body onload="window.print()">' + divToPrint.innerHTML + '</html>');
                                popupWin.document.close();
                                }
                            </script>
                            <div align="center" id="divToPrint" style="display:none;">
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
                                $alphon="$alamat_clinik</br>$email</br>$phone";
                                $namclin="$nama_clinik";
                                }else{
                                $alphon="Print Penjualan";
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
                                        <div align="center">
                                            <h1>INVOICE PENJUALAN</h1>
                                        </div>
                                        <div align="center">
                                            <h4><?php echo $no_invoice; ?></h4>
                                        </div>
                                        <table>
                                            <tr><th></th><th></th></tr>
                                            <tr><td>
                                                <table >
                                                    <tr>
                                                        <th align="left"> Nama Pelanggan: </th>
                                                        <td >
                                                            <?php echo $nama_pelanggan; ?> 
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th align="left"> Alamat: </th>
                                                        <td >
                                                            <?php echo $alamat; ?> 
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                            <td align="right">  
                                                <table>
                                                    <tr>
                                                        <th align="left"> Tanggal: </th>
                                                        <td >
                                                            <?php echo $tanggal; ?> 
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th align="left"> No Hp: </th>
                                                        <td >
                                                            <?php echo $no_hp; ?> 
                                                        </td>
                                                    </tr>
                                                </table>         
                                            </td>  
                                        </tr>
                                    </table> 
                                    <div align="center">
                                        <h4>Detail Transaksi Penjualan</h4>
                                    </div>
                                    <div id="page-report-body" class="table-responsive">
                                        <table class="table  table-striped table-sm text-left">
                                            <thead class="table-header">
                                                <tr>
                                                    <th > Kode Barang</th>
                                                    <th > Nama Barang</th>
                                                    <th > Jumlah</th>
                                                    <th > Harga</th>
                                                    <th > Diskon</th>
                                                    <th > Total Harga</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $quero = mysqli_query($koneksi, "select * from data_penjualan WHERE id_penjualan='$datid'")
                                                or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                                                // ambil jumlah baris data hasil query
                                                $rowso = mysqli_num_rows($quero);
                                                if ($rowso <> 0) {
                                                while ($rowo=mysqli_fetch_array($quero)){
                                                ?>
                                                <tr>
                                                    <td><?php echo $rowo['kode_barang'];?></td>
                                                    <td><?php echo $rowo['nama_barang'];?></td>
                                                    <td><?php echo $rowo['jumlah'];?></td>
                                                    <td>Rp.<?php echo number_format($rowo['harga'],0,",",".");?></td>
                                                    <td><?php echo number_format($rowo['diskon'],0,",",".");?></td>
                                                    <td>Rp.<?php $total=$rowo['jumlah'] * $rowo['harga']; echo number_format($total,0,",",".");?></td>
                                                </tr> 
                                                <?php }} 
                                                $querob = mysqli_query($koneksi, "select SUM(total_harga) AS valu from data_penjualan WHERE id_penjualan='$datid'")
                                                or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                                                $rowsob = mysqli_num_rows($querob);
                                                if ($rowsob <> 0) {
                                                $datob   = mysqli_fetch_assoc($querob);
                                                }
                                                ?>
                                                <tr> <th colspan="4"></th><th>Grandtotal</th><th>Rp.<?php 
                                                    $grandtot=$datob['valu'];
                                                echo number_format($grandtot,0,",",".");?></th></tr>                                 </tbody>
                                            </table> 
                                        </div>
                                        <div id="report-header2"> </div>
                                    </div>   
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
