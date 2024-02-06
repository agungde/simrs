<?php 
//check if current user role is allowed access to the pages
$can_add = ACL::is_allowed("pendaftaran_lab/add");
$can_edit = ACL::is_allowed("pendaftaran_lab/edit");
$can_view = ACL::is_allowed("pendaftaran_lab/view");
$can_delete = ACL::is_allowed("pendaftaran_lab/delete");
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
    <td class="td-tanggal"> <?php echo $data['tanggal']; ?></td>
    <td class="td-nama_pasien"> <?php echo $data['nama_pasien']; ?></td>
    <td class="td-no_rekam_medis"> <?php echo $data['no_rekam_medis']; ?></td>
    <td class="td-alamat"> <?php echo $data['alamat']; ?></td>
    <td class="td-no_hp"> <?php echo $data['no_hp']; ?></td>
    <td class="td-nama_poli"> <?php echo $data['nama_poli']; ?></td>
    <td class="td-dokter_pengirim"> <?php echo $data['dokter_pengirim']; ?></td>
    <td class="td-keluhan"> <?php echo $data['keluhan']; ?></td>
    <td class="td-jenis_pemeriksaan"> <?php echo $data['jenis_pemeriksaan']; ?></td>
    <td class="td-nama_pemeriksaan"> <?php echo $data['nama_pemeriksaan']; ?></td>
    <td class="td-action"> <span>
        <?php 
        $key="dermawangroup";
        $plaintext = "$rec_id";
        $ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
        $iv = openssl_random_pseudo_bytes($ivlen);
        $ciphertext_raw = openssl_encrypt($plaintext, $cipher, $key, $options=OPENSSL_RAW_DATA, $iv);
        $hmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary=true);
        $ciphertext = base64_encode( $iv.$hmac.$ciphertext_raw );
        if($data['setatus']=="Register" or $data['setatus']==""){
        ?>
        <a class="btn btn-sm btn-primary has-tooltip"  href="<?php  print_link("hasil_lab/proses_lab?csrf_token=$csrf_token&precord=$ciphertext");?>"
        <i class="fa fa-send"></i>Proses Lab</a>
        <?php
        }else{
        }
        ?>
    </span></td>
    <td class="td-setatus"> <?php echo $data['setatus']; ?></td>
    <td class="td-pasien"> <?php echo $data['pasien']; ?></td>
    <td class="td-operator">
        <a size="sm" class="btn btn-sm btn-primary page-modal" href="<?php print_link("user_login/view/" . urlencode($data['operator'])) ?>">
            <i class="fa fa-eye"></i> <?php echo $data['user_login_nama'] ?>
        </a>
    </td>
    <td class="td-date_created"> <?php echo $data['date_created']; ?></td>
    <td class="td-date_updated"> <?php echo $data['date_updated']; ?></td>
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
