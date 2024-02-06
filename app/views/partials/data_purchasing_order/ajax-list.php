<?php 
//check if current user role is allowed access to the pages
$can_add = ACL::is_allowed("data_purchasing_order/add");
$can_edit = ACL::is_allowed("data_purchasing_order/edit");
$can_view = ACL::is_allowed("data_purchasing_order/view");
$can_delete = ACL::is_allowed("data_purchasing_order/delete");
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
    <td class="td-id"><a href="<?php print_link("data_purchasing_order/view/$data[id]") ?>"><?php echo $data['id']; ?></a></td>
    <td class="td-id_purchasing_order"> <?php echo $data['id_purchasing_order']; ?></td>
    <td class="td-tanggal"> <?php echo $data['tanggal']; ?></td>
    <td class="td-id_suplier"> <?php echo $data['id_suplier']; ?></td>
    <td class="td-nama_suplier"> <?php echo $data['nama_suplier']; ?></td>
    <td class="td-alamat"> <?php echo $data['alamat']; ?></td>
    <td class="td-no_hp"> <?php echo $data['no_hp']; ?></td>
    <td class="td-email"><a href="<?php print_link("mailto:$data[email]") ?>"><?php echo $data['email']; ?></a></td>
    <td class="td-kode_barang"> <?php echo $data['kode_barang']; ?></td>
    <td class="td-nama_barang"> <?php echo $data['nama_barang']; ?></td>
    <td class="td-category_barang"> <?php echo $data['category_barang']; ?></td>
    <td class="td-harga"> <?php echo $data['harga']; ?></td>
    <td class="td-jumlah"> <?php echo $data['jumlah']; ?></td>
    <td class="td-total_harga"> <?php echo $data['total_harga']; ?></td>
    <td class="td-operator"> <?php echo $data['operator']; ?></td>
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
                <a class="dropdown-item page-modal" href="<?php print_link("data_purchasing_order/view/$rec_id"); ?>">
                    <i class="fa fa-eye"></i> View 
                </a>
                <?php } ?>
                <?php if($can_edit){ ?>
                <a class="dropdown-item page-modal" href="<?php print_link("data_purchasing_order/edit/$rec_id"); ?>">
                    <i class="fa fa-edit"></i> Edit
                </a>
                <?php } ?>
                <?php if($can_delete){ ?>
                <a  class="dropdown-item record-delete-btn" href="<?php print_link("data_purchasing_order/delete/$rec_id/?csrf_token=$csrf_token&redirect=$current_page"); ?>" data-prompt-msg="Are you sure you want to delete this record?" data-display-style="modal">
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
