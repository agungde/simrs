<?php 
//check if current user role is allowed access to the pages
$can_add = ACL::is_allowed("setok_barang/add");
$can_edit = ACL::is_allowed("setok_barang/edit");
$can_view = ACL::is_allowed("setok_barang/view");
$can_delete = ACL::is_allowed("setok_barang/delete");
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
$rec_id = (!empty($data['id_barang']) ? urlencode($data['id_barang']) : null);
$counter++;
?>
<tr>
    <td class="td-id_barang"><a href="<?php print_link("setok_barang/view/$data[id_barang]") ?>"><?php echo $data['id_barang']; ?></a></td>
    <td class="td-kode_barang"> <?php echo $data['kode_barang']; ?></td>
    <td class="td-nama_barang"> <?php echo $data['nama_barang']; ?></td>
    <td class="td-satuan"> <?php echo $data['satuan']; ?></td>
    <td class="td-harga_beli"> <?php echo $data['harga_beli']; ?></td>
    <td class="td-harga_jual"> <?php echo $data['harga_jual']; ?></td>
    <td class="td-jumlah"> <?php echo $data['jumlah']; ?></td>
    <td class="td-category_barang">
        <a size="sm" class="btn btn-sm btn-primary page-modal" href="<?php print_link("category_barang/view/" . urlencode($data['category_barang'])) ?>">
            <i class="fa fa-eye"></i> <?php echo $data['category_barang_category'] ?>
        </a>
    </td>
    <td class="td-operator">
        <a size="sm" class="btn btn-sm btn-primary page-modal" href="<?php print_link("user_login/view/" . urlencode($data['operator'])) ?>">
            <i class="fa fa-eye"></i> <?php echo $data['user_login_nama'] ?>
        </a>
    </td>
    <td class="td-date_created"> <?php echo $data['date_created']; ?></td>
    <td class="td-date_updated"> <?php echo $data['date_updated']; ?></td>
    <td class="td-harga_bpjs"> <?php echo $data['harga_bpjs']; ?></td>
    <td class="page-list-action td-btn">
        <div class="dropdown" >
            <button data-toggle="dropdown" class="dropdown-toggle btn btn-primary btn-sm">
                <i class="fa fa-bars"></i> 
            </button>
            <ul class="dropdown-menu">
                <?php if($can_view){ ?>
                <a class="dropdown-item page-modal" href="<?php print_link("setok_barang/view/$rec_id"); ?>">
                    <i class="fa fa-eye"></i> View 
                </a>
                <?php } ?>
                <?php if($can_edit){ ?>
                <a class="dropdown-item page-modal" href="<?php print_link("setok_barang/edit/$rec_id"); ?>">
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
