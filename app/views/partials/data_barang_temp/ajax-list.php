<?php 
//check if current user role is allowed access to the pages
$can_add = ACL::is_allowed("data_barang_temp/add");
$can_edit = ACL::is_allowed("data_barang_temp/edit");
$can_view = ACL::is_allowed("data_barang_temp/view");
$can_delete = ACL::is_allowed("data_barang_temp/delete");
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
    <td class="td-nama_barang"> <?php echo $data['nama_barang']; ?></td>
    <td class="td-satuan"> <?php echo $data['satuan']; ?></td>
    <td class="td-harga"> <?php echo $data['harga']; ?></td>
    <td class="td-operator">
        <a size="sm" class="btn btn-sm btn-primary page-modal" href="<?php print_link("user_login/view/" . urlencode($data['operator'])) ?>">
            <i class="fa fa-eye"></i> <?php echo $data['user_login_nama'] ?>
        </a>
    </td>
    <td class="page-list-action td-btn">
        <div class="dropdown" >
            <button data-toggle="dropdown" class="dropdown-toggle btn btn-primary btn-sm">
                <i class="fa fa-bars"></i> 
            </button>
            <ul class="dropdown-menu">
                <?php if($can_view){ ?>
                <a class="dropdown-item page-modal" href="<?php print_link("data_barang_temp/view/$rec_id"); ?>">
                    <i class="fa fa-eye"></i> View 
                </a>
                <?php } ?>
                <?php if($can_edit){ ?>
                <a class="dropdown-item page-modal" href="<?php print_link("data_barang_temp/edit/$rec_id"); ?>">
                    <i class="fa fa-edit"></i> Edit
                </a>
                <?php } ?>
                <?php if($can_delete){ ?>
                <a  class="dropdown-item record-delete-btn" href="<?php print_link("data_barang_temp/delete/$rec_id/?csrf_token=$csrf_token&redirect=$current_page"); ?>" data-prompt-msg="Are you sure you want to delete this record?" data-display-style="modal">
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