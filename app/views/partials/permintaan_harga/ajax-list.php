<?php 
//check if current user role is allowed access to the pages
$can_add = ACL::is_allowed("permintaan_harga/add");
$can_edit = ACL::is_allowed("permintaan_harga/edit");
$can_view = ACL::is_allowed("permintaan_harga/view");
$can_delete = ACL::is_allowed("permintaan_harga/delete");
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
    <td class="td-no_request"> <?php echo $data['no_request']; ?></td>
    <td class="td-nama_suplier"> <?php echo $data['nama_suplier']; ?></td>
    <td class="td-action"> <span>
        <?php 
        $key="dermawangroup";
        $plaintext = $data['no_request'];
        $ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
        $iv = openssl_random_pseudo_bytes($ivlen);
        $ciphertext_raw = openssl_encrypt($plaintext, $cipher, $key, $options=OPENSSL_RAW_DATA, $iv);
        $hmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary=true);
        $ciphertext = base64_encode( $iv.$hmac.$ciphertext_raw );
        //if($data['setatus']=="Register"){
        
        ?>
        <div class="dropup export-btn-holder mx-1">
            <button class="btn btn-sm btn-primary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-edit"></i>Action
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <a class="btn btn-sm btn-primary has-tooltip" style="margin-top:3px;" href="<?php  print_link("data_permintaan_harga?csrf_token=$csrf_token&detile_request=$plaintext");?>">
                <i class="fa fa-plus "></i>Beli Dari Suplier <?php echo $data['nama_suplier'];?></a>
            </div>
        </div> 
    <?php //echo $data['action']; ?></span></td>
    <td class="td-alamat"> <?php echo $data['alamat']; ?></td>
    <td class="td-no_hp"> <?php echo $data['no_hp']; ?></td>
    <td class="td-email"><a href="<?php print_link("mailto:$data[email]") ?>"><?php echo $data['email']; ?></a></td>
    <td class="td-category_barang">
        <a size="sm" class="btn btn-sm btn-primary page-modal" href="<?php print_link("category_barang/view/" . urlencode($data['category_barang'])) ?>">
            <i class="fa fa-eye"></i> <?php echo $data['category_barang_category'] ?>
        </a>
    </td>
    <td class="td-total_jumlah"> <?php echo $data['total_jumlah']; ?></td>
    <td class="td-operator">
        <a size="sm" class="btn btn-sm btn-primary page-modal" href="<?php print_link("user_login/view/" . urlencode($data['operator'])) ?>">
            <i class="fa fa-eye"></i> <?php echo $data['user_login_nama'] ?>
        </a>
    </td>
    <td class="td-setatus"> <?php echo $data['setatus']; ?></td>
    <td class="td-date_created"> <?php echo $data['date_created']; ?></td>
    <td class="td-date_updated"> <?php echo $data['date_updated']; ?></td>
    <td class="page-list-action td-btn">
        <div class="dropdown" >
            <button data-toggle="dropdown" class="dropdown-toggle btn btn-primary btn-sm">
                <i class="fa fa-bars"></i> 
            </button>
            <ul class="dropdown-menu">
                <?php if($can_view){ ?>
                <a class="dropdown-item page-modal" href="<?php print_link("permintaan_harga/view/$rec_id"); ?>">
                    <i class="fa fa-eye"></i> View 
                </a>
                <?php } ?>
                <?php if($can_edit){ ?>
                <a class="dropdown-item page-modal" href="<?php print_link("permintaan_harga/edit/$rec_id"); ?>">
                    <i class="fa fa-edit"></i> Edit
                </a>
                <?php } ?>
                <?php if($can_delete){ ?>
                <a  class="dropdown-item record-delete-btn" href="<?php print_link("permintaan_harga/delete/$rec_id/?csrf_token=$csrf_token&redirect=$current_page"); ?>" data-prompt-msg="Are you sure you want to delete this record?" data-display-style="modal">
                    <i class="fa fa-times"></i> Delete 
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
