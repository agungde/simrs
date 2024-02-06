<?php 
//check if current user role is allowed access to the pages
$can_add = ACL::is_allowed("transaksi/add");
$can_edit = ACL::is_allowed("transaksi/edit");
$can_view = ACL::is_allowed("transaksi/view");
$can_delete = ACL::is_allowed("transaksi/delete");
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
    