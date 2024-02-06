<?php 
//check if current user role is allowed access to the pages
$can_add = ACL::is_allowed("data_pasien/add");
$can_edit = ACL::is_allowed("data_pasien/edit");
$can_view = ACL::is_allowed("data_pasien/view");
$can_delete = ACL::is_allowed("data_pasien/delete");
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
$rec_id = (!empty($data['id_pasien']) ? urlencode($data['id_pasien']) : null);
$counter++;
?>
<tr>
    <td class="td-no_rekam_medis"> <span><?php echo $data['no_rekam_medis']; ?></span></td>
    <td class="td-no_ktp"> <?php echo $data['no_ktp']; ?></td>
    <td class="td-rm"> <?php echo $data['rm']; ?></td>
    <td class="td-tl"> <?php echo $data['tl']; ?></td>
    <td class="td-nama_pasien"> <?php echo $data['nama_pasien']; ?></td>
    <td class="td-alamat"> <?php echo $data['alamat']; ?></td>
    <td class="td-action"> <span>
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
        $key="dermawangroup";
        $plaintext = "$rec_id";
        $ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
        $iv = openssl_random_pseudo_bytes($ivlen);
        $ciphertext_raw = openssl_encrypt($plaintext, $cipher, $key, $options=OPENSSL_RAW_DATA, $iv);
        $hmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary=true);
        $ciphertext = base64_encode( $iv.$hmac.$ciphertext_raw );
        if(!empty($_GET['appointment'])){
        if($user_role_id=="3"){}else{
        ?>
        <a class="btn btn-sm btn-primary has-tooltip"  href="<?php  print_link("appointment/add?csrf_token=$csrf_token&precord=$ciphertext");?>"
        <i class="fa fa-send"></i>Add appointment</a>
        <?php }
        }else if(!empty($_GET['poli'])){
        if($user_role_id=="3"){}else{
        ?>
        <a class="btn btn-sm btn-primary has-tooltip"  href="<?php  print_link("pendaftaran_poli/add?csrf_token=$csrf_token&precord=$ciphertext");?>"
        <i class="fa fa-send"></i>Daftar Ke Poli</a>
        <?php }  }else{
        if($user_role_id=="3"){}else{
        ?>
        <a class="btn btn-sm btn-primary has-tooltip"  href="<?php  print_link("pendaftaran_poli/add?csrf_token=$csrf_token&precord=$ciphertext");?>"
        <i class="fa fa-send"></i>Daftar Ke Poli</a>
        <a class="btn btn-sm btn-primary has-tooltip"  href="<?php  print_link("appointment/add?csrf_token=$csrf_token&precord=$ciphertext");?>"
        <i class="fa fa-send"></i>Add appointment</a>
        <?php }
        }
        ?>
    </span></td>
    <td class="td-tanggal_lahir"> <?php echo $data['tanggal_lahir']; ?></td>
    <td class="td-no_hp"> <?php echo $data['no_hp']; ?></td>
    <td class="td-jenis_kelamin"> <?php echo $data['jenis_kelamin']; ?></td>
    <td class="td-umur"> <?php echo $data['umur']; ?></td>
    <td class="td-email"><a href="<?php print_link("mailto:$data[email]") ?>"><?php echo $data['email']; ?></a></td>
    <td class="td-photo"><?php Html :: page_img($data['photo'],50,50,1); ?></td>
    <td class="td-nokk"> <?php echo $data['nokk']; ?></td>
    <td class="td-namaortu"> <?php echo $data['namaortu']; ?></td>
    <td class="td-operator">
        <a size="sm" class="btn btn-sm btn-primary page-modal" href="<?php print_link("user_login/view/" . urlencode($data['operator'])) ?>">
            <i class="fa fa-eye"></i> <?php echo $data['user_login_nama'] ?>
        </a>
    </td>
    <td class="td-date_created"> <?php echo $data['date_created']; ?></td>
    <td class="td-date_updated"> <?php echo $data['date_updated']; ?></td>
    <td class="page-list-action td-btn">
        <div class="dropdown" >
            <button data-toggle="dropdown" class="dropdown-toggle btn btn-primary btn-sm">
                <i class="fa fa-bars"></i> 
            </button>
            <ul class="dropdown-menu">
                <?php if($can_view){ ?>
                <a class="dropdown-item page-modal" href="<?php print_link("data_pasien/view/$rec_id"); ?>">
                    <i class="fa fa-eye"></i> View 
                </a>
                <?php } ?>
                <?php if($can_edit){ ?>
                <a class="dropdown-item page-modal" href="<?php print_link("data_pasien/edit/$rec_id"); ?>">
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
