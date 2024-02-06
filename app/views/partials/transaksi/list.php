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
<section class="page ajax-page" id="<?php echo $page_element_id; ?>" data-page-type="list"  data-display-type="table" data-page-url="<?php print_link($current_page); ?>">
    <?php
    if( $show_header == true ){
    ?>
    <div  class="bg-white p-1 mb-1">
        <div class="container-fluid">
            <div class="row ">
                <div class="col ">
                    <h4 class="record-title"><?php
                        $sekarang = gmdate("Y-m-d", time() + 60 * 60 * 7);
                        $id_user = "".USER_ID;
                        $dbhost="".DB_HOST;
                        $dbuser="".DB_USERNAME;
                        $dbpass="".DB_PASSWORD;
                        $dbname="".DB_NAME;
                        //$koneksi=open_connection();
                        $koneksi = new mysqli($dbhost, $dbuser,$dbpass, $dbname);
                        $sql = mysqli_query($koneksi,"select * from user_login WHERE id_userlogin='$id_user'");
                        while ($row=mysqli_fetch_array($sql)){
                        $user_role_id = $row['user_role_id'];
                        }
                        $key="dermawangroup";
                        $plaintext = "$id_user";
                        $ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
                        $iv = openssl_random_pseudo_bytes($ivlen);
                        $ciphertext_raw = openssl_encrypt($plaintext, $cipher, $key, $options=OPENSSL_RAW_DATA, $iv);
                        $hmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary=true);
                        $ciphertext = base64_encode( $iv.$hmac.$ciphertext_raw );
                        ?>
                    Transaksi Kasir</h4>
                </div>
                <div class="col ">
                    <div class="">
                        <?php if(USER_ROLE==7){?>
                        <div class="col-sm-3 comp-grid">
                            <div class=""><div>
                                <a style="margin-top:2px;" class="btn btn-sm btn-primary has-tooltip page-modal"  href="<?php  print_link("transaksi/shift?precord=$ciphertext");?>">
                                <i class="fa fa-user "></i> Serah Terima Shift</a> 
                            </div>
                        </div>
                    </div>                          
                    <?php }?>
                </div>
            </div>
            <div class="col-sm-2 comp-grid">
                <div class=""><?php
                    $query = mysqli_query($koneksi, "SELECT * FROM `kas` ORDER BY `id` DESC")
                    or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                    $rows = mysqli_num_rows($query);
                    if ($rows <> 0) {
                    $datacek  = mysqli_fetch_assoc($query);
                    $saltunai = $datacek['saldo_cash'];
                    if($saltunai=="0" or $saltunai==""){ }else{
                    ?>
                    <div>
                        <a style="margin-top:2px;" class="btn btn-sm btn-primary has-tooltip page-modal"  href="<?php  print_link("transaksi/kredit?precord=$ciphertext");?>">
                        <i class="fa fa-money "></i> Penarikan Kas</a> 
                    </div>
                <?php } }?></div>
            </div>
            <div class="col-sm-2 comp-grid">
                <div class=""><div>
                    <a style="margin-top:2px;" class="btn btn-sm btn-primary has-tooltip page-modal"  href="<?php  print_link("transaksi/debet?precord=$ciphertext");?>">
                    <i class="fa fa-money "></i> Input Kas Awal</a> 
                </div>
            </div>
        </div>
        <div class="col-sm-3 ">
            <form  class="search" action="<?php print_link('transaksi'); ?>" method="get">
                <div class="input-group">
                    <input value="<?php echo get_value('search'); ?>" class="form-control" type="text" name="search"  placeholder="Search" />
                        <div class="input-group-append">
                            <button class="btn btn-primary"><i class="fa fa-search"></i></button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-12 comp-grid">
                <div class="">
                    <!-- Page bread crumbs components-->
                    <?php
                    if(!empty($field_name) || !empty($_GET['search'])){
                    ?>
                    <hr class="sm d-block d-sm-none" />
                    <nav class="page-header-breadcrumbs mt-2" aria-label="breadcrumb">
                        <ul class="breadcrumb m-0 p-1">
                            <?php
                            if(!empty($field_name)){
                            ?>
                            <li class="breadcrumb-item">
                                <a class="text-decoration-none" href="<?php print_link('transaksi'); ?>">
                                    <i class="fa fa-angle-left"></i>
                                </a>
                            </li>
                            <li class="breadcrumb-item">
                                <?php echo (get_value("tag") ? get_value("tag")  :  make_readable($field_name)); ?>
                            </li>
                            <li  class="breadcrumb-item active text-capitalize font-weight-bold">
                                <?php echo (get_value("label") ? get_value("label")  :  make_readable(urldecode($field_value))); ?>
                            </li>
                            <?php 
                            }   
                            ?>
                            <?php
                            if(get_value("search")){
                            ?>
                            <li class="breadcrumb-item">
                                <a class="text-decoration-none" href="<?php print_link('transaksi'); ?>">
                                    <i class="fa fa-angle-left"></i>
                                </a>
                            </li>
                            <li class="breadcrumb-item text-capitalize">
                                Search
                            </li>
                            <li  class="breadcrumb-item active text-capitalize font-weight-bold"><?php echo get_value("search"); ?></li>
                            <?php
                            }
                            ?>
                        </ul>
                    </nav>
                    <!--End of Page bread crumbs components-->
                    <?php
                    }
                    ?>
                </div>
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
            <div class="col-md-6 comp-grid">
                <div class=""><div>
                    <?php if(!empty($_GET['transaksi_tanggal'])){}else{?> 
                    <script>
                        window.onload = function(){
                        // document.forms['autoform'].submit();
                        //document.getElementById('autobtn').click();
                        }   
                    </script>
                    <?php }?>
                    <form method="get" action="<?php print_link($current_page) ?>" class="form filter-form">
                        <div class="input-group">
                            <input class="form-control datepicker  datepicker"  value="<?php echo $this->set_field_value('transaksi_tanggal',''); ?>" type="datetime"  name="transaksi_tanggal" placeholder="Tanggal" data-enable-time="" data-date-format="Y-m-d" data-alt-format="M j, Y" data-inline="false" data-no-calendar="false" data-mode="single" />
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                </div>
                                &nbsp;&nbsp;
                                <select required=""  name="transaksi_setatus"  placeholder="Select a value ..."    class="custom-select" >
                                    <option  value="Register" >Register</option>
                                    <option  value="Closed">Closed</option>
                                </select>
                                &nbsp;&nbsp;
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
                    <div id="transaksi-list-records">
                        <div id="page-report-body" class="table-responsive">
                            <?php Html::ajaxpage_spinner(); ?>
                            <table class="table table-hover table-sm text-left">
                                <thead class="table-header bg-success text-dark">
                                    <tr>
                                        <th  class="td-no_invoice"> No Invoice</th>
                                        <th  class="td-tanggal"> Tanggal</th>
                                        <th  class="td-no_rekam_medis"> No Rekam Medis</th>
                                        <th  class="td-nama_pasien"> Nama Pasien</th>
                                        <th  class="td-action"> Action</th>
                                        <th  class="td-setatus_tagihan"> Setatus Tagihan</th>
                                        <th  class="td-pembayaran"> Pembayaran</th>
                                        <th  class="td-setatus_bpjs"> Setatus Bpjs</th>
                                        <th  class="td-total_tagihan"> Total Tagihan</th>
                                        <th  class="td-deposit"> Deposit</th>
                                        <th  class="td-sisa_tagihan"> Sisa Tagihan</th>
                                        <th  class="td-poli"> Poli</th>
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
                                    $rec_id = (!empty($data['id']) ? urlencode($data['id']) : null);
                                    $counter++;
                                    ?>
                                    <tr>
                                        <td class="td-no_invoice"> <?php echo $data['no_invoice']; ?></td>
                                        <td class="td-tanggal"> <?php echo $data['tanggal']; ?></td>
                                        <td class="td-no_rekam_medis"> <?php echo $data['no_rekam_medis']; ?></td>
                                        <td class="td-nama_pasien"> <?php echo $data['nama_pasien']; ?></td>
                                        <td class="td-action"><?php
                                            $sekarang = gmdate("Y-m-d", time() + 60 * 60 * 7);
                                            $id_user = "".USER_ID;
                                            $dbhost="".DB_HOST;
                                            $dbuser="".DB_USERNAME;
                                            $dbpass="".DB_PASSWORD;
                                            $dbname="".DB_NAME;
                                            $koneksi = new mysqli($dbhost, $dbuser,$dbpass, $dbname);
                                            ?>
                                            <style>
                                                .dropdown a.dropdown-item:hover {
                                                cursor: pointer;
                                                background-color: #F5F5DC;
                                                }
                                            </style>
                                            <span><?php if(USER_ROLE==7 or USER_ROLE==1){?>
                                                <div class="dropdown" >
                                                    <button data-toggle="dropdown" class="dropdown-toggle btn btn-primary btn-sm">
                                                        <i class="fa fa-bars"></i> 
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <?php
                                                        $sqldt = mysqli_query($koneksi,"select * from data_penjualan WHERE id_transaksi='$rec_id'");
                                                        $rodt = mysqli_num_rows($sqldt);
                                                        if ($rodt<> 0) {
                                                        $edittag="";
                                                        while ($rodt=mysqli_fetch_array($sqldt)){
                                                        if($rodt['jumlah'] > 1){
                                                        $edittag="OK";
                                                        }
                                                        }
                                                        }else{
                                                        $edittag="";
                                                        }
                                                        $sqlpoli = mysqli_query($koneksi,"select * from pendaftaran_poli WHERE id_transaksi='$rec_id'");
                                                        $ropl = mysqli_num_rows($sqlpoli);
                                                        if ($ropl<> 0) {
                                                        $row   = mysqli_fetch_assoc($sqlpoli); 
                                                        if($row['setatus']=="Closed"){
                                                        $trxpoli="Ok";
                                                        }else{
                                                        $trxpoli="";
                                                        }
                                                        }else{
                                                        $trxpoli="";
                                                        }
                                                        $sqligd = mysqli_query($koneksi,"select * from igd WHERE id_transaksi='$rec_id'");
                                                        $roigd = mysqli_num_rows($sqligd);
                                                        if ($roigd<> 0) {
                                                        $rowigd   = mysqli_fetch_assoc($sqligd); 
                                                        $idigd=$rowigd['id_igd'];
                                                        $rekamigd=$rowigd['no_rekam_medis'];
                                                        $igdsetatus=$rowigd['setatus'];
                                                        if($igdsetatus=="Closed"){
                                                        $ijinigd="";
                                                        }else{
                                                        $sqijin = mysqli_query($koneksi,"select * from ijin_pulang WHERE id_daftar='$idigd' and no_rekam_medis='$rekamigd'");
                                                        $roiji = mysqli_num_rows($sqijin);
                                                        if ($roiji<> 0) {
                                                        $ijinigd="Ok";
                                                        }else{
                                                        $ijinigd="";
                                                        }
                                                        }
                                                        }else{
                                                        $ijinigd="";
                                                        }
                                                        // $sqlinp = mysqli_query($koneksi,"select * from rawat_inap WHERE id_transaksi='$rec_id'");
                                                        // $roinp = mysqli_num_rows($sqlinp);
                                                        // if ($roinp<> 0) {
                                                        //// $rowinp   = mysqli_fetch_assoc($sqlinp); 
                                                        // $idinp=$rowinp['id'];
                                                        //$rekaminp=$rowinp['no_rekam_medis'];
                                                        $sqijinp = mysqli_query($koneksi,"select * from ijin_pulang WHERE id_transaksi='$rec_id'");
                                                        $roijnp = mysqli_num_rows($sqijinp);
                                                        if ($roijnp<> 0) {
                                                        $ijininp="Ok";
                                                        }else{
                                                        $ijininp="";
                                                        }
                                                        //}else{
                                                        // $ijininp="";
                                                        // }
                                                        $key="dermawangroup";
                                                        $plaintext = "$rec_id";
                                                        $ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
                                                        $iv = openssl_random_pseudo_bytes($ivlen);
                                                        $ciphertext_raw = openssl_encrypt($plaintext, $cipher, $key, $options=OPENSSL_RAW_DATA, $iv);
                                                        $hmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary=true);
                                                        $ciphertext = base64_encode( $iv.$hmac.$ciphertext_raw );
                                                        ?>
                                                        <?php
                                                        if($data['setatus_tagihan']=="Register"){
                                                        if($edittag==""){ }else{
                                                        /*
                                                        ?>
                                                        <a style="margin-top:0px;" class="dropdown-item page-modal"  href="<?php  print_link("transaksi/obat?precord=$ciphertext");?>">
                                                        <i class="fa fa-money "></i> Edite Tagihan Obat</a> 
                                                        <?php
                                                        */
                                                        }
                                                        ?>
                                                        <a style="margin-top:0px;" class="dropdown-item  page-modal"  href="<?php  print_link("transaksi/invoice?precord=$ciphertext");?>">
                                                        <i class="fa fa-eye "></i><i class="fa fa-money "></i> Lihat Tagihan</a>
                                                        <?php   if($data['setatus_bpjs']=="Active"){}else{?>                            
                                                        <a style="margin-top:0px;" class="dropdown-item page-modal"  href="<?php  print_link("transaksi/deposit?precord=$ciphertext");?>">
                                                        <i class="fa fa-money "></i> Isi Deposit</a> 
                                                        <?php }
                                                        if($trxpoli=="Ok"){
                                                        $queryb = mysqli_query($koneksi, "select * from data_pasien WHERE no_rekam_medis='".$data['no_rekam_medis']."'")
                                                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                                                        // ambil jumlah baris data hasil query
                                                        $rowsb = mysqli_num_rows($queryb);
                                                        if ($rowsb <> 0) {
                                                        $row   = mysqli_fetch_assoc($queryb);
                                                        $idpasien=$row['id_pasien'];
                                                        }
                                                        $sqtt = mysqli_query($koneksi,"SELECT * FROM `data_tagihan_pasien` WHERE `id_transaksi`='$rec_id' AND `id_data`='$rec_id'");
                                                        $rott = mysqli_num_rows($sqtt);
                                                        if ($rott <> 0) {
                                                        ?>                       
                                                        <a  class="dropdown-item page-modal"  href="<?php  print_link("transaksi/proses?precord=$ciphertext");?>">
                                                        <i class="fa fa-dollar "></i> Proses Tagihan</a>  
                                                        <?php
                                                        }else{
                                                        ?>
                                                        <a  class="dropdown-item page-modal"  href="<?php  print_link("data_tagihan_pasien/embalase?precord=$ciphertext&datprecord=$idpasien");?>" >
                                                        <i class="fa fa-dollar "></i> Add Tagihan Embalase</a>
                                                        <?php
                                                        }
                                                        }else if($ijinigd=="Ok"){
                                                        $queryb = mysqli_query($koneksi, "select * from data_pasien WHERE no_rekam_medis='".$data['no_rekam_medis']."'")
                                                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                                                        // ambil jumlah baris data hasil query
                                                        $rowsb = mysqli_num_rows($queryb);
                                                        if ($rowsb <> 0) {
                                                        $row   = mysqli_fetch_assoc($queryb);
                                                        $idpasien=$row['id_pasien'];
                                                        }
                                                        $sqtt = mysqli_query($koneksi,"SELECT * FROM `data_tagihan_pasien` WHERE `id_transaksi`='$rec_id' AND `id_data`='$rec_id'");
                                                        $rott = mysqli_num_rows($sqtt);
                                                        if ($rott <> 0) {
                                                        ?>                       
                                                        <a  class="dropdown-item page-modal"  href="<?php  print_link("transaksi/proses?precord=$ciphertext");?>">
                                                        <i class="fa fa-dollar "></i> Proses Tagihan</a>  
                                                        <?php
                                                        }else{
                                                        ?>
                                                        <a  class="dropdown-item page-modal"  href="<?php  print_link("data_tagihan_pasien/embalase?precord=$ciphertext&datprecord=$idpasien");?>" >
                                                        <i class="fa fa-dollar "></i> Add Tagihan Embalase</a>
                                                        <?php
                                                        }
                                                        }else if($ijininp=="Ok"){
                                                        $queryb = mysqli_query($koneksi, "select * from data_pasien WHERE no_rekam_medis='".$data['no_rekam_medis']."'")
                                                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                                                        // ambil jumlah baris data hasil query
                                                        $rowsb = mysqli_num_rows($queryb);
                                                        if ($rowsb <> 0) {
                                                        $row   = mysqli_fetch_assoc($queryb);
                                                        $idpasien=$row['id_pasien'];
                                                        }
                                                        $sqtt = mysqli_query($koneksi,"SELECT * FROM `data_tagihan_pasien` WHERE `id_transaksi`='$rec_id' AND `id_data`='$rec_id'");
                                                        $rott = mysqli_num_rows($sqtt);
                                                        if ($rott <> 0) {
                                                        ?>                       
                                                        <a  class="dropdown-item page-modal"  href="<?php  print_link("transaksi/proses?precord=$ciphertext");?>">
                                                        <i class="fa fa-dollar "></i> Proses Tagihan</a>  
                                                        <?php
                                                        }else{
                                                        ?>
                                                        <a  class="dropdown-item page-modal"  href="<?php  print_link("data_tagihan_pasien/embalase?precord=$ciphertext&datprecord=$idpasien");?>" >
                                                        <i class="fa fa-dollar "></i> Add Tagihan Embalase</a>
                                                        <?php
                                                        }
                                                        } 
                                                        }else{
                                                        ?>
                                                        <a style="margin-bottom:3px;" class="dropdown-item page-modal"  href="<?php  print_link("transaksi/invoice?precord=$ciphertext");?>">
                                                        <i class="fa fa-eye "></i><i class="fa fa-send"></i> Print Transaksi</a> 
                                                        <?php
                                                        }
                                                        ?>
                                                    </ul>
                                                </div><?php }?>
                                            </span></td>
                                            <td class="td-setatus_tagihan"><?php
                                                if($data['setatus_tagihan']=="Closed"){
                                                // mysqli_query($koneksi,"UPDATE rawat_inap SET setatus='Closed'  WHERE id='$rec_id'");
                                                $cki= mysqli_query($koneksi, "select * from rawat_inap WHERE id_transaksi='$rec_id'")
                                                or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                                                // ambil jumlah baris data hasil query
                                                $roi = mysqli_num_rows($cki);
                                                if ($roi <> 0) {
                                                $cdt= mysqli_fetch_assoc($cki);
                                                $set=$cdt['setatus'];
                                                if($set=="Closed"){ }else{
                                                mysqli_query($koneksi,"UPDATE rawat_inap SET setatus='Closed'  WHERE id_transaksi='$rec_id'");
                                                }
                                                }
                                                $ckp= mysqli_query($koneksi, "select * from pendaftaran_poli WHERE id_transaksi='$rec_id'")
                                                or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                                                // ambil jumlah baris data hasil query
                                                $rop = mysqli_num_rows($ckp);
                                                if ($rop <> 0) {
                                                $cdp= mysqli_fetch_assoc($ckp);
                                                $set=$cdp['setatus'];
                                                if($set=="Closed"){ }else{
                                                mysqli_query($koneksi,"UPDATE pendaftaran_poli SET setatus='Closed'  WHERE id_transaksi='$rec_id'");
                                                }
                                                }    
                                                ?>
                                                <span style="border-radius: 8px; background-color:     #DC143C; color: white; padding:5px; font-weight: bold;"><?php echo $data['setatus_tagihan']; ?></span>
                                                <?php
                                                }else if($data['setatus_tagihan']=="Register"){
                                                ?>
                                                <span style="border-radius: 8px; background-color: #1E90FF; color: white; padding:5px; font-weight: bold;"><?php echo $data['setatus_tagihan']; ?></span>
                                                <?php
                                                }else{
                                                ?>
                                                <span ><?php echo $data['setatus_tagihan']; ?></span>
                                                <?php
                                                }
                                            ?></td>
                                            <td class="td-pembayaran">
                                                <a size="sm" class="btn btn-sm btn-primary page-modal" href="<?php print_link("data_bank/view/" . urlencode($data['pembayaran'])) ?>">
                                                    <i class="fa fa-eye"></i> <?php echo $data['data_bank_nama_bank'] ?>
                                                </a>
                                            </td>
                                            <td class="td-setatus_bpjs"> <?php echo $data['setatus_bpjs']; ?></td>
                                            <td class="td-total_tagihan"> <span><?php echo "Rp.".number_format( $data['total_tagihan'],0,",","."); ?></span></td>
                                            <td class="td-deposit"> <span><?php echo number_format($data['deposit'],0,",","."); ?></span></td>
                                            <td class="td-sisa_tagihan"> <span><?php
                                                if($data['sisa_tagihan']=="0" or $data['sisa_tagihan']==""){
                                                echo "Rp.".number_format($data['total_tagihan']);  
                                                }else{
                                                echo "Rp.".number_format($data['sisa_tagihan']);
                                                }
                                            ?></span></td>
                                            <td class="td-poli"> <?php echo $data['poli']; ?></td>
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
