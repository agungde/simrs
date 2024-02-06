<?php 
//check if current user role is allowed access to the pages
$can_add = ACL::is_allowed("rm_lama/add");
$can_edit = ACL::is_allowed("rm_lama/edit");
$can_view = ACL::is_allowed("rm_lama/view");
$can_delete = ACL::is_allowed("rm_lama/delete");
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
    <td class="td-tanggal_rm"> <?php echo $data['tanggal_rm']; ?></td>
    <td class="td-no_rekam_medis"> <?php echo $data['no_rekam_medis']; ?></td>
    <td class="td-pemeriksaan_fisik"> <span>
        <?php
        $sekarang = gmdate("Y-m-d", time() + 60 * 60 * 7);
        $id_user = "".USER_ID;
        $dbhost="".DB_HOST;
        $dbuser="".DB_USERNAME;
        $dbpass="".DB_PASSWORD;
        $dbname="".DB_NAME;
        //$koneksi=open_connection();
        $koneksi = new mysqli($dbhost, $dbuser,$dbpass, $dbname);
        
        $norm=$data['no_rekam_medis'];
        $qutr = mysqli_query($koneksi, "SELECT * from data_pasien WHERE no_rekam_medis='$norm'")
        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
        $rotr = mysqli_num_rows($qutr);
        if ($rotr <> 0) {
        $ctr= mysqli_fetch_assoc($qutr);
        $rm=$ctr['rm']; 
        $idpas=$ctr['id_pasien']; 
        }
        ?>
        <div class="dropdown" >
            <button data-toggle="dropdown" class="dropdown-toggle btn btn-primary btn-sm">
                <i class="fa fa-bars"></i> 
            </button>
            <ul class="dropdown-menu">
                <?php
                $key="dermawangroup";
                $plaintext = "$rec_id";
                $ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
                $iv = openssl_random_pseudo_bytes($ivlen);
                $ciphertext_raw = openssl_encrypt($plaintext, $cipher, $key, $options=OPENSSL_RAW_DATA, $iv);
                $hmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary=true);
                $ciphertext = base64_encode( $iv.$hmac.$ciphertext_raw );   
                $cnrm=$data['no_rekam_medis'];
                $ctgl=$data['tanggal_rm'];
                //$frm  = "uploads/rmlama/$postnrm";
                $ckfldr = "rmlama/$cnrm/$ctgl/fisik";
                //mkdir("$frm", 0770, true); 
                //mkdir("$ftgl", 0770, true); 
                if(is_dir($ckfldr)) {
                //echo ("$file is a directory");
                ?>
                <a style="margin-top:1px;" class="btn btn-sm btn-primary has-tooltip" href="<?php  print_link("rm_lama/detile/$rec_id?precord=$ciphertext&datprecord=$idpas&rmlama=fisik");?>">
                <i class="fa fa-plus "></i>Lihat Pemeriksaan Fisik RM Lama</a>                         
                <?php
                } else {
                // mkdir("$ftgl", 0770, true); 
                // echo ("$file is not a directory");
                }   
                ?>
                <a style="margin-top:1px;" class="btn btn-sm btn-primary has-tooltip" href="<?php  print_link("uploadsrm.php?precord=$ciphertext&datprecord=$idpas&rmlama=fisik");?>">
                <i class="fa fa-plus "></i>Uploads Pemeriksaan Fisik RM Lama</a>
                <?php?>
            </ul>
        </div>
        
    </span></td>
    <td class="td-assesment_triase"> <span><?php //echo $data['assesment_triase']; ?>
        
        <div class="dropdown" >
            <button data-toggle="dropdown" class="dropdown-toggle btn btn-primary btn-sm">
                <i class="fa fa-bars"></i> 
            </button>
            <ul class="dropdown-menu">
                <?php
                $key="dermawangroup";
                $plaintext = "$rec_id";
                $ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
                $iv = openssl_random_pseudo_bytes($ivlen);
                $ciphertext_raw = openssl_encrypt($plaintext, $cipher, $key, $options=OPENSSL_RAW_DATA, $iv);
                $hmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary=true);
                $ciphertext = base64_encode( $iv.$hmac.$ciphertext_raw );   
                $cnrm=$data['no_rekam_medis'];
                $ctgl=$data['tanggal_rm'];
                //$frm  = "uploads/rmlama/$postnrm";
                $ckfldr = "rmlama/$cnrm/$ctgl/triase";
                //mkdir("$frm", 0770, true); 
                //mkdir("$ftgl", 0770, true); 
                if(is_dir($ckfldr)) {
                //echo ("$file is a directory");
                ?>
                <a style="margin-top:1px;" class="btn btn-sm btn-primary has-tooltip" href="<?php  print_link("rm_lama/detile/$rec_id?precord=$ciphertext&datprecord=$idpas&rmlama=triase");?>">
                <i class="fa fa-plus "></i>Lihat Pemeriksaan Triase RM Lama</a>                         
                <?php
                } else {
                // mkdir("$ftgl", 0770, true); 
                // echo ("$file is not a directory");
                }   
                ?>
                <a style="margin-top:1px;" class="btn btn-sm btn-primary has-tooltip" href="<?php  print_link("uploadsrm.php?precord=$ciphertext&datprecord=$idpas&rmlama=triase");?>">
                <i class="fa fa-plus "></i>Uploads Pemeriksaan Triase RM Lama</a>
                <?php?>
            </ul>
        </div>
        
    </span></td>
    <td class="td-assesment_medis"> <span><?php //echo $data['assesment_medis']; ?>
        <div class="dropdown" >
            <button data-toggle="dropdown" class="dropdown-toggle btn btn-primary btn-sm">
                <i class="fa fa-bars"></i> 
            </button>
            <ul class="dropdown-menu">
                <?php
                $key="dermawangroup";
                $plaintext = "$rec_id";
                $ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
                $iv = openssl_random_pseudo_bytes($ivlen);
                $ciphertext_raw = openssl_encrypt($plaintext, $cipher, $key, $options=OPENSSL_RAW_DATA, $iv);
                $hmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary=true);
                $ciphertext = base64_encode( $iv.$hmac.$ciphertext_raw );   
                $cnrm=$data['no_rekam_medis'];
                $ctgl=$data['tanggal_rm'];
                //$frm  = "uploads/rmlama/$postnrm";
                $ckfldr = "rmlama/$cnrm/$ctgl/medis";
                //mkdir("$frm", 0770, true); 
                //mkdir("$ftgl", 0770, true); 
                if(is_dir($ckfldr)) {
                //echo ("$file is a directory");
                ?>
                <a style="margin-top:1px;" class="btn btn-sm btn-primary has-tooltip" href="<?php  print_link("rm_lama/detile/$rec_id?precord=$ciphertext&datprecord=$idpas&rmlama=medis");?>">
                <i class="fa fa-plus "></i>Lihat Assesment Medis RM Lama</a>                         
                <?php
                } else {
                // mkdir("$ftgl", 0770, true); 
                // echo ("$file is not a directory");
                }   
                ?>
                <a style="margin-top:1px;" class="btn btn-sm btn-primary has-tooltip" href="<?php  print_link("uploadsrm.php?precord=$ciphertext&datprecord=$idpas&rmlama=medis");?>">
                <i class="fa fa-plus "></i>Uploads Assesment Medis RM Lama</a>
                <?php?>
            </ul>
        </div>
        
    </span></td>
    <td class="td-catatan_medis"> <span><?php //echo $data['catatan_medis']; ?>
        <div class="dropdown" >
            <button data-toggle="dropdown" class="dropdown-toggle btn btn-primary btn-sm">
                <i class="fa fa-bars"></i> 
            </button>
            <ul class="dropdown-menu">
                <?php
                $key="dermawangroup";
                $plaintext = "$rec_id";
                $ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
                $iv = openssl_random_pseudo_bytes($ivlen);
                $ciphertext_raw = openssl_encrypt($plaintext, $cipher, $key, $options=OPENSSL_RAW_DATA, $iv);
                $hmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary=true);
                $ciphertext = base64_encode( $iv.$hmac.$ciphertext_raw );   
                $cnrm=$data['no_rekam_medis'];
                $ctgl=$data['tanggal_rm'];
                //$frm  = "uploads/rmlama/$postnrm";
                $ckfldr = "rmlama/$cnrm/$ctgl/catat";
                //mkdir("$frm", 0770, true); 
                //mkdir("$ftgl", 0770, true); 
                if(is_dir($ckfldr)) {
                //echo ("$file is a directory");
                ?>
                <a style="margin-top:1px;" class="btn btn-sm btn-primary has-tooltip" href="<?php  print_link("rm_lama/detile/$rec_id?precord=$ciphertext&datprecord=$idpas&rmlama=catat");?>">
                <i class="fa fa-plus "></i>Lihat Catatan Medis RM Lama</a>                         
                <?php
                } else {
                // mkdir("$ftgl", 0770, true); 
                // echo ("$file is not a directory");
                }   
                ?>
                <a style="margin-top:1px;" class="btn btn-sm btn-primary has-tooltip" href="<?php  print_link("uploadsrm.php?precord=$ciphertext&datprecord=$idpas&rmlama=catat");?>">
                <i class="fa fa-plus "></i>Uploads Catatan Medis RM Lama</a>
                <?php?>
            </ul>
        </div>
        
    </span></td>
    <td class="td-resep_obat"> <span><?php //echo $data['resep_obat']; ?>
        <div class="dropdown" >
            <button data-toggle="dropdown" class="dropdown-toggle btn btn-primary btn-sm">
                <i class="fa fa-bars"></i> 
            </button>
            <ul class="dropdown-menu">
                <?php
                $key="dermawangroup";
                $plaintext = "$rec_id";
                $ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
                $iv = openssl_random_pseudo_bytes($ivlen);
                $ciphertext_raw = openssl_encrypt($plaintext, $cipher, $key, $options=OPENSSL_RAW_DATA, $iv);
                $hmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary=true);
                $ciphertext = base64_encode( $iv.$hmac.$ciphertext_raw );   
                $cnrm=$data['no_rekam_medis'];
                $ctgl=$data['tanggal_rm'];
                //$frm  = "uploads/rmlama/$postnrm";
                $ckfldr = "rmlama/$cnrm/$ctgl/resep";
                //mkdir("$frm", 0770, true); 
                //mkdir("$ftgl", 0770, true); 
                if(is_dir($ckfldr)) {
                //echo ("$file is a directory");
                ?>
                <a style="margin-top:1px;" class="btn btn-sm btn-primary has-tooltip" href="<?php  print_link("rm_lama/detile/$rec_id?precord=$ciphertext&datprecord=$idpas&rmlama=resep");?>">
                <i class="fa fa-plus "></i>Lihat Resep Obat RM Lama</a>                         
                <?php
                } else {
                // mkdir("$ftgl", 0770, true); 
                // echo ("$file is not a directory");
                }   
                ?>
                <a style="margin-top:1px;" class="btn btn-sm btn-primary has-tooltip" href="<?php  print_link("uploadsrm.php?precord=$ciphertext&datprecord=$idpas&rmlama=resep");?>">
                <i class="fa fa-plus "></i>Uploads Resep Obat RM Lama</a>
                <?php?>
            </ul>
        </div>
        
    </span></td>
    <td class="td-tindakan"> <span><?php //echo $data['tindakan']; ?>
        <div class="dropdown" >
            <button data-toggle="dropdown" class="dropdown-toggle btn btn-primary btn-sm">
                <i class="fa fa-bars"></i> 
            </button>
            <ul class="dropdown-menu">
                <?php
                $key="dermawangroup";
                $plaintext = "$rec_id";
                $ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
                $iv = openssl_random_pseudo_bytes($ivlen);
                $ciphertext_raw = openssl_encrypt($plaintext, $cipher, $key, $options=OPENSSL_RAW_DATA, $iv);
                $hmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary=true);
                $ciphertext = base64_encode( $iv.$hmac.$ciphertext_raw );   
                $cnrm=$data['no_rekam_medis'];
                $ctgl=$data['tanggal_rm'];
                //$frm  = "uploads/rmlama/$postnrm";
                $ckfldr = "rmlama/$cnrm/$ctgl/tindakan";
                //mkdir("$frm", 0770, true); 
                //mkdir("$ftgl", 0770, true); 
                if(is_dir($ckfldr)) {
                //echo ("$file is a directory");
                ?>
                <a style="margin-top:1px;" class="btn btn-sm btn-primary has-tooltip" href="<?php  print_link("rm_lama/detile/$rec_id?precord=$ciphertext&datprecord=$idpas&rmlama=tindakan");?>">
                <i class="fa fa-plus "></i>Lihat Tindakan RM Lama</a>                         
                <?php
                } else {
                // mkdir("$ftgl", 0770, true); 
                // echo ("$file is not a directory");
                }   
                ?>
                <a style="margin-top:1px;" class="btn btn-sm btn-primary has-tooltip" href="<?php  print_link("uploadsrm.php?precord=$ciphertext&datprecord=$idpas&rmlama=tindakan");?>">
                <i class="fa fa-plus "></i>Uploads Tindakan RM Lama</a>
                <?php?>
            </ul>
        </div>
        
    </span></td>
    <td class="page-list-action td-btn">
        <div class="dropdown" >
            <button data-toggle="dropdown" class="dropdown-toggle btn btn-primary btn-sm">
                <i class="fa fa-bars"></i> 
            </button>
            <ul class="dropdown-menu">
                <?php if($can_edit){ ?>
                <a class="dropdown-item page-modal" href="<?php print_link("rm_lama/edit/$rec_id"); ?>">
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
